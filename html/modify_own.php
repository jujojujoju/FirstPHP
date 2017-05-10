<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/preset.php';
include $_SERVER['DOCUMENT_ROOT'].'/header.php';

$check_id = $_SESSION['member_name'];

if($new_password_check != '')
{
$q = "SELECT * FROM person WHERE id='$check_id' and
password='$check_password'";
$result = $mysqli->query($q);

if($result->num_rows>0)
{

  $q = "update person set password='$new_password_check' where id='$check_id'";
  $mysqli->query($q);

  $mysqli->close();

  echo "적용 되었습니다.";
}
else {
  echo "erroqr";
}
}
else {
  echo 'error';
}

include $_SERVER['DOCUMENT_ROOT'].'/footer.php';


?>
