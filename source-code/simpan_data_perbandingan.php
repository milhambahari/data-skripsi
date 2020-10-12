<?php 

	require_once "koneksi.php";
	require_once "algoritma.php";

	if($_POST['tipe'] == 'kata'){	
		$hasil = $_POST['hasil'];
		$kata_ditemukan = array_unique($hasil['array_hasil']);
		$kata_dicari = implode(",", $kata_ditemukan);
		$jumlah_kata = count($hasil['array_hasil']);
		$algoritma = $hasil['algoritma'];
		$waktu = $hasil['waktu'];
		$memory = $hasil['memory'];

		$sql = "SELECT * FROM kamus";
		$query = mysqli_query($koneksi, $sql);
		while($row = mysqli_fetch_assoc($query)){
			$kata[] = $row['kata'];
		}

		if($algoritma == 'Sequential Search'){
			$output = simpanDataSequentialSearch($kata, $hasil['cari']);
		}elseif($algoritma == 'Binary Search'){
			$output = simpanDataBinarySearch($kata, $hasil['cari']);	
		}else{
			$output = simpanDataSqlSearch($koneksi, $hasil['cari']);		
		}


		$jumlah_perbandingan = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM perbandingan"));
		$sql_perbandingan = "INSERT INTO perbandingan(pengujian, kata, algoritma, waktu, memory, jumlah_kata, detail) VALUES($jumlah_perbandingan+1, '$kata_dicari', '$algoritma', '$waktu', '$memory', '$jumlah_kata', '$output')";
		mysqli_query($koneksi, $sql_perbandingan);
	}else{
		$hasil = $_POST['hasil'];
		$kata_dicari = $hasil['file'];
		$jumlah_kata = $hasil['jumlah_kata'];
		$algoritma = $hasil['algoritma'];
		$waktu = $hasil['waktu'];
		$memory = $hasil['memory'];
		$output = '';
		
		$jumlah_perbandingan = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM perbandingan"));
		$sql_perbandingan = "INSERT INTO perbandingan(pengujian, kata, algoritma, waktu, memory, jumlah_kata, detail) VALUES($jumlah_perbandingan+1, '$kata_dicari', '$algoritma', '$waktu', '$memory', '$jumlah_kata', '$output')";
		mysqli_query($koneksi, $sql_perbandingan);
	}



 ?>