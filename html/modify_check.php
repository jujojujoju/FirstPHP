<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/preset.php';
include $_SERVER['DOCUMENT_ROOT'].'/header.php';


$q = "UPDATE board SET subject='$subject',content='$content' WHERE idx=$doc_idx";
$result = $mysqli->query($q);

if ($result==false) {
    // $_SESSION['modify_status'] = 'NO';
    echo "수정 실패";
}
else {
    // $_SESSION['modify_status'] = 'YES';
    echo "수정 성공";
    	header('Location: '.$url['root'].'/list.php');

}

//$result->free();

$mysqli->close();
//var_dump($url);


include $_SERVER['DOCUMENT_ROOT'].'/footer.php';

?>
