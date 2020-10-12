<?php 

	require_once "koneksi.php";
	$query = mysqli_query($koneksi, "SELECT detail FROM perbandingan WHERE pengujian = $_POST[id]");
	$row = mysqli_fetch_assoc($query);

	echo $row['detail'];
 ?>