<?php

namespace App\Controllers\Api;
use App\Libraries\Request;
use App\Libraries\Response;

class ApiController {
	public function __construct()
    {
        $request = new Request;
        switch ($request->getMethod()) {
            case 'GET':
                return $this->index($request);
            default:
                Response::json(null, 405, "Method Not Allowed");
                break;
        }
    }
}