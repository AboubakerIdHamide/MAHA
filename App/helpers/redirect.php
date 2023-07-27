<?php

// page redirect helper
function redirect($controller = '')
{
	ob_start();
	header('location: ' . URLROOT . '/' . $controller);
	ob_end_clean();
}
