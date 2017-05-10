<?php

$DB['host'] = 'localhost';
$DB['db'] = 'test';
$DB['id'] = 'root';
$DB['pw'] = '1234';

$mysqli = new mysqli($DB['host'], $DB['id'], $DB['pw'], $DB['db']);
if (mysqli_connect_error()) {
    exit('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
}

$user_id = $_POST['user_id'];
$user_pw = $_POST['user_pw'];
$user_sex = $_POST['user_sex'];

$user_year = $_POST['user_year'];
$user_month = $_POST['user_month'];
$user_day = $_POST['user_day'];

$input_birth = "$user_year"."-"."$user_month"."-"."$user_day";

$q = "INSERT INTO person ( id, password, sex, birth )
VALUES ( '$user_id', '$user_pw', '$user_sex', '$input_birth' )";

$mysqli->query($q);
$mysqli->close();

echo "success";


?>
