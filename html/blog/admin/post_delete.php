<?php

include $_SERVER['DOCUMENT_ROOT'].'/../config.php';
include '../core.php';
$blog->checkAdmin($sso);

//if form has been submitted process it
if (isset($_GET['id'])) {

	$stmt = $mysqli->prepare('DELETE FROM blog_posts WHERE postID=?');
	$stmt->bind_param('i', $_GET['id']);
	$stmt->execute();

	//redirect to index page
	$blog->redirect('index.php?action=deleted');
	die();

}

?>
