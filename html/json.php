<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/preset.php';



header("Content-Type:application/json");

$q = "select * from person";
$result = $mysqli->query($q);




 while($data = $result->fetch_array())
 {



 echo json_encode($data);


 }


 ?>
