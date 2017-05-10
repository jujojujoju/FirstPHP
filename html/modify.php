<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/preset.php';
include $_SERVER['DOCUMENT_ROOT'].'/header.php';
?>
<?php
if(isset($doc_idx)==false) {
    echo '글번호가 지정되지 않았습니다.';
    exit();
}

$q = "SELECT * FROM board WHERE idx = $doc_idx";
$result = $mysqli->query($q);
$data = $result->fetch_array();

?>
글수정하기<br />
<form name ="modify_form" method = "POST" action = "./modify_check.php">
<input type="hidden" name="doc_idx" value="<?php echo $doc_idx ?>">
<table>
    <tr>
        <td>
    제목
    </td>
    <td>
            <input type ="text" name = "subject" size ="75" value="<?php echo $data['subject'];?>">
    </td>
    </tr>
    <tr>
        <td>
            내용
    </td>
    <td>
            <textarea name="content" cols="75" rows="10" ><?php echo $data['content'];?></textarea>
    </td>
    </tr>
</table>

<div>
    <input type = "submit" value = "저장">
</div>



</form>

<div>
    <?php
    echo '<a href="http://'.$_SERVER['HTTP_HOST'].'/list.php" >목록</a>';
    ?>
</div>



<?php
    include $_SERVER['DOCUMENT_ROOT'].'/footer.php';
?>
