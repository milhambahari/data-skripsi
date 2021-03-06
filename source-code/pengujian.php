<?php 

	include('class.pdf2text.php');
	require_once "koneksi.php";
	require_once "algoritma.php";

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

	// sequential
	$start = microtime(true);
	usleep(100);
	$hasil = sequentialSearch($kata, $data);
	$end = microtime(true);
	$kecepatan_sequential = $end - $start;
	$memory_sequential = memorySequentialSearch($kata, $data);

	// binary
	$start = microtime(true);
	usleep(100);
	$hasil = binarySearch($kata, $data);
	$end = microtime(true);
	$kecepatan_binary = $end - $start;
	$memory_binary = memoryBinarySearch($kata, $data);

	// sql
	$start = microtime(true);
	usleep(100);
	$hasil = sqlSearch($koneksi, $data);
	$end = microtime(true);
	$kecepatan_sql = $end - $start;
	$memory_sql = memorySqlSearch($koneksi, $data);

	$json = [
		'kecepatan_sequential' => $kecepatan_sequential,
		'kecepatan_binary' => $kecepatan_binary,
		'kecepatan_sql' => $kecepatan_sql,
		'memory_sequential' => $memory_sequential,
		'memory_binary' => $memory_binary,
		'memory_sql' => $memory_sql,
	];

	echo json_encode($json);
 ?>