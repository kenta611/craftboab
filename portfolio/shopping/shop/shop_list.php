<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['member_login'])==false){
  print 'Hi guest! ';
  print '<a href="member_login.html">Sign in</a><br/>';
  print '<br/>';
}else{
  print 'Welcome ';
  print $_SESSION['member_name'];
  print '<a href="member_logout.php">Log out</a><br/>';
  print '<br/>';

}

 ?>

 <!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>shop</title>
</head>
<body>

  <?php

  try{
    $dsn= 'mysql:dbname=shop;host=localhost;charset=utf8';
    $user='root';
    $password='root';
    $dbh= new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql= 'SELECT code,name,price FROM mst_product WHERE 1';
    $stmt= $dbh->prepare($sql);
    $stmt->execute();

    $dbh= null;

    print 'Show products list<br/><br/>';

    while(true){
      $rec=$stmt->fetch(PDO::FETCH_ASSOC);
      if($rec==false){
        break;
      }
      print '<a href="shop_product.php?procode='.$rec['code'].'">';
      print $rec['name'].'---';
      print '$';
      print $rec['price'];
      print '</a>';
      print '<br/>';
    }

    print '<br/>';
    print '<a href="shop_cartlook.php">Go to Cart</a><br/>';

  }catch(Exception $e){
    print 'I am sorry to inconvenience';
    exit();
  }

  ?>

</body>
</html>
