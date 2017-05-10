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
$user_pw = $_POST['user_pw'];
$box_data = $_POST['box_data'];

if(!$is_ajax)
 exit;

$q = "SELECT * FROM person WHERE id='$user_id' and password='$user_pw'";
$result = $mysqli->query( $q);
$data = $result->fetch_array(MYSQLI_BOTH);
if($result->num_rows>=1)
{

  session_start();
  session_unset($_SESSION['nongroup_id']);
	$_SESSION['is_logged'] = 'YES';
	$_SESSION['member_name'] = $user_id;
  $_SESSION['user_id'] = $data['idx'];
if($box_data == 1)
  setcookie('user_id',$user_id,time()+3600,'/');
  else {
  setcookie('user_id', '', time()-3600, '/');
  }
  // setcookie('user_name',$members[$user_id]['name']);

  $message = "success";
}
else
{
  if($user_id == '')
    $message = 'noid';

  else if($user_pw == '')
      $message = 'nopass';

  else
  $message = "error";
 // echo 'error';
    // $message = "error";
}
// $message = 'dsfs';
// if($box_data == 1)
echo $message;


?>
