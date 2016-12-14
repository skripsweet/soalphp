<?php
include_once "include/cek_session.php"; 
include_once "include/koneksi.php"; 
$id_ujian = $_REQUEST['id_ujian'];
$sql_ujian = "select * from v_ujian_mapel where id_ujian='".$id_ujian."'";
$sql_ujian_exe = mysql_query($sql_ujian);
$data_ujian = mysql_fetch_assoc($sql_ujian_exe);
if(isset($_SESSION["mulai_".$id_ujian])){
    $telah_berlalu = time() - $_SESSION["mulai_".$id_ujian];
    }
else {
    $_SESSION["mulai_".$id_ujian] = time();
    $telah_berlalu = 0;
    }   
 
?>
<script type="text/javascript" src="js/jquery.countdown.js"></script>
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
                <div>
                    <?php 
                    // ambil data dari session yang dibuat ketika login
                    //echo $_SESSION["kelas_kj"];
                    ?>
                </div>
            </div>
            <div class="h_item">
                <div class="item_kiri">Nilai</div>
                <div>0</div>
            </div>
        </div>
        <!-- <div id="timer">00 : 00 : 00</div> -->
    </div><!-- akhir div header -->
     
    <!-- awal div tempat_soal -->
    <div id="tempat_soal">
        <div>Waktu perhalaman : <span id="timer_perhal">00 : 00 : 00</span></div>
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
$jum_soal = mysql_num_rows($sql_soal_exe);
$per_page = 2;
$page_awal = $page_now = 1;
$page_akhir = ceil($jum_soal / $per_page);
$no = 0;
while($soalnya = mysql_fetch_assoc($sql_soal_exe)){
    $no++;
    if($no > ($per_page * $page_now)){
        $page_now++;
        }
    echo '
        <div class="soal_ujian page_'.$page_now.'">
            <div class="no_soal">'.$no.'</div>
            <div class="isi_soal">
                <div class="pertanyaan">'.$soalnya["isi_soal"].'</div>';
            //  $sql_pil = "select * from pil_jawaban where id_soal='".$soalnya['id_soal']."' order by rand()";
            //  $sql_pil_exe = mysql_query($sql_pil);
            //  while($data_pil = mysql_fetch_assoc($sql_pil_exe)){
            //      echo '<div class="pilihan_jawaban"><input type="radio" name="'.$data_pil['id_soal'].'" value="'.$data_pil['status'].'" onclick="koreksi(this)"/><div>'.$data_pil['jawaban'].'</div></div>';
            //      }
            foreach($data_pil_arr[$soalnya["id_soal"]] as $data_pil) {
                echo '<div class="pilihan_jawaban" onclick="pilih_jawaban(this)"><input alt="'.$data_pil["id_jawaban"].'" type="radio" name="'.$soalnya["id_soal"].'" value="'.$data_pil['status'].'" /><div>'.$data_pil['jawaban'].'</div></div>';
                }
    echo '</div>
        </div>';
    }
}
else {
    echo "soal masih belum ada !!!!!!!!!";
    }   
?>       
    <!--
    <div style="margin-top:25px"><span style="padding:6px;font-size:95%" class="tombol" onclick="koreksi_simpan()">Koreksi dan Simpan</span></div>
    -->
    </div><!-- akhir div tempat_soal -->
 
<script type="text/javascript">
var waktu_perhal = 120 ; // 2 menit ( 2 * 60 detik) 
function waktuHabis(){
    alert("waktu habis ......");
    koreksi_simpan();
    }       
function hampirHabis(periods){
    if($.countdown.periodsToSeconds(periods) == 60){
        $(this).css({color:"red"});
        }
    }
function tutup_redirect(id_info,id_mp){
    $("#"+id_info).parent().remove();
    $("#content").html(info_loading).load("daftar_ujian_siswa.php?id_mp="+id_mp);
            };  
function coba_lagi(id_info){
    $("#"+id_info).parent().remove();
    koreksi_simpan();       
    }
function pilih_jawaban(elm){
    $(elm).find("input:radio").attr("checked",true);
    }               
