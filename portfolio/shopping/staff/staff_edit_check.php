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

require_once('../common/common.php');

$post=sanitize($_POST);
$staff_code=$post['code'];
$staff_name=$post['name'];
$staff_pass=$post['pass'];
$staff_pass2=$post['pass2'];

if($staff_name==''){
  print'Type your Name<br/>';
}else{
  print'Staff name: ';
  print $staff_name;
  print'<br/>';
}

if($staff_pass==''){
  print'Type your Password<br/>';
}

if($staff_pass!=$staff_pass2){
  print'Does not match Password<br/>';
}

if($staff_name==''|| $staff_pass=='' || $staff_pass!=$staff_pass2){
  print'<form>';
  print'<input type="button" onclick="history.back()" value="Back">';
  print'</form>';
}else{
  $staff_pass=md5($staff_pass);
  print '<form method="post" action="staff_edit_done.php">';
  print '<input type="hidden" name="code" value="'.$staff_code.'">';
  print '<input type="hidden" name="name" value="'.$staff_name.'">';
  print '<input type="hidden" name="pass" value="'.$staff_pass.'">';
  print '<br/>';
  print '<input type="button" onclick="history.back()" value="Back">';
  print '<input type="submit" value="submit">';
  print '</form>';
}

?>
</body>
</html>
