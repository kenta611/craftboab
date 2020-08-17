<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['member_login'])==false){
  print 'Hi Guest!';
  print '<a href="member_login.html">Sign in</a><br/>';
  print '<br/>';
}else{
  print 'Welcome ';
  print $_SESSION['member_name'];
  print '<a href="member_logout.php">Log out</a><br/>';
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
  $pro_code=$_GET['procode'];

  $dsn= 'mysql:dbname=shop;host=localhost;charset=utf8';
  $user= 'root';
  $password= 'root';
  $dbh= new PDO($dsn, $user, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql= 'SELECT name,price,gazou FROM mst_product WHERE code=?';
  $stmt= $dbh->prepare($sql);
  $data[]= $pro_code;
  $stmt->execute($data);

  $rec =$stmt->fetch(PDO::FETCH_ASSOC);
  $pro_name= $rec['name'];
  $pro_price=$rec['price'];
  $pro_gazou_name=$rec['gazou'];

  $dbh= null;

  if($pro_gazou_name==''){
    $disp_gazou='';
  }else{
    $disp_gazou='<img src="../product/gazou/'.$pro_gazou_name.'">';
  }
  print '<a href="shop_cartin.php?procode='.$pro_code.'">Add to cart</a><br/><br/>';

}catch(Exception $e){
  print 'I am sorry to inconvenience';
  exit();
}
?>

Display Products<br/>
<br/>
Product Code<br/>
<?php print $pro_code; ?>
<br/>
Product Name<br/>
<?php print $pro_name; ?>
<br/>
Price<br/>
$<?php print $pro_price; ?>
<br/>
<?php print $disp_gazou; ?>
<br/>
<br/>
<form>
  <input type="button" onclick="history.back()" value="Back">
</form>

</body>
</html>
