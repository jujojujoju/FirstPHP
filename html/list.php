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

if(!isset($_SESSION['user_id']) && !isset($_SESSION['nongroup_id']))
$_SESSION['nongroup_id'] = mt_rand(-100000,0);


include $_SERVER['DOCUMENT_ROOT'].'/header.php';


?>

<div class="board">

<div class="btn-info" style="padding-left : 500px;">목록</div><br><br>

<?php


extract($_GET);

if(!isset($search_name))
{
  $q = "SELECT * FROM board";
$result = $mysqli->query( $q);
$total_record = $result->num_rows;
}
else
{

if($select == 'subject')
{
  $q = "SELECT * FROM board WHERE subject like '%$search_name%'";
  $result = $mysqli->query($q);
  $total_record = $result->num_rows;
}
else if($select == 'subject|content')
{
  $q = "SELECT * FROM board WHERE (subject like '%$search_name%') or (content like '%$search_name%')";
  $result = $mysqli->query($q);
  $total_record = $result->num_rows;
}
else
{

  $q = "SELECT * FROM board WHERE member_name like '%$search_name%'";
  $result = $mysqli->query($q);
  $total_record = $result->num_rows;
}


}
?>

<?php if($total_record==0) :?>
    글이 없습니다.
<?php else :?>

<?php

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
if(!isset($search_name))
{
$q = "SELECT * FROM board ORDER BY idx DESC LIMIT $start_record, $record_to_get";
$result = $mysqli->query($q);
}
else
{
  if($select == 'subject')
  {
  $q = "SELECT * FROM board WHERE subject like '%$search_name%' ORDER BY idx DESC LIMIT $start_record, $record_to_get";
  $result = $mysqli->query($q);
}
else if($select == 'subject|content')
{
  $q = "SELECT * FROM board WHERE (subject like '%$search_name%') or (content like '%$search_name%') ORDER BY idx DESC LIMIT $start_record, $record_to_get";
  $result = $mysqli->query($q);
}
else
{
  $q = "SELECT * FROM board WHERE member_name like '%$search_name%' ORDER BY idx DESC LIMIT $start_record, $record_to_get";
  $result = $mysqli->query($q);
}
}
?>
  <table class="table">
 <thead>
        <th>글번호</th>
        <th>제목</th>
        <th>작성자</th>
        <th>등록일시</th>
        <th>    </th>
        <th>조회 수</th>
    </thead>
<?php while($data = $result->fetch_array()) :?>
    <tr>
        <td class="col-md-2"><?php echo $data['idx']?></td>
<td class="col-md-3"><a href="http://<?php echo $_SERVER['HTTP_HOST'];?>/board_view.php?doc_idx=<?php echo $data['idx']; ?>" ><?php echo $data['subject']?></a></td>

        <td><?php echo $data['member_name']?></td>
      <td class="col-md-3"><?php echo $data['date']?></td>
      <td>    </td>
      <td>    <?php echo "\t".$data['visit']?></td>

    </tr>

<?php endwhile ?>
</table>

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
    <li><a href="/list.php?page=<?php echo $pre_page;?>&search_name=<?php echo $search_name;?>&select=<?php echo $select;?>">이전</a>
  <?php endif ?>
  <li>
  <?php for($i=$start_page;$i<=$end_page;$i++) :?>
   <a href="/list.php?page=<?php echo $i; ?>&search_name=<?php echo $search_name;?>&select=<?php echo $select;?>"><?php echo $i; ?></a>
  <?php endfor?>

  <?php if($now_block < $total_block) :?>
    <?php $post_page = ($now_block)*$page_per_block+1;?>
    <a href="/list.php?page=<?php echo $post_page;?>&search_name=<?php echo $search_name;?>&select=<?php echo $select;?>">다음</a>
  </li>
  <?php endif ?>

  </div><!-- .pagination -->
</div>

<?php endif?>

<div class="" style="text-align:center;">
<form name="search" method="get" action="list.php">

  <select name='select'>
  <option value='subject' <?php if($select=='subject')echo 'selected';?>>제목</option>
  <option value='subject|content' <?php if($select=='subject|content')echo 'selected';?>>제목+내용</option>
  <option value='name'  <?php if($select=='name')echo 'selected';?>>작성자</option>
  </select>
  <input type="text" name="search_name" value='<?php echo $search_name;?>'>
  <input type="submit" value="검색">
</form>
</div>
<?php
    include $_SERVER['DOCUMENT_ROOT'].'/footer.php';
?>


</div>
