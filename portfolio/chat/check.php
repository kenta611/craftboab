<?php
session_start();
require('dbconnect.php');

if(!isset($_SESSION['join'])){
  header('Location: index.php');
  exit();
}

if(!empty($_POST)){
  $statement = $db->prepare('INSERT INTO members SET name=?, email=?, password=?, picture=?, created=NOW()');
  echo $statement->execute(array(
    $_SESSION['join']['name'],
    $_SESSION['join']['email'],
    sha1($_SESSION['join']['password']),
    $_SESSION['join']['image']
  ));
  unset($_SESSION['jon']);

  header('Location: thanks.php');
  exit();
}

?>

<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

  <title>confirm</title>
</head>
<body>
  <div class="jumbotron">
    <div class="container">
      <div class="text-center">
        <h1 class="display-4">Register</h1>
      </div>
      <p class='text-center'>Before regist please make sure your form</p>
      <form action="" method="post" class="text-center">
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
          <dd>
            <?php if($_SESSION['join']['image'] !==''): ?>
              <img src = "main/member_img/<?php print(htmlspecialchars($_SESSION['join']['image'], ENT_QUOTES)); ?>">
            <?php endif; ?>
          </dd>
        </dl>
        <div><input class="btn btn-primary" type="submit" value="Regist" /> |<a href="signup.php?action=rewrite">&laquo;&nbsp;Rewrite</a></div>
        <br>
        <a class="btn btn-primary" href="index.php" role="button">Home</a>
      </form>
    </div>
  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
