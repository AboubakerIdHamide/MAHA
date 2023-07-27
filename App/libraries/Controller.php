<?php

class Controller
{
    // Load Model
    public function model($model)
    {
        // DataBase Connection
        try {
            $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME.";charset=utf8mb4", DB_USER, DB_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }

        // require that model
        require_once "../App/models/" . $model . ".php";


        // Instantiate this model
        return new $model($db);
    }
}
