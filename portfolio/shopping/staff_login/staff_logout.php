<?php
session_start();
$_SESSION=array();
if(isset($_COOKIE[session_name()])==true){
  setcookie(session_name(),'',time()-42000,'/');
}
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Log out</title>
</head>
<body>
Log out<br/>
<br/>
<a href="../staff_login/staff_login.html">Login page</a>
</body>
</html>
