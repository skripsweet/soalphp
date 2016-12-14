<?php
session_start();
include_once "include/koneksi.php";
?>
<div style="margin:0 auto;width:50%;padding:10px">
<fieldset>
<legend>Ganti Password</legend>

<?php
// ambil data mata pelajaran dari database
$nis = $_SESSION['nis_kj'];
?>
<div class='div_profil'>
	<div class="tombol info"></div>
	<div><div class="l_kiri">Password Lama</div><input class='inputan' type='password' name='pass_lama'/></div>
	<div><div class="l_kiri">Password Baru</div><input class='inputan' type='password' name='pass_baru'/></div>
	<div><div class="l_kiri">Ulangi Password</div><input class='inputan' type='password' name='ulangi_pass'/></div>
	<div><div class="l_kiri">&nbsp;</div><input class='tombol simpan' type='button' value='Ubah Password' onclick='update_pass()'/></div>
</div>
</fieldset>
</div>
<script type="text/javascript">
function update_pass(){
	var errornya = 0;
	var info="";
	$(".inputan").each(function(){
		if($(this).val() == ""){
			errornya++;
			$(this).focus();
			info = "ada yang kosong, harus diisi semua";
			return false;
			}
		})	
	// cek apakah password baru dan ulangi password adalah sama
	if($("input[name=pass_baru]").val() == $("input[name=ulangi_pass]").val()){
	
		}	
	else {
		var info = "password baru dan ulangi password tidak sama ....."+$("input[name=pass_baru]").val()+"...."+$("input[name=ulangi_pass]").val();
		errornya++;	
		}
	if(errornya == 0){		
		//simpan ke database
		var url = "cek_ganti_pass.php";
		$.post(url,{pass_lama:$("input[name=pass_lama]").val(),pass_baru:$("input[name=pass_baru]").val()},function(hasil){
			if(hasil == 1){
				// update data pada baris yang diedit
				
				$(".info").html("sudah disimpan .......").fadeIn('slow').delay("2000").fadeOut();
				}
			else{
				$(".info").html(hasil).fadeIn("slow").delay("2000").fadeOut("slow");
				}	
			})			
		}
	else {
		$(".info").html(info).fadeIn("slow").delay("2000").fadeOut("slow");
	}	
}
$(function(){
	$("input:first").focus();
	})
</script>
<style>
.l_kiri{
	width:150px;
	float:left;
	}
.div_profil{
	width:80%;
	margin:10px;
	font-size:110%;
	font-weight:bolder;
	font-style=italic;
	border-radius:4px;
	padding:10px;
	}	
.div_profil:hover{	
	background:#E5E5E5;
	}
.div_profil>div{
	margin:4px;
	}	
div input.inputan{
	width:50%;
	padding:5px;
	}	
</style>
