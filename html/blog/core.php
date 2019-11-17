<?php

class Blog {

	public function getPosts($database) {

		$stmt = $database->prepare('SELECT * FROM blog_posts ORDER BY postID DESC');
		$stmt->execute();
		return $stmt->get_result();

	}

	public function getPost($database, $id) {

		$stmt = $database->prepare('SELECT * FROM blog_posts WHERE postID=?');
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$post = $stmt->get_result();
		return $post->fetch_array();

	}

	public function checkAdmin($sso) {
		if ($sso->logged_in()) {
			if ($sso->get_user_data('type')!='admin')
				header('LOCATION: /index.php');
		} else {
			header('LOCATION: /index.php');
		}
	}

	public function redirect($url) {

		if (headers_sent()) {
			die('<script type="text/javascript">window.location=\'' .$url.'\'; </script>');
		} else {
			header('LOCATION: '.$url);
			die();
		}

	}

}

$blog = new Blog();

$connect->dbDefineCredentials('blog');
$mysqli = $connect->dbConnect();

?>
