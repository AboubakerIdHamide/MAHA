<?php

/**
 * Model Admin
 */

namespace App\Models;

use App\Libraries\Database;

class Admin
{
    private $connect;

    public function __construct()
    {
        $this->connect = Database::getConnection();
    }

    public function getAdminByEmail($email)
    {
        $query = $this->connect->prepare("
            SELECT * FROM admins 
            WHERE email = :email
        ");
        $query->bindParam(':email', $email, \PDO::PARAM_STR);
        $query->execute();
        $admin = $query->fetch(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $admin;
        }
        return false;
    }

    public function getProfitAndPaypalToken()
    {
        $query = $this->connect->prepare("
            SELECT 
                platform_pourcentage, 
                password_paypal, 
                username_paypal 
            FROM admins 
        ");
        $query->execute();
        $settings = $query->fetch(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $settings;
        }
        return false;
    }

    public function replaceSettings($data)
    {
        $query = $this->connect->prepare("
			UPDATE admins 
			SET platform_pourcentage = :platform_pourcentage, 
			    username_paypal = :username_p, 
			    password_paypal = :password_p
		");

        $query->bindParam(':platform_pourcentage', $data['platform_pourcentage'], \PDO::PARAM_STR);
        $query->bindParam(':username_p', $data['username_p'], \PDO::PARAM_STR);
        $query->bindParam(':password_p', $data['password_p'], \PDO::PARAM_STR);
        $query->execute();

        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }
}
