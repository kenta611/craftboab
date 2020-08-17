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
  $pro_code = $post['code'];
  $pro_name= $post['name'];
  $pro_price= $post['price'];
  $pro_gazou_name_old=$post['gazou_name_old'];
  $pro_gazou_name=$post['gazou_name'];

  $dsn= 'mysql:dbname=shop;host=localhost;charset=utf8';
  $user= 'root';
  $password= 'root';
  $dbh= new PDO($dsn, $user, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = 'UPDATE mst_product SET name=?,price=?,gazou=? WHERE code=?';
  $stmt= $dbh->prepare($sql);
  $data[]= $pro_name;
  $data[]= $pro_price;
  $data[]= $pro_gazou_name;
  $data[]= $pro_code;
  $stmt->execute($data);

  $dbh= null;

  if($pro_gazou_name_old != $pro_gazou_name){
    if($pro_gazou_name_old !=''){
      unlink('./gazou/'.$pro_gazou_name_old);
    }
  }


  print 'Modified';
  print '<br/>';
}catch(Exception $e){
  print 'I am sorry to inconvenient';
  exit();
}

?>

<a href="pro_list.php">Back</a>

</body>
</html>
