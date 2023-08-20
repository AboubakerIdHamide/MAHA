<?php

namespace App\Controllers\Api;
use App\Libraries\Response;

class Api {
	public function index($request){ 
		return Response::json(null, 405, "Method Not Allowed");
	}

	public function store($request){
		return Response::json(null, 405, "Method Not Allowed");
	}

	public function show($request, $id){
		return Response::json(null, 405, "Method Not Allowed");
	}

	public function update($request, $id){
		return Response::json(null, 405, "Method Not Allowed");
	}

	public function delete($id){
		return Response::json(null, 405, "Method Not Allowed");
	}
}