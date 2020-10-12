<?php 
	
	require 'header.php';

	$start = microtime(true);
	usleep(100);
	$hasil = binarySearch($kata, $data);
	$end = microtime(true);
	$kecepatan = $end - $start;
	$memory = memoryBinarySearch($kata, $data);
	$algoritma = 'Binary Search';

	require 'footer.php';

 ?>