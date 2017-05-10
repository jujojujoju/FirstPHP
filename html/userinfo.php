<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/preset.php');
include $_SERVER['DOCUMENT_ROOT'].'/header.php';


?>

<!DOCTYPE html>
<meta charset="utf-8" />
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script type="text/javascript">
function page_move()
{
	if(confirm1==1 && confirm2 == 1)
	{
	var f=document.modify_own_form; //폼 name
	f.check_password.value = $("#user_pass").val(); //POST방식으로 넘기고 싶은 값
	f.new_password.value = $("#new_password").val();
	f.new_password_check.value = $("#new_password_check").val();
	f.submit();
}
else
{
	document.getElementById("submit_button").className= "btn btn-danger";
}
}
var confirm1 = 0;
var confirm2 = 0;
$(document).ready(function()
{

	$("#new_password_check").blur(function()
  {
    if($("#new_password").val() != $("#new_password_check").val())
    {
			document.getElementById("passcheck_form_group").className = "form-group has-error";
			document.getElementById("passcheck2_form_group").className = "form-group has-error";
		$("#message2").html("<p>비밀번호가 일치하지 않습니다!</p>");
		confirm1 = 0;
      }
    else
    {
      if($("#new_password").val()=='')
      {
				document.getElementById("passcheck_form_group").className = "form-group has-error";
				document.getElementById("passcheck2_form_group").className = "form-group has-error";
          $("#message2").html("<p>비밀번호를 입력해주세요!</p>");
					confirm1 = 0;
      }
      else {
				document.getElementById("passcheck_form_group").className = "form-group has-success";
				document.getElementById("passcheck2_form_group").className = "form-group has-success";
				confirm1 = 1;
        $("#message2").html("<p>비밀번호가 일치합니다</p>");
      }
    }
	});

  $("#user_pass").blur(function()
  {
    var form_data = {
      user_pass: $("#user_pass").val(),
      index : 2
    };
    $.ajax(
      {
      type: "POST",
      url: '/userinfo_check.php',
      data: form_data,
      success: function(response)
      {
        if(response == 'existed')
        {
					document.getElementById("pass_form_group").className = "form-group has-success";
          $("#message3").html("<p>비밀번호를 확인했습니다!</p>");
					confirm2=1;
        }
        else if(response == 'blank')
        {
					document.getElementById("pass_form_group").className = "form-group has-error";
          		confirm2=0;
							$("#message3").html("<p>비밀번호를 입력해주세요!</p>");
        }
        else if(response == 'nopass'){
					document.getElementById("pass_form_group").className = "form-group has-error";
          confirm2=0;
					$("#message3").html("<p>비밀번호가 일치하지 않습니다!</p>");
        }
      }
    });
    return false;

  });


});
</script>

<div class="board">

<form name="modify_own_form"class="form-horizontal" method="post" action="./modify_own.php">

  <div id="pass_form_group" class="form-group">
    <label for="inputPassword3" class="col-sm-3 control-label">Password 확인</label>
    <div class="col-sm-8">
      <input style="margin-left : 10%; width : 80%;" type="password" class="form-control" id="user_pass" name='check_password' placeholder="Password">
    </div><br><br>
	<div class="help-block" id='message3' style="text-align:center;"><br></div>
</div>
	<div id="passcheck_form_group" class="form-group">
    <label for="newPassword3" class="col-sm-3 control-label">새로운 Password</label>
    <div class="col-sm-8">
      <input type="password" class="form-control" style="margin-left : 10%; width : 80%;" id='new_password' name='new_password' placeholder="Password">
    </div>
  </div>
	<div id="passcheck2_form_group" class="form-group">
		<label for="newPassword3" class="col-md-3 control-label">새로운 Password 확인</label>
		<div class="col-md-8">
			<input type="password" class="form-control" id='new_password_check' style="margin-left : 10%; width : 80%;" name='new_password_check' placeholder="Password">
		</div><br><br>
	<div class="help-block" id='message2' style="text-align:center;"><br></div>
</div>

	<div style="padding-left : 40%;" class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <a id="submit_button" href="javascript:page_move();" class="btn btn-default">정보 변경</a>
    </div>
  </div>
</form>

<?php
include $_SERVER['DOCUMENT_ROOT'].'/footer.php';
?>
</div>
