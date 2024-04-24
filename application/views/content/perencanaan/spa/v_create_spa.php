<!-- <style type="text/css">
  #editor-a ol li::before, #editor-b ol li::before {
  content: counter(list-0, lower-alpha) '. ';
}
  }
</style> -->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <div class="d-flex align-items-center flex-wrap mr-2">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Perencanaan</span>
        
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">SPA</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Create</span>
      </div>
    </div>
  </div>
  <div class="d-flex flex-column-fluid">
    <div class="container">
      <form class="form" id="form_spa" method="post" enctype="multipart/form-data">
        <div class="card card-custom">
          <div class="card-header">
            <div class="card-title">
              <h3 class="card-label"><?= $title ?></h3>
            </div>

          </div>
          <div class="card-body">
            <?php if ($this->session->flashdata('error')) { ?>
              <div class="alert alert-danger alert-dismissible text-left">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban text-white"></i> Error!</h4>
                <?= $this->session->flashdata('error'); ?>
              </div>
            <?php } ?>
            <?php if ($this->session->flashdata('success')) { ?>
              <div class="input-group mb-3">
                <div class="alert alert-success alert-dismissible" style="width: 100%;">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h6><i class="icon fa fa-check text-white"></i> Success!</h6>
                  <?= $this->session->flashdata('success'); ?>
                </div>
              </div>
            <?php } ?>
            <!-- <div class="form-group row">
              <label class="col-form-label col-3 text-right">Key</label>
              <div class="col-9">
                <input type="text" <?= $disabled ?> class="form-control" id="nomor_surat" placeholder="Nomor Surat" name="NOMOR_SPA_SEQ" value="<?= $spa_detail->NOMOR_SURAT ?>">
              </div>
            </div> -->
            <div class="form-group row">
              <label class="col-form-label col-3 text-right">Auditee</label>
              <div class="col-8">
                <div class="form-label">
                  <select <?= $disabled ?> class="form-control select-dua" id="AUDITEE" name="AUDITEE" required>
                  <option value="">--Pilih--</option>
                  <?php foreach ($list_divisi as $data) { ?>
                    <option <?= $disabled ?> <?= $data['ID_DIVISI'] == $spa_detail->AUDITEE ? 'selected' : ''; ?> value="<?= $data['ID_DIVISI'] ?>"><?= $data['NAMA_DIVISI'] ?></option>
                  <?php } ?>
                </select>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-3 text-right">Tahun Audit</label>
              <div class="col-8">
                <div class="form-label">
                  <input type="text" <?= $disabled ?> class="form-control datepicker-year" value="<?= $spa_detail->TAHUN_AUDIT ?>" name="TAHUN_AUDIT" placeholder="Tahun Audit" required>
                </div>
              </div>
            </div>
            <div class="form-group row" style="display: none">
              <label class="col-form-label col-3 text-right">Dasar</label>
              <div class="col-9">
                <div id="editor-a" style="height: 200px;overflow: auto; <?= $enable_css ?>"></div>
                <input type="hidden" name="DASAR_AUDIT" id="DASAR_AUDIT">
              </div>
            </div>
            <div id="list_auditee">
              <div class="form-group row">
                <label class="col-form-label col-3 text-right">Dasar</label>
                <div class="col-8">
                  <!-- <input type="text" class="form-control" placeholder="Peserta Rapat" name="PESERTA[]" id="nama_auditee" value="<?= $peserta[0]['DASAR']  ?>"> -->
                  <textarea class="form-control" <?= $disabled ?> name="PESERTA[]" id="nama_auditee"><?= $peserta[0]['DASAR']  ?></textarea>
                </div>
                <div class="col-1">
                  <?php if ($disabled != 'disabled') { ?>
                    <span style="cursor: pointer;" name="add_auditee" id="add_auditee" class="label font-weight-bold label-lg label-success label-inline mt-2">+</span><br>
                  <?php } ?>
                </div>

              </div>
            </div>
            <div id="list_tim_audit">
              <div class="form-group row">
                <label class="col-form-label col-3 text-right">Diperintahkan kepada</label>
                <div class="col-4">
                  <select <?= $disabled ?> class="form-control select-dua" id="tim_audit" name="TIM_AUDIT[]">
                    <option value="">--Pilih User--</option>
                    <?php if (!empty($tim_audit)) { ?>
                      <option selected value="<?= $tim_audit[0]['ID_USER'] ?>"><?= $tim_audit[0]['NAMA'] ?></option>
                    <?php }
                    foreach ($list_user as $user) { ?>
                      <option value="<?= $user['ID_USER'] ?>"><?= $user['NAMA'] ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-4">
                  <select <?= $disabled ?> class="form-control select-dua" id="jabatan_tim" name="JABATAN_TIM[]">
                    <option value="">--Pilih Jabatan--</option>
                    <?php if (!empty($tim_audit)) {
                      $jabatan = ['Ketua Tim', 'Pengawas', 'Anggota Tim'];
                      $value = $tim_audit[0]['JABATAN'];
                    ?>
                      <option selected value="<?= $value ?>"><?= $jabatan[$value - 1] ?></option>
                    <?php } ?>
                    <option value="1">Ketua Tim</option>
                    <option value="2">Pengawas</option>
                    <option value="3">Anggota Tim</option>
                  </select>
                </div>
                <div style="<?= ($disabled == 'disabled') ? 'display:none' : '' ?>" class="col-1">
                  <span style="cursor: pointer;" name="add_tim_audit" id="add_tim_audit" class="label font-weight-bold label-lg label-success label-inline mt-2">+</span><br>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-3 text-right">Periode Audit</label>
              <div class="col-lg-4 col-md-11">
                <div class="form-label">
                  <div class="input-icon input-icon-right mb-2">
                    <input autocomplete="off" placeholder="Periode Awal" type="text" <?= $disabled ?> value="<?= $spa_detail->PERIODE_AUDIT_AWAL ?>"  name="PERIODE_AUDIT_AWAL" required class="form-control datepicker w-100">
                    <span>
                      <i class="fa fa-calendar"></i>
                    </span>
                  </div>
                </div>
              </div>
              <!-- <p class="my-auto">s/d</p> -->
              <div class="col-lg-4 col-md-11">
                <div class="form-label">
                  <div class="input-icon input-icon-right mb-2">
                    <input autocomplete="off" placeholder="Periode Selesai" type="text" <?= $disabled ?> type="date" value="<?= $spa_detail->PERIODE_AUDIT_AKHIR ?>" name="PERIODE_AUDIT_AKHIR" required class="form-control datepicker w-100">
                    <span>
                      <i class="fa fa-calendar"></i>
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-form-label col-3 text-right">Masa Audit</label>
              <div class="col-lg-4 col-md-11">
                <div class="form-label">
                  <div class="input-icon input-icon-right mb-2">
                    <input autocomplete="off" placeholder="Tanggal Awal Masa Audit" type="text" <?= $disabled ?> value="<?= $spa_detail->MASA_AUDIT_AWAL ?>"  name="MASA_AUDIT_AWAL" required class="form-control datepicker w-100">
                    <span>
                      <i class="fa fa-calendar"></i>
                    </span>
                  </div>
                </div>
              </div>
              <!-- <p class="my-auto">s/d</p> -->
              <div class="col-lg-4 col-md-11">
                <div class="form-label">
                  <div class="input-icon input-icon-right mb-2">
                    <input autocomplete="off" placeholder="Tanggal Akhir Masa Audit" type="text" <?= $disabled ?> type="date" value="<?= $spa_detail->MASA_AUDIT_AKHIR ?>" name="MASA_AUDIT_AKHIR" required class="form-control datepicker w-100">
                    <span>
                      <i class="fa fa-calendar"></i>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-3 text-right">Jumlah Hari Masa Audit</label>
              <div class="col-lg-4 col-md-11">
                <div class="form-label">
                  <input type="number" value="<?= $spa_detail->TOTAL_HARI_AUDIT ?>" name="TOTAL_HARI_AUDIT" class="form-control" <?= $disabled ?> required>
                </div>
              </div>
              <!-- <p class="my-auto">s/d</p> -->
              <div class="col-lg-4 col-md-11">
                <div class="form-label">
                  <select role="button" name="TOTAL_HARI_AUDIT_KET" class="form-control" <?= $disabled ?> required>
                    <option value="">--Pilih--</option>
                    <option <?= $spa_detail->TOTAL_HARI_AUDIT_KET == 'Hari Kerja' ? 'selected' : '' ; ?> value="Hari Kerja">Hari Kerja</option>
                    <option <?= $spa_detail->TOTAL_HARI_AUDIT_KET == 'Hari Kalender' ? 'selected' : '' ; ?> value="Hari Kalender">Hari Kalender</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group row" style="display: none;">
              <label class="col-form-label col-3 text-right">Isi Perintah</label>
              <div class="col-9">
                <div id="editor-b" style="height: 200px;overflow: auto; <?= $enable_css ?>"></div>
                <input type="hidden" name="ISI_PERINTAH" id="ISI_PERINTAH">
              </div>
            </div>
            <div id="list_perintah">
              <div class="form-group row">
                <label class="col-form-label col-3 text-right">Isi Perintah</label>
                <div class="col-8">
                  <textarea class="form-control" <?= $disabled ?> name="PERINTAH[]" id="nama_perintah"><?= $perintah[0]['PERINTAH']  ?></textarea>
                </div>
                <div class="col-1">
                  <?php if ($disabled != 'disabled') { ?>
                    <span style="cursor: pointer;" name="add_perintah" id="add_perintah" class="label font-weight-bold label-lg label-success label-inline mt-2">+</span><br>
                  <?php } ?>
                </div>

              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-3 text-right">Perintah Selesai.</label>
              <div class="col-9">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-3 text-right">Dikeluarkan di</label>
              <div class="col-8">
                <input type="text" <?= $disabled ?> class="form-control" id="dikeluarkan" placeholder="Ex : Jakarta" name="DIKELUARKAN" value="<?= $spa_detail->DIKELUARKAN ?>">
              </div>
            </div>
            <div id="list_tembusan">
              <div class="form-group row">
                <label class="col-form-label col-3 text-right">Tembusan</label>
                <div class="col-8">
                  <input type="text" class="form-control" <?= $disabled ?> name="TEMBUSAN[]" id="nama_tembusan" value="<?= $tembusan[0]['TEMBUSAN']  ?>">
                </div>
                <div class="col-1">
                  <?php if ($disabled != 'disabled') { ?>
                    <span style="cursor: pointer;" name="add_tembusan" id="add_tembusan" class="label font-weight-bold label-lg label-success label-inline mt-2">+</span><br>
                  <?php } ?>
                </div>

              </div>
            </div>
            <!-- <div class="form-group row">
              <label class="col-form-label col-3 text-right">Pada Tanggal</label>
              <div class="col-4">
                <input class="form-control" <?= $disabled ?> type="date" id="PADA_TANGGAL" name="PADA_TANGGAL" value="<?= $spa_detail->PADA_TANGGAL ?>">
              </div>
            </div> -->
            <div class="separator separator-dashed mb-5"></div>
            <?php if ($spa_detail->ID_STATUS == 4) { ?>
              <div class="form-group row">
                <div class="col-9 offset-3">
                  <label class="col-form-label text-right">
                    <h6><b>Log History</b></h6>
                  </label>
                  <div class="log" style="height:100px; background-color:#F3F6F9; border: 1px solid #1E1E2D; overflow-y:scroll; padding:10px">
                    <?php if (!empty($data_log)) {
                      foreach ($data_log as $value) {
                        echo $value['TGL_LOG'] . ' - ' . $value['LOG'] . '<br>';
                      }
                    } ?>
                  </div>
                </div>
              </div>
            <?php } ?>
            <div class="form-group row">
              <label class="col-form-label col-3 text-right"></label>
              <div class="col-9">
                <?php if ($spa_detail->ID_SPA != '') { ?>
                  <a target="_blank" href="<?= base_url() ?>perencanaan/spa/cetak_preview?id=<?= base64_encode($spa_detail->ID_SPA) ?>" class="btn btn-light-primary font-weight-bold">Preview</a>
                <?php } ?>
                <?php if ($spa_detail->ID_STATUS != 2 && $spa_detail->ID_STATUS != 3) { ?>
                  <a onclick="save(<?= $spa_detail->ID_SPA ?>)" class="btn btn-light-success font-weight-bold">Simpan</a>
                  <a onclick="kirim(<?= $spa_detail->ID_SPA ?>)" class="btn btn-light-warning font-weight-bold">Kirim</a>
                <?php } ?>
                <?php if ($spa_detail->APPROVER_COUNT == $spa_detail->APPROVED_COUNT && $spa_detail->ID_STATUS == 3) { ?>
                  <a data-toggle="modal" data-target="#modal_upload" class="btn btn-success font-weight-bold">Upload</a>
                <?php } ?>
                <a onclick="back()" class="btn btn-light-danger font-weight-bold">Kembali</a>
              </div>
            </div>
          </div>
      </form>
    </div>
    <!--end::Card-->
    <!--end::Dashboard-->
  </div>
  <!--end::Container-->
</div>
<!--end::Entry-->
</div>
<!--end::Content-->
<!-- Modal-->
<div class="modal fade" id="modal_upload" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update SPA</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <form class="form" id="kt_form" method="post" action="<?= base_url() ?>perencanaan/spa/upload_lampiran?id=<?= base64_encode($spa_detail->ID_SPA) ?>" enctype="multipart/form-data">
        <div class="modal-body" style="height: auto">

          <div class="form-group row">
            <div class="col-12">
              <label>Nomor Surat</label>
              <input type="text" class="form-control" placeholder="Nomor Surat" name="NOMOR_SURAT" id="NOMOR_SURAT">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
              <label>Pada Tanggal</label>
              <div class="form-label">
                <div class="input-icon input-icon-right mb-2">
                  <input autocomplete="off" placeholder="Tanggal" type="text" name="PADA_TANGGAL" required class="form-control datepicker w-100">
                  <span>
                    <i class="fa fa-calendar"></i>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
              <label>Lampiran</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="LAMPIRAN" id="LAMPIRAN" />
                <label class="custom-file-label" for="customFile">Choose file</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-primary font-weight-bold" value="Submit">
        </div>
      </form>
    </div>
  </div>
</div>
<!-- end:modal -->

<script type="text/javascript">
  $(document).ready(function() {
    
    var i = 1;
    var tim_audit = '<?= json_encode($tim_audit) ?>';
    var disabled = '<?= $disabled ?>';
    tim_audit = JSON.parse(tim_audit);
    if (tim_audit) {
      var jabatan = ['Ketua Tim', 'Pengawas', 'Anggota Tim'];
      tim_audit.splice(0, 1);
      tim_audit.forEach(element => {
        i++
        $('#list_tim_audit').append('<div class="form-group row" id="row' + i + '"><label class="col-form-label col-3 text-right"></label><div class="col-4"><select ' + disabled + ' class="form-control select-dua" id="tim_audit' + i + '" name="TIM_AUDIT[]"><option value="">--Pilih User--</option><option selected value="' + element.ID_USER + '">' + element.NAMA + '</option><?php foreach ($list_user as $user) { ?><option value="<?= $user['ID_USER'] ?>"><?= $user['NAMA'] ?></option><?php } ?></select></div><div class="col-4"><select ' + disabled + ' class="form-control select-dua" id="jabatan_tim' + i + '" name="JABATAN_TIM[]"><option value="">--Pilih Jabatan--</option><option selected value="' + element.JABATAN + '">' + jabatan[element.JABATAN - 1] + '</option><option value="1">Ketua Tim</option><option value="2">Pengawas</option><option value="3">Anggota Tim</option></select></div><div class="col-1"><span style="cursor: pointer; <?= ($disabled == 'disabled') ? 'display:none' : '' ?>" name="remove" id="' + i + '" class="btn-remove label font-weight-bold label-lg label-danger label-inline mt-2">-</span><br></div></div>');
      });
      selectRefresh();
    }
    var peserta = '<?= json_encode($peserta) ?>';
    peserta = JSON.parse(peserta);
    if (peserta) {
      peserta.splice(0, 1);
      peserta.forEach(element => {
        i++
        $('#list_auditee').append('<div class="form-group row" id="row' + i + '"><label class="col-form-label col-3 text-right"></label><div class="col-8"><textarea <?= $disabled ?> class="form-control" name="PESERTA[]" id="nama_auditee">' + element.DASAR + '</textarea></div><div class="col-1"><span style="cursor: pointer;<?= ($disabled == 'disabled') ? 'display:none' : '' ?>" name="remove" id="' + i + '" class="btn-remove label font-weight-bold label-lg label-danger label-inline mt-2">-</span><br></div></div>');
      });
    }
    var perintah = '<?= json_encode($perintah) ?>';
    perintah = JSON.parse(perintah);
    if (perintah) {
      perintah.splice(0, 1);
      perintah.forEach(element => {
        i++
        $('#list_perintah').append('<div class="form-group row" id="row' + i + '"><label class="col-form-label col-3 text-right"></label><div class="col-8"><textarea <?= $disabled ?> class="form-control" name="PERINTAH[]" id="nama_perintah">' + element.PERINTAH + '</textarea></div><div class="col-1"><span style="cursor: pointer;<?= ($disabled == 'disabled') ? 'display:none' : '' ?>" name="remove" id="' + i + '" class="btn-remove label font-weight-bold label-lg label-danger label-inline mt-2">-</span><br></div></div>');
      });
    }
    var tembusan = '<?= json_encode($tembusan) ?>';
    tembusan = JSON.parse(tembusan);
    if (tembusan) {
      tembusan.splice(0, 1);
      tembusan.forEach(element => {
        i++
        $('#list_tembusan').append('<div class="form-group row" id="row' + i + '"><label class="col-form-label col-3 text-right"></label><div class="col-8"><input type="text" <?= $disabled ?> class="form-control" name="TEMBUSAN[]" id="nama_tembusan" value="' + element.TEMBUSAN + '"></div><div class="col-1"><span style="cursor: pointer;<?= ($disabled == 'disabled') ? 'display:none' : '' ?>" name="remove" id="' + i + '" class="btn-remove label font-weight-bold label-lg label-danger label-inline mt-2">-</span><br></div></div>');
      });
    }
    $('#add_tembusan').click(function() {
      i++;
      $('#list_tembusan').append('<div class="form-group row" id="row' + i + '"><label class="col-form-label col-3 text-right"></label><div class="col-8"><input type="text" class="form-control" name="TEMBUSAN[]" id="nama_tembusan"></div><div class="col-1"><span style="cursor: pointer;" name="remove" id="' + i + '" class="btn-remove label font-weight-bold label-lg label-danger label-inline mt-2">-</span><br></div></div>');
    });
    $('#add_auditee').click(function() {
      i++;
      $('#list_auditee').append('<div class="form-group row" id="row' + i + '"><label class="col-form-label col-3 text-right"></label><div class="col-8"><textarea class="form-control" name="PESERTA[]" id="nama_auditee"></textarea></div><div class="col-1"><span style="cursor: pointer;" name="remove" id="' + i + '" class="btn-remove label font-weight-bold label-lg label-danger label-inline mt-2">-</span><br></div></div>');
    });
    $('#add_perintah').click(function() {
      i++;
      $('#list_perintah').append('<div class="form-group row" id="row' + i + '"><label class="col-form-label col-3 text-right"></label><div class="col-8"><textarea class="form-control" name="PERINTAH[]" id="nama_perintah"></textarea></div><div class="col-1"><span style="cursor: pointer;" name="remove" id="' + i + '" class="btn-remove label font-weight-bold label-lg label-danger label-inline mt-2">-</span><br></div></div>');
    });
    $('#add_tim_audit').click(function() {
      i++;
      $('#list_tim_audit').append('<div class="form-group row" id="row' + i + '"><label class="col-form-label col-3 text-right"></label><div class="col-4"><select class="form-control select-dua" id="tim_audit' + i + '" name="TIM_AUDIT[]"><option value="">--Pilih User--</option><?php foreach ($list_user as $user) { ?><option value="<?= $user['ID_USER'] ?>"><?= $user['NAMA'] ?></option><?php } ?></select></div><div class="col-4"><select class="form-control select-dua" id="jabatan_tim' + i + '" name="JABATAN_TIM[]"><option value="">--Pilih Jabatan--</option><option value="1">Ketua Tim</option><option value="2">Pengawas</option><option value="3">Anggota Tim</option></select></div><div class="col-1"><span style="cursor: pointer;" name="remove" id="' + i + '" class="btn-remove label font-weight-bold label-lg label-danger label-inline mt-2">-</span><br></div></div>');
      selectRefresh();
    });
    $(document).on('click', '.btn-remove', function() {
      var button_id = $(this).attr("id");
      $("#row" + button_id + "").remove();
    });
  });

  function getValueQuill(id, hiddenId, currentValue, enable = true, placeholder = '') {
    var quill = new Quill(id, {
      modules: {
        toolbar: [
          ['bold', 'italic', 'underline'],
          ['link'],
          [{
            list: 'ordered'
          }, {
            list: 'bullet'
          }]
        ]
      },
      placeholder,
      theme: 'snow'
    });
    quill.enable(enable);
    if (currentValue) {
      var myEditor = document.querySelector(id);
      var html = myEditor.children[0].innerHTML = currentValue;
    }
    quill.on('text-change', function(delta, oldDelta, source) {
      var myEditor = document.querySelector(id);
      var html = myEditor.children[0].innerHTML;
      document.getElementById(hiddenId).value = html;
    });
  }
  getValueQuill('#editor-a', 'DASAR_AUDIT', '<?= $spa_detail->DASAR_AUDIT ?>', '<?= $enable ?>');
  getValueQuill('#editor-b', 'ISI_PERINTAH', '<?= $spa_detail->ISI_PERINTAH ?>', '<?= $enable ?>');

  function kirim(id) {
    Swal.fire({
      text: 'Apakah Anda yakin akan mengirim surat ini ?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.value) {
        // $("#form_spa").submit(function(e){
        //   e.preventDefault();
        var obj = {
          "ID_SPA": id,
          "ACTION": 3,
        };
        var form_data = $("#form_spa").serialize() + '&' + $.param(obj);
        $.ajax({
          url: '<?= base_url() ?>perencanaan/spa/simpan/',
          type: 'post',
          data: form_data,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(data) {
            // console.log(data);
            window.location = data;
          },
          error: function(data) {
            Swal.fire("Gagal menyimpan data!", "Pastikan semua kolom terisi!", "error");
          }
        });
        // });
      }
    })
  }

  function save(id) {
    Swal.fire({
      text: 'Apakah Anda yakin akan menyimpan surat ini ?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.value) {
        var obj = {
          "ID_SPA": id,
          "ACTION": 2,
        };
        var form_data = $("#form_spa").serialize() + '&' + $.param(obj);
        if ($('#dikeluarkan').val() == '' || $('#jabatan_tim').val() == '' || $('#tim_audit').val() == '')
          Swal.fire("Gagal menyimpan data!", "Pastikan semua kolom terisi!", "error");
        else {
          $.ajax({
            url: '<?= base_url() ?>perencanaan/spa/simpan',
            type: 'post',
            data: form_data,
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
              // console.log("DATA RETURN", data);
              // alert(data);
              window.location = data;
              // console.log(data);
            },
            error: function(data) {
              Swal.fire("Gagal mengirim data!", "Pastikan semua kolom terisi!", "error");
            }
          });
        }
        // });
      }
    })
  }

  function preview() {
    Swal.fire({
      text: 'Data akan tersimpan sebagai draft, lanjutkan preview?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.value) {
        if ($('#nomor_surat').val() == '')
          Swal.fire("Gagal menyimpan data!", "Nomor Surat tidak boleh kosong!", "error");
        else if ($('#kepada').val() == '')
          Swal.fire("Gagal menyimpan data!", "Kepada tidak boleh kosong!", "error");
        else if ($('#perihal').val() == '')
          Swal.fire("Gagal menyimpan data!", "Perihal tidak boleh kosong!", "error");
        else {
          $.ajax({
            url: '<?= base_url() ?>perencanaan/spa/preview',
            type: 'post',
            data: $("#form_spa").serialize(),
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
              if (data == "error") {
                Swal.fire("Gagal menyimpan data!", "Pastikan semua data terpenuhi!", "error");
              } else {
                console.log(data);
                window.open("<?php echo base_url() ?>" + 'perencanaan/apm/cetak_preview', '_blank');
                // window.location.href="<?php echo base_url() ?>"+'perencanaan/kotak_keluar/spa/';
              }
              // alert(data);
            },
            error: function(data) {
              Swal.fire("Gagal mengirim data!", "Pastikan semua kolom terisi!", "error");
            }
          });
        }
      }
    })
  }

  function back() {
    window.location = '<?= base_url() ?>perencanaan/spa/kotak_keluar'
  }
</script>