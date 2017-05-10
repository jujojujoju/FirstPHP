<?php include $_SERVER['DOCUMENT_ROOT'].'/header.php';?>

<meta charset="utf-8" />
<title>회원가입</title>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
  var idok = 0;
  var passok = 0;
	$("#user_id").blur(function()
  {
		var action = $("#form1").attr('action');
		var form_data = {
			user_id: $("#user_id").val(),
			is_ajax: 1
		};
		$.ajax(
      {
			type: "POST",
			url: '/signup_check2.php',
			data: form_data,
			success: function(response)
      {
				if(response == 'existed')
        {
          idok = 0;
          document.getElementById("id_form_group").className = "form-group has-error";
					$("#message_id").html("<p>이미 사용중인 아이디입니다!</p>");
        }
        else if(response == 'blank')
        {
          idok = 0;
          document.getElementById("id_form_group").className = "form-group has-error";
					$("#message_id").html("<p>아이디를 입력해주세요!</p>");

        }
				else
        {
          idok = 1;
          document.getElementById("id_form_group").className = "form-group has-success";
					$("#message_id").html("<p>멋진 아이디네요!</p>");
        }
      }
		});
		return false;
	});
  $("#user_pw").blur(function()
{
  if($("#user_pw").val()!='')
  {
    document.getElementById("password_form_group").className = "form-group";
      $("#message_pass").html("<p><br></p>");
  }
  else {

  }
});
  $("#user_pw_check").blur(function()
  {
    if($("#user_pw").val() != $("#user_pw_check").val())
    {
      passok=0;
      document.getElementById("password_form_group").className = "form-group has-error";
      document.getElementById("password_form_group2").className = "form-group has-error";
      $("#message_pass2").html("<p>비밀번호가 일치하지 않습니다!</p>");
      }
    else
    {
      if($("#user_pw").val()=='')
      {
        passok=0;
        document.getElementById("password_form_group").className = "form-group has-error";
          $("#message_pass").html("<p>비밀번호를 입력해주세요!</p>");
      }
      else {
        passok=1;
        document.getElementById("password_form_group").className = "form-group has-success";
        document.getElementById("password_form_group2").className = "form-group has-success";
          $("#message_pass").html("<p><br></p>");
        $("#message_pass2").html("<p>비밀번호가 일치합니다</p>");
      }
    }
	});

  $("#signup").click(function()
  {
    // var action = $("#form1").attr('action');
    if(passok ==0 || idok==0)
    {
      document.getElementById("id_form_group").className = "form-group has-error";
      document.getElementById("password_form_group").className = "form-group has-error";
      document.getElementById("password_form_group2").className = "form-group has-error";
      $("#message3").html("<p style='color:#a94442;'>필수정보를 입력해주세요!</p>");
    }
    else
    {
    var form_data_button = {
      user_id: $("#user_id").val(),
      user_pw: $("#user_pw").val(),
      user_sex: $("input[name=sex]:checked").val(),
      user_year: $("#year").val(),
      user_month: $("#month").val(),
      user_day: $("#day").val()

    };
    $.ajax(
      {
      type: "POST",
      url: '/signup_check.php',
      data: form_data_button,
      success: function(response_button)
      {
        if(response_button == 'success')
        {
          $("#message3").html("<p style='color:#3c763d;font-weight:bold'>회원가입 성공!</p>");
	         $("#form1").slideUp('slow');
           setTimeout(function(){
             $("#message3").html("<p style='color:#3c763d;font-weight:bold'>로그인 해주세요.</p>");
           },1500);

          }
        else
          $("#message3").html("<p style='color:red'>회원가입 실패.</p>");
      }
    });
  }
    return false;
  });

});
</script>
<div class="board">
<body>
  <form id="form1" name="form1" class="form-horizontal"action="signup_check.php" method="post">
		<div id="id_form_group" class="form-group">
	    <label class="col-md-3 control-label">아이디(필수)</label>

	    <div class="col-md-8">
	      <input style="margin-left:10%; width:80%;" type="text" class="form-control" tabindex="1"
				id="user_id" name='user_id' placeholder="ID">
	    </div>

				<br><br>
		<div class="help-block" id='message_id' style="text-align:center;"><br></div>
	</div>


	<div id="password_form_group" class="form-group">
		<label class="col-md-3 control-label">비밀번호(필수)</label>

		<div class="col-md-8">
			<input type="password" tabindex="2" class="form-control" style="margin-left : 10%; width: 80%;"
			id='user_pw' name='user_pw'  placeholder="Password">
		</div><br><br>
		<div class="help-block" id='message_pass' style="text-align:center;"><br></div>
	</div>

  <div id="password_form_group2" class="form-group">
		<label class="col-md-3 control-label">비밀번호 확인(필수)</label>

		<div class="col-md-8">
			<input type="password" tabindex="3" class="form-control" style="margin-left : 10%; width: 80%;"
			id='user_pw_check' name='user_pw_check'  placeholder="Password">
		</div><br><br>
		<div class="help-block" id='message_pass2' style="text-align:center;"><br></div>
	</div>


<table style="margin-left :40%;">
<tr>
<td>성별</td>
<td><input type="radio" id='sex' name='sex' value="man" tabindex='4'>남자
  <input type="radio" id='sex' name='sex' value="woman" tabindex='5'>여자</td>
</tr>

<tr>
  <td>생년월일</td>
  <td>
<select id= 'year' name='birth'>
<?php
echo '<option value="" >'.$asd.'</option>';

  for($i=1940;$i<=2016;$i++)
    echo '<option value="'.$i.'" >'.$i.'</option>';
?>
</select>
년
<select id= 'month' name='birth'>
<?php
echo '<option value="" >'.$asd.'</option>';

for($i=1;$i<=12;$i++)
  echo '<option value="'.$i.'" >'.$i.'</option>';
?>
</select>
월
<select id= 'day' name='birth'>
<?php
echo '<option value="" >'.$asd.'</option>';

for($i=1;$i<=31;$i++)
  echo '<option value="'.$i.'" >'.$i.'</option>';
?>
</select>
일
</td>
</tr>

<tr>
<td><input type='button' id='signup' tabindex='6' value='회원가입' style='margin-left:50%;height:50px'/></td>
</tr>
</table>
</form>
<div style="padding-left:45%;"id="message3"></div>

</body>

<?php include $_SERVER['DOCUMENT_ROOT'].'/footer.php';?>
</div>
