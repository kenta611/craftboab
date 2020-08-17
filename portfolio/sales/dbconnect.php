<?php
try{
  $db = new PDO('mysql:dbname=orderdb;host=104.197.201.17;charset=utf8','root','portfolio');
} catch(PDOException $e){
  print('Date Base connect error:' . $e->getMessage());
}
