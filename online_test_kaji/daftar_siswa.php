<?php
/*--------------------------------------------------------
 * Buat ujian untuk mata pelajaran tertentu
 *--------------------------------------------------------*/ 
include_once "include/cek_session.php";
include_once "include/koneksi.php"; 
include_once "include/fungsi.php"; 
?>
<div style="width:80%;margin:0 auto">	
<fieldset style="margin:0 auto">
<legend>Daftar Siswa Peserta Ujian </legend>
<form id="f_siswa">
<input type="text" name="nis" value="nomer daftar" class="inputan" onfocus="bersihkan(this)" onblur="kembali_semula(this)"/>
<input type="text" name="nama" value="nama siswa" class="inputan" onfocus="bersihkan(this)" onblur="kembali_semula(this)"/>
<input type="text" name="alamat" value="alamat siswa" class="inputan" onfocus="bersihkan(this)" onblur="kembali_semula(this)"/>
<input type="text" name="agama" readonly value="Islam" class="inputan"/>
<span id="simpan_siswa" class="tombol tambah" onclick="simpan_siswa(this)">Siswa</span>
<span id="update_siswa" style="display:none">
<span class="tombol simpan" onclick="update_siswa(this)">Siswa</span>
<span class="tombol batal" onclick="batal_update()">Batal</span>
</span>
<span class='tombol info'></span>	
</form>
	<?php
	$sql="select * from siswa";
	$sql_exe = mysql_query($sql);
	if(mysql_num_rows($sql_exe) > 0){
	echo "<table class='listing' cellpadding='0' cellspacing='0'>";	
	// buat headernya kawan
	echo "<thead>";
	echo "<tr>";
	echo "<th>No</th>";
	$jum_kolom = mysql_num_fields($sql_exe);
	for($i = 0; $i < $jum_kolom; $i++){
		echo "<th>".mysql_field_name($sql_exe,$i)."</th>";
		}
	echo "<th>Aksi</th>";	
	echo "</tr>";
	echo "</thead>";
	echo "<tbody>";
	$no = 1;
	while($data_baris = mysql_fetch_assoc($sql_exe)){
		echo "<tr>";
		echo "<td>".$no++."</td>";
		foreach($data_baris as $data){
			echo "<td>".$data."</td>";
			}
		echo "<td><span class='tombol edit' onclick='edit_siswa(this)'>Siswa</span>&nbsp;<span class='tombol hapus' onclick='hapus_siswa(this,\"".$data_baris['nis']."\")'>Siswa</span></td>";	
		echo "</tr>";
		}
	echo "</tbody>";
	echo "</table>";
		}
	else {
		echo "Data masih kosong, diisi dulu ya ........";
		}	 
	?>
</fieldset>
</div>
<div class="kembali" onclick="kembali_lagi()">Kembali</div>
<script >
function kembali_lagi(){
	$("#content").html(info_loading).load("beranda.php");
	}	
function simpan_siswa(elm){
	var errornya = 0;
	$(".inputan").each(function(){
		if($(this).val() == ""){
			errornya++;
			$(this).focus();
			return false;
			}
		})	
	if(errornya == 0){
		//simpan ke database
		var data = $(elm).parent().serializeArray();
		var url = "simpan_form.php";
		var tabel = "siswa";
		$.post(url,{data:data,tbl:tabel},function(hasil){
			if(hasil == 1){
				// reload content dengan halaman ini
			//	$("#content").html("").load("daftar_siswa.php");
			var jml_baris = $("table.listing tr").length;
			var data_baru = "<td>"+jml_baris+"</td>";
				$(".inputan").each(function(index){
					data_baru +="<td>"+$(this).val()+"</td>";
					});
			data_baru +="<td><span class='tombol edit' onclick='edit_siswa(this)'>Siswa</span>&nbsp;<span class='tombol hapus' onclick='hapus_siswa(this,\""+$(".inputan").eq(0).val()+"\")'>Siswa</span></td>";		
			var baris_baru = "<tr>"+data_baru+"</tr>";		
			$(baris_baru).insertAfter($("table.listing tr:last"));
			$(".info").html("sudah disimpan .......").fadeIn('slow').delay("2000").fadeOut();
				}
			else{
				alert("gagal disimpan, mungkin data sudah ada \n atau koneksi bermasalah");
				}	
			})
		}
	else {
		alert("harus diisi semua....");
		}	
	}
function edit_siswa(elm){
	var baris = $(elm).parent().parent();
	// hapus kelas sedang diedit pada baris lainnya
	$(baris).parent().find("td.sedang_diedit").removeClass("sedang_diedit");
	$(baris).children().addClass("sedang_diedit");
	var inputan = $(".inputan");
	$(baris).find("td").not(":first").each(function(index){
		$(inputan).eq(index).val($(this).text());
		})
	// nis siswa jadikan readonly supaya gak bisa diedit
	$(inputan).eq(0).attr("readonly",true);	
	$("#update_siswa").fadeIn();
	$("#simpan_siswa").fadeOut();
	}		
function update_siswa(elm){
	var errornya = 0;
	$(".inputan").each(function(){
		if($(this).val() == ""){
			errornya++;
			$(this).focus();
			return false;
			}
		})	
	if(errornya == 0){
		//simpan ke database
		var data = $(elm).parent().parent().serializeArray();
		var url = "update_data.php";
		var tabel = "siswa";
		//data.unshift({"name":"id_ujian","value":$("#update_ujian").data("id_ujian")});
		$.post(url,{data:data,table:tabel},function(hasil){
			if(hasil == 1){
				// update data pada baris yang diedit
				var kolom_data = $("td.sedang_diedit").not(":first");
				$(".inputan").each(function(index){
					$(kolom_data).eq(index).text($(this).val());
					});
				// hapus class sedang diedit dan tambahkan kelas telah diedit
				$(kolom_data).removeClass("sedang_diedit").addClass("telah_diedit");
				$(".info").html("sudah disimpan .......").fadeIn('slow').delay("2000").fadeOut();
				}
			else{
				alert("gagal disimpan, mungkin data sudah ada \n atau koneksi bermasalah"+hasil);
				
				}	
			})			
		}
	else {
		alert("harus diisi semua....");
	}	
}
function batal_update(){
	$("td.sedang_diedit").removeClass("sedang_diedit");
	$("#update_siswa").fadeOut();
	$("#simpan_siswa").fadeIn();
	$(".inputan").each(function(){
		$(this).val($("#content").data("awal_"+$(this).attr("name")));
		})
	$(".inputan").eq(0).attr("readonly",false);		
	}
function hapus_siswa(elm,nis){
	var hapus = confirm("Yakin akan menghapus siswa dengan nis = "+nis);
	if(hapus){
	var url = "hapus_data.php";		
	$.post(url,{id_nilai:nis,id_nama:"nis",table:"siswa"},function(hasil){
		if(hasil == 1){
			// hapus dibaris yang dihapus saja kawan
			$(elm).parent().parent().remove();
			}
		else {
			alert("gagal dihapus cek query anda .....");
			}	
		})
	}
}		
$(function(){
	$(".inputan").each(function(){
		$("#content").data("awal_"+$(this).attr("name"),$(this).val());
		})
	})		
</script>


