<?php

	@$halaman = $_GET['halaman'];

	if($halaman == "departemen")
	{
		//tampil halaman Departemen
		//echo "Tampil Halaman Modul Departemen";
		include "modul/departemen/departemen.php";
	}
	elseif ($halaman == "pengirim_surat")
	{
		//tampil halaman pengirim surat
		//echo "Tampil Halaman Modul Pengirim Surat";
		include "modul/pengirim_surat/pengirim_surat.php";
	}
	elseif ($halaman == "arsip_surat")
	{
		//tampil halaman arsip surat
		//echo "Tampil Halaman Modul Arsip Surat";
		if (@$_GET['hal'] == "tambahdata" || @$_GET['hal'] == "edit" || @$_GET['hal'] == "hapus")
		{
			include "modul/arsip/form.php";
		}else{
			include "modul/arsip/data.php";
		}
	}
	elseif ($halaman == "arsip_suratkeluar")
	{
		//tampil halaman arsip surat
		//echo "Tampil Halaman Modul Arsip Surat";
		if (@$_GET['hal'] == "tambahdata" || @$_GET['hal'] == "edit" || @$_GET['hal'] == "hapus")
		{
			include "modul/arsip/formkeluar.php";
		}else{
			include "modul/arsip/data_arsipkeluar.php";
		}
	}
	else
	{
		//echo "Tampil Halaman Home";
		include "Modul/home.php";
	}
?>