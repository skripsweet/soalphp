<?php
/*--------------------------------------------------------
 * Buat ujian untuk mata pelajaran tertentu
 *--------------------------------------------------------*/ 
include_once "include/cek_session.php";  
include_once "include/koneksi.php"; 
$id_mp = $_REQUEST['id_mp'];
$nama_mp = mysql_result(mysql_query("select nama_mp from mapel where id_mp='".$id_mp."'"),0);
?>
<div style="font-size:80%;width:80%;margin:0 auto;background:#FFFFFF">
<fieldset>
<legend>Daftar Ujian Pada Mata Pelajaran <?php echo $nama_mp ?></legend>
<div class='daftar_ujian'>
	<div class='no'>No</div>
	<div class='nama_ujian'>Nama Ujian</div>
	<div class='tanggal'>Tanggal</div>
	<div class='waktu'>Waktu</div>
	<div class='ket'>Keterangan</div>
	<div class='aksi'>Aksi</div>
	<div class='nilai'>Nilai</div>
</div>
<?php
// cek ujian yang sudah dilaksanakan
$sql_nilai = "select id_ujian,nilai from nilai where id_user='".$_SESSION['nis_kj']."'";
$sql_nilai_exe = mysql_query($sql_nilai);
if(mysql_num_rows($sql_nilai_exe) > 0){
	$nilai = array();
	while($d_nilai = mysql_fetch_assoc($sql_nilai_exe)){
		$nilai[$d_nilai['id_ujian']] = $d_nilai['nilai'];
		}
	}
// tampilkan seluruh ujian pada mata pelajaran ini
$sql = "select * from ujian where id_mp ='".$id_mp."'";
$sql_exe = mysql_query($sql);
$no = 1;
while($data = mysql_fetch_assoc($sql_exe)){
	echo "<div class='daftar_ujian'>";
	echo "<div class='no'>".$no++."</div>";
	echo "<div class='nama_ujian'>".$data['nama_ujian']."</div>";
	echo "<div class='tanggal'>".$data['tanggal']."</div>";
	echo "<div class='waktu'>".$data['waktu']." Menit</div>";
	echo "<div class='ket'>".$data['keterangan']."</div>";
// jika suda dikerjakan
	if(isset($nilai[$data['id_ujian']])){
	echo "<div class='aksi'><span class='tombol view' onclick='view_jawaban(\"".$data['id_ujian']."\")'>Jawaban</span></div>";
	echo "<div class='nilai'>".$nilai[$data['id_ujian']]."</div>";
		}
	else {
	echo "<div class='aksi'><span class='tombol edit' onclick='kerjakan_ujian(\"".$data['id_ujian']."\")'>Kerjakan</span></div>";
	echo "<div class='nilai'>Nilainya</div>";
	}	
	
	echo "</div>";
	}

?>
</fieldset>
</div>
<div class="kembali" onclick="kembali_daftar_mp()">Kembali</div>
<script>
function kembali_daftar_mp(){
	$("#content").html(info_loading).load("mp_siswa.php");
	}		
function kerjakan_ujian(id_ujian){
	$("#content").html(info_loading).load("kerjakan_ujian.php?id_ujian="+id_ujian);
	}
function view_jawaban(id_ujian){
	$("#content").html(info_loading).load("view_jawaban.php?id_ujian="+id_ujian);
	}
	
</script>
<style>
.daftar_ujian{
	border:1px solid gray;
	margin:2px;
	overflow:auto;
	}	
.daftar_ujian div{
	float:left;
	margin:3px;
	padding:4px;
	}
.daftar_ujian div.no{
	width:2%;
	}	
.daftar_ujian div.nama_ujian{
	width:15%;
	}
.daftar_ujian div.tanggal{
	width:15%;
	}
.daftar_ujian div.waktu{
	width:14%;
	}
.daftar_ujian div.ket{
	width:20%;
	}			
.daftar_ujian div.aksi{
	width:10%;
	}	
</style>
