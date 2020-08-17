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
  $staff_code= $_POST['code'];
  $dsn= 'mysql:dbname=shop;host=localhost;charset=utf8';
  $user= 'root';
  $password= 'root';
  $dbh= new PDO($dsn, $user, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql ='DELETE FROM mst_staff WHERE code=?';
  $stmt= $dbh->prepare($sql);
  $data[]= $staff_code;
  $stmt->execute($data);

  $dbh= null;

}catch(Exception $e){
  print 'I am sorry to inconvenient';
  exit();
}

?>

Deleted<br/>
<br/>
<a href="staff_list.php">Back</a>

</body>
</html>
