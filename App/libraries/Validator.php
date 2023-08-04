<?php

namespace App\Libraries;

use App\Libraries\Database;

class Validator
{
    private $data;
    private $errors;

    public function __construct($data)
    {
        $this->data = $data;
        $this->errors = [];
    }

    public function validate($rules, $view = null)
    {
        foreach ($rules as $field => $rule) {
            $rulesList = explode('|', $rule);

            foreach ($rulesList as $singleRule) {
                $this->applyValidationRule($field, $singleRule);
            }
        }



        if (!empty($this->errors)) {
            if (explode('/', $_GET['url'])[0] !== "api") {
                $this->setOldValuesInSession();
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
            $fileSize = explode(':', $rule)[1];
            $fileSizeInBytes = $value['size'];

            if ($fileSizeInBytes > $fileSize) {
                $this->addError($field, 'The ' . $field . ' field must be smaller than ' . $fileSize . ' bytes.');
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
        } elseif ($rule === 'checkbox') {
            // Assuming the field is an array of checkbox values

            if (!is_array($value) || empty($value)) {
                $this->addError($field, 'The ' . $field . ' field must be checked.');
            }
        } elseif ($rule === 'radio') {
            // Assuming the field is a single radio button value

            if (empty($value)) {
                $this->addError($field, 'Please select a value for the ' . $field . ' field.');
            }
        } elseif ($rule === 'confirm') {
            if ($value !== $this->data[$field . '_confirmation']) {
                $this->addError($field, "Passwords do not match.");
            }

            unset($this->data[$field . '_confirmation']);
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
