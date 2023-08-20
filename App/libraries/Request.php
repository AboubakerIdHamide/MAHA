<?php

namespace App\Libraries;

class Request
{
    private $method;
    private $uri;
    private $headers;
    private $get;
    private $post;
    private $params;

    public function __construct()
    {
        $this->headers = $_SERVER;
        $this->uri = isset($_GET["url"]) ? explode("/", $_GET["url"]) : [null];
        $this->setParams();
        $this->method = $_POST['method'] ?? $_SERVER['REQUEST_METHOD'];
        $this->get = $_GET;
        $this->post = $_POST;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function body($field)
    {
        if (array_key_exists($field, $this->body)) {
            return $this->body[$field];
        }
        return "";
    }

    public function get($field)
    {
        if (array_key_exists($field, $this->get)) {
            return $this->get[$field];
        }
        return "";
    }

    public function post($field)
    {
        if (array_key_exists($field, $this->post)) {
            return $this->post[$field];
        }
        return "";
    }

    private function setParams()
    {
        $uri = $this->uri;
        if (!isset($uri[2])) {
            return $this->params = [];
        }
        unset($uri[0], $uri[1]);
        $i = 0;
        foreach ($uri as $param) {
            $this->params[$i++] = $param;
        }
    }

    public function getParams()
    {
        return $this->params;
    }
}
