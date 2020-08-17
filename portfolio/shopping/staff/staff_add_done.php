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
  require_once('../common/common.php');

  $post=sanitize($_POST);
  $staff_name= $post['name'];
  $staff_pass= $post['pass'];

  $dsn= 'mysql:dbname=shop;host=localhost;charset=utf8';
  $user= 'root';
  $password= 'root';
  $dbh= new PDO($dsn, $user, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql ='INSERT INTO mst_staff(name,password) VALUE (?,?)';
  $stmt= $dbh->prepare($sql);
  $data[]= $staff_name;
  $data[]= $staff_pass;
  $stmt->execute($data);

  $dbh= null;

  print 'adding ';
  print $staff_name;
  print '<br/>';
}catch(Exception $e){
  print 'I am sorry to inconvenient';
  exit();
}

?>

<a href="staff_list.php">Back</a>

</body>
</html>
