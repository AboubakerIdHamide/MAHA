<?php

// Load view helper
function view($view, $data = [])
{
    // check for view file
    if (file_exists('../App/views/' . $view . '.php')) {
        extract($data);

        // require that view
        require_once "../App/views/" . $view . ".php";
    } else {
        require_once "../App/views/errors/page_404.php";
    }
}
