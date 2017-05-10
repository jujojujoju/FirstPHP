
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/preset.php';
include $_SERVER['DOCUMENT_ROOT'].'/header.php';
?>

<?php

  // setcookie('deleted_board_idx_'.$doc_idx, $data, time()+60, '/');
$board_array = array();

// echo $result->num_rows;
// $board_array =  unserialize(stripslashes($_COOKIE['deleted_board_idx_9']));
// echo $board_array['idx'];

$write_num = $_COOKIE['deleted_doc'];


// while($data = $result->fetch_array())

for($i=1;$i<=$write_num+1;$i++)
// while( $_COOKIE)
{
  $board_array =  unserialize(stripslashes($_COOKIE['deleted_board_idx_'.$i]));
  if(isset($board_array['idx']))
  {

   $idx = $board_array['idx'];
   $member_name = $board_array['member_name'];
   $subject = $board_array['subject'];
   $content = $board_array['content'];
   $date = $board_array['date'];
   $visit = $board_array['visit'];

   $q = "INSERT INTO board (idx, member_name, subject, content, date, visit)
     VALUES('$idx', '$member_name', '$subject', '$content', '$date', '$visit')";
     $mysqli->query( $q);
// echo $idx;
// echo $subject;ss
  }
    // echo $board_array['idx']."<br>";
    // echo "d";
 }
 header('Location: '.$url['root'].'/list.php');

// echo "fff";
include $_SERVER['DOCUMENT_ROOT'].'/footer.php';
?>
