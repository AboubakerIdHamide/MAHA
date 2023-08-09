<?php

namespace App\Libraries;

class Request
{
    private $method;
    private $uri;
    private $headers;
    private $body;
    private $get;
    private $post;
    private $params;

    public function __construct()
    {
        $this->headers = $_SERVER;
        $this->uri = isset($_GET["url"]) ? explode("/", $_GET["url"]) : [null];
        // $this->checkContentType();
        $this->setParams();
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->body = $this->getBody();
        $this->get = $_GET;
        $this->post = $_POST;
    }

    public function getMethod()
    {
        return $this->method;
    }

    private function checkContentType()
    {
        if ($this->uri[0] === "api") {
            if (!isset($this->headers["CONTENT_TYPE"]) or $this->headers["CONTENT_TYPE"] !== "application/json") {
                Response::json(null, 415, 'Content-Type must be application/json');
            }
        }
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    private function getBody()
    {
        $body = json_decode(file_get_contents('php://input'), true);
        if ($this->uri[0] === "api" && $this->method !== "DELETE" && $this->method !== "GET") {
            if (!$body) {
                Response::json(null, 400, 'Request body is not valid JSON');
            }
            return $body;
        }
        return [];
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
