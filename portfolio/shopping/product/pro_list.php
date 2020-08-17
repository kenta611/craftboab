<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['login'])==false){
  print 'You can not open this page before Login <br/>';
  print '<a href="../staff_login/staff_login.html">Login page</a>';
  exit();
}else{
  print 'Welcome ';
  print $_SESSION['staff_name'];
  print '<br/>';
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

    print '<form method="post" action="pro_branch.php">';
    while(true){
      $rec=$stmt->fetch(PDO::FETCH_ASSOC);
      if($rec==false){
        break;
      }
      print '<input type="radio" name="procode" value="'.$rec['code'].'">';
      print $rec['name'].'---';
      print '$';
      print $rec['price'];
      print '<br/>';
    }
    print '<input type="submit" name="disp" value="Display">';
    print '<input type="submit" name="add" value="add">';
    print '<input type="submit" name="edit" value="edit">';
    print'<input type="submit" name="delete" value="delete">';
    print '</form>';
  }catch(Exception $e){
    print 'I am sorry to inconvenient';
    exit();
  }

  ?>

  <br/>
  <a href="../staff_login/staff_top.php">Top Menu</a><br/>

</body>
</html>
