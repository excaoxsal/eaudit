<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <div class="d-flex align-items-center flex-wrap mr-2">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Master</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Setting TTD SPA</span>
      </div>
    </div>
  </div>
  <div class="d-flex flex-column-fluid">
    <div class="container">
      <div class="row mb-5">
        <div class="col-lg-12">
          <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
          <div class="card-title">
            <h3 class="card-label"><?= $title ?></h3> 
          </div>
        </div>
        <div class="card-body">
          <form class="form" id="form" method="post">
            <div class="tab-content">
                <div class="row">
                  <div class="col-xl-2"></div>
                  <div class="col-xl-7 my-2">
                    
                    <div class="form-group row">
                      <label class="col-form-label col-3 text-lg-right text-left">Nama</label>
                      <div class="col-9">
                        <div class="form-label">
                          <input required class="form-control form-control-lg" placeholder="Nama" name="nama" type="text" value="<?= $data->NAMA ?>">
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-form-label col-3 text-right">Jabatan</label>
                      <div class="col-9">
                        <div class="form-label">
                          <input required class="form-control form-control-lg" placeholder="Jabatan" name="jabatan" type="text" value="<?= $data->JABATAN ?>">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer pb-0">
                  <div class="row">
                    <div class="col-xl-2"></div>
                    <div class="col-xl-7">
                      <div class="row">
                        <div class="col-3"></div>
                        <div class="col-9">
                          <button type="submit" id="save" class="btn btn-light-primary font-weight-bold">Simpan perubahan</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            
            </div>
          </form>
        </div>
      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    $("#form").validate({
      errorClass: 'text-danger is-invalid',
      submitHandler: function () {
        Toast.fire({
          title: 'Simpan perubahan?',
          icon: 'question',
          showCancelButton: true
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url : "<?= base_url('setting_ttd_spa/ubah_ttd') ?>",
              method : "POST",
              data : $('#form').serialize(),
              async : true,
              beforeSend: function() {
                $('#save').addClass('pr-15 spinner spinner-primary spinner-right');
              },
              success: function(data){
                $('#save').removeClass('pr-15 spinner spinner-primary spinner-right'); 
                if(data=='OK')
                  ToastTopRightTimer.fire({ icon: 'success', title: 'Proses Berhasil! Tanda Tangan SPA telah diubah.' })             
                else
                  ToastTopRightTimer.fire({ icon: 'error', title: 'Proses Gagal!' })
              },
              error: function(data) { 
                var status = data.status+' '+ data.statusText;
                Swal.fire(status,'Proses Gagal! Silakan hubungi Admin.', 'error');
                $('#save').removeClass('pr-15 spinner spinner-primary spinner-right'); 
              }
            });  
          }
        });
      }
    });
  });
</script>