<?php
// Load Config
require_once "config/config.php";

// Load Helpers
require_once 'helpers/session_helper.php';
require_once 'helpers/url_helper.php';
require_once 'helpers/view_helper.php';

// Auto Load Core Libraries
spl_autoload_register(function ($class) {
    require_once "libraries/" . $class . ".php";
});