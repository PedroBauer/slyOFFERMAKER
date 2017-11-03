<?php
/*
Filename: session.php
Author: Pedro Bauer
Description: This file is the API slyLOGIN which is used on the index page.
This file is also used on all other pages for session management.
*/
	require_once ("thirdparty/slyLOGIN/slyLOGIN.api.php");
	session_cache_limiter(20);
	slyLOGIN::config(Array(
	"key" => "2f5c0fd78118743271bade43beb033e5054e62fa3",
	"secret" => "8ad8794b1f0a84bf3697402508d08d1a",
	"onLogin" => function($user) {
	$_SESSION['user'] = $user;
	},
	"onLogout" => function() {
		unset($_SESSION['user']);
	}
	));
?>