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
  <p>Please select Product name</p>
  <a href="pro_list.php">Back</a>

</body>
</html>
