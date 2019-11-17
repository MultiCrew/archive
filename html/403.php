<?php

include $_SERVER['DOCUMENT_ROOT'].'/../config.php';
include $_SERVER['DOCUMENT_ROOT'].'/../global_header.php';

?>

<div class="container my-5 py-5">
	<h1 class="display-4">Error 403</h1>
	<p class="lead">You broke the MultiCrew website! Or, perhaps, the problem lies between keyboard and chair...</p>

	<hr>

	<p>If you believe this to be a mistake, please send the error number, page URL and the last action you tried to perform to <a href="mailto:&#097;&#100;&#109;&#105;&#110;&#064;&#109;&#117;&#108;&#116;&#105;&#099;&#114;&#101;&#119;&#046;&#099;&#111;&#046;&#117;&#107;">&#097;&#100;&#109;&#105;&#110;&#064;&#109;&#117;&#108;&#116;&#105;&#099;&#114;&#101;&#119;&#046;&#099;&#111;&#046;&#117;&#107;</a>.</p>
	<p><small class="text-muted">Did you know: an "Error 404" means your browser doesn't have permission to fetch the resource (page, script, image, document, etc.) it just tried to?</small></p>
	<button class="btn btn-primary btn-lg" onclick="goBack()"><i class="fas fa-angle-double-left fa-lg fa-fw mr-2"></i>Back</button>
</div>

<script>
function goBack() {
    window.history.back();
}
</script>

<?php include $_SERVER['DOCUMENT_ROOT'].'/../footer_plain.php'; ?>
