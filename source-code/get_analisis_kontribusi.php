<?php 
	require_once "koneksi.php";
	$table = '';
	$pengujian = isset($_POST['pengujian']) ? $_POST['pengujian'] : '';
	if($pengujian == 'awal')
		$sql = "WHERE pengujian = 1";
	elseif($pengujian == 'tengah')
		$sql = "WHERE pengujian = 2";
	elseif($pengujian == 'akhir')
		$sql = "WHERE pengujian = 3";
	elseif($pengujian == 'banyak')
		$sql= "WHERE pengujian = 4";
	else
		$sql = "";
	
	$query_table = mysqli_query($koneksi, "SELECT * FROM kontribusi $sql ORDER BY pengujian ASC");		
	if(mysqli_num_rows($query_table) == 0){
		$table .= '<td colspan="7" class="text-center">Tidak ada data</td>';
	}
	
	$no = 1;			
	while($row = mysqli_fetch_assoc($query_table)) {
		$table .= '<tr>
			<td class="text-center">'.$no.'</td>
			<td class="text-center">'.$row['nama'].'</td>
			<td class="text-center">'.$row['pengujian'].'</td>
			<td class="text-center">'.$row['kecepatan_sequential'].'</td>
			<td class="text-center">'.$row['kecepatan_binary'].'</td>
			<td class="text-center">'.$row['kecepatan_sql'].'</td>
			<td class="text-center">'.$row['memory_sequential'].'</td>
			<td class="text-center">'.$row['memory_binary'].'</td>
			<td class="text-center">'.$row['memory_sql'].'</td>
		</tr>';
	 	$no++;
	 }

	 echo $table;

 ?>