<?php

namespace App\Controllers\Api;
use App\Libraries\Request;
use App\Libraries\Response;

/*
    GET /api/resource       // Get all resources
    GET /api/resource/{id}  // Get a specific resource
    POST /api/resource      // Create a new resource
    PUT /api/resource/{id}  // Update a specific resource
    PATCH /api/resource/{id}  // Update a specific resource
    DELETE /api/resource/{id} // Delete a specific resource
*/

class ApiController extends Api {
	public function __construct()
    {
        $request = new Request;
        $params = $request->getParams();
        switch ($request->getMethod()) {
            case 'GET':
                if (count($params) === 0) {
                    return $this->index($request);
                }
                return $this->show($request, $params[0]);
            case 'POST':
                if (count($params) > 0) {
                    Response::json(null, 405, "Method Not Allowed");
                }
                return $this->store($request);
            case 'PUT':
                if (count($params) !== 1) {
                    Response::json(null, 405, "Method Not Allowed");
                }
                return $this->update($request, $params[0]);
            case 'PATCH':
                if (count($params) !== 1) {
                    Response::json(null, 405, "Method Not Allowed");
                }
                return $this->update($request, $params[0]);
            case 'DELETE':
                if (count($params) !== 1) {
                    Response::json(null, 405, "Method Not Allowed");
                }
                return $this->delete($params[0]);
            default:
                Response::json(null, 405, "Method Not Allowed");
                break;
        }
    }
}