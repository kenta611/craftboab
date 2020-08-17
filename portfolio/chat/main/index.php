<?php
session_start();
require('../dbconnect.php');

if(isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()){
	$_SESSION['time'] = time();

	$members = $db->prepare('SELECT * FROM members WHERE id=?');
	$members->execute(array($_SESSION['id']));
	$member = $members->fetch();
}else{
	header('Location: ../index.php');
	exit();
}

if(!empty($_POST)){
	if($_POST['message'] !== ''){
		$message = $db->prepare('INSERT INTO posts SET member_id=?, message=?, reply_message_id=?, created=NOW()');
		$message->execute(array(
			$member['id'],
			$_POST['message'],
			$_POST['reply_post_id']
		));

		header('Location:index.php');
		exit();
	}
}

$page = $_REQUEST['page'];
if($page == ''){
	$page = 1;
}
$page = max($page, 1);

$counts = $db->query('SELECT COUNT(*) AS cnt FROM posts');
$cnt = $counts->fetch();
$maxPage =  ceil($cnt['cnt'] / 5);
$page = min($page, $maxPage);


$start = ($page - 1) * 5;

$posts= $db->prepare('SELECT * FROM members, posts WHERE members.id=posts.member_id ORDER BY posts.created DESC LIMIT ?,5');
$posts->bindParam(1, $start, PDO::PARAM_INT);
$posts->execute();


if(isset($_REQUEST['res'])){
	//返信の処理
	$response = $db->prepare('SELECT * FROM members, posts WHERE members.id=posts.member_id AND posts.id=?');
	$response->execute(array($_REQUEST['res']));

	$table = $response->fetch();
	$message = '@' . $table['name'] . ' ' . $table['message'];
}

?>

<!doctype html>
<html lang="jp">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<title>chat place</title>
</head>
<body>
	<nav class="navbar navbar-light bg-primary">
		<span class="navbar-brand mb-0 h1">CraftBoab</span>
	</nav>

	<div class="jumbotron jumbotron-fluid">
		<div class="container">
			<div class="text-right"><a href="logout.php">Log out</a></div>
			<h1 class="display-4 text-center">Chat place</h1>
			<hr>
			<form action="" method="POST">
				<dl class="text-center">
					<dt>Hi <?php print(htmlspecialchars($member['name'], ENT_QUOTES)); ?>, post your message</dt>
					<br>
					<dd>
						<textarea name="message" cols="80" rows="5"><?php print(htmlspecialchars($message, ENT_QUOTES)); ?></textarea>
						<input type="hidden" name="reply_post_id" value="<?php print(htmlspecialchars($_REQUEST['res'], ENT_QUOTES)); ?>" />
					</dd>
				</dl>
				<div class="text-center">
						<input type="submit" class="btn btn-primary" value="Post" />
				</div>
			</form>
			<hr>
			<div class="container text-center">
			<?php foreach ($posts as $post): ?>
				<div>
					<img src="member_img/<?php print(htmlspecialchars($post['picture'], ENT_QUOTES)); ?>" width="48" height="48" alt="<?php print(htmlspecialchars($post['name'], ENT_QUOTES)); ?>" />
					<p><?php print(mb_substr($post['message'],0, 50)); ?><span>（<?php print(htmlspecialchars($post['name'], ENT_QUOTES)); ?>）</span>[<a href="index.php?res=<?php print(htmlspecialchars($post['id'], ENT_QUOTES)); ?> ">Re</a>]</p>
					<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">entire message</a>
					<p>	<?php print(htmlspecialchars($post['created'], ENT_QUOTES)); ?></p>


						<?php if($post['reply_message_id'] > 0): ?>
							<a href="view.php?id=<?php print(htmlspecialchars($post['reply_message_id'], ENT_QUOTES)); ?>">
								Original message</a>
							<?php endif; ?>

							<?php if($_SESSION['id'] == $post['member_id']): ?>
								[<a href="delete.php?id=<?php print(htmlspecialchars($post['id'])); ?>"
									style="color: #F33;">delete</a>]
								<?php endif;?>
					</div>
					<hr>
					<br>
					<?php endforeach; ?>
				</div>
					<div class="text-center">
						<?php if($page > 1): ?>
							<a href="index.php?page=<?php print($page-1); ?>">Back</a>
						<?php else: ?>
							<p>Back</p>
						<?php endif; ?>
						<?php if($page < $maxPage): ?>
							<a href="index.php?page=<?php print($page+1); ?>">Next</a>
						<?php else: ?>
							<p>Next</p>
						<?php endif; ?>

					</div>

				</div>
			</div>

			<!-- Optional JavaScript -->
			<!-- jQuery first, then Popper.js, then Bootstrap JS -->
			<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
			<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
			<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
		</body>
		</html>
