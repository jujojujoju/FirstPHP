<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/preset.php';
include $_SERVER['DOCUMENT_ROOT'].'/header.php';

$send_idx = $_POST['message_idx'];
$index = $_POST['form_index'];
$q = "SELECT * from message where send_idx='$send_idx'";
$result = $mysqli->query($q);
$data = $result->fetch_array(MYSQLI_BOTH);
?>
<div class="board">
<?php if($index == 1) : ?>
<div class="panel panel-success">
<?php else : ?>
  <div class="panel panel-warning">
  <?php endif?>
  <div class="panel-heading">
    <div class="row">
      <?php if($index ==1) :?>
      <div class="col-md-2">FROM</div>
      <div class="col-md-2"><?php echo $data['from_name']; ?></div>
    <?php else :?>
    <div class="col-md-2">TO</div>
    <div class="col-md-2"><?php echo $data['to_name']; ?></div>
    <?php endif?>
    </div>
  </div>
  <div class="panel-heading">
    <div class="row">
      <div class="col-md-2">등록 일시</div>
      <div class="col-md-4"><?php echo $data['send_time']; ?></div>
    </div>
  </div>

  <div class="panel-body">
    <?php echo $data['message_text']; ?>
  </div>
</div>

<?php if($index == 1) : ?>
<a href="send_message.php?name=<?php echo $data['from_name']; ?>" class="btn btn-success">
  답장
</a>
  <?php endif?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/footer.php';?>
</div>
