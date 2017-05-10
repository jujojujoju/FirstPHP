<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/preset.php';
include $_SERVER['DOCUMENT_ROOT'].'/header.php';
?>
<div class="board">
<div class="btn-primary" style="padding-left : 500px;">메세지 보내기</div>
<br><br>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script type="text/javascript">

  function page_move(message_idx,index)
  {
    if(index==1)
    {
    var f=document.message_view_form; //폼 name
    f.message_idx.value = message_idx; //POST방식으로 넘기고 싶은 값
    f.form_index.value = index;
    f.submit();
  }
  else {
    var f=document.message_view_form2; //폼 name
    f.message_idx.value = message_idx; //POST방식으로 넘기고 싶은 값
    f.form_index = index;
    f.submit();
  }
  }

$(document).ready(function()
{

    $("#received-box").show();
    $("#sended-box").hide();

  $("#received").click(function()
{
  document.getElementById("received-li").className="active";
  document.getElementById("sended-li").className="";
  $("#received-box").show();
  $("#sended-box").hide();

  return false;
});

  $("#sended").click(function()
{
    document.getElementById("received-li").className="";
  document.getElementById("sended-li").className="active";
  $("#sended-box").show();
  $("#received-box").hide();
  return false;
});

  $("#submit").hide();

  $("#content").focus(function()
{
  var form_data = {
    user_id: $("#user_id").val(),
    content : $("#content").val(),
    index : 1
    };
  $.ajax({
    type: "POST",
    url: '/sended_check.php',
    data: form_data,
    success: function(response) {
      if(response == 'exist')
      {
        $("#submit").show();
        $("#message").html("<p style='color:green;font-weight:bold'>아이디를 확인했습니다.</p>");
      }
      else {
        $("#message").html("<p style='color:red;font-weight:bold'>아이디를 찾을 수 없습니다.</p>");
          $("#submit").hide();
      }
    }
});
  return false;
});
});
</script>


<form style="margin-left : 300px;" name='message' method='post' action="sended_check.php">
받는 이<br><input id="user_id" name='user_id' type='text' size='50' value="<?php echo $_GET['name'];?>"><div id="message"></div><br>
내용<br><textarea id="content" name='messagetext' cols="50" rows="10"></textarea><br>
<input id="submit" type='submit' value='보내기'>

</form>


        <ul style="padding-left : 40%;"class="nav nav-tabs">
  <li id="received-li" role="presentation" class="active">
    <a id="received" style=" color: #3c763d; text-decoration: none; background-color : #dff0d8;" href="#"> 받은 메세지</a></li>
  <li role="presentation"  id="sended-li">
    <a id="sended" style="color:#8a6d3b; text-decoration: none; background-color : #fcf8e3;" href="#"> 보낸 메세지</a></li>
</ul>


<div id="received-box" class="panel panel-success message-box">
  <div class="panel-heading">받은 메세지</div>
  <form name="message_view_form" action="message_view.php" method="post">
    <input type="hidden" name="message_idx">
    <input type="hidden" name="form_index">
  <?php
  $userinfo = $_SESSION['member_name'];
  $q = "SELECT * FROM message WHERE to_name ='$userinfo'";
  $result = $mysqli->query( $q);
   while($data = $result->fetch_array(MYSQLI_BOTH)) :?>
   <div class="panel-body" style="border-bottom: .5px solid #d6e9c6;">
     <a href="javascript:page_move(<?php echo $data['send_idx'];?>,1);">
       <div class="row">
       <div class="col-md-5" style="border-right: .5px solid #d6e9c6;">
         <div><?php echo $data['send_time'];?></div>
         <div><?php echo "보낸 이 : ".$data['from_name'];?></div>
       </div>
   <div class="col-md-5">
      <?php echo $data['message_text'];?>
 </div>
   </div>
 </a>
 </div>
  <?php endwhile?>
  </form>
</div>

<div id="sended-box" class="panel panel-warning message-box">
  <div class="panel-heading">보낸 메세지</div>
  <form name="message_view_form2" action="message_view.php" method="post">
    <input type="hidden" name="message_idx">
    <input type="hidden" name="form_index">

<?php
  $userinfo = $_SESSION['member_name'];
  $q = "SELECT * FROM message WHERE from_name ='$userinfo'";
  $result = $mysqli->query( $q);
   while($data = $result->fetch_array(MYSQLI_BOTH)) :?>
   <div style="border-bottom: .5px solid #faebcc;" class="panel-body">
     <a href="javascript:page_move(<?php echo $data['send_idx'];?>,2);">
     <div class="row">
       <div class="col-md-5"style="border-right: .5px solid #faebcc;">
         <div ><?php echo $data['send_time'];?></div>
         <div ><?php echo "받는 이 : ".$data['to_name'];?></div>
    </div>
    <div class="col-md-5">
    <?php   echo $data['message_text'];?>
  </div>
   </div>
 </a>
   </div>
  <?php endwhile?>
</form>
</div>

<?php
include $_SERVER['DOCUMENT_ROOT'].'/footer.php';
?>

</div>
