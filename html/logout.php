<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/preset.php';


?>
<?php
$_SESSION['is_logged'] = 'NO';
$_SESSION['member_name'] = '';

session_unset($_SESSION['is_logged']);
session_unset($_SESSION['member_name']);

session_destroy();


include $_SERVER['DOCUMENT_ROOT'].'/header.php';?>
<div class="board">
<div style="padding-left : 40%; font-size : 150%; color : #ff6666">
로그 아웃 성공
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/footer.php';?>
</div>
