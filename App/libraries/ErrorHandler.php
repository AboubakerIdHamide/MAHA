<?php

namespace App\Libraries;

class ErrorHandler {
	public static function handleError($errno, $errstr, $errfile, $errline)
	{
		throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
	}

	public static function handleException(\Throwable $exception)
	{
		return Response::json(null, 500, [
	        "code" => $exception->getCode(),
	        "message" => $exception->getMessage(),
	        "file" => $exception->getFile(),
	        "line" => $exception->getLine(),
    	]);
	}
}