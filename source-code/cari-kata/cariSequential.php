<?php 
	
	require 'header.php';

	$start = microtime(true);
	usleep(100);
	$hasil = sequentialSearch($kata, $data);
	$end = microtime(true);
	$kecepatan = $end - $start;
	$memory = memorySequentialSearch($kata, $data);
	$algoritma = 'Sequential Search';

	require 'footer.php';

 ?>