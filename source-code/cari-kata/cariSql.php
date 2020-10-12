<?php 
	
	require 'header.php';

	$start = microtime(true);
	usleep(100);
	$hasil = sqlSearch($koneksi, $data);
	$end = microtime(true);
	$kecepatan = $end - $start;
	$memory = memorySqlSearch($koneksi, $data);
	$algoritma = 'SQL Search';

	require 'footer.php';


 ?>