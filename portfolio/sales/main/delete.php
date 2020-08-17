<?php
session_start();
require('../dbconnect.php');

if (isset($_SESSION['id'])){
  $id = $_REQUEST['id'];

  $products = $db->prepare('SELECT * FROM products WHERE id=?');
  $products->execute(array($id));
  $product = $products->fetch();

  $del = $db->prepare('DELETE FROM products WHERE id=?');
  $del->execute(array($id));

}

header('Location: master_room.php');
exit();

?>
