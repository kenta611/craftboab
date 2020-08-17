<?php
session_start();
require('dbconnect.php');


if($_COOKIE['email'] !== ''){
  $email = $_COOKIE['email'];
}

if (!empty($_POST)){
  $email = $_POST['email'];

  if($_POST['email'] !== '' && $_POST['password'] !== ''){
    $login = $db->prepare('SELECT * FROM members WHERE email=? AND password=?');
    $login->execute(array(
      $_POST['email'],
      sha1($_POST['password'])
    ));
    $member = $login->fetch();

    if ($member){
      $_SESSION['id'] = $member['id'];
      $_SESSION['time'] = time();

      if($_POST['save'] === 'on'){
        setcookie('email', $_POST['email'], time()+60*60*24*14);
      }

      header('Location: main/index.php');
      exit();
    }else {
      $error['login'] = 'failed';
    }
  }else {
    $error['login'] = 'blank';
  }
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
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
crossorigin="anonymous">

  <title>chat place</title>

  <link rel="stylesheet" href="style.css">
</head>
<body data-spy="scroll" data-target="#main-nav" id="home">
  <!--Nav bar  -->
  <nav class="navbar navbar-expand-lg bg-dark navbar-dark fixed-top">
    <div class="container">
      <a href="#" class="navbar-brand">CraftBoab</a>
      <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a href="#home" class="nav-link">Home</a>
          </li>
          <li class="nav-item">
            <a href="#introduction" class="nav-link">Introduction</a>
          </li>
          <li class="nav-item">
            <a href="#about" class="nav-link">About</a>
          </li>
          <div class="mr-2">
            <li class="nav-item">
              <script>
              function signup() {
                location.href = "signup.php" ;
              }
              </script>
              <form class="form-inline ml-auto">
                <button class="btn btn-outline-primary my-2 my-sm-0" type="button" onclick="signup()">Sign Up</button>
              </form>
            </li>
          </div>
        </ul>
      </div>
    </div>
  </nav>
  <header id="home-section">
    <div>
        <div class="home-inner container">
          <div class="row">
            <div class="col-lg-8 d-none d-lg-block">
              <h1 class="display-4">
                <strong>Chat Place</strong>
              </h1>
              <div class="d-flex">
                <div class="p-4 align-self-start">
                  <i class="fas fa-check fa-2x"></i>
                </div>
                <div class="p-4 align-self-end">
                  <h4>Communication tool</h4>
                </div>
              </div>
            </div>

            <!-- sign up -->
            <div class="col-lg-4">
              <div class="card bg-primary text-center card-form">
                <div class="card-body">
                  <h3>Log In</h3>
                  <hr>
                  <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      <p>Email</p>
                      <input type="text" name="email" class="form-control form-control-lg" value="<?php print(htmlspecialchars($_['email'], ENT_QUOTES)); ?>" />
                      <?php if($error['login'] === 'blank'): ?>
                        <p class="error">* Please fill out Email</p>
                      <?php endif; ?>
                    </div>
                    <div class="form-group">
                      <p>Password</p>
                      <input type="password" name="password" class="form-control form-control-lg" value="<?php print(htmlspecialchars($_POST['password'], ENT_QUOTES)); ?>" />
                      <?php if($error['login'] === 'failed'): ?>
                        <p class="error">* Please make sure your password</p>
                      <?php endif; ?>
                    </div>

                    <dl>
                      <dt>Record login information</dt>
                      <dd>
                        <input id="save" type="checkbox" name="save" value="on">
                        <label for="save">Automatically log in next time</label>
                      </dd>
                    </dl>
                    <input type="submit" value="Submit" class="btn btn-outline-light btn-block">
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </header>

  <section id="introduction">
    <div class="lead container">
      <div class="row">
        <div class="col py-5">
          <h1>Introduction</h1>
          <br>
            <h4>使用目的:　社内チャット</h4>
             <br>
             <p>:アプリケーションについて</p>
             このアプリは部署別など小さなコミニティー内でのコミニティーツールとして開発しました。<br>
             sign upまたはlog in後チャット形式でメッセージを投稿する事ができます。<br>
             送られたメッセージに対しての返信機能、削除機能が備わっています。<br>
             その他機能としてページネーション、投稿内容詳細表示が備わっています。<br>
             サンプルとして下記のアカウントを用意していますので1度使用して頂ければ幸いです。<br>
             user name: sample<br>
             E-mail: sample1@gmail.com <br>
             Password: 1111<br>
             <br>
             使用した言語:<br>
             HTML、CSS、PHP、MySQL、Bootstrap
           </p>
        </div>
      </div>
    </div>
  </section>

  <section id="about" class="bg-primary">
  <div class="container">
    <div class="row">
      <div class="col text-center py-5">
        <h1 class="display-4">About this service</h1>
        <p class="lead">
          This service allows you to communicate with your coworkers in your working place.</p>
      </div>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="bg-dark">
  <div class="container">
    <div class="row">
      <div class="col text-center py-4">
        <h3>CraftBoab</h3>
        <p>Copyright &copy;
          <span id="year"></span>
        </p>
      </div>
    </div>
  </div>
</footer>



  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
