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


extract($_POST);


include $_SERVER['DOCUMENT_ROOT'].'/header.php';
?>

<?php

extract($_GET);

$current_userid = $_SESSION['nongroup_id'];

if(isset($_SESSION['user_id']))
$current_userid = $_SESSION['user_id'];

// echo $current_userid;
// echo $_SESSION['member_name'];



$q = "insert into log (id, board_idx, date)
values ('$current_userid', '$doc_idx', now())";
$mysqli->query($q);


$q = "SELECT * FROM board WHERE idx = $doc_idx";
$result = $mysqli->query($q);
$data = $result->fetch_array();
$exception_data = $data['subject'];
if($_COOKIE['board_idx_'.$doc_idx] != $doc_idx)
{
  $new_visit = $data['visit']+1;
  $q = "update board set visit='$new_visit' where idx='$doc_idx'";
  $mysqli->query($q);

setcookie('board_idx_'.$doc_idx, $doc_idx, time()+60, '/');
}

?>
<div class="board">
<div class="panel panel-info">
  <div class="panel-heading">
    <div class="row">
      <div class="col-md-2">제목</div>
      <div class="col-md-2"><?php echo $data['subject']; ?></div>
    </div>
  </div>
  <div class="panel-heading">
    <div class="row">
      <div class="col-md-2">작성자</div>
      <div class="col-md-2"><?php echo $data['member_name']; ?></div>
    </div>
  </div>
  <div class="panel-heading">
    <div class="row">
      <div class="col-md-2">등록 일시</div>
      <div class="col-md-4"><?php echo $data['date']; ?></div>
    </div>
  </div>
  <div class="panel-heading">
    <div class="row">
      <div class="col-md-2">조회 수</div>
      <div class="col-md-4"><?php echo $data['visit']; ?></div>
    </div>
  </div>
  <div class="panel-body">
    <?php echo $data['content']; ?>
  </div>
</div>


<div class="row">

<div class="col-md-1">
<a type='button' class="btn btn-info" href="list.php">목록</a>
</div>

<div class="col-md-1">
<?php if( $_SESSION['member_name']==$data['member_name']) :?>
<form name='modify' method='post' action='/modify.php'>
<input type='hidden' name='doc_idx' value='<?php echo $doc_idx;?>'>
<input type='submit' class="btn btn-warning" value='수정'>
</form>
<?php endif?>
</div>

<div class="col-md-1">
<?php if( $_SESSION['member_name']==$data['member_name']) :?>
<form name='delete' method='post' action='delete.php'>
<input type='hidden' name='doc_idx' value='<?php echo $doc_idx;?>'>
<input type='submit' id='submit' class="btn btn-danger" value='삭제'>
</form>
<?php endif?>
</div>

</div>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script type="text/javascript">

  function page_move()
  {
    if($("#comment").val()!='')
    {
    var f=document.comment_write; //폼 name
    f.doc_idx.value = $("#doc_idx").val(); //POST방식으로 넘기고 싶은 값
    f.comment = $("#comment").val();
    f.submit();
    }
    else
    {
      	document.getElementById("comment").style.color = "red";
      	document.getElementById("submit").className= "btn btn-danger";
    }
  }

  $(document).ready(function()
  {
    $("#comment").focus(function()
  {
    document.getElementById("comment").style.color = "blue";
    document.getElementById("submit").className= "btn btn-info";
    return false;
  });

});

</script>
<?php
$q = "select name from comment where doc_idx='$doc_idx'";
$result = $mysqli->query($q);

$sex_man = 0;
$sex_woman = 0;
$array = array();
while($data = $result->fetch_array(MYSQLI_BOTH))
{
  $current_id = $data['name'];
  $qq = "select * from person where id='$current_id'";
  $current_result = $mysqli->query($qq);
  $person_data = $current_result->fetch_array(MYSQLI_BOTH);
    if($person_data['sex'] == 'man')
    $sex_man++;
    else if($person_data['sex'] == 'woman'){
      $sex_woman++;
    }
$nowyear = date("Y"); //현재년도
$age = $nowyear-(int)$person_data['birth']+1; //한국나이

 for($i=0;$i<8;$i++)
 {
   if(ceil($age/10)-1 == $i)
   {
      if(!isset($array[$i]))
      $array[$i] = 1;
      else
        $array[$i]++;
   }
 }

}
?>
<style>

