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
		$sql_pengujian = "pengujian BETWEEN '1' AND '15'";
	}elseif($pengujian == 'tengah'){
		$sql_pengujian = "pengujian BETWEEN '16' AND '30'";
	}elseif($pengujian == 'akhir'){
		$sql_pengujian = "pengujian BETWEEN '31' AND '45'";
	}elseif($pengujian == 'banyak'){
		$sql_pengujian = "pengujian BETWEEN '46' AND '60'";
	}

	if($perbandingan == 'kecepatan' || $perbandingan == 'memory'){
		if($algoritma == 'semua'){

			// $query = mysqli_query($koneksi, "SELECT * FROM perbandingan WHERE pengujian BETWEEN '1' AND '15'");
			$query = mysqli_query($koneksi, "SELECT * FROM perbandingan $where $sql_pengujian");
			$data_ss = [];
			$data_bs = [];
			$data_sql = [];
			while($row_chart = mysqli_fetch_assoc($query)){
				if($perbandingan == 'kecepatan'){
					if($row_chart['algoritma'] == 'Sequential Search') $data_ss[] = $row_chart['waktu'];
					if($row_chart['algoritma'] == 'Binary Search') $data_bs[] = $row_chart['waktu'];
					if($row_chart['algoritma'] == 'SQL Search') $data_sql[] = $row_chart['waktu'];
				}
				elseif($perbandingan == 'memory'){
					if($row_chart['algoritma'] == 'Sequential Search') $data_ss[] = $row_chart['memory'];
					if($row_chart['algoritma'] == 'Binary Search') $data_bs[] = $row_chart['memory'];
					if($row_chart['algoritma'] == 'SQL Search') $data_sql[] = $row_chart['memory'];
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
				$sql = "Sequential Search";
				$color = 'green';
			}elseif($algoritma == 'bs'){
				$sql = "Binary Search";
				$color = 'red';
			}else{
				$sql = "SQL Search";
				$color = 'gray';
			}

			// $query = mysqli_query($koneksi, "SELECT * FROM perbandingan WHERE algoritma ='".$sql."' AND pengujian BETWEEN '1' AND '15'");
			$query = mysqli_query($koneksi, "SELECT * FROM perbandingan WHERE algoritma ='".$sql."' AND $sql_pengujian");
			$i = 1;
			while($row_chart = mysqli_fetch_assoc($query)){
				if($perbandingan == 'kecepatan') $data_perbandingan = $row_chart['waktu'];
				else $data_perbandingan = $row_chart['memory'];

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
		$query = mysqli_query($koneksi, "SELECT algoritma, AVG(waktu) AS data_waktu, AVG(memory) AS data_memory FROM perbandingan $where $sql_pengujian GROUP BY algoritma");
		while($row_chart = mysqli_fetch_assoc($query)){
			if($perbandingan == 'hasil_kecepatan') $jenis_perbandingan = $row_chart['data_waktu'];
			elseif($perbandingan == 'hasil_memory') $jenis_perbandingan = $row_chart['data_memory'];

			$data[] = [
				'y' => $row_chart['algoritma'],
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