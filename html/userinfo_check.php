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

$user_id = $_SESSION['member_name'];
$user_pass = $_POST['user_pass'];
$index = $_POST['index'];
// $user_pw = $_POST['user_pw'];

	$q = "SELECT * FROM person WHERE password='$user_pass' and id='$user_id'";

	$result = $mysqli->query( $q);

	if($result->num_rows>=1)
	  $message = "existed";
		else {
			$message = "nopass";
		}

		if($user_pass == '')
		$message = "blank";
	// $message = 'dsfs';
	echo $message;


?>
