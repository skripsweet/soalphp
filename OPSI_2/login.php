<?php
/*--------------------------------------------------------
 Halaman untuk memproses aktivitas login dari user
 *--------------------------------------------------------*/ 
session_start();
include_once "include/koneksi.php"; 
// cek apakah id_user dan password telah terdaftar
function cek_login($username,$pass){
	$sql = "select * from user where id_user='".$username."' and password='".md5($pass)."'";
	$sql_exe = mysql_query($sql);
	if(mysql_num_rows($sql_exe) > 0){
		// simpan level dari user yang login
		$data_login = mysql_fetch_assoc($sql_exe);
		$_SESSION['level_kj'] = $data_login['level']; 
		return true;
		}
	else {
		return false;
		}	
	}
function ambil_data($username){
	$sql = "select * from ".$_SESSION['level_kj']." where nis='".$username."'";
	$sql_exe = mysql_query($sql);
	$data = mysql_fetch_assoc($sql_exe);
	return $data;
	}
$id_user = $_POST['id_user'];
$pass = $_POST['password'];
if(cek_login($id_user,$pass)){
	$data_siswa = ambil_data($id_user);
	// buat session berdasarkan data siswa
	$_SESSION['nis_kj'] = $data_siswa['nis'];
	$_SESSION['nama_kj'] = $data_siswa['nama'];
	$_SESSION['login_kj'] = true;
	header("location:hal_".$_SESSION['level_kj'].".php");
	}		
else{
	header("location:index.php?info=Username atau password salah");
	}	
?>
