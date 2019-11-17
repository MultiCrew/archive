<?php

include $_SERVER['DOCUMENT_ROOT'].'/../config.php';

if (isset($_COOKIE['visited'])) {
	header('LOCATION: '.PROTOCOL.'://www.'.DOMAIN.'/home.php');
	die();
} else {
	setcookie('visited', 'true');
	header('LOCATION: '.PROTOCOL.'://www.'.DOMAIN.'/landing.php');
	die();
}

?>
