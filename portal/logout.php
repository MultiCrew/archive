<?php

include $_SERVER['DOCUMENT_ROOT'].'/../config.php';

$sso->log_out();
if (isset($_SERVER['HTTP_REFERRER']))
	header('LOCATION: '.$_SERVER['HTTP_REFERRER']);
else
	header('LOCATION: '.PROTOCOL.'://www.'.DOMAIN.'/home.php');

?>
