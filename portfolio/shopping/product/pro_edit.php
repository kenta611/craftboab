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
  $pro_price = $rec['price'];
  $pro_gazou_name_old=$rec['gazou'];

  $dbh= null;

  if($pro_gazou_name_old==''){
    $disp_gazou='';
  }else{
    $disp_gazou='<img src="./gazou/'.$pro_gazou_name_old.'">';
  }
}catch(Exception $e){
  print 'I am sorry to inconvenience';
  exit();
}
?>

Edit Product<br/>
<br/>
Product Code<br/>
<?php print $pro_code; ?>
<br/>
<br/>
<form method="post" action="pro_edit_check.php" enctype="multipart/form-data">
  <input type="hidden" name="code" value="<?php print $pro_code; ?>">
  <input type="hidden" name="gazou_name_old" value="<?php print $pro_gazou_name_old; ?>">
  Product Name<br/>
  <input type="text" name="name" style="width:200px" value="<?php print $pro_name; ?>"><br/>

  Price<br/>
  <input type="text" name="price" style="width:50px" value="<?php print $pro_price; ?>"><br/>
  <br/>
  <?php print $disp_gazou; ?>
  <br/>
  Please select picture<br/>
  <input type="file" name="gazou" style="width:400px"><br/>
  <br/>
  <input type="button" onclick="history.back()" value="Back">
  <input type="submit" value="submit">
</form>

</body>
</html>
