<?php

class SessionManager {
    private $key;

    public function __construct($key) {
        $this->key = $key;
    }

    public function set($value) {
        $_SESSION[$this->key] = $value;
    }

    public function get() {
        return $_SESSION[$this->key] ?? false;
    }

    public function remove() {
        if (isset($_SESSION[$this->key])) {
            unset($_SESSION[$this->key]);
        }
    }

    public function flush() {
        session_unset(); 
        session_destroy(); 
    }
}

function session($key = "") {
    return new SessionManager($key);
}