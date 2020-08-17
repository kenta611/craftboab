<?php
session_start();
require("../dbconnect.php");

if(empty($_REQUEST['id'])){
	header('Location: index.php');
	exit();
}

$posts = $db->prepare('SELECT m.name, m.picture, p.* FROM members m, posts p WHERE m.id=p.member_id AND p.id=?');
$posts->execute(array($_REQUEST['id']));
?>


<!doctype html>
<html lang="jp">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<title>Post</title>
</head>
<body>
	<div class="jumbotron">
		<div class="container">
			<div class="card mb-3" style="max-width: 100%;">
				<div class="row no-gutters">
					<div class="col-md-4">
						<?php if($post = $posts->fetch()): ?>
							<img src="member_img/<?php print(htmlspecialchars($post['picture'])); ?>" width="100%" height="100%" alt="<?php print(htmlspecialchars($post['name'], ENT_QUOTES));?>" />
						</div>
						<div class="col-md-8">
							<div class="card-body">
								<p class="card-text"><?php print(htmlspecialchars($post['message'])); ?><span>（<?php print(htmlspecialchars($post['name'])); ?>）</span></p>
								<p class="card-text"><small class="text-muted"><?php print(htmlspecialchars($post['created'])); ?></small></p>
							</div>
						</div>
					<?php else: ?>
						<p>This post has been deleted</p>
					<?php endif; ?>
				</div>
			</div>
			<hr class="my-4">
			<a class="btn btn-primary btn-lg" href="index.php" role="button">&laquo;Back</a>
		</div>

	</div>

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
