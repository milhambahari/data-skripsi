<?php 

	require 'header.php';

	// binary
	$start = microtime(true);
	usleep(100);
	$hasil = binarySearch($kata, $data);
	$end = microtime(true);
	$kecepatan_binary = $end - $start;
	$memory_binary = memoryBinarySearch($kata, $data);

	$json = [
		'kecepatan_binary' => $kecepatan_binary,
		'memory_binary' => $memory_binary,
	];

	echo json_encode($json);

 ?>