<!DOCTYPE HTML>
<html>


<head>
<title>팝업 </title>

<style>
.x {
	padding: 10px 20px;
	border: 1px solid #ccc;
	background-color: #f2f2f2;
	border-radius: 10px;
	color: black;
	text-decoration: none;
}

.x:hover {
	text-decoration: none;
	background-color: #e3e3e3;

}

</style>
<script src="http://code.jquery.com/jquery-latest.js"></script> <!-- 레이어 팝업에 필요한 jquery소스파일 -->
<script type="text/javascript">
function setCookie(cname, cvalue, exdays)
{
    var d = new Date();
    d.setTime(d.getTime() + (exdays*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
    $(document).ready(function()
		 {
        $('#close').click(function() {  //close라는 영역을 클릭했을때,
              window.close();  //popup이라는 영역을 사라지게(혹은 숨겨지도록)
              self.close();
              close();
        });
				$('#neveropen').click(function() {  //close라는 영역을 클릭했을때,
						setCookie('popup','popup',10); //10분
						// alert("fsdfdsf");
						window.close();  //popup이라는 영역을 사라지게(혹은 숨겨지도록)
						self.close();
						close();
				});
    });
    </script>

</head>
<body>

팝 업
<div id="neveropen" class="x">하루동안 보지 않기</div>
<div id="close" class="x">close</div>

</body>


</html>
