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
  $staff_code=$_GET['staffcode'];

  $dsn= 'mysql:dbname=shop;host=localhost;charset=utf8';
  $user= 'root';
  $password= 'root';
  $dbh= new PDO($dsn, $user, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql= 'SELECT name FROM mst_staff WHERE code=?';
  $stmt= $dbh->prepare($sql);
  $data[]= $staff_code;
  $stmt->execute($data);

  $rec =$stmt->fetch(PDO::FETCH_ASSOC);
  $staff_name= $rec['name'];

  $dbh= null;
}catch(Exception $e){
  print 'I am sorry to inconvenience';
  exit();
}
?>

Delete Staff<br/>
<br/>
Staff Code<br/>
<?php print $staff_code; ?>
<br/>
Staff Name<br/>
<?php print $staff_name; ?>
<br/>
Are your sure to delete this staff?<br/>
<br/>
<form method="post" action="staff_delete_done.php">
  <input type="hidden" name="code" value="<?php print $staff_code; ?>">
  <input type="button" onclick="history.back()" value="Back">
  <input type="submit" value="submit">
</form>

</body>
</html>
