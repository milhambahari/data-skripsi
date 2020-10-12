<?php 
	ini_set('max_execution_time', 1000);
	include('../class.pdf2text.php');
	require_once "../algoritma.php";
	require_once "../koneksi.php";

	$cari = '';
	$kata = [];
	$data = [];
	$hasil = [];


	$sql = "SELECT * FROM kamus ORDER BY kata ASC";
	$query = mysqli_query($koneksi, $sql);
	while($row = mysqli_fetch_assoc($query)){
		$kata[] = $row['kata'];
	}

	if(isset($_FILES['pdf']['name'])){
		$nama_file = $_FILES['pdf']['name'];
		$target = basename($_FILES['pdf']['name']);
	    move_uploaded_file($_FILES['pdf']['tmp_name'], $target);
	    chmod($_FILES['pdf']['name'],0777);
		$var = new PDF2Text();
		$var->setFilename($_FILES['pdf']['name']);
		$var->decodePDF();
		$cari = preg_replace('/[^A-Za-z0-9 ]/', '', trim(strtolower($var->output())));
		$data = explode(" ",$cari);
		unlink($nama_file);
	}else{
		$cari = preg_replace('/[^A-Za-z0-9 ]/', '', trim(strtolower($_POST['kata'])));
		$data = explode(" ", $cari);
	}

 ?>