<?php
/*--------------------------------------------------------
 * Buat soal ujian, bisa upload gambar dan rumus matematika
 *--------------------------------------------------------*/ 
include_once "include/cek_session.php"; 
if($_SESSION["level_kj"] != "siswa"){
	echo "<div class='peringatan'>hanya untuk siswa, area terlarang untuk anda .....<a href='index.php'>Kembali</a></div>";	
	echo "<style>
	.peringatan{
		border:2px solid #FF0000;
		background:#FAC7D0;
		padding:7px;
		}
	
	</style>";
}
else {
?>
<html>
<head>
<link href="image/kj.png" rel="shortcut icon">
<link  href="css/soal.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
<script >
var info_loading = "<div style='font-size:110%;font-style:italic;font-weight:bolder;width:150px;margin:0 auto;' class='tombol loading'>Sedang proses .............</div>";	
function load_menu(elm){
		$(".menu_terpilih").eq(0).removeClass("menu_terpilih").addClass("menu_awal");
		$(elm).parent().removeClass("menu_awal").addClass("menu_terpilih");
		var url = $(elm).attr("href");
		$("#content").html(info_loading).load(url);
		return false;
	}
$(function(){
	$(".menu_awal>a").eq(0).click();
	})
</script>
</head>
<body>
	<div id="nav_menu">
		<ul class="menu_kiri">
			<li class="menu_awal"><a onclick="return load_menu(this)" href="beranda.php">Beranda</a></li>
			<li class="menu_awal"><a onclick="return load_menu(this)" href="mp_siswa.php">Ujian</a></li>
		</ul>
		<ul class="menu_kanan">
			<li class="menu_awal"><a onclick="return load_menu(this)" href="profil.php"><?php echo ucwords($_SESSION['nama_kj']) ?></a></li>
			<li class="menu_awal"><a onclick="return load_menu(this)" href="ganti_pass.php">Ganti Password</a></li>
			<li class="menu_awal"><a href="logout.php">Keluar</a></li>
		</ul>
	</div>
	<div id="content">
	</div>
</body>
</html>
<?php
}
?>
