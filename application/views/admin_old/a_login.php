<?php
//cache

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
<style type="text/css">
body,html{
	margin:0;
	font-family:arial;
	font-size:12px;
	background:#eee;
}
button, input[type=submit]{
	cursor:pointer;
}
h1{
	color:#0B55C4;
	text-align:center;
	font-size:20px;
	font-weight:normal;
	margin:0 35px;
	background:#fff;
	position:relative;
	top:-25px;
}
#bg{
	background:#fff;
	padding:70px;
}
#container{
	width:400px;
	padding:10px;
	border:1px solid #999;
	border-radius:5px;
	margin:0 auto;
}
#container p{
	margin:0 0 10px;
}
#container label{
	display:block;
	width:130px;
	float:left;
	text-align:right;
	padding:0 5px 0 0;
	line-height:17px;
}
.input_text{
	font-size:10px;
	width:150px;
	border:1px solid #ccc;
}
.input_text:focus{
	border:1px solid #aaa;
}
#logo{
	width:88px;
	height:31px;
	display:block;
	margin:0 auto;
	background:url(../images/logo_bot.png);
}
#footer a{
	text-decoration:none;
	color:#666;
}
#footer a:hover{
	color:#00baff;
	text-decoration:underline;
}

</style>
</head>
<body>
<div id="bg">
<div id="container">
	<h1>Вход в административный раздел</h1>
	<form method="POST" action="<?=base_url(); ?>/administrator/login">
		<p>
		<label for="login">Login</label>
		<input class="input_text" type="text" id="login" value="" name="login">
		</p>
		<p>
		<label for="pass">Password</label>
		<input class="input_text" type="password" id="pass" value="" name="pass">
		</p>
		<p>
		<label>&nbsp;</label>
		<input type="submit" value="Войти">
		</p>
	</form>
</div>
</div>
<div id="footer" style="text-align:center;padding:10px 0 0 0;border-top:1px solid #ccc;">
	&copy; <a href="/"><?=$_SERVER['SERVER_NAME']?></a> <?php echo date('Y', time())?>
</div>

</body>
</html>