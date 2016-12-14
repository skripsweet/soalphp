<?php
include_once "include/cek_session.php"; 
include_once "include/koneksi.php"; 
$id_ujian = $_REQUEST['id_ujian'];
$sql_ujian = "select * from v_ujian_mapel where id_ujian='".$id_ujian."'";
$sql_ujian_exe = mysql_query($sql_ujian);
$data_ujian = mysql_fetch_assoc($sql_ujian_exe);
$nilai_exe = mysql_query("select nilai,detail_jawaban from nilai where id_user='".$_SESSION['nis_kj']."' and id_ujian='".$id_ujian."'");
$data_nilai = mysql_fetch_assoc($nilai_exe);
$jawaban_siswa_terpilih = explode(",",$data_nilai["detail_jawaban"]);
//$jawaban_benar = mysql_query("select * from pil_jawaban where id_soal="" status=1 and id_user='".$_SESSION['nis_kj']."' and id_ujian='".$id_ujian."'");
?>
<link  href="css/soal.css" rel="stylesheet" type="text/css" />
<!-- awal div header -->
	<div id="header">
		<div id="h_item_kiri">
			<div class="h_item">
				<div class="item_kiri">Nama</div>
				<div><?php echo $_SESSION['nama_kj']; ?></div>
			</div>
			<div class="h_item">
				<div class="item_kiri">Mata Pelajaran</div>
				<div><?php echo ucwords($data_ujian['nama_mp'])." ( ".ucwords($data_ujian['nama_ujian']).")" ?></div>
			</div>
		</div>
		<div id="h_item_kanan">
			<div class="h_item">
				<div class="item_kiri">Kelas</div>
				<div>Calon Siswa</div>
			</div>
			<div class="h_item">
				<div class="item_kiri">Nilai</div>
				<div><?php echo $data_nilai['nilai'] ?></div>
			</div>
		</div>
		
	</div><!-- akhir div header -->
	
	<!-- awal div tempat_soal -->
	<div id="tempat_soal">
<?php
// ambil pilihan jawaban dari database dan simpan de dalam array
$sql_pil = "select * from pil_jawaban where id_soal in (select id_soal from soal where id_ujian='".$id_ujian."') order by rand()";
$sql_pil_exe = mysql_query($sql_pil);
if(mysql_num_rows($sql_pil_exe) > 0){	
$data_pil_arr = array();
while($data = mysql_fetch_assoc($sql_pil_exe)){
	if(isset($data_pil_arr[$data['id_soal']])){
		$pil_jawabannya = array("id_jawaban" => $data['id_jawaban'],"status" => $data['status'],"jawaban" => $data['jawaban']);
		array_push($data_pil_arr[$data['id_soal']],$pil_jawabannya);
		}
	else {
		$data_pil_arr[$data['id_soal']] = array();
		$pil_jawabannya = array("id_jawaban" => $data['id_jawaban'],"status" => $data['status'],"jawaban" => $data['jawaban']);
		array_push($data_pil_arr[$data['id_soal']],$pil_jawabannya);
		}	
	}
// tampilkan soal ujian
$sql_soal = "select * from soal where id_ujian='".$id_ujian."' order by rand()";
$sql_soal_exe = mysql_query($sql_soal);
$no = 0;
while($soalnya = mysql_fetch_assoc($sql_soal_exe)){
	$no++;
	echo '
		<div class="soal_ujian">
			<div class="no_soal">'.$no.'</div>
			<div class="isi_soal">
				<div class="pertanyaan">'.$soalnya["isi_soal"].'</div>';
			//	$sql_pil = "select * from pil_jawaban where id_soal='".$soalnya['id_soal']."' order by rand()";
			//	$sql_pil_exe = mysql_query($sql_pil);
			//	while($data_pil = mysql_fetch_assoc($sql_pil_exe)){
			//		echo '<div class="pilihan_jawaban"><input type="radio" name="'.$data_pil['id_soal'].'" value="'.$data_pil['status'].'" onclick="koreksi(this)"/><div>'.$data_pil['jawaban'].'</div></div>';
			//		}
			foreach($data_pil_arr[$soalnya["id_soal"]] as $data_pil) {
				if(in_array($data_pil["id_jawaban"],$jawaban_siswa_terpilih)){
					$checked_radio = "checked";
					$class_div = "radio_terpilih";
					}
				// else if(in_array($data_pil["id_jawaban"],$jawaban_benar)){
				// 	$class_div = "yang_benar";
				// }
// tandai jawaban yang benar
    // $(":radio").each(function(){
    //     if($(this).val() == 1){
    //     $(this).parent().addClass("yang_benar");
    //     }
    //     })
    
						
				else {
					$checked_radio = "";
					$class_div = "";
					}	
				echo '<div class="pilihan_jawaban '.$class_div.'"><input alt="'.$data_pil["id_jawaban"].'" type="radio" name="'.$soalnya["id_soal"].'" value="'.$data_pil['status'].'" '.$checked_radio.' /><div>'.$data_pil['jawaban'].'</div></div>';
				}
	echo '</div>
		</div>
	';
	}
}
else {
	echo "soal masih belum ada !!!!!!!!!";
	}	
?>		
</div><!-- akhir div tempat_soal -->
<div class="kembali" onclick="kembali_daftar_ujian()">Kembali</div>
<script >
function kembali_daftar_ujian(){
	var id_mp = "<?php echo $data_ujian["id_mp"] ?>";
	$("#content").html(info_loading).load("daftar_ujian_siswa.php?id_mp="+id_mp);
	}		
</script>
<style>
.pilihan_jawaban > div{
	padding-left:5px;
	margin-left:25px;
	}
.radio_terpilih{
	background:#F4F4BA;
	}
.yang_benar{

}	
</style>
