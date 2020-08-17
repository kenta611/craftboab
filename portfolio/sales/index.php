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

if (!empty($_POST)){
  $email = $_POST['email'];

  if($_POST['email'] !== '' && $_POST['password'] !== ''){
    $login = $db->prepare('SELECT * FROM master_member WHERE email=? AND password=?');
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

      header('Location: main/master_room.php');
      exit();
    }else {
      $error['login'] = 'failed';
    }
  }else {
    $error['login'] = 'blank';
  }
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
  <title>CraftBoab</title>

  <link rel="stylesheet" href="style.css" />
</head>
<body data-spy="scroll" data-target="#main-nav" id="home">
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top" id="main-nav">
    <div class="container">
      <a href="master_login.php" class="navbar-brand">CraftBoab</a>
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
          <li class="nav-item">
            <a href="#howto" class="nav-link">How to</a>
          </li>
          <li>
            <a href="#pic" class="nav-link">Picture</a>
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


  <!-- HOME SECTION -->
  <header id="home-section">
    <div>
      <div class="home-inner container">
        <div class="row">
          <div class="col-lg-8 d-none d-lg-block">
            <h1 class="display-4">
              <strong>Web site</strong> for each
              <strong>Salesperson</strong>
            </h1>
            <div class="d-flex">
              <div class="p-4 align-self-start">
                <i class="fas fa-check fa-2x"></i>
              </div>
              <div class="p-4 align-self-end">
                <h4>Easy to manage your custmer</h4>
              </div>
            </div>

            <div class="d-flex">
              <div class="p-4 align-self-start">
                <i class="fas fa-check fa-2x"></i>
              </div>
              <div class="p-4 align-self-end">
                <h4>Easy to organize your products</h4>
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
    <div class="display-4 container">
      <div class="row">
        <div class="col py-5">
          <h1>Introduction</h1>
          <br>
          <h5>この度は私のポートフォリオを拝見していただきありがとうございます。<br>
             簡単ではありますが自己紹介とこのサービスを作った経緯、サービスの使用方法ついてご説明させて貰います。<br>
             <br>
             :自己紹介<br>
             はじめまして、植田健太と申します。現在ロサンゼルスに拠点を構える水産卸売会社で4年間営業業務をしています。<br>
             <br>
             :経緯<br>
             主なターゲットは小売の営業業務をされている方、個人事業主の方に向けて作ったサービスです。<br>
             こちらのサービスで自社で取り扱う商品をお客様にビジュアル的にも分かりやすくご提示でき、新規商品もすぐにお客様にシェア出来るよう設計されています。<br>
             それによりお客様は商品内容不明による発注ミスを防げ、売り手も新規商品の参入を円滑にする事が出来ます。<br>
             <br>
             :使用方法<br>
             サービス利用にあたり２つのアカウントをご用意しました。<br>
             売り手のアカウント<br>
             E-mail: manage@gmail.com <br>
             Password: 1111<br>
             こちらからLog inすると新規アイテム追加項目があります。１度お試しして頂けると幸いです。追記された商品は直ぐに売り手のアカウントと買い手のアカウントに反映されます。<br>
             <br>
             買い手のアカウント<br>
             E-mail: customer@gmail.com<br>
             Password: 1111<br>
             こちらからLog inすると売り手のアカウントが取り扱う商品を一覧できます。各商品ごとに個数を選べるようになっていますので、<br>
             必要商品の必要個数を選んでもらい"Submit"すれば売り手のEmailアドレスへ発注内容を含んだメールを送信できます。<br>
             使用した言語:<br>
             HTML、CSS、PHP、MySQL、Bootstrap
           </h5>
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
            This service allows each sales person to integrate and manage customer's information and own products, and to provide customers with the latest information through this service.</p>
        </div>
      </div>
    </div>
  </section>

  <section id="howto" class="bg-light text-muted py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <img src="main/img/create-section1.jpg" alt="" class="img-fluid mb-3 rounded-circle">
        </div>
        <div class="col-md-6">
          <h3>How to Use this service</h3>
          <p>This service allow to manage your customers your products, and order control.</p>
          <p>This service has two pages for Sales person and customers. </p>
          <br>


          <div class="d-flex">
            <div class="p-4 align-self-start">
              <i class="fas fa-check fa-2x"></i>
            </div>
            <div>
              First of all please Log in to as a Sales person<br>
              Username: manage@gmail.com<br>
              Password: 1111
            </div>
            <div class="p-4 align-self-end">
              -Step1 Fill out products name<br>
              -Step2 Fill out products description<br>
              -Step3 Select products image<br>
              -Step4 Click "submit" button<br>
            </div>
          </div>

          <div class="d-flex">
            <div class="p-4 align-self-start">
              <i class="fas fa-check fa-2x"></i>
            </div>
            <div>
              Also try as a customer<br>
              Username: customer@gmail.com<br>
              Password: 1111
            </div>
            <div class="p-4 align-self-end">
              -Step1 Select amount of product<br>
              -Step2 After make sure your order, click "send" button<br>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="pic" class="mx-5">
    <div class="container">
      <div card-body>
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner pic">
            <div class="carousel-item active">
              <img src="main/img/church.jpeg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="main/img/create-section1.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="main/img/dog.jpeg" class="d-block w-100" alt="...">
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>

    </div>
  </section>

  <!-- FOOTER -->
  <footer id="main-footer" class="bg-dark">
    <div class="container">
      <div class="row">
        <div class="col text-center py-4">
          <h3>CraftBoab</h3>
          </p>
        </div>
      </div>
    </div>
  </footer>

<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
crossorigin="anonymous"></script>


</div>
</body>
</html>
