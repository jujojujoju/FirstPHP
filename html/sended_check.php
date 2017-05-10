<?php
session_start();
$DB['host'] = 'localhost';
$DB['db'] = 'test';
$DB['id'] = 'root';
$DB['pw'] = '1234';

$mysqli = new mysqli($DB['host'], $DB['id'], $DB['pw'], $DB['db']);
if (mysqli_connect_error()) {
    exit('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
}

$user_id = $_POST['user_id'];
$index = $_POST['index'];
$message_text = $_POST['messagetext'];
// $user_pw = $_POST['user_pw'];

if($index == 1)
{
$q = "SELECT * FROM person WHERE id='$user_id'";

$result = $mysqli->query( $q);

if($result->num_rows>=1)
{
  $message = 'exist';
}
else {
  $message = 'fff';
}

echo $message;


}
else {
  $sessionmember = $_SESSION['member_name'];
  $q = "insert into message (from_name, to_name, message_text, send_time)
  values ('$sessionmember', '$user_id', '$message_text', now())";

  $mysqli->query( $q);


  require_once $_SERVER['DOCUMENT_ROOT'].'/preset.php';
  include $_SERVER['DOCUMENT_ROOT'].'/header.php';

  echo 전송완료;


  include $_SERVER['DOCUMENT_ROOT'].'/footer.php';
}




?>
