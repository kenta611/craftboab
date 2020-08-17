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
  <title>Top Menu</title>
</head>
<body>
  Staff top menu<br/>
  <br/>
  <a href="../staff/staff_list.php">Manage staff</a><br/>
  <br/>
  <a href="../product/pro_list.php">Manage product</a><br/>
  <br/>
  <a href="staff_logout.php">Log out</a><br/>

</body>
</html>
