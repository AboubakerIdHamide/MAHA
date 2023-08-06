<?php

use App\Models\Stocked;

// Get Theme
$stocked = new Stocked;
$theme = $stocked->getThemeData();

// Global Constants
define('URLROOT', "http://localhost/maha");
define('CSSROOT', URLROOT . '/public/css');
define('JSROOT', URLROOT . '/public/js');
define('IMAGEROOT', URLROOT . '/public/images');
define('APPROOT', dirname(dirname(__FILE__)));
define('SITENAME', "MAHA");
define('LOGO', URLROOT . '/public/'.$theme->logo);