function koreksi_simpan(){
    // hapus timer countdown
    $("#timer").countdown("destroy");
    $("#timer_perhal").countdown("destroy");
    var id_mp = "<?php echo $data_ujian['id_mp'] ?>";
    var id_ujian ="<?php echo $id_ujian ?>";
    var id_user = "<?php echo $_SESSION['nis_kj'] ?>";
    var id_info ="<?php echo 'info_'.$id_ujian ?>";
    var jum_soal = "<?php echo $no ?>";
    // lihat berapa jawaban yang benar
    var benar = 0;
    // tandai jawaban yang benar
    $(":radio").each(function(){
        if($(this).val() == 1){
        $(this).parent().addClass("yang_benar");
        }
        })
    // koreksi gan
    var jawaban_siswa = new Array();
    $(":checked").each(function(){
        if($(this).val() == 1){
            benar++;
            };
        jawaban_siswa += $(this).attr("alt")+",";   
        })
    if(jawaban_siswa.length > 0){
    jawaban_siswa = jawaban_siswa.substr(0,jawaban_siswa.length - 1);   
    }   
//  alert(jawaban_siswa);
    var nilai = (benar / jum_soal) * 100;
    // simpan ke database
    var tinggi_div_soal = $("#tempat_soal").outerHeight();
    var lebar_div_soal = $("#tempat_soal").outerWidth();
    var posisi = $("#tempat_soal").position();
    var div_overlay = "<div style='position:absolute;top:"+posisi.top+";left:"+posisi.left;
        div_overlay +=";width:"+lebar_div_soal+"px;height:"+tinggi_div_soal+";background:#FFFFFF;opacity:0.4;z-index:9' >";  
        div_overlay +="</div>";
        div_overlay +="<div id='"+id_info+"' style='position:absolute;border:1px solid #000000;font-weight:bolder;z-index:10";
        div_overlay +=";width:"+0.25 * lebar_div_soal+"px;background:#CEF3CE;padding:6px;border:1px solid #00FF00;border-radius:3px;' >";
        div_overlay +="Sedang menyimpan ...........</div>";
    $(div_overlay).appendTo("#tempat_soal");
    var atas = (($(window).height() - $("#"+id_info).height()) / 2) + $(window).scrollTop();
    var kiri = (($(window).width() - $("#"+id_info).width()) / 2) + $(window).scrollLeft();
    $("#"+id_info).css({"top":atas+"px","left":kiri+"px"});
    //simpan ke database
    var url = "simpan_form.php";
    var tabel = "nilai";
    var data = [{"name":"id_user","value":id_user},{"name":"id_ujian","value":id_ujian},{"name":"nilai","value":nilai},{"name":"detail_jawaban","value":jawaban_siswa}];
    /*
    $.post(url,{tbl:tabel,data:data},function(hasil){
        if(hasil == 1){
            var ket_nilai = "<div>Nilai Anda : "+nilai+"</div><div>Jawaban Yang benar :"+benar+"</div><div>Jumlah soal "+jum_soal+"</div>";
                ket_nilai +="<div style='margin-top:5px'><span class='tombol' onclick='tutup_redirect(\""+id_info+"\",\""+id_mp+"\")'>OK</span></div>";
            $("#"+id_info).html(ket_nilai);
            // hapus overlay
            //$("#"+id_info).parent().remove();
            //$("#content").html("").load("daftar_ujian_siswa.php?id_mp="+id_mp);
            }
        else {
            var lagi = confirm("Gagal disimpan, mungkin koneksi terputus <br /> Coba lagi");
            if(lagi){
            // hapus overlay
            $("#"+id_info).parent().remove();
            koreksi_simpan();       
                }
             
            }   
        })
        */
        $.ajax({
            type:"POST",
            url: url,
            data:{tbl:tabel,data:data},
            success:function(){
                var ket_nilai = "<div>Nilai Anda : "+nilai+"</div><div>Jawaban Yang benar :"+benar+"</div><div>Jumlah soal "+jum_soal+"</div>";
                ket_nilai +="<div style='margin-top:5px'><span class='tombol' onclick='tutup_redirect(\""+id_info+"\",\""+id_mp+"\")'>OK</span></div>";
            $("#"+id_info).html(ket_nilai);
            },
            error:function(){
            $("#"+id_info).html("Gagal menyimpan ...........<span class='tombol' onclick='coba_lagi(\""+id_info+"\")'>Coba lagi</span>");
            }
            })
    }
