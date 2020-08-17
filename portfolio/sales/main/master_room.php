<?php
session_start();
require('../dbconnect.php');

if(isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()){
	$_SESSION['time'] = time();

	$members = $db->prepare('SELECT * FROM master_member WHERE id=?');
	$members->execute(array($_SESSION['id']));
	$member = $members->fetch();
}else{
	header('Location:../index.php');
	exit();
}

if (!empty($_POST)){
	if($_POST['item_name'] === ''){
		$error['item_name'] = 'blank';
	}
	if($_POST['item_description'] === ''){
		$error['item_description'] = 'blank';
	}
	$fileName = $_FILES['image']['name'];
	if(!empty($fileName)){
		$ext = substr($fileName, -3);
		if ($ext !== 'jpg' && $ext !=='gif' && $ext !=='png'){
			$error['image'] = 'type';
		}
	}

	if  (empty($error)){
		$image = date('YmdHis') . $_FILES['image']['name'];
		move_uploaded_file($_FILES['image']['tmp_name'],
		'item_image/' . $image);
		$_SESSION['master'] = $_POST;
		$_SESSION['master']['image'] = $image;
		header('Location: item_confirm.php');
		exit();
	}

}

$items = $db->query('SELECT * FROM products');

?>

<!doctype html>
<html lang="jp">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<title>Master room</title>


</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-secondary">
		<div class='container'>
			<div class='col-8'>
				<a class="navbar-brand" href="#">CraftBoab</a>
			</div>
			<div class='col-4'>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav">
						<div class="mr-2">
							<li class="nav-item">
								<script>
								function logout() {
									location.href = "logout.php" ;
								}
								</script>
								<form class="form-inline ml-auto">
									<button class="btn btn-outline-primary my-2 my-sm-0" type="button" onclick="logout()">Log Out</button>
								</form>
							</li>
						</div>

					</ul>
				</div>
			</div>
		</div>
	</nav>
	<br>
	<h5 class="container">Welcome <?php print(htmlspecialchars($member['name'], ENT_QUOTES)); ?> .</h5>
	<br>

	<div class="jumbotron jumbotron-fluid">
		<div class="container">
			<form action="" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<p>Products Name</p>
					<input type="text" name="item_name" class="form-control form-control-lg" value="<?php print(htmlspecialchars($_POST['item_name'], ENT_QUOTES)); ?>" />
					<?php if($error['item_name'] === 'blank'): ?>
						<p class="error">* Please fill out Product Name</p>
					<?php endif; ?>
				</div>
				<div class="form-group">
					<p>Item description</p>
					<input type="text" name="item_description" class="form-control form-control-lg" value="<?php print(htmlspecialchars($_POST['item_description'], ENT_QUOTES)); ?>" />
					<?php if($error['item_description'] === 'blank'): ?>
						<p class="error">* Please fill out item description</p>
					<?php endif; ?>
				</div>
				<input type="file" name="image" value="test" />
				<?php if($error['image'] === 'type'): ?>
					<p class="error"> * Please use [.jpg], [.gif], or [.png]</p>
				<?php endif; ?>

				<input type="submit" value="Submit" class="btn btn-outline-success btn-block m-2">
			</form>
		</div>
	</div>

	<br>
	<div class="container">
		<h4 class="text-center">Your Products</h4>
		<br>
		<div class="container">
			<div class="card-group">
				<!--bootstrap card with 3 horizontal images-->
				<div class="row">
					<?php foreach ($items as $item): ?>
						<div class="card col-md-3 m-2">
							<img class="card-img-top" src="item_image/<?php print(htmlspecialchars($item['image_name'], ENT_QUOTES)); ?>" width="200" height="200">
							<div class="card-body">
								<h3 class="card-title"><?php print(htmlspecialchars($item['item_name'], ENT_QUOTES)); ?></h3>
								<p class="card-text"><?php print(htmlspecialchars($item['item_description'], ENT_QUOTES)); ?></p>
								[<a href="delete.php?id=<?php print(htmlspecialchars($item['id']));?>" style="color: #F33;">Delete</a>]

							</div>
						</div>
					<?php endforeach; ?>
				</div>
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
