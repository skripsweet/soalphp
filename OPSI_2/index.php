<?php
session_start();
if(isset($_SESSION['login_kj'])){
	header("location:hal_".$_SESSION['level_kj'].".php");	
	}
else {	
?>
<html>
<head>
	<link href="image/kj.png" rel="shortcut icon">
	<title>Ujian Online Sederhana by Kaji</title>
</head>
<body onload="document.forms[0]['id_user'].focus()">
	<div id="div_login">
	<fieldset>
		<legend>Halaman login</legend>
		<?php
		if(isset($_GET['info'])){
			$display = "block";
			$pemberitahuan = $_GET['info'];
			}
		else{
			$display = "none";	
			$pemberitahuan = "";
			}
		?>
		<div class="info" style="display:<?php echo $display ?>"><?php echo $pemberitahuan; ?></div>
		<form action="login.php" method="post">
		<div>
			<label class="kiri">NIS atau No. Pendaftaran</label>
			<input type="text" class="inputan" name="id_user"/>
		</div>
		<div>
			<label class="kiri">Password anda</label>
			<input type="password" class="inputan" name="password"/>
		</div>
		<div>
			<label class="kiri"> </label>
			<input type="submit" class="inputan tombol" value="Login"/>
		</div>
		</form>
	</fieldset>
	</div>
</body>
</html>
<style>
body{
	background:#1A1A1A;
	}
#div_login{
	width:450px;
	margin:0 auto;
	margin-top:150px;
	background:#FFFFFF;
	border:4px solid #BFBFBF;
	border-radius:6px;
	padding:10px;
	overflow:auto;
	}
fieldset{
	border-radius:3px;
	border:2px solid #000000;
	}	
form>div{
	margin:4px;
	padding:2px;
	}	
.inputan{
	border-radius:4px;
	border:1px solid #000000;
	padding:4px;
	font-size:90%;
	margin-left:50%;
	}
label.kiri{
	position:absolute;
	}
.tombol{
	border-radius:4px;
	border:1px solid #000000;
	background:url('image/b_usrcheck.png') no-repeat left #E5E5E5;
	color:#000000;
	padding-left:20px;
	font-size:90%;
	font-weight:bolder;
	}				
.tombol:hover{	
	cursor:pointer;
	}
.info{
	background:#912828;
	color:#FFFFFF;
	text-align:center;
	padding:5px;
	}	
</style>
<?php
}
?>
