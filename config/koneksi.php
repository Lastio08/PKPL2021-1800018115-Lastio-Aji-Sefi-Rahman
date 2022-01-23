<?php

	//koneksi database

	//persiapan identitas server
	$server 	= "localhost"; //Nama Server
	$user 		= "root"; //Username database
	$pass 		= ""; //password database server
	$database	= "dbarsip"; //Nama database

	//koneksi database
	$koneksi = mysqli_connect($server, $user, $pass, $database) or die (mysqli_error($koneksi));
