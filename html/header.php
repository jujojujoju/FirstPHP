<?php session_start();
$DB['host'] = 'localhost';
$DB['db'] = 'test';
$DB['id'] = 'root';
$DB['pw'] = '1234';

$mysqli = new mysqli($DB['host'], $DB['id'], $DB['pw'], $DB['db']);
if (mysqli_connect_error()) {
		exit('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
}

$q = "select subject, idx, visit from board order by visit desc limit 0,5;";
$result = $mysqli->query($q);
$i = 0;
?>
<link href="./bootstrap-3.3.7-dist/css/bootstrap.css" rel="stylesheet">
<style>
					 .top-menu {
						 background-color: white;
							 border-bottom: 3px solid #1177ee;
							 top: 1;
							 position: fixed;
					 }
					 .top-menu ul {
							 margin: 0;
							 padding: 0;
					 }
					 .top-menu ul li {
						 	font-size: 120%;
							 display: inline-block;
							 margin:10;
					 }
					 .top-menu ul li:hover {
						 background: #eeeeee;
							 cursor: pointer;
					 }
					 .top-menu ul a {
						 color: #000066;
						 display: inline-block;
						 font-family: fantasy;
					 padding: 10px 26px;
						padding-left: 80px;
						padding-right: 80px;
							text-decoration: none;
					}
					.panel-my
				 {
						 background: #eeeeff;
				 }
				 .sidebar
				 {
					 border-radius: 20px;
				   position: fixed;
				   width : 265px;
				   height : 55%;
				   margin-left: 78%;
				   background: #77ddff;
				 overflow-x: hidden;
				 overflow-y: auto;
				 }
				 .board
				 {
				   padding-right: 350px;
				   margin-left: 50px;
				 }
				 .sidebar-brand
				 {
					 color: white;
					 font-size: 150%;
				 }
				 .sidebar-nav {
				     width: 400px;
				     margin: 0;
				     padding: 0;
				     list-style: none;
				 }
				 .sidebar-nav li {
					 border-bottom: 1px solid white;
				   text-indent: 1.5em;
				      line-height: 2.8em;
				 }
				 .sidebar-nav li a {
				     display: block;
				     text-decoration: none;
				     font-size: 160%;
				     color: white;
						 padding-top: 15px;
				 }

				 .sidebar-nav li a:hover {

				     background: #ccccff;
				 }
				 .message-box
				 {
				   margin-left: 30%;
				   overflow-y: auto;
				   overflow-x:hidden;
				    width: 50%;
				    height:500px;
				 }

</style>
<div class="top-menu">
					 <ul>
							 <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>">홈</a></li>
							 <li><a href="list.php">게시판</a></li>
							 <li><a href="write.php">글쓰기</a></li>
							 <li><a href="send_message.php" >쪽지</a></li>

							 <?php if(!isset($_SESSION['member_name'])) : ?>
							 <li><a href="signup.php" >회원가입</a></li>
							 <li><a href="login.php">로그인</a></li>
							 <?php endif?>

							 <?php if($_SESSION['is_logged']=='YES') :?>
							 <li><a href="userinfo.php" >내 정보</a></li>
							 <li><a href="logout.php" >로그아웃</a></li>
							<?php endif ?>
					 </ul>
			 </div>
		 <div>
				 <br><br><br><br><br><div class="sidebar">
				   <ul class="sidebar-nav">
				   			<li class="sidebar-brand"><div class="row">	<div class="col-md-4">인기 글</div><div class="col-md-4">조회 수</div></div> </li>
				         <?php while($data = $result->fetch_array()) : ?>
				            <li><a href="http://<?php echo $_SERVER['HTTP_HOST'];?>/board_view.php?doc_idx=<?php echo $data['idx']; ?>">
				              <div class="row"><div class="col-md-5"><?php echo $data['subject']?></div>
				            <div class="col-md-5"><?php echo $data['visit']; ?></div></div></a></li>
				         <?php endwhile?>
				   		</ul>
				 </div><br><br><br><br>
			 </div>
