<?php 

	$koneksi = mysqli_connect('localhost', 'root', '', 'kbbi') OR mysqli_error();

	$kamus = [];
	$sql = mysqli_query($koneksi, "SELECT * FROM kamus");
	while($query = mysqli_fetch_assoc($sql)){
		$row[] = [
			'kata' => $query['kata'],
			'definisi' => str_replace('"', "'", $query['definisi']),
			'sumber' => $query['sumber'],
		];
	}

	// $hasil = [
	// 	'kamus' => $row
	// ];
	header('Content-type: application/json');
	echo json_encode($row);

 ?>