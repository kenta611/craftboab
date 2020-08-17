<?php
session_start();
session_regenerate_id(true);
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
require_once('../common/common.php');

$post=sanitize($_POST);

$name2= $post['name'];
$email= $post['email'];
$zip= $post['zip'];
$address= $post['address'];
$tel= $post['tel'];
$order= $post['order'];
$pass= $post['pass'];
$sex= $post['sex'];
$birth= $post['birth'];

print 'Hi '.$name2.'<br/><br/>';
print 'Thank you for your order.<br/><br/>';
print 'Plase make sure confirmation mail. It sent to ' .$email. '<br/><br/>';
print 'Products are ship to below address<br/><br/>';
print $address.' '.$zip.'<br/><br/>';
print 'cell:'.$tel.'<br/><br/>';

$honbun='';
$honbun.= 'Hi '.$name2."\n \n Thank you for your order \n";
$honbun.= "\n";
$honbun.= "Your order \n";
$honbun .= "---------------\n";

$cart= $_SESSION['cart'];
$kazu= $_SESSION['kazu'];
$max= count($cart);

$dsn= 'mysql:dbname=shop;host=localhost;charset=utf8';
$user= 'root';
$password= 'root';
$dbh= new PDO($dsn, $user, $password);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

for($i=0; $i<$max; $i++){
  $sql= 'SELECT name,price FROM mst_product WHERE code=?';
  $stmt= $dbh->prepare($sql);
  $data[0]= $cart[$i];
  $stmt->execute($data);

  $rec= $stmt->fetch(PDO::FETCH_ASSOC);
  $name= $rec['name'];
  $price= $rec['price'];
  $kakaku[]= $price;
  $suryo= $kazu[$i];
  $shokei= $price * $suryo;

  $honbun.= $name.' ';
  $honbun.= '$'.$price.' x ';
  $honbun.= $suryo.' pc= ';
  $honbun.= '$'.$shokei."\n";
}

$sql='LOCK TABLES dat_sales WRITE,dat_sales_product WRITE, dat_member WRITE';
$stmt= $dbh->prepare($sql);
$stmt->execute();

$lastmembercode=0;
if($order=='regist'){
  $sql='INSERT INTO dat_member(password,name,email,zip,address,tel,sex,born) VALUE(?,?,?,?,?,?,?,?)';
  $stmt= $dbh->prepare($sql);
  $data= array();
  $data[]= md5($pass);
  $data[]= $name2;
  $data[]= $email;
  $data[]= $zip;
  $data[]= $address;
  $data[]= $tel;
  if($sex=='m'){
    $data[]=1;
  }else{
    $data[]=2;
  }
  $data[]= $birth;
  $stmt->execute($data);

  $sql='SELECT LAST_INSERT_ID()';
  $stmt=$dbh->prepare($sql);
  $stmt->execute();
  $rec= $stmt->fetch(PDO::FETCH_ASSOC);
  $lastmembercode= $rec['LAST_INSERT_ID()'];
}

$sql= 'INSERT INTO dat_sales(code_member,name,email,zip,address,tel) VALUE(?,?,?,?,?,?)';
$stmt= $dbh->prepare($sql);
$data= array();
$data[]=$lastmembercode;
$data[]=$name2;
$data[]=$email;
$data[]=$zip;
$data[]=$address;
$data[]=$tel;
$stmt->execute($data);

$sql= 'SELECT LAST_INSERT_ID()';
$stmt= $dbh->prepare($sql);
$stmt->execute();
$rec= $stmt->fetch(PDO::FETCH_ASSOC);
$lastcode= $rec['LAST_INSERT_ID()'];

print '<br/><br/>';


for($i=0; $i<$max; $i++){
  $sql= 'INSERT INTO dat_sales_product(code_sales,code_product,price,quantity) VALUE(?,?,?,?)';
  $stmt= $dbh->prepare($sql);
  $data= array();
  $data[]=$lastcode;
  $data[]=$cart[$i];
  $data[]=$kakaku[$i];
  $data[]=$kazu[$i];
  $stmt->execute($data);
}

$sql= 'UNLOCK TABLES';
$stmt= $dbh->prepare($sql);
$stmt->execute();

$dbh =null;

if($order=='regist'){
  print 'Registered<br/>';
  print 'Now you can log in as membership<br/>';
  print 'Make it easy shopping<br/>';
}

$honbun.="Free delivery\n";
$honbun.="-------------\n";
$honbun.="\n";
$honbun.="Please pay to below account.\n";
$honbun.="Sample Bank  check account: 1234567890\n";
$honbun.="After received, it will be packed and delivery.\n";
$honbun.="\n";
$honbun.="øøøøøøøøøøøøøøøøø\n";
$honbun.="~Sample company~\n";
$honbun.="\n";
$honbun.="123 Sample Street Los Angels, CA,90013";
$honbun.="cell: 123-456-7890";
$honbun.="email: sample@gmail.com\n";
$honbun.="øøøøøøøøøøøøøøøøø\n";
$honbun.="\n";

if($order=='regist'){
  $honbun.="Registered\n";
  $honbun.="Now you can log in as membership\n";
  $honbun.="Make it easy shopping\n";
  $honbun.="\n";
}

//print "<br/>";
//print nl2br($honbun);

$title= 'Thank you for your order.';
$header= 'From: kenta_u611@gmail.com';
$honbun= html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
mb_language('Japanese');
mb_internal_encoding('UTF-8');
mb_send_mail($email, $title, $honbun, $header);

$title= 'You got order from'.$name;
$header= 'From:'.$email;
$honbun= html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
mb_language('Japanese');
mb_internal_encoding('UTF-8');
mb_send_mail('kenta_u611@gmail.com', $title, $honbun, $header);

}catch(Exception $e){
  print 'I am sorry to inconvenience';
  exit();
}
?>

<br/>
<a href="shop_list.php">Product list</a>
</body>
</html>
