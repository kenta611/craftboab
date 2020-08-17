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

$name2=$post['onamae'];
$email=$post['email'];
$zip=$post['zip'];
$address=$post['address'];
$tel=$post['tel'];
$order= $post['order'];
$pass= $post['pass'];
$pass2= $post['pass2'];
$sex= $post['sex'];
$birth= $post['birth'];

$okflg=true;

if($name2==''){
  print 'Please type your name<br/><br/>';
  $okflg=false;
}else{
  print 'Name:<br/>';
  print $name2;
  print '<br/><br/>';
}

if(preg_match('/\A[\w\-\.]+\@[\w\-\.]+\.([a-z]+)\z/',$email)==0){
  print 'Please type E-mail address<br/><br/>';
  $okflg=false;
}else{
  print 'Email:<br/>';
  print $email;
  print '<br/><br/>';
}

if(preg_match('/\A[0-9]+\z/',$zip)==0){
  print 'Please type zipcode<br/><br/>';
  $okflg=false;
}else{
  print 'Zipcode:<br/>';
  print $zip;
  print '<br/><br/>';
}

if($address==''){
  print 'Please type your address<br/><br/>';
  $okflg=false;
}else{
  print 'Address:<br/>';
  print $address;
  print '<br/><br/>';
}

if(preg_match('/\A[0-9]+\z/',$tel)==0){
  print 'Plase type your Phone number<br/><br/>';
  $okflg=false;
}else{
  print 'Contact number:<br/>';
  print $tel;
  print '<br/><br/>';
}

if($order=='regist'){
  if($pass==''){
    print 'Please type your password<br/><br/>';
    print '<br/>';
    $okflg='false';
  }
  if($pass != $pass2){
    print 'Does not match confirmation password<br/>';
    print '<br/>';
    $okflg= 'false';
  }

  print 'sex<br/>';
  if($sex=='m'){
    print 'Man';
  }else{
    print 'Woman';
  }
  print '<br/><br/>';

  print 'Year of the birth<br/>';
  print $birth;
  print '<br/><br/>';
}

if($okflg==true){
print '<form method="post" action="shop_form_done.php">';
print '<input type="hidden" name="name" value="'.$name2.'">';
print '<input type="hidden" name="email" value="'.$email.'">';
print '<input type="hidden" name="zip" value="'.$zip.'">';
print '<input type="hidden" name="address" value="'.$address.'">';
print '<input type="hidden" name="tel" value="'.$tel.'">';
print '<input type="hidden" name="order" value="'.$order.'">';
print '<input type="hidden" name="pass" value="'.$pass.'">';
print '<input type="hidden" name="sex" value="'.$sex.'">';
print '<input type="hidden" name="birth" value="'.$birth.'">';
print '<input type="button" onclick="history.back()" value="Back">';
print '<input type="submit" value="submit"><br/>';
print '</form>';
}else{
  print '<form>';
  print '<input type="button" onclick="history.back()" value="Back">';
  print '</form>';
}

?>

</body>
</html>
