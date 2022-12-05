<?php

/**
 * class Admin
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
        $request = $this->connect->prepare("SELECT * FROM admin WHERE email_admin = :email");
        $request->bindParam(':email', $email);
        $request->execute();
        $admin = $request->fetch();
        return $admin;
    }

    public function updateAdmin($admin)
    {
    }

    public function updateAdminPasswordByEmail($admin)
    {
    }

    public function deteleAdmin($admin_id)
    {
    }

    public function getAdminById($admin_id)
    {
    }
}
