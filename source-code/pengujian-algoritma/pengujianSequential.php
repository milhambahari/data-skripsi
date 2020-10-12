<?php 

	require 'header.php';

	// sequential
	$start = microtime(true);
	usleep(100);
	$hasil = sequentialSearch($kata, $data);
	$end = microtime(true);
	$kecepatan_sequential = $end - $start;
	$memory_sequential = memorySequentialSearch($kata, $data);

	$json = [
		'kecepatan_sequential' => $kecepatan_sequential,
		'memory_sequential' => $memory_sequential,
	];

	echo json_encode($json);


 ?>