<?php

$global_section = 'about';
$page = 'blog';
$title = ' - Blog';
include $_SERVER['DOCUMENT_ROOT'].'/../config.php';
include '../core.php';
include $_SERVER['DOCUMENT_ROOT'].'/../global_header.php';
$blog->checkAdmin($sso);

//if form has been submitted process it
if(isset($_POST['submit'])){

	//very basic validation
	if($_POST['postTitle'] ==''){
		$error[] = 'Please enter the title.';
	}

	if($_POST['postDesc'] ==''){
		$error[] = 'Please enter the description.';
	}

	if($_POST['postCont'] ==''){
		$error[] = 'Please enter the content.';
	}

	if(!isset($error)){

		//insert into database
		$stmt = $mysqli->prepare('INSERT INTO blog_posts (postTitle,postDesc,postCont,postDate) VALUES (?,?,?,?)');
		$stmt->bind_param('ssss', $_POST['postTitle'], $_POST['postDesc'], $_POST['postCont'], $_POST['postDate']);
		$stmt->execute();

		//redirect to index page
		$blog->redirect('index.php?action=added');
		die();

	}

}

?>

<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
<script>
	tinymce.init({
		selector: "textarea",
		plugins: [
			"advlist autolink lists link image charmap print preview anchor",
			"searchreplace visualblocks code fullscreen",
			"insertdatetime media table contextmenu paste"
		],
		toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
	});
</script>

<!-- Page Content -->
<div class="container mt-4">

	<div class="text-center mb-4">
		<h1 class="display-2">Dev Blog</h1>
		<p class="lead">You can expect regular development updates from the MultiCrew development team detailing progress, what's been achieved since the last update and what's coming up in the near future too.</p>
	</div>

	<h3 class="my-4 text-center">New Post</h3>

	<?php

	//check for any errors
	if(isset($error)){
		foreach ($error as $error)
			echo '<div class="alert alert-danger">'.$error.'</p>';
	}

	?>

	<form action="" method="POST">

		<div class="form-group">
			<label>Title</label>
			<input class="form-control" type="text" name="postTitle" value="<?php if(isset($error)){ echo $_POST['postTitle'];}?>">
		</div>

		<div class="form-group">
			<label>Description</label>
			<textarea name="postDesc" cols="60" rows="10"><?php if(isset($error)){ echo $_POST['postDesc'];}?></textarea>
		</div>

		<div class="form-group">
			<label>Content</label>
			<textarea name="postCont" cols="60" rows="10"><?php if(isset($error)){ echo $_POST['postCont'];}?></textarea>
		</div>

		<div class="form-group">
			<input class="btn btn-primary" type="submit" name="submit" value="Submit">
			<a class="btn btn-secondary" href="index.php">Cancel</a>
		</div>

	</form>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/../footer_plain.php'; ?>
