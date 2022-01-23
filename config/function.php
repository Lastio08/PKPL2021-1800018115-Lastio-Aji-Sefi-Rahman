<?php

//persiapan function untuk upload file/foto
function upload($subFolder)
{
	//deklarasi variabel kebutuhan
	$namafile = $_FILES['file']['name'];
	$ukuranfile = $_FILES['file']['size'];
	$error = $_FILES['file']['error'];
	$tmpname = $_FILES['file']['tmp_name'];

	//cek apakah file yang diupload file/gambar
	$eksfilevalid = ['jpg','jpeg','png','pdf','docx','csv','xls','xlsx','pptx'];
	$eksfile = explode('.', $namafile);
	$eksfile = strtolower(end($eksfile));
	if(!in_array($eksfile, $eksfilevalid)){
		echo "<script> alert('Yang anda Upload tidak sesuai. . .!') </script>";
		return false;
	}

	//cek jika ukuran file terlalu besar
	if($ukuranfile > 1000000000000){
		echo "<script> alert('Ukuran File anda terlalu besar. . .!') </script>";
		return false;
	}

	//jika lolos pengecekkan, file siap diupload
	//genrate nama file baru

	$namafilebaru = uniqid();
	$namafilebaru .= '.';
	$namafilebaru .= $eksfile;


    $uplad = mkdir("file/".$subFolder."/");
    $dirUpload = "file/".$subFolder."/";


        // // pindahkan file
        // $terupload = move_uploaded_file($namaSementara, $dirUpload.$namaFile);

	move_uploaded_file($tmpname, $dirUpload.$namafile);
	return $namafile;
}

?>