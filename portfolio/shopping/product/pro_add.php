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
  Add Product<br/>
  <br/>
  <form method="post" action="pro_add_check.php" enctype="multipart/form-data">
    Type product name<br/>
    <input type="text" name="name"style="width:200px"><br/>
    Type product price<br/>
    <input type="text" name="price" style="width:50px"><br/>
    Select your photo<br/>
    <input type="file" name="gazou" style="width:400px"><br/>
    <br/>
    <input type="button" onclick="history.back()" value="Back">
    <input type="submit" value="Submit">
  </form>
</body>
</html>
