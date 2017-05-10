<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/preset.php';
include $_SERVER['DOCUMENT_ROOT'].'/header.php';

?>
<div class="board">
<div class='btn-success' style="padding-left : 50%;">글쓰기</div><br><br>

<form class="text-center" name ="write_form" method = "POST" action = "./write_check.php">
<input type="hidden" name="member_idx" value="<?php echo $_SESSION['member_id'] ?>">
<table style="margin-left : 150px">
    <tr>
        <td>
    	제목
    	</td>

	  <td>
            <input type ="text" name = "subject" size ="75">
   	  </td>
    </tr>

    <tr>
        <td>
            내용
  	</td>
   	 <td>
            <textarea name="content" cols="75" rows="10"></textarea>
    	 </td>
    </tr>

</table>
<div>
    <input class="button btn-success" type = "submit" value = "저장">
</div>
</form>

<?php  include $_SERVER['DOCUMENT_ROOT'].'/footer.php';?>

</div>
