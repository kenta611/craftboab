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
    if(isset($_SESSION['cart'])==true){
      $cart= $_SESSION['cart'];
      $kazu= $_SESSION['kazu'];
      $max=count($cart);
    }else{
      $max= 0;
    }

    if($max==0){
      print 'There is no product in the cart<br/>';
      print '<br/>';
      print '<a href="shop_list.php">Back</a>';
      exit();
    }

    $dsn= 'mysql:dbname=shop;host=localhost;charset=utf8';
    $user= 'root';
    $password= 'root';
    $dbh= new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    foreach($cart as $key=> $val){
      $sql ='SELECT code,name,price,gazou FROM mst_product WHERE code=?';
      $stmt=$dbh->prepare($sql);
      $data[0]=$val;
      $stmt->execute($data);

      $rec= $stmt->fetch(PDO::FETCH_ASSOC);

      $pro_name[]= $rec['name'];
      $pro_price[]= $rec['price'];
      if($rec['gazou']==''){
        $pro_gazou[]='';
      }else{
        $pro_gazou[]='<img src="../product/gazou/'.$rec['gazou'].'">';
      }
    }
    $dbh= null;

  }catch(Exception $e){
    print 'I am sorry to inconvenience';
    exit();
  }
  ?>

  Your Cart<br/>
  <br/>
  <form method='post' action="kazu_change.php">
    <table border="1">
      <tr>
        <td>Product</td>
        <td>Product photo</td>
        <td>Price</td>
        <td>Amount</td>
        <td>Total</td>
        <td>Delete</td>
      </tr>
      <?php for($i=0; $i<$max; $i++){ ?>
        <tr>
          <td><?php print $pro_name[$i];?></td>
          <br/>
          <td><?php print $pro_gazou[$i];?></td>
          <br/>
          <td><?php print '$'.$pro_price[$i];?></td>
          <br/>
          <td><input type="text" name="kazu<?php print $i; ?>" value="<?php print $kazu[$i]; ?>"></td>
          <td><?php print '$'.$pro_price[$i] * $kazu[$i]; ?></td>
          <td><input type="checkbox" name="sakujo<?php print $i; ?>"></td>
        </tr>
        <br/>
      <?php } ?>
    </table>
    <input type="hidden" name="max" value="<?php print $max; ?>">
    <input type="submit" value="Change amount"><br/>
    <input type="button" onclick="history.back()" value="Back">
  </form>
  <br/>
  <a href="shop_form.html">Buy now</a><br/>

<?php
if(isset($_SESSION["member_login"])==true){
  print '<a href="shop_kantan_check.php">Order page for membership</a><br/>';
}
?>

</body>
</html>
