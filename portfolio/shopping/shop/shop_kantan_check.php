<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['member_login'])==false){
  print 'Please log in before comming this page.';
  print '<a href="shop_list.php">Item List</a>';
  exit();
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
$code= $_SESSION['member_code'];

$dsn= 'mysql:dbname=shop;host=localhost;charset=utf8';
$user= 'root';
$password= 'root';
$dbh= new PDO($dsn, $user, $password);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql= 'SELECT name,email,zip,address,tel FROM dat_member WHERE code=?';
$stmt= $dbh->prepare($sql);
$data[]=$code;
$stmt->execute($data);
$rec= $stmt->fetch(PDO::FETCH_ASSOC);

$dbh= null;

$name2= $rec['name'];
$email= $rec['email'];
$zip= $rec['zip'];
$address= $rec['address'];
$tel= $rec['tel'];

print 'name<br/>';
print $name2;
print '<br/><br/>';

print 'email<br/>';
print $email;
print '<br/><br/>';

print 'zip code<br/>';
print $zip;
print '<br/><br/>';

print 'address<br/>';
print $address;
print '<br/><br/>';

print 'phone number<br/>';
print $tel;
print '<br/><br/>';

print '<form method="post" action="shop_kantan_done.php">';
print '<input type="hidden" name="name" value="'.$name2.'">';
print '<input type="hidden" name="email" value="'.$email.'">';
print '<input type="hidden" name="zip" value="'.$zip.'">';
print '<input type="hidden" name="address" value="'.$address.'">';
print '<input type="hidden" name="tel" value="'.$tel.'">';
print '<input type="button" onclick="history.back()" value="Back">';
print '<input type="submit" value="submit"><br/>';
print '</form>';
?>

</body>
</html>
