<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/preset.php';
include $_SERVER['DOCUMENT_ROOT'].'/header.php';
?>

<?php

$member_name = $_SESSION['member_name'];

if($subject == '')
{
  echo "제목을 입력해주세요";
}
else {
  # code...
$q = "INSERT INTO board (member_name, subject, content, date, visit) VALUES('$member_name', '$subject', '$content', now(), 0)";
$result = $mysqli->query($q);

if ($result==false) {
    // $_SESSION['writing_status'] = 'NO';
    echo "글쓰기 실패";
}
else {
    // $_SESSION['writing_status'] = 'YES';

    echo "글쓰기 성공";
}

$mysqli->close();

}

include $_SERVER['DOCUMENT_ROOT'].'/footer.php';

?>
