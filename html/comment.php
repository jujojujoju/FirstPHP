<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/preset.php';
?>

<?php

$member_name = $_SESSION['member_name'];
  # code...
$q = "INSERT INTO comment (name, content, date, doc_idx) VALUES('$member_name', '$comment', now(), '$doc_idx')";
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
header("Location: ".$url['root']."/board_view.php?doc_idx=$doc_idx");


?>
