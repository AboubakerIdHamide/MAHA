<?php

function session($key, $value = null)
{
	if(!is_null($value)){
		return $_SESSION[$key] = $value;
	}
	return $_SESSION[$key] ?? false;
}