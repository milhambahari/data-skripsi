<?php 

	require_once "koneksi.php";
	
	if(!$_GET['id']){
		$sql = "DELETE FROM perbandingan";
	}else{
		$sql = "DELETE FROM perbandingan WHERE id = $_GET[id]";
	}

	mysqli_query($koneksi, $sql);
	header("Location: analisis");

 ?>