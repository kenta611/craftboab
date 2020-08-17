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

  if(isset($_SESSION['cart'])==true){
    $cart= $_SESSION['cart'];
    $kazu= $_SESSION['kazu'];
    if(in_array($pro_code,$cart)==true){
      print 'This product has already been selected<br/>Go to Cart and change amount<br/>';
      print '<a href="shop_list.php">Back</a>';
      exit();
    }
  }
  $cart[]=$pro_code;
  $kazu[]=1;
  $_SESSION['cart']=$cart;
  $_SESSION['kazu']=$kazu;
}catch(Exception $e){
  print 'I am sorry to inconvenience';
  exit();
}
?>

Added selected item<br/>
<br/>
<a href="shop_list.php">Back to the Product list</a>
</body>
</html>