function next_page(){
    var page_akhir = <?php echo $page_akhir; ?>;
    // cari halaman sekarang
    var page_now = $(".soal_ujian:visible").eq(0).attr("class");
    // page_now akan menghasilkan nilai soal_ujian page_1 misalnya dan kita hanya memerlukan nilai 1
    var page_next = parseInt(page_now.substring(16)) + 1;
    $(".soal_ujian:visible").hide();
    $(".page_"+page_next).show();
    // update link nav
    if(page_next == page_akhir){
    var link_baru ='<span style="padding:6px;font-size:95%" class="tombol" onclick="prev_page()">Sebelumnya</span><span style="padding:6px;font-size:95%" class="tombol" onclick="koreksi_simpan()">Koreksi dan Simpan</span>';
        }
    else {
//  var link_baru ='<span style="padding:6px;font-size:95%" class="tombol" onclick="prev_page()">Sebelumnya</span><span style="padding:6px;font-size:95%" class="tombol" onclick="next_page()">Selanjutnya</span>'; 
    var link_baru ='<span style="padding:6px;font-size:95%" class="tombol" onclick="next_page()">Selanjutnya</span>';   
        }
    $("#nav_soal").html(link_baru);
    // update timer per halaman
    $("#timer_perhal").countdown("change",{until:waktu_perhal}); 
    }
function prev_page(){
    var page_awal = <?php echo $page_awal; ?>;
    // cari halaman sekarang
    var page_now = $(".soal_ujian:visible").eq(0).attr("class");
    // page_now akan menghasilkan nilai soal_ujian page_1 misalnya dan kita hanya memerlukan nilai 1
    var page_prev = parseInt(page_now.substring(16)) - 1;
    $(".soal_ujian:visible").hide();
    $(".page_"+page_prev).show();
    // update link nav
    if(page_prev == page_awal){
    var link_baru ='<span style="padding:6px;font-size:95%" class="tombol" onclick="next_page()">Selanjutnya</span>';
        }
    else {
    var link_baru ='<span style="padding:6px;font-size:95%" class="tombol" onclick="prev_page()">Sebelumnya</span><span style="padding:6px;font-size:95%" class="tombol" onclick="next_page()">Selanjutnya</span>'; 
        }
    $("#nav_soal").html(link_baru);
    }                   
$(function(){
    var longWayOff = "<?php echo ($data_ujian['waktu'] * 60) - $telah_berlalu ?>";
    if(parseInt(longWayOff) <= 0 ){
        waktuHabis();
        }
    else {
    $("#timer").countdown({ 
        until: longWayOff,
        compact:true,
        onExpiry:waktuHabis,
        onTick: hampirHabis
        });
    }
// tampilkan timer untuk perhalaman
    $("#timer_perhal").countdown({ 
        until: waktu_perhal,
        compact:true,
        onExpiry:next_page,
        onTick: hampirHabis
        }); 
// tampilkan hanya halaman pertama saja         
    var per_page = <?php echo $per_page; ?>;
    var page_awal = <?php echo $page_awal; ?>;
    var page_akhir = <?php echo $page_akhir; ?>;
    $(".soal_ujian").hide();
    $(".page_"+page_awal).show();
    // tambahkan tombol next, prev atau simpan ke tempat_soal
    if(page_awal == page_akhir){
    var link_nav = '<div id="nav_soal" style="margin-top:25px"><span style="padding:6px;font-size:95%" class="tombol" onclick="koreksi_simpan()">Koreksi dan Simpan</span></div>';
        }
    else {
    var link_nav = '<div id="nav_soal" style="margin-top:25px"><span style="padding:6px;font-size:95%" class="tombol" onclick="next_page()">Selanjutnya</span></div>';  
        }
    $(link_nav).appendTo("#tempat_soal");
})
</script>
<style>
.pilihan_jawaban > div{
    padding-left:5px;
    margin-left:25px;
    }
.yang_benar{
    background:#C4F7C4;
    }
.yang_salah{
    background:#00ffff;
}
#timer_perhal{
    padding:4px;
    border:1px solid #000000;
    border-radius:3px;
    }   
</style>