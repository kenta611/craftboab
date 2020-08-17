<?php
session_start();
require('../dbconnect.php');


if(!isset($_SESSION['master'])){
  header('Location: master_member.php');
  exit();
}

if(!empty($_POST)){
  $statement = $db->prepare('INSERT INTO products SET item_name=?, item_description=?, image_name=?, created=NOW()');
  echo $statement->execute(array(
    $_SESSION['master']['item_name'],
    $_SESSION['master']['item_description'],
    $_SESSION['master']['image'],
  ));
  unset($_SESSION['master']);

  header('Location: master_room.php');
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
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

  <title>Confirmation</title>
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
          <dt>Product Image</dt>
          <dd>
            <?php if($_SESSION['master']['image'] !==''): ?>
              <img src = "item_image/<?php print(htmlspecialchars($_SESSION['master']['image'], ENT_QUOTES)); ?>" width="200" height="200">
            <?php endif; ?>
            <?php if(!empty($error)): ?>
              <p class = "error"> * Please select product image again</p>
            <?php endif; ?>
          </dd>
          <dt>Product Name</dt>
          <dd>
            <?php print(htmlspecialchars($_SESSION['master']['item_name'], ENT_QUOTES)); ?>
          </dd>
          <dt>item_description</dt>
          <dd>
            <?php print(htmlspecialchars($_SESSION['master']['item_description'], ENT_QUOTES)); ?>
          </dd>
        </dl>
        <div><a href="master_room.php?action=rewrite">&laquo;&nbsp;Rewrite</a> | <input type="submit" value="Regist" /></div>
      </form>

      <a class="btn btn-primary btn-lg" href="master_room.php" role="button">back</a>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
  </html>
