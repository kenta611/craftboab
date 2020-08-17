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
  Add staff<br/>
  <br/>
  <form method="post" action="staff_add_check.php">
    Type staff Name<br/>
    <input type="text" name="name"style="width:200px"><br/>
    Type your Password<br/>
    <input type="password" name="pass" style="width:100px"><br/>
    Confirm your Password<br/>
    <input type="password" name="pass2" style="width:100px"><br/>
    <br/>
    <input type="button" onclick="history.back()" value="Back">
    <input type="submit" value="Submit">
  </form>
</body>
</html>
