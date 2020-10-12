<?php 

	require 'header.php';

	// sql
	$start = microtime(true);
	usleep(100);
	$hasil = sqlSearch($koneksi, $data);
	$end = microtime(true);
	$kecepatan_sql = $end - $start;
	$memory_sql = memorySqlSearch($koneksi, $data);

	$json = [
		'kecepatan_sql' => $kecepatan_sql,
		'memory_sql' => $memory_sql,
	];

	if(isset($_FILES['pdf']['name'])) unlink($nama_file);

	echo json_encode($json);

 ?>