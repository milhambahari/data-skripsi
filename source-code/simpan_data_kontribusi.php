<?php 

	require_once "koneksi.php";

	$data_get = $_POST['data_get'];
	$data = $_POST['data'];

	$nama = $data_get['nama'];
	$nim = $data_get['nim'];
	$email = $data_get['email'];
	$no_wa = $data_get['no_wa'];
	$email = $data_get['email'];
	$pengujian = $data_get['pengujian'];
	$kecepatan_sequential = $data['kecepatan_sequential'];
	$kecepatan_binary = $data['kecepatan_binary'];
	$kecepatan_sql = $data['kecepatan_sql'];
	$memory_sequential = $data['memory_sequential'];
	$memory_binary = $data['memory_binary'];
	$memory_sql = $data['memory_sql'];

	$sql = "INSERT INTO kontribusi(nama,nim,no_wa,email,pengujian,kecepatan_sequential,kecepatan_binary,kecepatan_sql,memory_sequential,memory_binary,memory_sql) VALUES('$nama','$nim','$no_wa','$email','$pengujian','$kecepatan_sequential','$kecepatan_binary','$kecepatan_sql','$memory_sequential','$memory_binary','$memory_sql')";
	mysqli_query($koneksi, $sql);

 ?>