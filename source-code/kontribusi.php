    <?php require_once 'header.php'; ?>


    <?php if(!isset($_GET['nim'])) : ?>
    <div class="container mt-5">
      <div class="card">
          <div class="card-header">Lengkapi data dibawah ini untuk ikut berkontribusi pada penelitian</div>
          <div class="card-body">
            <form action="" method="get">
              <div class="md-form">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" class="md-input form-control" required="">
              </div>

              <div class="md-form">
                <label>NIM</label>
                <input type="text" name="nim" class="md-input form-control" required="">
              </div>

              <div class="md-form">
                <label>No. WA</label>
                <input type="number" name="no_wa" class="md-input form-control">
              </div>

              <div class="md-form">
                <label>Email</label>
                <input type="text" name="email" class="md-input form-control">
              </div>

              <input type="hidden" name="pengujian" value="1">

              <button type="submit" class="btn btn-primary btn-sm">Kirim</button>
            </form>
          </div>
        </div>
    </div>

    <?php else : ?>
      <?php if($_GET['pengujian'] == 1 || $_GET['pengujian'] == 2 || $_GET['pengujian'] == 3 || $_GET['pengujian'] == 4) : ?>
        <div class="container mt-5">
          <div class="progress">
            <?php if(isset($_GET['pengujian'])) : ?>
              <?php if($_GET['pengujian'] == 2) : ?>
              <div class="progress-bar bg-danger" role="progressbar" style="width: 25%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">Pengujian 1</div>
              <?php elseif($_GET['pengujian'] == 3) : ?>
              <div class="progress-bar bg-danger" role="progressbar" style="width: 25%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">Pengujian 1</div>
              <div class="progress-bar bg-warning" role="progressbar" style="width: 25%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">Pengujian 2</div>
              <?php  elseif($_GET['pengujian'] == 4) : ?>
              <div class="progress-bar bg-danger" role="progressbar" style="width: 25%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">Pengujian 1</div>
              <div class="progress-bar bg-warning" role="progressbar" style="width: 25%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">Pengujian 2</div>
              <div class="progress-bar bg-primary" role="progressbar" style="width: 25%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">Pengujian 3</div>
              <?php elseif($_GET['pengujian'] == 5) : ?>
              <div class="progress-bar bg-danger" role="progressbar" style="width: 25%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">Pengujian 1</div>
              <div class="progress-bar bg-warning" role="progressbar" style="width: 25%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">Pengujian 2</div>
              <div class="progress-bar bg-primary" role="progressbar" style="width: 25%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">Pengujian 3</div>
              <div class="progress-bar bg-success" role="progressbar" style="width: 25%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">Pengujian 4</div>
              <?php endif; ?>
            <?php endif; ?>
          </div>

          <?php 
            if($_GET['pengujian'] == 1){
              $card_header = 'Pengujian 1 : Pencarian pada awal data';
              $penjelasan = 'Huruf "a" adalah data awal didalam kamus';
              $value = 'a';
              $_GET['pengujian'] = 2; 
            }elseif($_GET['pengujian'] == 2){
              $card_header = 'Pengujian 2 : Pencarian pada tengah data';
              $penjelasan = 'Kata "kuala" adalah data tengah didalam kamus';
              $value = 'kuala';
              $_GET['pengujian'] = 3; 
            }elseif($_GET['pengujian'] == 3){
              $card_header = 'Pengujian 3 : Pencarian pada akhir data';
              $penjelasan = 'Kata "zuriah" adalah data akhir didalam kamus';
              $value = 'zuriah';
              $_GET['pengujian'] = 4;
            }elseif($_GET['pengujian'] == 4){
              $card_header = 'Pengujian 4 : Pencarian pada banyak data lewat file';
              $penjelasan = 'Pencarian kata diambil dari file  yang diupload';
              $value = 'file';
              $_GET['pengujian'] = 5;
            }
           ?>
          <div class="card mt-5">
            <div class="card-header"><?= $card_header; ?></div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-4">
                  <p><?= $penjelasan; ?></p>
                  <input type="hidden" name="kata" id="dicari" value="<?= $value; ?>">
                  <?php if($_GET['pengujian'] != 5) : ?>
                    <button class="btn btn-primary btn-sm" id="mulai-pengujian">Mulai Pengujian</button><br>
                    <a href="kontribusi.php?<?= http_build_query($_GET); ?>" id="btn-selanjutnya" class="btn btn-success btn-sm" style="display: none">Pengujian Selanjutnya</a>
                  <?php else : ?>
                    <form method="post" id="upload-file" enctype="multipart/form-data">  
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Upload</span>
                        </div>
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" name="pdf" id="file" aria-describedby="inputGroupFileAddon01">
                          <label class="custom-file-label" for="inputGroupFile01">Pilih file .pdf</label>
                        </div>
                      </div>
                      <div class="text-center">
                        <button type="submit" name="upload" class="btn btn-primary btn-sm" id="mulai-pengujian-file">Mulai Pengujian</button>
                      </div>
                    </form>
                    <a href="kontribusi.php?<?= http_build_query($_GET); ?>" id="btn-selanjutnya" class="btn btn-success btn-sm mt-5" style="display: none">Selesai</a>
                  <?php endif; ?>
                </div>

                <div class="col-md-8" align="right">

                  <table class="table table-sm table-bordered">
                    <tr>
                      <th class="text-center">Metode Pencarian</th>
                      <th class="text-center">Kecepatan</th>
                      <th class="text-center">Memory</th>
                    </tr>

                    <tr>
                      <td class="text-center">Sequential Search</td>
                      <td class="text-center" id="kecepatan-sequential"></td>
                      <td class="text-center" id="memory-sequential"></td>
                    </tr>

                    <tr>
                      <td class="text-center">Binary Search</td>
                      <td class="text-center" id="kecepatan-binary"></td>
                      <td class="text-center" id="memory-binary"></td>
                    </tr>

                    <tr>
                      <td class="text-center">SQL Search</td>
                      <td class="text-center" id="kecepatan-sql"></td>
                      <td class="text-center" id="memory-sql"></td>
                    </tr>
                  </table>

                  </div>
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php else : ?>
          <div class="container mt-5">
            <div class="progress">
            <?php if(isset($_GET['pengujian'])) : ?>
              <?php if($_GET['pengujian'] == 2) : ?>
              <div class="progress-bar bg-danger" role="progressbar" style="width: 25%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">Pengujian 1</div>
              <?php elseif($_GET['pengujian'] == 3) : ?>
              <div class="progress-bar bg-danger" role="progressbar" style="width: 25%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">Pengujian 1</div>
              <div class="progress-bar bg-warning" role="progressbar" style="width: 25%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">Pengujian 2</div>
              <?php  elseif($_GET['pengujian'] == 4) : ?>
              <div class="progress-bar bg-danger" role="progressbar" style="width: 25%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">Pengujian 1</div>
              <div class="progress-bar bg-warning" role="progressbar" style="width: 25%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">Pengujian 2</div>
              <div class="progress-bar bg-primary" role="progressbar" style="width: 25%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">Pengujian 3</div>
              <?php elseif($_GET['pengujian'] == 5) : ?>
              <div class="progress-bar bg-danger" role="progressbar" style="width: 25%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">Pengujian 1</div>
              <div class="progress-bar bg-warning" role="progressbar" style="width: 25%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">Pengujian 2</div>
              <div class="progress-bar bg-primary" role="progressbar" style="width: 25%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">Pengujian 3</div>
              <div class="progress-bar bg-success" role="progressbar" style="width: 25%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">Pengujian 4</div>
              <?php endif; ?>
            <?php endif; ?>
          </div>
            <div class="card mt-5">
              <div class="card-body text-center">
                <div class="alert alert-success">
                  Terima kasih telah ikut berkontribusi pada penelitian ini.
                </div>
              </div>
            </div>
          </div>
      <?php endif; ?>
    <?php endif; ?>

    <!-- <script src="assets/js/app.js"></script> -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/mdb.min.js"></script>
    <script src="assets/js/dark-mode-switch.min.js"></script>
    <script>
        function simpanDataKontribusi(data)
        {
          let data_get = {
            nama : "<?= $_GET['nama']; ?>",
            nim : "<?= $_GET['nim']; ?>",
            no_wa : "<?= $_GET['no_wa']; ?>",
            email : "<?= $_GET['email']; ?>",
            pengujian : "<?= $_GET['pengujian']-1; ?>",
          };

          let hasil = {data_get: data_get, data:data};
          $.ajax({
              url: 'simpan_data_kontribusi.php',
              type: 'post',
              data: hasil,
              cache: false,
              success:function(response){

              }
            });

          return true;
        }

        function ambilDataSetelahUpload(count)
        {
           if(count == 3){
             var kecepatan_sequential = $('#kecepatan-sequential').text();
             var kecepatan_binary = $('#kecepatan-binary').text();
             var kecepatan_sql = $('#kecepatan-sql').text();
             var memory_sequential = $('#memory-sequential').text();
             var memory_binary = $('#memory-binary').text();
             var memory_sql = $('#memory-sql').text();
             var data = {
              kecepatan_sequential: kecepatan_sequential,
              kecepatan_binary: kecepatan_binary,
              kecepatan_sql: kecepatan_sql,
              memory_sequential: memory_sequential,
              memory_binary: memory_binary,
              memory_sql: memory_sql,
            }
            if(simpanDataKontribusi(data)){
              $('#btn-selanjutnya').show();
            }
           }
        }

        $(document).ready(function(){

            // $('#mulai-pengujian').click(function(){
            //     let kata = $('#dicari').val();
            //     $.ajax({
            //       url: 'pengujian.php',
            //       method: 'post',
            //       data: {kata: kata},
            //       dataType: 'json',
            //       beforeSend: function(){
            //          $('#mulai-pengujian').html("Menguji...");
            //          $('#mulai-pengujian').attr('disabled', 'disabled');
            //       },
            //       success: function(response){
            //          $('#mulai-pengujian').html("Mulai Pengujian");
            //          $('#mulai-pengujian').attr('disabled', 'disabled');
            //          $('#btn-selanjutnya').show();
            //          $('#kecepatan-sequential').html(response.kecepatan_sequential+" detik");
            //          $('#kecepatan-binary').html(response.kecepatan_binary+" detik");
            //          $('#kecepatan-sql').html(response.kecepatan_sql+" detik");
            //          $('#memory-sequential').html(response.memory_sequential+" KB");
            //          $('#memory-binary').html(response.memory_binary+" KB");
            //          $('#memory-sql').html(response.memory_sql+" KB");
            //          simpanDataKontribusi(response);
            //       }
            //     });
            // });

            $('#mulai-pengujian').click(function(){
                let kata = $('#dicari').val();
                var count = 0;
                $.ajax({
                  url: 'pengujian-algoritma/pengujianSequential.php',
                  method: 'post',
                  data: {kata: kata},
                  dataType: 'json',
                  beforeSend: function(){
                    $('#mulai-pengujian').html("Menguji...");
                    $('#mulai-pengujian').attr('disabled', 'disabled');
                    $('#kecepatan-sequential').html("Loading...");
                    $('#memory-sequential').html("Loading...");
                  },
                  success: function(response){
                     $('#kecepatan-sequential').html(response.kecepatan_sequential);
                     $('#memory-sequential').html(response.memory_sequential);
                     count++;
                     ambilDataSetelahUpload(count);
                  }
                });

                $.ajax({
                  url: 'pengujian-algoritma/pengujianBinary.php',
                  method: 'post',
                  data: {kata: kata},
                  dataType: 'json',
                  beforeSend: function(){
                     $('#kecepatan-binary').html("Loading...");
                     $('#memory-binary').html("Loading...");
                  },
                  success: function(response){
                     $('#kecepatan-binary').html(response.kecepatan_binary);
                     $('#memory-binary').html(response.memory_binary);
                     count++;
                     ambilDataSetelahUpload(count);
                  }
                });

                $.ajax({
                  url: 'pengujian-algoritma/pengujianSql.php',
                  method: 'post',
                  data: {kata: kata},
                  dataType: 'json',
                  beforeSend: function(){
                   $('#kecepatan-sql').html("Loading...");
                   $('#memory-sql').html("Loading...");
                  },
                  success: function(response){
                     $('#mulai-pengujian').html("Mulai Pengujian");
                     $('#mulai-pengujian').attr('disabled', 'disabled');
                     $('#btn-selanjutnya').show();
                     $('#kecepatan-sql').html(response.kecepatan_sql);
                     $('#memory-sql').html(response.memory_sql);
                     count++;
                     ambilDataSetelahUpload(count);
                  }
                });

                // simpanDataKontribusi(response);
            });

            let link;
            let upload;
            let kata = $('#hasil_kata').text();
            let array_kata = kata.split(" ");

            $('#upload-file').on('submit', function(e){
              e.preventDefault();
              var count = 0;
              $.ajax({
                url: 'pengujian-algoritma/pengujianSequential.php',
                method: 'POST',
                contentType: false,
                cache:false,
                processData:false,
                dataType: 'json',
                data: new FormData(this),
                beforeSend: function(){
                   $('#mulai-pengujian-file').html("Menguji...");
                   $('#mulai-pengujian-file').attr('disabled', 'disabled');
                   $('#kecepatan-sequential').html("Loading...");
                   $('#memory-sequential').html("Loading...");
                },
                success: function(response){
                   $('#kecepatan-sequential').html(response.kecepatan_sequential);
                   $('#memory-sequential').html(response.memory_sequential);
                   count++;
                   ambilDataSetelahUpload(count);
                }
              });

              $.ajax({
                url: 'pengujian-algoritma/pengujianBinary.php',
                method: 'POST',
                contentType: false,
                cache:false,
                processData:false,
                dataType: 'json',
                data: new FormData(this),
                beforeSend: function(){
                   $('#kecepatan-binary').html("Loading...");
                   $('#memory-binary').html("Loading...");
                },
                success: function(response){
                   $('#kecepatan-binary').html(response.kecepatan_binary);
                   $('#memory-binary').html(response.memory_binary);
                   count++;
                   ambilDataSetelahUpload(count);
                }
              });

              $.ajax({
                url: 'pengujian-algoritma/pengujianSql.php',
                method: 'POST',
                contentType: false,
                cache:false,
                processData:false,
                dataType: 'json',
                data: new FormData(this),
                beforeSend: function(){
                   $('#kecepatan-sql').html("Loading...");
                   $('#memory-sql').html("Loading...");
                },
                success: function(response){
                   $('#mulai-pengujian-file').html("Mulai Pengujian");
                   $('#mulai-pengujian-file').attr('disabled', 'disabled');
                   $('#kecepatan-sql').html(response.kecepatan_sql);
                   $('#memory-sql').html(response.memory_sql);
                   count++;
                   ambilDataSetelahUpload(count);
                }
              });
               
            });

        });
    </script>
</body>
</html>