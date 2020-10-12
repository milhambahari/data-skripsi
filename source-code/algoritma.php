<?php 

	// ================= algoritma =================
	function sequentialSearch($array, $cari)
	{
		$hasil = [];
		for($j=0; $j<count($cari); $j++){
			for($i=0; $i<=count($array); $i++){
				if( (isset($array[$i])) && ($array[$i] == $cari[$j]) ){
					$hasil[] = $array[$i];
					break;
				} 
			}
		}

		return $hasil;
	}

	
	function binarySearch($array, $cari)
	{
		$hasil = [];
		for($i=0; $i<count($cari); $i++){   
	        $batasAtas = 0;
	        $batasBawah = count($array) - 1; 

	        while($batasAtas <= $batasBawah){
	            $tengah = floor(($batasBawah + $batasAtas)/2);
	            if($array[$tengah] == $cari[$i]){	
	            	$hasil[] = $array[$tengah];
	            	break;
	            } 
	            if($array[$tengah] < $cari[$i]) 
	            	$batasAtas = $tengah + 1;
	            else 
	            	$batasBawah = $tengah - 1;
	        }
    	}

    	return $hasil;
	}

	// function sqlSearch($koneksi, $cari)
	// {
	// 	$hasil = [];
	// 	for($i=0; $i<count($cari); $i++){
	// 		$query = mysqli_query($koneksi, "SELECT * FROM kamus WHERE kata = '$cari[$i]'");
	// 		if(mysqli_num_rows($query) > 0){
	// 			$row = mysqli_fetch_assoc($query);
	// 			$hasil[] = $row['kata'];
	// 		}
	// 	}

	// 	return $hasil;
	// }

	function sqlSearch($koneksi, $cari)
	{
		$hasil = [];
		$sql = '';
		for($i=0; $i<count($cari); $i++){
			$sql .= "kata = '$cari[$i]' OR ";	
		}

		$sql = substr($sql, 0, -3);

		$query = mysqli_query($koneksi, "SELECT * FROM kamus WHERE $sql");
		while($row = mysqli_fetch_assoc($query)){
			$hasil[] = $row['kata'];
		}

		return $hasil;
	}


	// ================= memory =================
	function memorySequentialSearch($array, $cari)
	{
		$hasil = [];
		for($j=0; $j<count($cari); $j++){
			for($i=0; $i<=count($array); $i++){
				if( (isset($array[$i])) && ($array[$i] == $cari[$j]) ){
					$hasil[] = $array[$i];
					break;
				} 
			}
		}

		$memory = memory_get_usage()/1024;
    	return $memory; 
	}

	function memoryBinarySearch($array, $cari)
	{
		$hasil = [];
		for($i=0; $i<count($cari); $i++){   
	        $batasAtas = 0;
	        $batasBawah = count($array) - 1; 

	        while($batasAtas <= $batasBawah){
	            $tengah = floor(($batasBawah + $batasAtas)/2);
	            if($array[$tengah] == $cari[$i]){	
	            	$hasil[] = $array[$tengah];
	            	break;
	            } 
	            if($array[$tengah] < $cari[$i]) 
	            	$batasAtas = $tengah + 1;
	            else 
	            	$batasBawah = $tengah - 1;
	        }
    	}

    	$memory = memory_get_usage()/1024;
    	return $memory; 
	}

	function memorySqlSearch($koneksi, $cari)
	{
		$hasil = [];
		$sql = '';
		for($i=0; $i<count($cari); $i++){
			$sql .= "kata = '$cari[$i]' OR ";	
		}

		$sql = substr($sql, 0, -3);

		$query = mysqli_query($koneksi, "SELECT * FROM kamus WHERE $sql");
		while($row = mysqli_fetch_assoc($query)){
			$hasil[] = $row['kata'];
		}

    	$memory = memory_get_usage()/1024;
    	return $memory; 
	}
	

	// ================= simpan data =================
	function simpanDataSequentialSearch($array, $cari)
	{
		for($j=0; $j<count($cari); $j++){
	        $langkah = 0;
	        for($i=0; $i<=count($array); $i++){
	            $cek[] = 'Apakah '.$cari[$j].' = '.$array[$i].' ?';
	            $langkah++;
	            if( (isset($array[$i])) && ($array[$i] == $cari[$j]) ){
	            // if( (isset($array[$i]['array'])) && (stripos($array[$i]['array'], $cari[$j]) !== FALSE) ){
	                $array_langkah[] = $langkah;
	                $hasil[] = $array[$i];
	                $jawab[] = 'Ya, kata sama';
	                $kondisi[] = true;
	                break;
	            }else{
	                $hasil[] = '';
	                $array_langkah[] = '';
	                $jawab[] = 'Tidak, kata tidak sama';
	                $kondisi[] = false;
	            }

	        }
	    }

	    $output = '';
	    if(count($jawab) > 100)
	    	$k = count($jawab)-100;
	    else
	    	$k = 0;

	    for($k; $k<count($jawab); $k++){
	    	$output .= '<div class="col-md-3">';
	        $output .= $cek[$k].' <br>';
	        $output .= '<ul><li>'.$jawab[$k].'</li>';
	        if($kondisi[$k])
	            $output .= '<li><span class="'.$hasil[$k].'" style="color: green;"> Kata ditemukan: '.$hasil[$k].' (pada langkah '.$array_langkah[$k].')</span></li><br>';
	        $output .= '</ul>';
	        $output .= '</div>';
	    }

	    return $output;

	}

	function simpanDataBinarySearch($array, $cari)
	{
		for($i=0; $i<count($cari); $i++){  
	        $batasAtas = 0;
	        $batasBawah = count($array) - 1; 

	        $langkah = 0;
	        while($batasAtas <= $batasBawah){
	            $batasAtasDanBatasBawah[] = 'Apakah '.$batasAtas.' <= '.$batasBawah.'?';

	            $tengah = floor(($batasBawah + $batasAtas)/2);
	            $nilaiTengah[] = 'Nilai Tengah = ('.$batasAtas.' + '.$batasBawah.') / 2 = '.$tengah; 

	            $langkah++;
	            $samaDengan[] = 'apakah '.$array[$tengah].' = '.$cari[$i];
	            if($array[$tengah] == $cari[$i]){
	                $jawabSama[] = 'Ya, kata sama';
	                $array_langkah[] = $langkah;   
	                $hasil[] = $array[$tengah];
	                $kondisi[] = 1;
	                break;
	            }elseif($array[$tengah] < $cari[$i]){
	                $jawabSama[] = 'Tidak, kata lebih kecil dari yang dicari'; 
	                $array_langkah[] = '';
	                $batasAtas = $tengah + 1;
	                $hasil[] = 'Batas atas = '.$tengah.' + 1 = '.$batasAtas;
	                $kondisi[] = 2;
	            }else{
	                $jawabSama[] = 'Tidak, kata lebih besar dari yang dicari';
	                $array_langkah[] = '';
	                $batasBawah = $tengah - 1;
	                $hasil[] = 'Batas bawah = '.$tengah.' - 1 = '.$batasBawah;
	                $kondisi[] = 3;
	            }
	            
	        }
    	}

    	$output = '';
	    for($j=0; $j<count($hasil); $j++){
	    	$output .= '<div class="col-md-3">';
	        $output .= $batasAtasDanBatasBawah[$j].'<br>'.
	                    $nilaiTengah[$j].'<br>'.
	                    $samaDengan[$j].'<br>'.
	                    $jawabSama[$j].'<br>';
	                    
	        if($kondisi[$j] == 1) 
	            $output .= '<span class="'.$hasil[$j].'" style="color: green;">Kata ditemukan: '.$hasil[$j].' (pada langkah '.$array_langkah[$j].')</span><br><br>';
	        else 
	            $output .= $hasil[$j].' <br><br>';

	        $output .= '</div>';
	    }

	    return $output;
	}

	function simpanDataSqlSearch($koneksi, $cari)
	{
		for($i=0; $i<count($cari); $i++){
			$tanya[] = 'Apakah kata '.$cari[$i].' ada di table kamus?';
			$query = mysqli_query($koneksi, "SELECT * FROM kamus WHERE kata = '$cari[$i]'");
			if(mysqli_num_rows($query) > 0){
				$row = mysqli_fetch_assoc($query);
				$hasil[] = $row['kata'];
				$jawab[] = 'Ya, Kata '.$row['kata'].' ada didalam table kamus';
				break;
			}else{
				$hasil[] = $row['kata'];
				$jawab[] = 'Kata tidak ada didalam table kamus';
			}
		}

		// $output = '';
	    $output = '<div class="col-md-6">';
	    for($j=0; $j<count($hasil); $j++){
	        $output .= $tanya[$j].'<br>'.
	                    $jawab[$j].'<br>';                

	    }
	    $output .= '</div>';

		return $output;
	}

?>