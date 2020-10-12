<?php 

	require_once "koneksi.php";
	$cari = '';
	$kata = [];
	$data = [];


	$sql = "SELECT * FROM kamus WHERE kata = '$_POST[kata]'";
	$query = mysqli_query($koneksi, $sql);
	while($row = mysqli_fetch_assoc($query)){	
		$hasil[] = [
			'id' => $row['id'],
			'kata' => $row['kata'],
			'definisi' => $row['definisi'],
			'sumber' => $row['sumber'],
		];
	}	

	echo json_encode($hasil);

 ?>