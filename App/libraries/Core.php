<?php
/*
 * App Core Class
 * Creates URL and Loads Core Controller
 * URL FORMAT - controller/method/params
 */

 class Core{
    protected $currentController="Pages";
    protected $currentMethod="index";
    protected $currentParams=[];

    public function __construct()
    {
        $url=$this->getUrl();
        // Check For Controllers From Url
        if(isset($url[0])){
            if(file_exists("../App/controllers/".ucwords($url[0]).".php")){
                $this->currentController=ucwords($url[0]);
                unset($url[0]);
            }
        }
        

        // Require The Controller
        require_once '../App/controllers/'.$this->currentController.".php";

        // initialize a contoller object
        $this->currentController=new $this->currentController;

        // get Methods from url
        if(isset($url[1])){
            if(method_exists($this->currentController, $url[1])){
                $this->currentMethod=$url[1];
                unset($url[1]);
            }
        }

        // getParams
        $this->currentParams=$url?array_values($url):[];

        // call callback with the params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->currentParams);
    }

    public function getUrl()
    {
        if(isset($_GET["url"])){
            $url=rtrim($_GET["url"], "/");
            $url=filter_var($url, FILTER_SANITIZE_URL);
            $url=explode("/", $url);
            return $url;
        }
    }
 }