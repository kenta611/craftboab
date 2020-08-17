<?php
session_start();
require('dbconnect.php');


if(!isset($_SESSION['join'])){
	header('Location: index.php');
	exit();
}

if(!empty($_POST)){
$statement = $db->prepare('INSERT INTO master_member SET name=?, email=?, password=?, created=NOW()');
echo $statement->execute(array(
$_SESSION['join']['name'],
$_SESSION['join']['email'],
sha1($_SESSION['join']['password']),

));
unset($_SESSION['join']);

header('Location: thanks.php');
exit();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
	crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<title>Register</title>

	<!--<link rel="stylesheet" href="../css/style.css" />-->
</head>
<body>
	<div class="jumbotron">
		<div class="container">
			<div class="text-center">
			<h1 class="display-4">Register</h1>
		</div>
			<p>Before regist please make sure your form</p>
			<form action="" method="post">
				<input type="hidden" name="action" value="submit" />
				<dl>
					<dt>name</dt>
					<dd>
						<?php print(htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES)); ?>
					</dd>
					<dt>Email address</dt>
					<dd>
						<?php print(htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES)); ?>
					</dd>
					<dt>Password</dt>
					<dd>
						【***********】
					</dd>
				</dl>
				<div><a href="signup.php?action=rewrite">&laquo;&nbsp;Rewrite</a> | <input type="submit" value="Regist" /></div>
			</form>

		<a class="btn btn-primary btn-lg" href="index.php" role="button">Home</a>
	</div>





</div>
<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
crossorigin="anonymous"></script>





</body>
</html>
