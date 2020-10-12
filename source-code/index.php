    <?php require_once 'header.php'; ?>

    <div class="container mt-3">

        <div class="my-2">              
            <button class="btn btn-primary btn-sm" id="pilih-kata"><i class="fas fa-spell-check"></i> Kata</button>
            <button class="btn btn-primary btn-sm" id="pilih-file"><i class="far fa-file"></i></i> File</button>
            <a href="analisis" class="btn btn-success btn-sm float-right"><i class="far fa-chart-bar"></i> Analisis</a>
        </div>

        <div class="row justify-content-center mt-5">          
          <div id="upload-file" class="col-md-6" style="display: none">
              <form method="POST" enctype="multipart/form-data" id="import-file">

                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Upload</span>
                    </div>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" name="pdf" id="nama-file" aria-describedby="inputGroupFileAddon01">
                      <label class="custom-file-label" for="inputGroupFile01">Pilih file .pdf</label>
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="submit" name="upload" class="btn btn-primary btn-sm" id="submit-file">Upload</button>
                  </div>
              </form>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-md-6">
              <select id="pilih-algoritma">
                <option value="" disabled selected>--- Pilih Metode Pencarian ---</option>
                <option value="ss">Algortima Sequential Search</option>
                <option value="bs">Algortima Binary Search</option>
                <option value="sql">SQL Search</option>
              </select>
          </div>
        </div>
      
        <div class="row mt-2">
            <div class="col-md-6 mb-3" style="margin-right: 0 !important; padding: 1px !important;">  
                <div class="card">
                    <div class="card-header text-center">Pencarian Kata</div>
                    <div class="card-body" id="tempat-cari" style="min-height: 300px; display: none;">

                    </div>
                    <div class="card-body" id="card-cari">
                      <form method="POST" id="form-cari">
                        <div class="md-form">
                            <textarea name="kata" class="md-textarea form-control" id="textarea-kata" rows="5"></textarea>
                            <label for="form7">Cari Kata</label>
                        </div>
                        <button type="submit" id="tombol-cari" class="btn btn-primary btn-sm">Cari</button>
                      </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6" style="margin-left: 0 !important; padding: 1px !important;">
                <div class="card">
                     <div class="card-header text-center">Kata yang ditemukan</div>
                     <div class="card-body" style="min-height: 300px"> 
                          <div>
                            <div id="hasil_waktu"></div><br>
                            <div id="hasil_kata"></div>
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
    <script src="assets/js/dark-mode-switch.min.js"></script>
    <script>
        function getClassName(namakelas)
        {
            if(namakelas){   
              let klik = namakelas;

              $.ajax({
                url: 'proses_ajax.php',
                type: 'post',
                data: {kata: klik},
                dataType: 'json',
                cache: false,
                success:function(response){
                    $('#data-kata').html('');
                        $.each(response, function(i, data){
                            $('#judul').html(data.kata);
                            $('#data-kata').append(
                                '<p>'+data.definisi+'</p>'+
                                '<small> Sumber : '+data.sumber+'</small> <hr>'
                            );
                        });

                    $('#exampleModal').modal('show');
                }
              });
            }
        }

        function simpanDataPerbandingan(tipe, data)
        {
          let hasil = {hasil: data, tipe:tipe};
          $.ajax({
              url: 'simpan_data_perbandingan.php',
              type: 'post',
              data: hasil,
              cache: false,
              success:function(response){

              }
            });
        }

        $(document).ready(function(){

            getClassName();


            $('#pilih-kata').click(function(){
                $('#cari-kata').show();
                $('#upload-file').hide();
                $('#tempat-cari').html('');
                $('#hasil_kata').html('');
                $('#card-cari').show();
                $('#tempat-cari').hide();
                // $('#textarea-kata').val('');
            });

            $('#pilih-file').click(function(){
                $('#cari-kata').hide();
                $('#upload-file').show();
                $('#tempat-cari').html('');
                $('#hasil_kata').html('');
                $('#tempat-cari').show();
                $('#card-cari').hide();
            });


            let link;
            let upload;
            $('#tombol-cari').hide();
            $('#submit-file').hide();
            $('#pilih-algoritma').change(function(){
              if( $(this).val() == 'ss' ){
                link = 'cari-kata/cariSequential.php';
                upload = 'upload.php?algoritma=ss';
                $('#tombol-cari').show();
                $('#submit-file').show();
              }else if( $(this).val() == 'bs' ){
                link = 'cari-kata/cariBinary.php';
                upload = 'upload.php?algoritma=bs';
                $('#tombol-cari').show();
                $('#submit-file').show();
              }else{
                link = 'cari-kata/cariSql.php';
                upload = 'upload.php?algoritma=sql';
                $('#tombol-cari').show();
                $('#submit-file').show();
              }
            });

            $('#form-cari').on('submit', function(e){
                e.preventDefault();
                $.ajax({
                  url: link,
                  method: 'POST',
                  contentType: false,
                  cache:false,
                  processData:false,
                  dataType: 'json',
                  data: new FormData(this),
                  beforeSend: function(){
                     $('#hasil_kata').html("<h5>Mencari...</h5>");
                  },
                  success: function(response){
                    if(response.status == 0){
                      $('#hasil_kata').html(response.hasil_unik);
                    }else{
                      $('#hasil_waktu').html(response.hasil_waktu);
                      $('#hasil_kata').html("<h5>"+response.hasil_unik+"</h5>");
                      simpanDataPerbandingan('kata', response.data_perbandingan);
                    }
                  }
                });
            });


            let kata = $('#hasil_kata').text();
            let array_kata = kata.split(" ");


            $('#import-file').on('submit', function(e){
              e.preventDefault();
              $.ajax({
                url: link,
                method: 'POST',
                contentType: false,
                cache:false,
                processData:false,
                dataType: 'json',
                data: new FormData(this),
                beforeSend: function(){
                  $('#submit-file').html('Loading...');
                  $('#submit-file').attr('disabled', 'disabled');
                },
                success: function(response){
                  $('#custom-file-label').text('Pilih File');
                  $('#submit-file').html('Upload');
                  $('#submit-file').attr('disabled', false);
                  $('#tempat-cari').html("<h5>"+response.cari+"</h5>");
                  $('#hasil_waktu').html("<h6>"+response.hasil_waktu+"</h6>");
                  $('#hasil_kata').html("<h5>"+response.hasil_unik+"</h5>");
                  simpanDataPerbandingan('file', response.data_perbandingan);
                }
              });
            });

        });
    </script>
</body>
</html>