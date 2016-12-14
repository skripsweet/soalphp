<?php
session_start();
include_once "include/koneksi.php";
?>
<div style="margin:0 auto;width:50%;padding:10px">
<fieldset>
<legend>Data Pribadi</legend>

<?php
// ambil data mata pelajaran dari database
$tabel = $_SESSION['level_kj'];
$nis = $_SESSION['nis_kj'];
$profil_exe = mysql_query("select * from ".$tabel." where nis='".$nis."'");
$data_profil = mysql_fetch_assoc($profil_exe);
foreach($data_profil as $index => $nilai){
	echo "<div class='div_profil'><div class=l_kiri>".ucwords($index)."</div><div>".ucwords($nilai)."</div></div>";
	}
?>
</fieldset>
</div>
<style>
.l_kiri{
	width:100px;
	float:left;
	
	}
.div_profil{
	width:80%;
	margin:10px;
	font-size:110%;
	font-weight:bolder;
	font-style=italic;
	border:1px solid #000000;
	border-radius:4px;
	padding:10px;
	}	
.div_profil:hover{	
	background:#E5E5E5;
	}
</style>
