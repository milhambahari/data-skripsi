<?php 

	
	ini_set('max_execution_time', 1000);
	include('class.pdf2text.php');


	$cari = '';
	$kata = [];
	
	$data = [];

	$koneksi = mysqli_connect('localhost', 'root', '', 'kbbi') OR mysqli_error();
	$hasil = [];
	if(isset($_POST['upload'])){
		$target = basename($_FILES['pdf']['name']) ;
        move_uploaded_file($_FILES['pdf']['tmp_name'], $target);

		$var = new PDF2Text();
		$var->setFilename($_FILES['pdf']['name']);
		$var->decodePDF();
		$cari = $var->output();

		$sql = "SELECT * FROM kamus";
		$query = mysqli_query($koneksi, $sql);
		while($row = mysqli_fetch_assoc($query)){
			$kata[] = $row;
		}

		$data = explode(" ",$cari);
		$jumlah_kata = (integer)count($data);
		for($j=0; $j<count($data); $j++){
			for($i=0; $i<=(integer)count($kata); $i++){
				if( (isset($kata[$i]['kata'])) && ( ($kata[$i]['kata']) ==  ($data[$j]) ) ){
					$hasil[] = [
						'kata' => $kata[$i]['kata'],
						'definisi' => "(Definisi : ".$kata[$i]['definisi'].")",
						'sumber' => $kata[$i]['sumber']
					];
				}
			}
		}
		
	}


	if(isset($_POST['submit'])){
		$sql = "SELECT * FROM kamus";
		$query = mysqli_query($koneksi, $sql);
		while($row = mysqli_fetch_assoc($query)){
			$kata[] = $row;
		}

		$cari = $_POST['kata'];
		$data = explode(" ", $cari);
		$jumlah_kata = (integer)count($data);
		for($j=0; $j<count($data); $j++){
			for($i=0; $i<=(integer)count($kata); $i++){
				if( (isset($kata[$i]['kata'])) && ( ($kata[$i]['kata']) ==  ($data[$j]) ) ){
					$hasil[] = [
						'kata' => $kata[$i]['kata'],
						'definisi' => "(Definisi : ".$kata[$i]['definisi'].")",
						'sumber' => $kata[$i]['sumber']
					];
				}
			}
		}

	}



?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Cek Definisi</title>

	<link rel="stylesheet" type="application/octet-stream" href="assets/font/roboto/Roboto-Regular.woff2">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/mdb.min.css">
<body>

	<nav class="navbar navbar-expand-lg navbar-light light-color">
		<div class="container">
		  <a class="navbar-brand" href="#">Navbar</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
		    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>
		  <div class="collapse navbar-collapse" id="navbarNav">
		    <ul class="navbar-nav">
		      <li class="nav-item active">
		        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="#">Features</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="#">Pricing</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link disabled" href="#">Disabled</a>
		      </li>
		    </ul>
		  </div>
	  </div>
	</nav>

	<div class="container mt-3">

		<div class="my-2">				
			<button class="btn btn-primary btn-sm" id="pilih-kata">Kata</button>
			<button class="btn btn-primary btn-sm" id="pilih-file">File</button>
		</div>

		<div id="cari-kata">
			<form method="POST">
				<div class="md-form">
					<textarea name="kata" class="md-textarea form-control" rows="5"></textarea>
					<label for="form7">Cari Kata</label>
				</div>
				<button type="submit" name="submit" class="btn btn-primary btn-sm">cari</button>
			</form>
		</div>

		<div id="upload-file" style="display: none">
			<form method="POST" enctype="multipart/form-data">

				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
				  </div>
				  <div class="custom-file">
				    <input type="file" class="custom-file-input" name="pdf" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
				    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
				  </div>
				</div>
				<button type="submit" name="upload" class="btn btn-primary btn-sm">Upload</button>
			</form>
		</div>
		
		<div class="row mt-3">
			<div class="col-md-6">	
				<div class="card">
					<div class="card-header">Cari Kata</div>
					<div class="card-body">
						<span><?= $cari; ?>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card">
					<?php 
						$final_array_hasil = [];
						foreach($hasil as $array_hasil) $final_array_hasil[] = $array_hasil['kata'];
						$kata_ditemukan = array_unique($final_array_hasil);
						$final_hasil_unik = implode(" ", $kata_ditemukan);

					 ?>
					 <div class="card-header">Kata yang ditemukan <small class="text-muted">(Klik dua kali pada salah satu kata untuk mendapatkan definisi)</small></div>
					 <div class="card-body"> 

						 <div id="hasil_kata">
						 	<h5><?= $final_hasil_unik; ?></h5>
						 </div>

					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="judul"></h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>

	      <div class="modal-body" id="data-kata">
	        <p id="judul-kata"></p>
	        <p id="definisi-kata"></p>
	        <p id="sumber-kata"></p>
	      </div>

	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>

	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/mdb.min.js"></script>

	<script>
		$(document).ready(function(){

			// $('#pilih').click(function(){
			// 	let pilih = $(this).val();
			// 	if(pilih == 'kata'){
			// 		$('#cari-kata').show();
			// 		$('#upload-file').hide();
			// 	}else{
			// 		$('#cari-kata').hide();
			// 		$('#upload-file').show();
			// 	}
			// });

			$('#pilih-kata').click(function(){
				$('#cari-kata').show();
				$('#upload-file').hide();
			});

			$('#pilih-file').click(function(){
				$('#cari-kata').hide();
				$('#upload-file').show()
			});

			let kata = $('#hasil_kata').text();
			let array_kata = kata.split(" ");

		    $("#hasil_kata").dblclick(function() {
			  var s = window.getSelection();
			  s.modify('extend', 'backward', 'word');
			  var b = s.toString();

			  s.modify('extend', 'forward', 'word');
			  var a = s.toString();
			  s.modify('move', 'forward', 'character');
			  let klik = b+a;

			  $.ajax({
			  	url: 'proses_ajax.php',
			  	type: 'post',
			  	data: {kata: klik},
			  	dataType: 'json',
			  	cache: false,
			  	success:function(response){
			  		if(response.length > 1){
			  			$('#data-kata').html('');
			  			$.each(response, function(i, data){
			  				$('#judul').html(data.kata);
				  			$('#data-kata').append(
				  				'<p>'+data.definisi+'</p>'+
				  				'<small> Sumber : '+data.sumber+'</small>'+
				  				'<hr>'
				  			);
			  			});
			  		}else{
			  			$('#data-kata').html('');
			  			$.each(response, function(i, data){
			  				$('#judul').html(data.kata);
				  			$('#data-kata').append(
				  				'<p>'+data.definisi+'</p>'+
				  				'<small> Sumber : '+data.sumber+'</small>'
				  			);
			  			});
			  		}

			  		$('#exampleModal').modal('show');
			  	}
			  });

			});


		});
	</script>
</body>
</html>