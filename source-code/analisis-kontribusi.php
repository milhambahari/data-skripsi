	<?php 
		require_once "header.php";
	 ?>	

	<!-- BAR CHART -->
	<div class="container mt-5 mb-5">
		<h3 class="text-center">Analisis data kontribusi</h3>
		<select id="pilih_pengujian" class="mb-3">
			<option value="" disabled selected>Pilih Pengujian</option>
			<option value="semua">Semua Pengujian</option>
			<option value="awal">Pengujian Awal Kata</option>
			<option value="tengah">Pengujian Tengah Kata</option>
			<option value="akhir">Pengujian Akhir Kata</option>
			<option value="banyak">Pengujian Banyak Kata</option>
		</select>	

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

				<select id="pilih-perbandingan" name="perbandingan" class="float-right" style="display: none">
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
				<thead>	
					<tr>
						<th class="text-center">No</th>
						<th class="text-center">Nama</th>
						<th class="text-center">Pengujian</th>
						<th class="text-center">Kecepatan Sequential</th>
						<th class="text-center">Kecepatan Binary</th>
						<th class="text-center">Kecepatan SQL</th>
						<th class="text-center">Memory Sequential</th>
						<th class="text-center">Memory Binary</th>
						<th class="text-center">Memory SQL</th>
					</tr>
				</thead>
				<tbody id="table_analisis">
					
				</tbody>
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
		      labels: label,
		      hideHover: 'auto',
		    });

			// let barColors = ['red', 'green', 'gray'];
		 //    chart.options.labels.forEach(function(label, i){
			//     var legendItem = $('<span></span>').text(label).css('color', barColors[i])
			//     $('#legend').append(legendItem)
			// });
		}

		function getAnalisis(pengujian){
			$.ajax({
				url: 'get_analisis_kontribusi.php',
				data: {pengujian: pengujian},
				type: 'post',
				success:function(response){
					$('#table_analisis').html(response);
				}
			});
		}

		$(document).ready(function(){

			getAnalisis();
			let pengujian;
			$('#pilih_pengujian').change(function(){
				$('#bar-chart').html('');
		    	$('#pilih-perbandingan').val('');
		    	$('#pilih-algoritma').val('');
		    	$('#pilih-perbandingan').show();
				pengujian = $(this).val();
				if(pengujian == 'semua'){
					$('select[name*="perbandingan"] > option[value="kecepatan"]').hide();
					$('select[name*="perbandingan"] > option[value="memory"]').hide();
				}else{
					$('select[name*="perbandingan"] > option[value="kecepatan"]').show();
					$('select[name*="perbandingan"] > option[value="memory"]').show();
				}
				getAnalisis(pengujian);
			});

		   $(document).on('click', '.btn-detail', function(){
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
		    	pengujian = $('#pilih_pengujian').val();
              	let perbandingan = $(this).val();
              	if(perbandingan == 'kecepatan' || perbandingan == 'memory'){
              		$('#pilih-algoritma').show();
	              	$('#pilih-algoritma').change(function(){
		              	let algoritma = $(this).val();
		              	$.ajax({
					        url:"proses_analisis_kontribusi.php",
					        method:"POST",
					        data:{pengujian: pengujian, perbandingan:perbandingan, algoritma:algoritma},
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
				        url:"proses_analisis_kontribusi.php",
				        method:"POST",
				        data:{pengujian: pengujian, perbandingan:perbandingan},
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