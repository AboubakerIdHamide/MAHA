<?php

namespace App\Libraries;

use App\Libraries\Database;
use getID3\getID3;

class Validator
{
    private $data;
    private $errors;

    public function __construct($data)
    {
        $this->data = $data;
        $this->errors = [];
    }

    public function validate($rules, $view = null, $setOldValue = false)
    {
        foreach ($rules as $field => $rule) {
            $rulesList = explode('|', $rule);

            foreach ($rulesList as $singleRule) {
                $this->applyValidationRule($field, $singleRule);
            }
        }

        if (!empty($this->errors)) {
            if (explode('/', $_GET['url'])[0] !== "api") {
                if($setOldValue) $this->setOldValuesInSession();
                if(!is_null($view)) {
                    view($view, $this->errors);
                    exit;
                }
            }
            return Response::json(null, 400, $this->errors);
        }
    }

    private function applyValidationRule($field, $rule)
    {
        $value = $this->data[$field];

        if ($rule === 'required') {
            if (empty($value)) {
                $this->addError($field, 'The ' . $field . ' field is required.');
            }
        } elseif (strpos($rule, 'min:') === 0) {
            $minLength = explode(':', $rule)[1];
            if (strlen($value) < $minLength) {
                $this->addError($field, 'The ' . $field . ' field must be at least ' . $minLength . ' characters long.');
            }
        } elseif (strpos($rule, 'max:') === 0) {
            $maxLength = explode(':', $rule)[1];
            if (strlen($value) > $maxLength) {
                $this->addError($field, 'The ' . $field . ' field cannot exceed ' . $maxLength . ' characters.');
            }
        }elseif (strpos($rule, 'numeric_min:') === 0) {
            $minValue = floatval(explode(':', $rule)[1]);
            if (!is_numeric($value) || floatval($value) < $minValue) {
                $this->addError($field, 'The ' . $field . ' field must be at least ' . $minValue . '.');
            }
        } elseif (strpos($rule, 'numeric_max:') === 0) {
            $maxValue = floatval(explode(':', $rule)[1]);
            if (!is_numeric($value) || floatval($value) > $maxValue) {
                $this->addError($field, 'The ' . $field . ' field cannot exceed ' . $maxValue . '.');
            }
        } elseif ($rule === 'alphanum') {
            if (!ctype_alnum($value)) {
                $this->addError($field, 'The ' . $field . ' field must contain only alphanumeric characters.');
            }
        } elseif ($rule === 'image') {
            $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($fileInfo, $value['tmp_name']);
            finfo_close($fileInfo);

            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

            if (!in_array($mimeType, $allowedTypes)) {
                $this->addError($field, 'The ' . $field . ' field must be an image (JPEG, PNG, GIF).');
            }
        } elseif ($rule === 'numeric') {
            if (!is_numeric($value)) {
                $this->addError($field, 'The ' . $field . ' field must be a numeric value.');
            }
        } elseif (strpos($rule, 'size:') === 0) {
            $maxFileSizeMB = floatval(explode(':', $rule)[1]); // Maximum file size in MB
            $maxFileSizeBytes = $maxFileSizeMB * 1024 * 1024; // Convert MB to bytes

            if ($value['size'] > $maxFileSizeBytes) {
                $this->addError($field, 'The ' . $field . ' field must be smaller than ' . $maxFileSizeMB . ' MB.');
            }
        } elseif ($rule === 'date') {
            $date = \DateTime::createFromFormat('Y-m-d', $value);

            if (!$date || $date->format('Y-m-d') !== $value) {
                $this->addError($field, 'The ' . $field . ' field must be a valid date (YYYY-MM-DD).');
            }
        } elseif ($rule === 'time') {
            if (!preg_match('/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/', $value)) {
                $this->addError($field, 'The ' . $field . ' field must be a valid time (HH:MM).');
            }
        } elseif ($rule === 'datetime') {
            $dateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $value);

            if (!$dateTime || $dateTime->format('Y-m-d H:i:s') !== $value) {
                $this->addError($field, 'The ' . $field . ' field must be a valid datetime (YYYY-MM-DD HH:MM:SS).');
            }
        } elseif ($rule === 'alpha') {
            if (!ctype_alpha($value)) {
                $this->addError($field, 'The ' . $field . ' field must contain only alphabetic characters.');
            }
        } elseif ($rule === 'email') {
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $this->addError($field, 'The ' . $field . ' field must be a valid email address.');
            }
        } elseif (strpos($rule, 'unique:') === 0) {
            $tableName = explode(':', $rule)[1]; // Your table name here;
            $columnName = $field;

            // Perform a query to check uniqueness
            $query = "SELECT COUNT(*) FROM {$tableName} WHERE {$columnName} = :value";
            $statement = Database::getConnection()->prepare($query);
            $statement->bindParam(':value', $value);
            $statement->execute();
            $count = $statement->fetchColumn();

            if ($count > 0) {
                $this->addError($field, 'The ' . $field . ' already taken.');
            }
        } elseif ($rule === 'confirm') {
            if ($value !== $this->data[$field . '_confirmation']) {
                $this->addError($field, "Passwords do not match.");
            }

            unset($this->data[$field . '_confirmation']);
        } elseif (strpos($rule, 'in_array:') === 0) {
            $allowedValues = explode(',', explode(':', $rule)[1]);

            if (!in_array($value, $allowedValues)) {
                $this->addError($field, 'The selected ' . $field . ' value is not allowed.');
            }
        } elseif (strpos($rule, 'exists:') === 0) {
            $tablesName = explode(',', explode(':', $rule)[1]);
            $columnName = $field;

            foreach ($tablesName as $table) {
                $isExist = false;
                $query = "SELECT COUNT(*) FROM {$table} WHERE {$columnName} = :value";
                $statement = Database::getConnection()->prepare($query);
                $statement->bindParam(':value', $value);
                $statement->execute();
                $count = $statement->fetchColumn();
                if($count > 0) {
                    $isExist = true;
                    $this->data['type'] = rtrim($table, 's');
                    break;
                }
            }
            
            if ($isExist === false) {
                $this->addError($field, 'The ' . $field . " doesn't exist.");
            }
        } elseif ($rule === 'auth') {
            $tablesName = ['etudiants', 'formateurs'];

            foreach ($tablesName as $table) {
                $isExist = false;
                $query = "SELECT mot_de_passe FROM {$table} WHERE email = :email";
                $statement = Database::getConnection()->prepare($query);
                $statement->bindParam(':email', $value);
                $statement->execute();
                $hashed_password = $statement->fetchColumn();
                if(!password_verify($this->data['password'], $hashed_password ?? '')) {
                    continue;
                }
                $isExist = true;
                $this->data['type'] = rtrim($table, 's');
                break;
            }
      
            if ($isExist === false) {
                $this->addError($field, "Les identifiants ne correspondent pas à nos enregistrements.");
            }
        } elseif ($rule === 'video') {
            $allowedTypes = ['video/mp4', 'video/mov', 'video/avi', 'video/x-matroska'];
            $fileType = $value['type'];

            if (!in_array($fileType, $allowedTypes)) {
                $this->addError($field, 'The ' . $field . ' field must be of allowed file types: (MP4, MOV, AVI, MKV).');
            }
        } elseif (strpos($rule, 'video_duration:') === 0) {
            $durationInMinutes = intval(explode(':', $rule)[1]);
            
            $filename = $value['tmp_name'];
            $getID3 = new \getID3;
            $fileInfo = $getID3->analyze($filename);
            $this->data['duration'] = $fileInfo['playtime_seconds'];
            $maxDuration = $durationInMinutes * 60; 

            if ($fileInfo && isset($fileInfo['playtime_seconds']) && $fileInfo['playtime_seconds'] > $maxDuration) {
                $this->addError($field, 'The ' . $field . ' video duration must not exceed ' . $durationInMinutes . ' minutes.');
            }
        }

        // Add more validation rules as needed...
    }

    private function addError($field, $message)
    {
        if (!isset($this->errors[$field . '_error'])) {
            $this->errors[$field . '_error'] = $message;
        }
    }

    private function setOldValuesInSession()
    {
        if (count($this->errors) > 0) {
            foreach ($this->data as $field => $data) {
                if ($field !== 'password' && $field !== 'password_confirmation') {
                    old($field, $this->data[$field]);
                }
            }
        }
    }

    public function validated()
    {
        if (isset($this->data['password'])) {
            $this->data['password'] = password_hash($this->data['password'], PASSWORD_DEFAULT);
            return $this->data;
        }
        return $this->data;
    }
}
