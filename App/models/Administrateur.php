<?php

/**
 * Model Admin
 */

class Administrateur
{
    private $connect;

    public function __construct($database)
    {
        $this->connect = $database;
    }

    public function insertAdmin($admin)
    {
    }

    public function getAdminByEmail($email)
    {
        $request = $this->connect->prepare("
            SELECT * FROM admin 
            WHERE email_admin = :email
        ");
        $request->bindParam(':email', $email);
        $request->execute();
        $admin = $request->fetch(PDO::FETCH_OBJ);
        return $admin;
    }

    public function getProfitAndPaypalToken()
    {
        $request = $this->connect->prepare("
            SELECT platform_pourcentage, password_paypal, username_paypal FROM admin 
        ");
        $request->execute();
        $settings = $request->fetch(PDO::FETCH_OBJ);
        return $settings;
    }

    public function replaceSettings($data)
    {

        $request = $this->connect->prepare("
			UPDATE admin 
			SET 
                platform_pourcentage = :platform_pourcentage, 
			    username_paypal = :username_p, 
			    password_paypal = :password_p
		");

        $request->bindParam(':platform_pourcentage', $data['platform_pourcentage']);
        $request->bindParam(':username_p', $data['username_p']);
        $request->bindParam(':password_p', $data['password_p']);
        $response = $request->execute();

        return $response;
    }
}