.sex_box
{
  background-color: #77ddff;
  width:800px;
  height: 200px;
  border: 2px solid #77ddff;
  border-radius: 4px;
}
.ratebox
{
  width:5px;
  height: 10px;
  border : 1px solid #ccccff;
  background-color: #ccccff;
}
</style>

<div>
<br><br>
<form name="comment_write" class="text-center" action="comment.php" method="post">
<input id="doc_idx" name="doc_idx" value="<?php echo $doc_idx;?>" type="hidden">
<textarea id="comment"placeholder="댓글을 입력해 주세요" name="comment" cols="100" rows="5"></textarea>
  <a href="javascript:page_move();"id="submit" class="btn btn-info">등록</a>
</form>
</div>

<?php
  $q = "SELECT * FROM comment where doc_idx='$doc_idx'";
$result = $mysqli->query( $q);
$total_record = $result->num_rows;


if( isset($page) ) {
    $now_page = $page;
}
else {
    $now_page = 1;
}
$record_per_page = 5;

$start_record = $record_per_page*($now_page-1);
$record_to_get = $record_per_page;

if( $start_record+$record_to_get > $total_record) {
  $record_to_get = $total_record - $start_record;
}

$q = "SELECT * FROM comment where doc_idx='$doc_idx' ORDER BY com_idx DESC LIMIT $start_record, $record_to_get";
$result = $mysqli->query($q);

 ?>

 <div name="comment">
 <?php
 while($data = $result->fetch_array(MYSQLI_BOTH)) : ?>

 <table class="table">

 <tr>
<td>
    <div class="row">
   <div class="col-md-6"><?php echo "작성자  ".$data['name'];?></div>
   <div style="margin-left:10%;" class="col-md-4"><?php echo "등록일시 : ".$data['date'];?></div>
 </div><div class="col-md-6"><?php echo "내용";?></div>
 <div style="margin-left:10%;"class="row"><?php echo $data['content'];?></div>
</td>
 </tr>
 </table>
 <?php endwhile?>

 </div>


 <div class="center" style="text-align:center;">
   <div class="pagination">
 <?php
 $page_per_block = 5;
 $now_block = ceil($now_page / $page_per_block);
 $total_page = ceil($total_record / $record_per_page);
 $total_block = ceil($total_page / $page_per_block);

 $start_page = ($now_block-1)*$page_per_block+1;
 $end_page = $now_block*$page_per_block;
 if($end_page>$total_page) {
   $end_page = $total_page;
 }

 ?>
 <?php if(1<$now_block ) :?>
 <?php  $pre_page = ($now_block-1)*$page_per_block;?>
   <li><a href="/board_view.php?doc_idx=<?php echo $doc_idx;?>&page=<?php echo $pre_page;?>">이전</a>
 <?php endif ?>
 <li>
 <?php for($i=$start_page;$i<=$end_page;$i++) :?>
  <a href="/board_view.php?doc_idx=<?php echo $doc_idx;?>&page=<?php echo $i;?>"><?php echo $i; ?></a>
 <?php endfor?>

 <?php if($now_block < $total_block) :?>
   <?php $post_page = ($now_block)*$page_per_block+1;?>
   <a href="/board_view.php?doc_idx<?php echo $doc_idx;?>&page=<?php echo $post_page;?>">다음</a>
 </li>
 <?php endif ?>

</div>
</div>

<?php
$q = "SELECT * FROM comment where doc_idx='$doc_idx'";
$result = $mysqli->query( $q);
if ($result->num_rows!=0) : ?>

