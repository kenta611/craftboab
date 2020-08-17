<?php
session_start();
require('dbconnect.php');

if (!empty($_POST)){
  if($_POST['name'] === ''){
    $error['name'] = 'blank';
  }
  if($_POST['email'] === ''){
    $error['email'] = 'blank';
  }
  if(strlen($_POST['password']) < 4){
    $error['password'] = 'length';
  }
  if($_POST['password'] === ''){
    $error['password'] = 'blank';
  }

  //アカウントの重複をチェック
if(empty($error)){
  $member = $db->prepare('SELECT COUNT(*) AS cnt FROM members WHERE email=?');
  $member->execute(array($_POST['email']));
  $record = $member->fetch();
  if($record['cnt'] > 0){
    $error['email'] = 'duplicate';
  }
}

if(empty($error)){
  $member = $db->prepare('SELECT COUNT(*) AS cnt FROM master_member WHERE email=?');
  $member->execute(array($_POST['email']));
  $record = $member->fetch();
  if($record['cnt'] > 0){
    $error['email'] = 'duplicate';
  }
}

  if(empty($error)){

    $_SESSION['join'] = $_POST;
    header('Location: master_check.php');
    exit();
  }
}

if ($_REQUEST['action'] == 'rewrite' && isset($_SESSION['join'])) {
    $_POST = $_SESSION['join'];
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
      <form class="container" action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label>Name</label>
          <input type="text" name="name" class="form-control" value="<?php print(htmlspecialchars($_POST['name'], ENT_QUOTES)); ?>" placeholder="Name">
          <?php if($error['name'] === 'blank'): ?>
            <p class="error"> * Please type your Name</p>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="text" name="email" class="form-control" value="<?php print(htmlspecialchars($_POST['email'], ENT_QUOTES)); ?>" placeholder="Email">
          <?php if($error['email'] === 'blank'): ?>
            <p class="error"> * Please type email</p>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" class="form-control" value="<?php print(htmlspecialchars($_POST['password'], ENT_QUOTES)); ?>" placeholder="Password">
          <?php if($error['password'] === 'length'): ?>
            <p class="error"> * Plese make more than 4 digit for your password</p>
          <?php endif; ?>
          <?php if($error['password'] === 'blank'): ?>
            <p class="error"> * Please type the Password</p>
          <?php endif; ?>
        </div>
        <input type="submit" class="btn btn-primary" value="submit"> <a class="btn btn-primary ml-2" href="index.php" role="button">Back</a>

      </form>
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
