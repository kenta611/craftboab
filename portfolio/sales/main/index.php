<?php
session_start();
require('../dbconnect.php');

if(isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()){
	$_SESSION['time'] = time();

	$members = $db->prepare('SELECT * FROM members WHERE id=?');
	$members->execute(array($_SESSION['id']));
	$member = $members->fetch();
}else{
	header('Location:../index.php');
	exit();
}
$items = $db->query('SELECT * FROM products');

if(isset($_POST['confirm'])){
	$_SESSION['inquiry'] = $_POST;
        header('Location: submit.php');
        exit();
}

?>



<!doctype html>
<html lang="jp">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<title>Main</title>

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
						<li class="nav-item active">
							<a class="nav-link" href=>Home <span class="sr-only">(current)</span></a>
						</li>
						<!-- <li class="nav-item">
							<a class="nav-link" href="#">Pricing</a>
						</li> -->
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
	<div class="container">
		<h5 class="container">Welcome <?php print(htmlspecialchars($member['name'], ENT_QUOTES)); ?> さん</h5>
		<br>

		<form action="submit.php" method="post">
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
									<select name="<?php
									$product = $item['item_name'];
									print(htmlspecialchars($_POST[$product], ENT_QUOTES)); print(htmlspecialchars($item['item_name'], ENT_QUOTES)); ?>" size="1">
										<option value="0">0</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
										<option value="10">10</option>
									</select>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
				<input class="btn btn-primary my-2 my-sm-0" type='submit' name="confirm" value='Submit' />
			</div>
		</form>
	</div>






	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
