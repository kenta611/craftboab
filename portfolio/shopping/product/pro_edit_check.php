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
$pro_code = $post['code'];
$pro_name=$post['name'];
$pro_price=$post['price'];
$pro_gazou_name_old=$post['gazou_name_old'];
$pro_gazou=$_FILES['gazou'];

if($pro_name==''){
  print'Type Product Name<br/>';
}else{
  print'Product name: ';
  print $pro_name;
  print'<br/>';
}

if(preg_match('/[0-9]/',$pro_price)==0){
  print 'use half-width character<br/>';
}else{
  print 'Price: ';
  print '$';
  print $pro_price;
  print '<br/>';
}

if($pro_gazou['size']>0){
  if($pro_gazou['size'>1000000]){
    print 'Please choose small size photo';
  }else{
    move_uploaded_file($pro_gazou['tmp_name'],'./gazou/'.$pro_gazou['name']);
    print '<img src="./gazou/'.$pro_gazou['name'].'">';
    print '<br/>';
  }
}

if($pro_name=='' || preg_match('/[0-9]/',$pro_price)==0 || $pro_gazou['size']>1000000){
  print '<form>';
  print '<input type="button" onclick="history.back()" value="Back">';
  print '</form>';
}else{
  print 'Edit above product<br/>';
  print '<form method="post" action="pro_edit_done.php">';
  print '<input type="hidden" name="code" value="'.$pro_code.'">';
  print '<input type="hidden" name="name" value="'.$pro_name.'">';
  print '<input type="hidden" name="price" value="'.$pro_price.'">';
  print '<input type="hidden" name="gazou_name_old" value="'.$pro_gazou_name_old.'">';
  print '<input type="hidden" name="gazou_name" value="'.$pro_gazou['name'].'">';
  print '<br/>';
  print '<input type="button" onclick="history.back()" value="Back">';
  print '<input type="submit" value="submit">';
  print '</form>';
}

?>
</body>
</html>
