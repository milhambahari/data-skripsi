	<?php 
		require_once "koneksi.php";
		require_once "header.php";
		$query_table = mysqli_query($koneksi, "SELECT * FROM perbandingan ORDER BY pengujian ASC");
	 ?>	

	<!-- BAR CHART -->
	<div class="container mt-5 mb-5">	
		<div class="card">
			<div class="card-header">
				Hasil Analisis Algoritma
				<select id="pilih-algoritma" class="float-right" style="display: none">
	                <option value="" disabled selected>Pilih Metode Pencarian</option>
	                <option value="semua">Semua Metode</option>
	                <option value="ss">Algoritma Sequential Search</option>
	                <option value="bs">Algoritma Binary Search</option>
	                <option value="sql">SQL Search</option>
              	</select>

				<select id="pilih-perbandingan" class="float-right">
	                <option value="" disabled selected>Pilih perbandingan</option>
	                <option value="kecepatan">Kecepatan</option>
	                <option value="memory">Memory yang digunakan</option>
	                <option value="hasil_kecepatan">Hasil Akhir Kecepatan</option>
	                <option value="hasil_memory">Hasil Akhir Memory yang digunakan</option>
              	</select>
			</div>
		    <div class="card-body chart-responsive">
		      <div class="chart" id="bar-chart" style="height: 350px;"></div>
		      <div id="legend" class="text-center"></div>
		    </div>
		</div><br>

		<div class="card">
			<div class="card-header">
				Table Pengujian
				<a onclick="return confirm('Apa anda yakin ingin menghapus semua data?')" href="hapus_perbandingan.php" class="btn btn-danger btn-sm float-right">Hapus Semua</a>
			</div>
			<table class="table table-bordered">
				<tr>
					<th class="text-center">Pengujian</th>
					<th>Kata yang dicari</th>
					<th>Algoritma</th>
					<th class="text-center">Kecepatan</th>
					<th class="text-center">Memory</th>
					<th class="text-center">Jumlah Kata</th>
					<th class="text-center">Aksi</th>
				</tr>
				<?php if(mysqli_num_rows($query_table) == 0) : ?>
					<td colspan="7" class="text-center">Tidak ada data</td>
				<?php endif; ?>
				
				<?php while($row = mysqli_fetch_assoc($query_table)) : ?>
					<tr>
						<td class="text-center"><?= $row['pengujian']; ?></td>
						<td><?= substr($row['kata'], 0, 50) ?></td>
						<td><?= $row['algoritma']; ?></td>
						<td class="text-center"><?= $row['waktu']; ?></td>
						<td class="text-center"><?= $row['memory']; ?></td>
						<td class="text-center"><?= $row['jumlah_kata']; ?></td>
						<td class="text-center">
							<button class="btn btn-success btn-sm btn-detail" data-detail="<?= $row['pengujian']; ?>">Detail</button>
							<a onclick="return confirm('Apa anda yakin?')" href="hapus_perbandingan.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm">Hapus</a>
						</td>
					</tr>
				 <?php endwhile; ?>
			</table>
		</div>

		<div id="detail" class="mt-4 card" style="display: none;">
			<div class="card-header">
				Detail
				<button id="clear" class="btn btn-danger btn-sm float-right">Tutup</button>
			</div>
			<div class="card-body">
				<div class="row">
					
				</div>
			</div>
		</div>
	</div>

	<script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/mdb.min.js"></script>
    <script src="assets/js/dark-mode-switch.min.js"></script>
	<script src="assets/vendor/raphael.js/raphael.min.js"></script>
	<script src="assets/vendor/morris.js/morris.min.js"></script>
	<script>

		function chart_line_semua(data)
		{
			$('#bar-chart').html('');
			$('#legend').html('');
		   	let chart = new Morris.Area({
		      element: 'bar-chart',
		      resize: true,
		      data: data,
		      lineColors: ['green', 'red', 'gray'],
		      xkey: 'y',
		      ykeys: ['ss', 'bs', 'sql'],
		      labels: ['Sequential Search', 'Binary Search', 'SQL Search'],
		      fillOpacity: 0.5,
		      hideHover: 'auto',
		      parseTime: false
		    });

		    chart.options.labels.forEach(function(label, i){
			    var legendItem = $('<span></span>').text(label).css('color', chart.options.lineColors[i])
			    $('#legend').append(legendItem)
			});
		}

		function chart_line(json)
		{
			$('#bar-chart').html('');
			$('#legend').html('');
			let label = json.perbandingan;
			let data = json.data;
		   	let chart = new Morris.Line({
		      element: 'bar-chart',
		      resize: true,
		      data: data,
		      lineColors: [json.color],
		      xkey: 'y',
		      ykeys: ['a'],
		      labels: [json.algoritma],
		      hideHover: 'auto',
		      parseTime: false
		    });

		    chart.options.labels.forEach(function(label, i){
			    var legendItem = $('<span></span>').text(label).css('color', chart.options.lineColors[i])
			    $('#legend').append(legendItem)
			});
		}

		function chart_bar(perbandingan, data)
		{
			$('#bar-chart').html('');
			$('#legend').html('');
			let label;
			if(perbandingan == 'hasil_kecepatan')
				label = ['Hasil Akhir Kecepatan'];
			else if(perbandingan == 'hasil_memory')
				label = ['Hasil Akhir Memory yang digunakan']; 

			let chart = new Morris.Bar({
		      element: 'bar-chart',
		      resize: true,
		      data: data,
		      // barColors: ['green', 'red', 'gray'],
		      barColors: function (row, series, type) {
				if(row.label == "Sequential Search") return "green";
				else if(row.label == "Binary Search") return "red";
				else if(row.label == "SQL Search") return "gray";
			  },
		      xkey: 'y',
		      ykeys: ['a'],
		      labels: ['Binary Search', 'Sequential Search', 'SQL Search'],
		      hideHover: 'auto',
		    });

			// let barColors = ['red', 'green', 'gray'];
		 //    chart.options.labels.forEach(function(label, i){
			//     var legendItem = $('<span></span>').text(label).css('color', barColors[i])
			//     $('#legend').append(legendItem)
			// });
		}

		$(document).ready(function(){

		    $('.btn-detail').click(function(){
		    	let id = $(this).data('detail');
		    	$.ajax({
	              url: 'get_detail.php',
	              type: 'post',
	              data: {id: id},
	              cache: false,
	              success:function(response){
	              	$('#detail').show();
	              	$('#detail .row').html(response);
	              }
	            });
		    });

		    $('#clear').click(function(){
		    	$('#detail .row').html('');
		    	$('#detail').hide();
		    });

		    $('#pilih-perbandingan').change(function(){
		    	$('#bar-chart').html('');
		    	$('#pilih-algoritma').val('');
              	let perbandingan = $(this).val();
              	if(perbandingan == 'kecepatan' || perbandingan == 'memory'){
              		$('#pilih-algoritma').show();
	              	$('#pilih-algoritma').change(function(){
		              	let algoritma = $(this).val();
		              	$.ajax({
					        url:"proses_analisis.php",
					        method:"POST",
					        data:{perbandingan:perbandingan, algoritma:algoritma},
					        dataType:"JSON",
					        cache: false,
					        success:function(response)
					        {
					        	if(response.metode == 'algoritma')
					            	chart_line(response);
					            else
					            	chart_line_semua(response.data);
					        }
					    });
	            	});
	            }else{
	            	$('#pilih-algoritma').val('');
	            	$('#pilih-algoritma').hide();		
	              	$.ajax({
				        url:"proses_analisis.php",
				        method:"POST",
				        data:{perbandingan:perbandingan},
				        dataType:"JSON",
				        cache: false,
				        success:function(response)
				        {
				            chart_bar(perbandingan, response.data);
				        }
				    });
              	}
            });

		});

		
	</script>
</body>
</html>