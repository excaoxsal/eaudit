<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <div class="d-flex align-items-center flex-wrap mr-2">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Monitoring</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Entry LHA</span>
        <!-- <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Create</span> -->
        <!--end::Actions-->
      </div>
    </div>
  </div>
  <div class="d-flex flex-column-fluid">
    <div class="container">

        <form class="form" id="form_lha" method="post">  
        <div class="card card-custom">
          <div class="card-header">
            <div class="card-title">
              <h3 class="card-label">Entry Laporan Hasil Audit</h3>
            </div>
            
          </div>
          <div class="card-body">
              <div class="form-group row">
                <label class="col-form-label col-3 text-right">Nomor SPA</label>
                <div class="col-9">
                  <div class="input-icon input-icon-right mb-2 autocomplete">
                    <input type="text" class="form-control" autocomplete="off" name="NOMOR_SPA" placeholder="Search..." id="nomor_spa" />
                    <span>
                      <i class="fa fa-search"></i>
                    </span>
                  </div>
                  <input type="hidden" class="form-control" id="id_spa" name="id_spa">
                  <!-- <a onclick="reset()" type="submit" class="btn btn-light-primary font-weight-bold">Reset Nomor SPA</a> -->
                </div>
              </div>
              <!-- <div class="form-group row">
                <label class="col-form-label col-3 text-right">Dikeluarkan</label>
                <div class="col-9">
                  <input type="text" class="form-control form-control-solid" placeholder="[autocomplete] [tempat]" id="tempat" name="tempat" readonly>
                </div>
              </div> -->
              <!-- <div class="form-group row">
                <label class="col-form-label col-3 text-right">Pada Tanggal</label>
                <div class="col-9">
                  <input type="date" class="form-control form-control-solid" placeholder="[autocomplete] [tanggal]" id="waktu" name="waktu" readonly>
                </div>
              </div> -->
              <!-- <div class="form-group row">
                <label class="col-form-label col-3 text-right">Pembuat</label>
                <div class="col-9">
                  <input type="text" class="form-control form-control-solid" placeholder="[autocomplete] [pembuat]" id="pembuat" name="pembuat" readonly>
                </div>
              </div> -->
              <!-- <div class="form-group row">
                <label class="col-form-label col-3 text-right">Tahun Audit</label>
                <div class="col-9">
                  <input type="text" class="form-control form-control-solid" placeholder="[autocomplete] [tahun_audit]" name="tahun_audit" id="tahun_audit" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-3 text-right">Status</label>
                <div class="col-9">
                  <input type="text" class="form-control form-control-solid" placeholder="[autocomplete] [status]" name="status" id="status" readonly>
                </div>
              </div> -->
              <div class="form-group row">
                <label class="col-form-label col-3 text-right">Jenis Audit</label>
                <div class="col-9">
                  <select class="form-control" id="" name="ID_JENIS_AUDIT" required>
                    <option value="">--Pilih--</option>
                    <?php foreach($list_ja as $data){ ?>
                    <option value="<?= $data['ID_JENIS_AUDIT'] ?>"><?= $data['JENIS_AUDIT'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-3 text-right">Auditee</label>
                <div class="col-9">
                  <select class="form-control" id="" name="AUDITEE" required>
                    <option value="">--Pilih--</option>
                    <?php foreach($list_divisi as $data){ ?>
                    <option value="<?= $data['ID_DIVISI'] ?>"><?= $data['NAMA_DIVISI'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-3 text-right">Tahun Audit</label>
                <div class="col-9">
                  <input type="text" class="form-control" name="TAHUN" placeholder="Tahun Audit" required>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-3 text-right">Periode Audit</label>
                <div class="col-3">
                    <input class="form-control"  <?= $disabled ?> type="date" value="<?= $data_apm->TGL_PERIODE_MULAI ?>"  name="TGL_PERIODE_MULAI">
                  </div><p>s/d</p>
                  <div class="col-3">
                    <input class="form-control"  <?= $disabled ?> type="date" value="<?= $data_apm->TGL_PERIODE_SELESAI ?>"  name="TGL_PERIODE_SELESAI">
                  </div>
              </div>
              <div class="separator separator-dashed mb-5"></div>
              <div class="form-group row">
                <label class="col-form-label col-3 text-right"></label>
                <div class="col-9">
                  <a onclick="tindak_lanjut()" type="submit" class="btn btn-primary font-weight-bold">Simpan</a>
                  <a href="<?= base_url() ?>monitoring/entry" class="btn btn-light-primary font-weight-bold">Back</a>
                </div>
              </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">

function tindak_lanjut()
{
  Swal.fire({
      text: 'Simpan data?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.value) {
        // if(document.getElementById('id_spa').value == '') Swal.fire("Surat Tidak Ditemukan!", "Periksa kembali Nomor Surat!", "error");
        // else window.location.href="<?php echo base_url() ?>"+'monitoring/entry/tindak_lanjut/'+$('#id_spa').val();
        $.ajax({
            url: '<?= base_url() ?>/monitoring/entry/simpan/',
            type: 'post',
            data: $("#form_lha").serialize(),
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
              if(data == "ERR")
                Swal.fire("Proses Gagal!", "Data sudah ada.", "error")
              else
                window.location = data;
            },
            error: function(data){
                Swal.fire("Error!", "Server Error!", "error")
            }
        });
      }
    })
}


</script>