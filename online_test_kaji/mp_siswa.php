<?php
include_once "include/koneksi.php";
?>
<div class="daftar_pelajaran">
<fieldset>
<legend>Pilih Mata Pelajaran</legend>
<?php
// ambil data mata pelajaran dari database
$mp_exe = mysql_query("select * from mapel");
$jml_mp = mysql_num_rows($mp_exe);
if($jml_mp > 0){
?>
	<ul>
		<?php
		while($data = mysql_fetch_assoc($mp_exe)){
			$jml_ujian = mysql_result(mysql_query("select count(*) from ujian where id_mp='".$data['id_mp']."'"),0);
			echo "<div onclick=\"lihat_ujian_siswa('".$data['id_mp']."')\"><span class='jml_ujian'>".$jml_ujian."</span><li><a title='".$data['id_mp']."'>".$data['nama_mp']."</a></li>";
			echo "<div class='tombol edit' >Daftar ujiann</div>";
			echo "</div>";
			}
			
		?>
	</ul>
<?php	
	}
else {
	echo "Mata Pelajaran Belum Dibuat";
	}	
?>

</fieldset>
</div>
<script>	
function lihat_ujian_siswa(id_mp){
	// load content dengan data dari daftar_ujian.php
	$("#content").html(info_loading).load("daftar_ujian_siswa.php?id_mp="+id_mp);
	}
</script>
<style>
.daftar_pelajaran{
	width:80%;
	margin: 0 auto;
	}
.daftar_pelajaran>fieldset>ul>div{
	float:left;
	width:150px;
	min-height:120px;
	padding:6px;
	border-radius:5px;
	margin:10px;
	border:2px solid #000000;
	color:#000000;
	overflow:auto;
	}
.daftar_pelajaran div:hover{
	cursor:pointer;
	}
.jml_ujian{
	padding:3px;
	border-radius:4px;
	border:1px solid #105610;
	background:#479F47;
	color:#FFFFFF;
	font-weight:bolder;
	font-size:0.8 em;
	position:relative;
	float:right;
	margin-right:-6px;
	margin-top:-7px;
	z-index:20;
	}		
.daftar_pelajaran ul,.daftar_pelajaran li{
	list-style:none;
//	text-align:center;
	}
.daftar_pelajaran li{
	position:relative;
	font-weight:bolder;
	border-bottom:2px solid #000000;
	}
</style>