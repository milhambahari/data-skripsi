<?php 

	require_once "algoritma.php";
	require_once "koneksi.php";

	$cari = '';
	$kata = [];
	$data = [];
	$hasil = [];


	$sql = "SELECT * FROM kamus ORDER BY kata ASC";
	$query = mysqli_query($koneksi, $sql);
	while($row = mysqli_fetch_assoc($query)){
		$kata[] = $row['kata'];
	}

	$start = microtime(true);
	usleep(100);

	$cari = preg_replace('/[^A-Za-z0-9 ]/', '', trim(strtolower($_POST['kata'])));
	$data = explode(" ", $cari);
	if($_GET['algoritma'] == 'ss'){
		$start = microtime(true);
		usleep(100);
		$hasil = sequentialSearch($kata, $data);
		$end = microtime(true);
		$kecepatan = $end - $start;
		$memory = memorySequentialSearch($kata, $data);
		$algoritma = 'Sequential Search';
	}elseif($_GET['algoritma'] == 'bs'){
		$start = microtime(true);
		usleep(100);
		$hasil = binarySearch($kata, $data);
		$end = microtime(true);
		$kecepatan = $end - $start;
		$memory = memoryBinarySearch($kata, $data);
		$algoritma = 'Binary Search';
	}else{
		$start = microtime(true);
		usleep(100);
		$hasil = sqlSearch($koneksi, $data);
		$end = microtime(true);
		$kecepatan = $end - $start;
		$memory = memorySqlSearch($koneksi, $data);
		$algoritma = 'SQL Search';
	}

	if(count($hasil) == 0){
		$tidak_ditemukan = '<span>Kata tidak ditemukan</span>';

	 	$output = [
			'status' => 0,
			'hasil_unik' => $tidak_ditemukan,
		];

		echo json_encode($output);

	}else{

		$final_kata_ditemukan = [];
		$kata_ditemukan = array_unique($hasil);
		$jumlah_kata = count($hasil);
		foreach($kata_ditemukan as $ditemukan) $final_kata_ditemukan[] = '<span style="cursor:pointer;" onclick="getClassName('."'".$ditemukan."'".')"><u>'.$ditemukan.'</u></span>';
		
		$final_hasil_unik = implode(" ", $final_kata_ditemukan);

		$hasil_waktu = "Algortima ".$algoritma." <br> Jumlah Kata ".$jumlah_kata." <br>Waktu pencarian ".$kecepatan." detik <br> Memory yang digunakan ".$memory." KB <br> Maksimum Memory ".memory_get_peak_usage(true);

		$data_perbandingan = [
			'algoritma' => $algoritma,
			'array_hasil' => $hasil,
			'memory' => $memory,
			'waktu' => $kecepatan,
			'cari' => $data,
	 	];

	 	$output = [
	 		'status' => 1,
			'data_perbandingan' => $data_perbandingan,
			'hasil_unik' => $final_hasil_unik,
			'hasil_waktu' => $hasil_waktu,
		];

		echo json_encode($output);
	}

 ?>