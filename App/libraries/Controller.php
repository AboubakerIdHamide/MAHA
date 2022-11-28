<?php

// pCloud Classes
use pCloud\Sdk\App;
use pCloud\Sdk\Folder;
use pCloud\Sdk\File;

// pCloud Classes Autolader
require APPROOT.'/pCloud/vendor/autoload.php';

class Controller
{
    // Load Model
    public function model($model)
    {
        // DataBase Connection
        try {
            $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } 
        catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }        

        // require that model
        require_once "../App/models/" . $model . ".php";


        // Instantiate this model
        return new $model($db);
    }

    // Load View
    public function view($view, $data=[])
    {
        // check for view file
        if (file_exists('../App/views/' . $view . '.php')) {
            // require that model
            require_once "../App/views/" . $view . ".php";
        } else {
            die("View Does Not Exists !");
        }
    }
    
    // pcloud Methods
    public function pCloudApp()
    {
        $pCloudApp = new App();
        $pCloudApp->setAccessToken("RMiu7ZMHkx8X1cEMzZM8uWc7ZJVsOoA1ivS8mjThYfGA97ytfhmh7");
        $pCloudApp->setLocationId(1);
        return $pCloudApp;
    }

    public function pcloudFolder()
    {
        $pcloudFolder = new Folder($this->pCloudApp());
        return $pcloudFolder;
    }

    public function pcloudFile()
    {
        $pcloudFile = new File($this->pCloudApp());
        return $pcloudFile;
    }
}
