<?php 
	
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

		if(isset($_FILES['pdf']['name'])){	
			$data_perbandingan = [
				'algoritma' => $algoritma,
				'memory' => $memory,
				'waktu' => $kecepatan,
				'file' => $nama_file,
				'jumlah_kata' => count($data)
		 	];

		 	$output = [
		 		'status' => 1,
				'data_perbandingan' => $data_perbandingan,
				'cari' => $cari,
				'hasil_unik' => $final_hasil_unik,
				'hasil_waktu' => $hasil_waktu,
			];
		}else{
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
		}

		echo json_encode($output);
	}

 ?>