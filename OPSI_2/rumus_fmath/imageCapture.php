<?php
//boleh diganti dengan $_SERVER['SERVER_NAME']; bila memang telah pasti nama servernya
if($_POST["save"]){
			$type = $_POST["type"];
			if($_POST["name"] and ($type=="JPG" or $type=="PNG" or $type=="GIF")){
				$img = base64_decode($_POST["image"]);

				$myFile = "img/".$_POST["name"].".".$type ;
				$fh = fopen($myFile, 'w');
				fwrite($fh, $img);
				fclose($fh);
				echo "http://localhost/app-skripsi/farah/otk/online_test_kaji/rumus_fmath/img/".$_POST["name"].".".$type;
				}
		}else{
			header('Content-Type: image/jpeg');
			echo base64_decode($_POST["image"]);
		}
?>
