<?php
session_start();
require('../dbconnect.php');

if(isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()){
	$_SESSION['time'] = time();

	$members = $db->prepare('SELECT * FROM members WHERE id=?');
	$members->execute(array($_SESSION['id']));
	$member = $members->fetch();
}else{
	header('Location:login.php');
	exit();
}

$items = $db->query('SELECT * FROM products');

if(isset($_POST['send'])){


	$to = "ku.trade@gmail.com";
	$subject = print(htmlspecialchars($member['name'], ENT_QUOTES));
	$message = "Hello!\r\nThis is TEST MAIL.";
	$headers = "From: ku.trade611@gmail.com";

	$result = mail($to, $subject, $message, $headers);

	if($result){

		header('Location: order_mail.php');
		exit;
	}else{
		echo "Send faild";
	}

}


?>

<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<title>form</title>
</head>
<body>
	<nav class="navbar navbar-light bg-secondary">
		<span class="navbar-brand mb-0 h1">CraftBoab</span>

		<div style="text-align: right"><a href="logout.php">LogOut</a></div>
	</nav>
	<div class="jumbotron jumbotron-fluid">
		<div class="container">
			<h2 class="col text-center py-5　display-4">YOUR ORDER</h2>
			<hr class="my-4">
			<h4 class="col text-center py-5">Hi,<?php print(htmlspecialchars($member['name'], ENT_QUOTES)); ?>. Befor click the "send" Plese Make sure your order.</h4>

			<form action="" method="POST">
				<table  class="container text-center">
					<?php foreach ($items as $item): ?>
						<tr>
							<td><?php if($_POST[$item['item_name']] > 0){
								$product = $item['item_name'];
								print($item['item_name']. ' '. htmlspecialchars($_POST[$product], ENT_QUOTES));}?></td>
							</tr>
						<?php endforeach; ?>
					</table>
					<br>
					<div class="container text-center">
					  <input class="btn btn-primary m-5 my-sm-0" type="submit" name="send" value="send">
					  <a href="index.php" class="btn btn-primary">Back</a>
				  </div>
				</form>
			</div>
		</div>



		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</body>
	</html>
