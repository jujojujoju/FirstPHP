<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/preset.php');

 $encryped_pass = sha1($user_pass);


$q = "SELECT * FROM person WHERE id='$user_id' and
password='$encryped_pass'";

$result = $mysqli->query( $q);

if($result->num_rows>=1)
{

    $row = $result->fetch_array(MYSQLI_BOTH);

    if( $row['password'] == $encryped_pass )
	{
	$_SESSION['is_logged'] = 'YES';
	$_SESSION['user_id'] = $user_id;
	$_SESSION['member_name'] = $row['id'];
  header("Progma:no-cache");
  header("Cache-Control:no-cache,must-revalidate");

	header('Location: '.$url['root'].'/login_done.php');
        exit();
	}

	else
	{
      		echo 'wrong password';
   	 }

}
else
{
    echo 'error';
}

?>
