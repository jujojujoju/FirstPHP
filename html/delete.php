<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/preset.php';
include $_SERVER['DOCUMENT_ROOT'].'/header.php';

?>
<?php

//
// $q = "SELECT max(idx) FROM board";
// $result = $mysqli->query( $q);
// $maxdata = $result->fetch_array(MYSQLI_BOTH);

$q = "select * FROM board WHERE idx=$doc_idx";
$result = $mysqli->query($q);
$data = $result->fetch_array(MYSQLI_BOTH);
$serialized_data = serialize($data);
//
// $serialized_data['max'] = $maxdata['max(idx)'];

$q = "DELETE FROM board WHERE idx=$doc_idx";
$result = $mysqli->query($q);



if ($result==false) {
    // $_SESSION['delete_status'] = 'NO';
    echo "삭제 실패";
}
else {
    // $_SESSION['delete_status'] = 'YES';
    if(!isset($_COOKIE['deleted_doc']))
    setcookie('deleted_doc',1,time()+3600,'/');
    else
     {
      // $_COOKIE['deleted_doc']+1
      setcookie('deleted_doc', $_COOKIE['deleted_doc']+1, time()+3600,'/');
    }
    $write_num = $_COOKIE['deleted_doc'];


    setcookie('deleted_board_idx_'.$write_num, $serialized_data, time()+3600, '/');
    echo "삭제 성공<br>";
    // echo "삭제 한 게시글은 24시간 내에 복구 할 수 있습니다.";
}

//$result->free();

$mysqli->close();
//var_dump($url);
// exit();

include $_SERVER['DOCUMENT_ROOT'].'/footer.php';

?>
