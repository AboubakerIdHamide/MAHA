<?php

function auth()
{
	return isset($_SESSION['user']);
}