<?php 

	require_once "koneksi.php";

	$pengujian = isset($_POST['pengujian']) ? $_POST['pengujian'] : '';
	$perbandingan = isset($_POST['perbandingan']) ? $_POST['perbandingan'] : '';
	$algoritma = isset($_POST['algoritma']) ? $_POST['algoritma'] : '';
	$where = "WHERE";
	$sql_pengujian = "";
	if($pengujian == 'semua'){
		$sql_pengujian = "";
		$where = "";
	}elseif($pengujian == 'awal'){
		$sql_pengujian = "pengujian  = 1";
	}elseif($pengujian == 'tengah'){
		$sql_pengujian = "pengujian = 2";
	}elseif($pengujian == 'akhir'){
		$sql_pengujian = "pengujian = 3";
	}elseif($pengujian == 'banyak'){
		$sql_pengujian = "pengujian = 4";
	}

	if($perbandingan == 'kecepatan' || $perbandingan == 'memory'){
		if($algoritma == 'semua'){

			// $query = mysqli_query($koneksi, "SELECT * FROM perbandingan WHERE pengujian BETWEEN '1' AND '15'");
			$query = mysqli_query($koneksi, "SELECT * FROM kontribusi $where $sql_pengujian");
			$data_ss = [];
			$data_bs = [];
			$data_sql = [];
			while($row_chart = mysqli_fetch_assoc($query)){
				if($perbandingan == 'kecepatan'){
					$data_ss[] = $row_chart['kecepatan_sequential'];
					$data_bs[] = $row_chart['kecepatan_binary'];
					$data_sql[] = $row_chart['kecepatan_sql'];
				}
				elseif($perbandingan == 'memory'){
					$data_ss[] = $row_chart['memory_sequential'];
					$data_bs[] = $row_chart['memory_binary'];
					$row_chart['memory_sql'];
				}

			}

			for($i=0; $i<count($data_ss); $i++){
				$data[] = [
					'y' => $i+1,
					'ss' => $data_ss[$i],
					'bs' => $data_bs[$i],
					'sql' => $data_sql[$i],
				];
			}

			$json = [
				'data' => $data,
				'metode' => 'semua',
			];

			echo json_encode($json);
		}else{
			if($algoritma == 'ss'){
				$sql = "kecepatan_sequential";
				$sql_m = "memory_sequential";
				$color = 'green';
			}elseif($algoritma == 'bs'){
				$sql = "kecepatan_binary";
				$sql_m = "memory_binary";
				$color = 'red';
			}else{
				$sql = "kecepatan_sql";
				$sql_m = "memory_sql";
				$color = 'gray';
			}

			// $query = mysqli_query($koneksi, "SELECT * FROM perbandingan WHERE algoritma ='".$sql."' AND pengujian BETWEEN '1' AND '15'");
			$query = mysqli_query($koneksi, "SELECT * FROM kontribusi WHERE $sql_pengujian");
			$i = 1;
			while($row_chart = mysqli_fetch_assoc($query)){
				if($perbandingan == 'kecepatan') $data_perbandingan = $row_chart[$sql];
				else $data_perbandingan = $row_chart[$sql_m];

				$data[] = [
					'y' => $i,
					'a' => $data_perbandingan,
				];

				$i++;
			}

			$json = [
				'data' => $data,
				'color' => $color,
				'algoritma' => $sql,
				'perbandingan' => $perbandingan,
				'metode' => 'algoritma'
			];

			echo json_encode($json);
		}



	}

	if($perbandingan == 'hasil_kecepatan' || $perbandingan == 'hasil_memory'){
		// $query = mysqli_query($koneksi, "SELECT algoritma, AVG(waktu) AS data_waktu, AVG(memory) AS data_memory FROM perbandingan WHERE pengujian BETWEEN '16' AND '30' GROUP BY algoritma");
		$query = mysqli_query($koneksi, "SELECT AVG(kecepatan_sequential) AS data_kecepatan_sequential, AVG(kecepatan_binary) AS data_kecepatan_binary, AVG(kecepatan_sql) AS data_kecepatan_sql, AVG(memory_sequential) AS data_memory_sequential, AVG(memory_binary) AS data_memory_binary, AVG(memory_sql) AS data_memory_sql FROM kontribusi $where $sql_pengujian");
		$row_kontribusi = mysqli_fetch_assoc($query);
		$perbandingan_kecepatan = [
			$row_kontribusi['data_kecepatan_sequential'],
			$row_kontribusi['data_kecepatan_binary'],
			$row_kontribusi['data_kecepatan_sql'],
			
		];
		$perbandingan_memory = [
			$row_kontribusi['data_memory_sequential'],
			$row_kontribusi['data_memory_binary'],
			$row_kontribusi['data_memory_sql'],
		];
		$data_algoritma = [
			'Sequential Search',
			'Binary Search',
			'SQL Search',
		];
		for($k=0; $k<count($perbandingan_kecepatan); $k++){
			if($perbandingan == 'hasil_kecepatan') $jenis_perbandingan = $perbandingan_kecepatan[$k];
			elseif($perbandingan == 'hasil_memory') $jenis_perbandingan = $perbandingan_memory[$k];

			$data[] = [
				'y' => $data_algoritma[$k],
				'a' => $jenis_perbandingan,
			];
		}

		$json = [
			'data' => $data,
			'chart' => 'bar'
		];

		echo json_encode($json);
	}
 ?>