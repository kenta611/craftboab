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
  if($_POST['confirm_password'] !== $_POST['password']){
    $error['confirm_password'] = "miss_match";
  }
  if($_POST['confrim_password'] === ''){
    $error['confrim_password'] = 'blank';
  }
  $fileName = $_FILES['image']['name'];
  if (!empty($fileName)){
    $ext = substr($fileName, -3);
    if($ext != 'jpg' && $ext !='gif' && $ext != 'png'){
      $error['image'] = 'type';
    }
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

  //プロフィール写真管理
  if(empty($error)){
    $image = date('YmdHis'). $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], 'main/member_img/' .$image);
    $_SESSION['join'] = $_POST;
    $_SESSION['join']['image'] = $image;
    header('Location: check.php');
    exit();
  }

  if(empty($error)){
    $_SESSION['join'] = $_POST;
    header('Location: check.php');
    exit();
  }
}

if ($_REQUEST['action'] == 'rewrite' && isset($_SESSION['join'])) {
  $_POST = $_SESSION['join'];
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

  <title>sign up</title>
</head>
<body>
  <nav class="navbar navbar-light bg-light">
    <span class="navbar-brand mb-0 h1">CraftBoab</span>
  </nav>

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
            <p class="error"> * Please type your email address</p>
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
        <div class="form-group">
          <label>Confirm Password</label>
          <input type="password" name="confirm_password" class="form-control" value="<?php print(htmlspecialchars($_POST['confirm_password'], ENT_QUOTES)); ?>" placeholder="confirm_password">
          <?php if($error['confirm_password'] === 'miss_match'): ?>
            <p class="error"> * Password id not matched. Please make sure your password</p>
          <?php endif; ?>
          <?php if($error['confirm_password'] === 'blank'): ?>
            <p class="error"> * Please confirm your Password</p>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label>Picture</label>
          <br>
          <input type="file" name="image" size="35" value="test"  />
							<?php if($error['image'] === 'type'): ?>
								<p class="error">* 写真の拡張子は『.jpg』,『.gif』,『.png』にしてください。</p>
							<?php endif; ?>
							<?php if(!empty($error)): ?>
							<p class = "error"> * 恐れ入りますが、画像を改めて指定してください。</p>
							<?php endif; ?>
        </div>

        <a class="btn btn-primary ml-2" href="index.php" role="button">Back</a>  <input type="submit" class="btn btn-primary" value="submit"> 

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
