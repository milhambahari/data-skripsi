<?php 
	require_once "koneksi.php";
	$table = '';
	$pengujian = isset($_POST['pengujian']) ? $_POST['pengujian'] : '';
	if($pengujian == 'awal')
		$sql = "WHERE pengujian BETWEEN '1' AND '15'";
	elseif($pengujian == 'tengah')
		$sql = "WHERE pengujian BETWEEN '16' AND '30'";
	elseif($pengujian == 'akhir')
		$sql = "WHERE pengujian BETWEEN '31' AND '45'";
	elseif($pengujian == 'banyak')
		$sql= "WHERE pengujian BETWEEN '46' AND '60'";
	else
		$sql = "";
	
	$query_table = mysqli_query($koneksi, "SELECT * FROM perbandingan $sql ORDER BY pengujian ASC");		
	if(mysqli_num_rows($query_table) == 0){
		$table .= '<td colspan="7" class="text-center">Tidak ada data</td>';
	}
	
				
	while($row = mysqli_fetch_assoc($query_table)) {
		$table .= '<tr>
			<td class="text-center">'.$row['pengujian'].'</td>
			<td>'.substr($row['kata'], 0, 50).'</td>
			<td>'.$row['algoritma'].'</td>
			<td class="text-center">'.$row['waktu'].'</td>
			<td class="text-center">'.$row['memory'].'</td>
			<td class="text-center">'.$row['jumlah_kata'].'</td>
			<td class="text-center">
				<button class="btn btn-success btn-sm btn-detail" data-detail="'. $row['pengujian'].'">Detail</button>
				<a onclick="return confirm('."'Apa anda yakin?'".')" href="hapus_perbandingan.php?id='. $row['id'].'" class="btn btn-danger btn-sm">Hapus</a>
			</td>
		</tr>';
	 }

	 echo $table;

 ?>