<div  class="btn btn-info" style="margin-left : 40%;">누가 댓글을 썼을까요?</div><br><br>
<table class="sex_box">
  <tr style="border-bottom : 1px solid white;">
    <td style="padding-right:-80px;border-right:1px solid white;">남자</td>
    <td style="padding-left:80px;">
      <?php
      $rate = 100*$sex_man/($sex_woman+$sex_man);for($i=0;$i<$rate;$i++) : ?>
        <div class="ratebox" style="float : left;"></div>
      <?php endfor?>
      </td>
      <td><?php echo $rate."%";?></td>
  </tr>
  <tr>
    <td style="padding-right:-80px;border-right:1px solid white;">여자</td>
    <td style="padding-left:80px;">
      <?php
      $rate = 100*$sex_woman/($sex_woman+$sex_man);for($i=0;$i<$rate;$i++) : ?>
        <div class="ratebox" style="float : left;"></div>
      <?php endfor?>
      <td><?php echo $rate."%";?></td>
    </td>
  </tr>
</table>
<br>
<div>
<?php $sum = 0; for($i=0;$i<8;$i++) :?>

<?php $sum = $sum + $array[$i];?>

<?php endfor?>
</div>

<table class="sex_box">

  <?php for($j=0;$j<8;$j++) :?>
  <tr style="border-bottom : 1px solid white;">

    <?php if($j<=4) : ?>
    <td style="padding-right:-80px;border-right:1px solid white;"><?php echo $j."0 대";?></td>
    <td style="padding-left:80px;">
      <?php
      $rate = 100*$array[$j]/$sum; for($i=0;$i<$rate;$i++) : ?>
        <div class="ratebox" style="float : left;"></div>
      <?php endfor?>
      </td>
<td><?php echo $rate."%";?></td>
    <?php elseif ($j == 7) :?>
      <td style="padding-right:-80px;border-right:1px solid white;"><?php echo "50 대 이상";?></td>
      <td style="padding-left:80px;">
        <?php
        $rate = 100*($array[5]+$array[6]+$array[7])/$sum; for($i=0;$i<$rate;$i++) : ?>
          <div class="ratebox" style="float : left;"></div>
        <?php endfor?>
        </td>
<td><?php echo $rate."%";?></td>
    <?php endif?>
  </tr>
  <?php endfor?>

</table>


<br><br>

<?php endif?>
<div class="panel panel-warning message-box" style="height:300px;">
  <div class="panel-heading">추전 게시물</div>

<?php
$array = array();

$q = "select distinct id from log where board_idx='$doc_idx'";
$result = $mysqli->query($q);

 while($data = $result->fetch_array(MYSQLI_BOTH))
 {
   $current_data = $data['id'];
   $qq = "select distinct board_idx from log where id='$current_data'";
   $current_result = $mysqli->query($qq);
   while($current_data = $current_result->fetch_array(MYSQLI_BOTH))
   {
     $current_board_data = $current_data['board_idx'];
     if(!isset($array[$current_board_data]))
      $array[$current_board_data] = 1;
      else
        $array[$current_board_data] = $array[$current_board_data]+1;
   }
 }
 $ux = array();
 $q = "select max(board_idx) from log";
 $result = $mysqli->query($q);
 $data = $result->fetch_array(MYSQLI_BOTH);
for($i=1;$i<=$data['max(board_idx)'];$i++)
{
  if($array[$i]>4)
  array_push($ux,$array[$i]);
}
rsort($ux);
$new_ux = array_unique($ux);

$subject_array = array();
for($j=0;$j<count($new_ux);$j++)
{
  for($i=1;$i<=$data['max(board_idx)'];$i++)
  {
    if($array[$i]==$new_ux[$j])
      array_push($subject_array,$i);
  }
}
?>
<?php for($j=0;$j<count($subject_array);$j++) : ?>

  <?php
    $aaa = $subject_array[$j];
    $q = "select subject, idx from board where idx='$aaa'";
    $result = $mysqli->query($q);
    $data = $result->fetch_array();?>
    <!-- echo $data['subject']."<br>"; -->
    <?php if($exception_data!=$data['subject']) : ?>
      <div  style="border-bottom: .5px solid #faebcc;" class="panel-body">
<a href="http://<?php echo $_SERVER['HTTP_HOST'];?>/board_view.php?doc_idx=<?php echo $data['idx']; ?>" ><?php echo $data['subject']?></a><br>
</div>
    <?php endif ?>
<?php endfor ?>
</div>




<?php
    include $_SERVER['DOCUMENT_ROOT'].'/footer.php';
?>
</div>
