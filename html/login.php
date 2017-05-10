<?php $remembered_id = $_COOKIE['user_id']; ?>

<div id='include'>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/header.php';?></div>
<meta charset="utf-8" />

<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
	var count = [];
	function setCookie(cname, cvalue, exdays)
	{
	    var d = new Date();
	    d.setTime(d.getTime() + (exdays*60*1000));
	    var expires = "expires="+ d.toUTCString();
	    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}
	function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length,c.length);
        }
    }
    return "";
}
	$("#login").click(function()
  {
		if(getCookie( $("#user_id").val())=='banned')
		alert($("#user_id").val()+"님은 로그인이 당분간 정지됩니다.");
		else
		{
		var action = $("#form1").attr('action');
    var box_checked = 0;

    if($("#remember").prop('checked'))
      box_checked= 1;
      else
         box_checked = 0;

		var form_data = {
			user_id: $("#user_id").val(),
			user_pw: $("#user_pw").val(),
			is_ajax: 1,
      box_data: box_checked
		};
		$.ajax({
			type: "POST",
			url: action,
			data: form_data,
			success: function(response) {
				if(response == 'success')
        {
					$("#message").html("<p style='color:#3c763d;font-weight:bold'>로그인 성공!</p>");
					$("#form1").slideUp('slow');
          $("#include").load("/header.php");
				}
      else if(response == 'noid')
        {
					document.getElementById("id_form_group").className = "form-group has-error";
          $("#message_id").html("<p>아이디를 입력해주세요!</p>");
        }
        else if(response == 'nopass')
        {
					document.getElementById("password_form_group").className = "form-group has-error";
            $("#message_pass").html("<p>비밀번호를 입력해주세요!</p>");
        }
				else {
						if(	typeof (count[$("#user_id").val()]) == 'undefined')
						count[$("#user_id").val()] = 1;
						else {
							count[$("#user_id").val()] =count[$("#user_id").val()]+ 1;
						}
						if(count[$("#user_id").val()]>=5)
						{
							setCookie($("#user_id").val(),'banned',1);
						$("#message").html("<p style='color:red'>24시간 동안 로그인이 정지됩니다.</p>");
					}	else
							{
								document.getElementById('user_pw').value="";
									document.getElementById("id_form_group").className = "form-group has-error";
									document.getElementById("password_form_group").className = "form-group has-error";
					$("#message").html("<p style='color:#a94442'>아이디 또는 비밀번호가 잘못되었습니다.</p>");
				}
				}
			}
		});
		return false;
		}
	});
});
</script>

<div class="board">
<body>
	<div style="margin-left:38%;" class="btn btn-warning">비밀번호를 5회 이상 틀리면 24시간 동안 로그인이 금지됩니다.</div><br><br><br>
	<form id="form1" name="form1" class="form-horizontal" action="login_check2.php" method="post">
		<div style="margin-left : 45%;">
			<?php if(isset($_COOKIE['user_id'])) : ?>
				<input type="checkbox" id='remember' name='remember' value="remember" checked="checked">아이디 기억하기
			<?php else : ?>
				<input type="checkbox" id='remember' name='remember' value="remember">아이디 기억하기
			<?php endif ?>
	</div>
	<br><br>

		<div id="id_form_group" class="form-group">
	    <label class="col-md-3 control-label">아이디</label>
	    <div class="col-md-8">
	      <input style="margin-left:10%; width:80%;" type="text" class="form-control" tabindex="1"
				id="user_id" name='user_id' value='<?php echo $remembered_id;?>' placeholder="ID">
	    </div>

				<br><br>
		<div class="help-block" id='message_id' style="text-align:center;"><br></div>
	</div>


	<div id="password_form_group" class="form-group">
		<label class="col-md-3 control-label">비밀번호</label>
		<div class="col-md-8">
			<input type="password" tabindex="2"class="form-control" style="margin-left : 10%; width: 80%;"
			id='user_pw' name='user_pw'  placeholder="Password">
		</div><br><br>
		<div class="help-block" id='message_pass' style="text-align:center;"><br></div>
	</div>

	<div style="padding-left : 40%;" class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<input type="button" id="login" tabindex='3' value='로그인' class="btn btn-default">
		</div>
	</div>
	</form>

	<div style="padding-left : 40%;" id="message"></div>
</body>


<?php include $_SERVER['DOCUMENT_ROOT'].'/footer.php';?>
</div>
