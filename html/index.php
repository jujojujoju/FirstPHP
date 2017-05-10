<?php require_once $_SERVER['DOCUMENT_ROOT'].'/header.php';?>

<!DOCTYPE HTML>
<html>
<head>
<title>start</title>
 <meta charset="utf-8">

<?php if(!isset($_COOKIE['popup'])) : ?>
<script language="javascript">
function OpenWindow()
{
    window.open("popup.php","_blank","top=50,left=50,width=470,height=340,resizable=1,scrollbars=no");
}
</script>
<?php endif ?>

</head>
<body onload="OpenWindow()">

<div class="board">
  <br><br><br><br><br><br>
<h1>안녕하십니까</h1>
</div>

</body>

<?php require_once 'footer.php' ;?>

</html>
