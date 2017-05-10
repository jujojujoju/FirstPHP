<?php
session_start();

$p = array();
$path['root'] = $_SERVER['DOCUMENT_ROOT'].'/';

require_once ($path['root'].'config.php');

$mysqli = new mysqli($DB['host'], $DB['id'], $DB['pw'], $DB['db']);
if (mysqli_connect_error()) {
    exit('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
}

$url = array();
$url['root'] = 'http://'.$_SERVER['HTTP_HOST'].'/';
//
extract($_POST);
?>

<?php if(!isset($_SESSION['member_name'])) : ?>
<script>
alert("회원으로 로그인 하십시오");
location.replace("login.php");
</script>
<?php exit();?>

<?php endif?>
