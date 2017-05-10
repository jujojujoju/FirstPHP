<?php
$DB['host'] = 'localhost';
$DB['db'] = 'test';
$DB['id'] = 'root';
$DB['pw'] = '1234';

$mysqli = new mysqli($DB['host'], $DB['id'], $DB['pw'], $DB['db']);
if (mysqli_connect_error()) {
    exit('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
}

if(!isset($_POST['is_ajax'])) exit;

$is_ajax=$_POST['is_ajax'];
$user_id = $_POST['user_id'];
// $user_pw = $_POST['user_pw'];

if(!$is_ajax)
 exit;

$q = "SELECT * FROM person WHERE id='$user_id'";

$result = $mysqli->query( $q);

if($result->num_rows>=1)
  $message = "existed";
  else if($user_id == '')
  $message = "blank";
// $message = 'dsfs';
echo $message;


?>
