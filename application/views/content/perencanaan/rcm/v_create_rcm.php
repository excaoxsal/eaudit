<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <div class="d-flex align-items-center flex-wrap mr-2">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Perencanaan</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Tanggapan Pertanyaan Audit</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Create TPA</span>
      </div>
    </div>
  </div>
  <div class="d-flex flex-column-fluid">
    <div class="container">
      <form class="form" id="form_rcm" method="post" enctype="multipart/form-data">
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
            <div class="form-group row">
              <label class="col-form-label col-3 text-right">Nomor SPA</label>
              <div class="col-8">
                <?php if(empty($data_rcm)){ ?>
                <select <?= $disabled ?> class="form-control select-dua" id="id_spa" name="ID_SPA">
                  <option value="">--Pilih Nomor--</option>
                  <?php 
                  foreach ($nomor_spa as $nomor) { ?>
                    <option value="<?= $nomor['ID_SPA'] ?>"><?= $nomor['NOMOR_SURAT'] ?></option>
                  <?php } ?>
                </select>
                <?php }else{ ?>
                    <input disabled type="text" value="<?= $nomor_surat ?>" class="form-control" placeholder="Auditee">
                <?php } ?>
              </div>
            </div>
            <!-- <div class="separator separator-dashed mb-5"></div> -->
            <div class="form-group row">
              <label class="col-form-label col-3 text-right">Auditee</label>
              <div class="col-8">
                <input <?= $disabled ?> type="text" value="<?= $data_rcm->KEPADA ?>" class="form-control" name="KEPADA" id="KEPADA" placeholder="Auditee">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-3 text-right">Area Audit</label>
              <div class="col-8">
                <input <?= $disabled ?> type="text" value="<?= $data_rcm->AREA_AUDIT ?>" class="form-control" name="AREA_AUDIT" id="AREA_AUDIT" placeholder="Area Audit">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-3 text-right">Periode Audit</label>
              <div class="col-lg-4 col-md-11">
                <div class="form-label">
                  <div class="input-icon input-icon-right mb-2">
                    <input autocomplete="off" placeholder="Periode Awal" type="text" <?= $disabled ?> value="<?= $data_rcm->TGL_PERIODE_MULAI ?>" name="TGL_PERIODE_MULAI" class="form-control datepicker w-100">
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
                    <input autocomplete="off" placeholder="Periode Selesai" type="text" <?= $disabled ?> value="<?= $data_rcm->TGL_PERIODE_SELESAI ?>" name="TGL_PERIODE_SELESAI" class="form-control datepicker w-100">
                    <span>
                      <i class="fa fa-calendar"></i>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-8 offset-3">
                <?php if (((empty($disabled) || $disabled == null) && !isset($_GET['review'])) || $_GET['sts-approver'] == 1) { ?>
                  <a href="" onclick="modalOpen()" data-toggle="modal" data-target="#modal_proses" class="btn btn-primary font-weight-bolder"><i class="fa fa-plus" style="font-size: 12px;"></i>&nbsp;&nbsp;&nbsp;Add Proses</a><br><br>
                <?php } ?>
              </div>
              
            </div>
            <div class="form-group row">
              <div class="col-12">
                <table id="tableProses" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Proses</th>
                      <th>Risiko</th>
                      <?php if ((empty($disabled) || $disabled == null) && !isset($_GET['review'])) { ?>
                        <th class="text-center">Action</th>
                      <?php } ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($list_add_proses as $key => $dt) { ?>
                      <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= $dt['DESKRIPSI_PROSES'] ?></td>
                        <td><?= $dt['DESKRIPSI_RESIKO'] ?></td>
                        <?php if (((empty($disabled) || $disabled == null) && !isset($_GET['review'])) || $_GET['sts-approver'] == 1) { ?>
                          <td class="text-center">
                            <a onclick="edit_proses('<?= $dt['ID_RCM_ADD_PROSES'] ?>', '<?= $dt['ID_RCM'] ?>')" href="#" data-toggle="modal" data-target="#modal_proses" title="Edit">
                              <i class="fa fa-edit text-dark"></i>
                            </a>
                            <a onclick="delete_proses('<?= $dt['ID_RCM_ADD_PROSES'] ?>', '<?= $dt['ID_RCM'] ?>')" class="btn btn-sm btn-clean btn-icon" title="Hapus"><i class="fa fa-trash text-dark"></i></a>
                          </td>
                        <?php } ?>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-3 text-right"></label>
              <div class="col-8">
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
                <div class="datatable datatable-bordered datatable-head-custom" id="datatable"></div>
              </div>
            </div>
            <?php if (isset($_GET['review'])) { ?>
              <div class="form-group row">
                <label class="col-form-label col-3 text-right">Komentar</label>
                <div class="col-8">
                  <textarea name="KOMENTAR" id="KOMENTAR"></textarea>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-3 text-right">Tanggal Approve</label>
                <div class="col-4">
                  <div class="form-label">
                      <div class="input-icon input-icon-right mb-2">
                        <input autocomplete="off" placeholder="Tanggal" type="text" value="<?= date('Y-m-d') ?>" name="TANGGAL" class="form-control datepicker w-100">
                        <span>
                          <i class="fa fa-calendar"></i>
                        </span>
                      </div>
                   </div>
                </div>
              </div>
              <div class="separator separator-dashed mb-5"></div>
              <div class="form-group row">
                <div class="col-8 offset-3">
                  <label class="col-form-label text-right">
                    <h6><b>Log History</b></h6>
                  </label>
                  <div class="timeline timeline-justified timeline-4 mb-5">
                    <div class="timeline-bar"></div>
                    <div class="timeline-items">
                      <?php if(!empty($data_log)) {
                        foreach ($data_log as $value) { ?>
                        <div class="timeline-item">
                            <div class="timeline-badge">
                                <div class="bg-primary"></div>
                            </div>

                            <div class="timeline-label">
                                <span class="text-primary font-weight-bold"><?= $value['TGL_LOG'] ?></span>
                            </div>

                            <div class="timeline-content">
                                <?= $value['LOG'] ?>
                            </div>
                        </div>
                      <?php } } ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php } else if ($data_rcm->ID_STATUS == 4) { ?>
              <div class="form-group row">
                <div class="col-8 offset-3">
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
              <div class="col-8">
                <?php if (isset($_GET['review'])) { ?>
                  <a target="_blank" href="<?= base_url() ?>perencanaan/rcm/cetak_preview/<?= $data_rcm->ID_RCM ?>" class="btn btn-light-primary font-weight-bold">Preview</a>
                  <?php if ($_GET['sts-approver'] == 1) { ?>
                    <a onclick="submitButton(3)" class="btn btn-light-success font-weight-bold">Approve</a>
                    <a onclick="submitButton(4)" class="btn btn-light-warning font-weight-bold">Reject</a>
                  <?php } ?>
                  <a onclick="back('<?= $data_rcm->ID_RCM ?>')" class="btn btn-light-danger font-weight-bold">Kembali</a>
                <?php } else { ?>
                  <a target="_blank" href="<?= base_url() ?>perencanaan/rcm/cetak_preview/<?= $data_rcm->ID_RCM ?>" class="btn btn-light-primary font-weight-bold">Preview</a>
                  <?php if ($data_rcm->ID_STATUS != 2 && $data_rcm->ID_STATUS != 3) { ?>
                    <a onclick="save('<?= $data_rcm->ID_RCM ?>', 1)" class="btn btn-light-success font-weight-bold">Simpan</a>
                    <a onclick="save('<?= $data_rcm->ID_RCM ?>', 2)" class="btn btn-light-warning font-weight-bold">Kirim</a>
                  <?php } ?>
                  <a onclick="back()" class="btn btn-light-danger font-weight-bold">Kembali</a>
                <?php } ?>
              </div>
            </div>
          </div>
      </form>
    </div>
  </div>
</div>
</div>
<!-- Modal-->
<div class="modal fade" id="modal_proses" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content" style="width:1200px;height:850px">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Proses</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <!-- <form class="form" id="kt_form" method="post" action="<?= base_url() ?>monitoring/entry/add_rekomendasi/<?= $detail_temuan->ID ?>" enctype="multipart/form-data">  -->
      <div class="modal-body" style="height: 500px;">
        <?php
        $this->load->view('/content/perencanaan/rcm/v_add_proses_rcm');
        ?>
      </div>
      <!-- </form> -->
    </div>
  </div>
</div>
<!-- end:modal -->
<!-- Modal resiko-->
<div class="modal fade" id="modal_desc_resiko" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content " style="width:1000px; min-height:500px;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pilih Resiko</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <div class="modal-body" style="min-height: 200px;">
        <div class="mb-7">
          <div class="row align-items-center">
            <div class="col-12">
              <div class="row align-items-center">
                <div class="col-md-3 my-2 my-md-0">
                  <div class="input-icon">
                    <input type="text" class="form-control" placeholder="Search..." id="datatable_search_query" />
                    <span>
                      <i class="fa fa-search"></i>
                    </span>
                  </div>
                </div>
                <div class="col-md-4 my-2 my-md-0">
                  <div class="d-flex align-items-center">
                    <label class="mr-3 mb-0 d-none d-md-block">Auditee:</label>
                    <select class="form-control select-dua" id="datatable_search_auditee" name="AUDITEE" required>
                      <option value="">--Pilih--</option>
                      <?php foreach ($list_divisi as $data) { ?>
                        <option value="<?= $data['ID_DIVISI'] ?>"><?= $data['NAMA_DIVISI'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4 my-2 my-md-0">
                  <div class="d-flex align-items-center">
                    <label class="mr-3 mb-0 d-none d-md-block">Deskripsi Proses:</label>
                    <select class="form-control select-dua" id="datatable_search_klasifikasi" name="KLASIFIKASI" required>
                      <option value="">--Pilih--</option>
                      <?php foreach ($klasifikasi as $data) { ?>
                        <option value="<?= $data['ID'] ?>"><?= $data['KLASIFIKASI'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="datatable datatable-bordered datatable-head-custom" id="table_resiko"></div>
      </div>
    </div>
  </div>
</div>
<!-- end:modal -->
<script src="https://cdn.quilljs.com/1.0.0/quill.js"></script>
<script type="text/javascript">

  function save(id, action) {
    Swal.fire({
      text: 'Apakah Anda yakin mengupdate data ini ?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.value) {
        var obj = {
          ACTION: action
        };
        if (id) {
          obj.ID_RCM = id;
        }
        var form_data = $("#form_rcm").serialize() + '&' + $.param(obj);
        $.ajax({
          url: '<?= base_url() ?>/perencanaan/rcm/simpan/',
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
            Swal.fire("Gagal menyimpan data!", "Pastika semua kolom terisi!", "error");
          }
        });
      }
    })
  }

  function submitButton(action) {
    Swal.fire({
      text: 'Yakin melakukan aksi ini ?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.value) {

        var obj = {
          ACTION: action
        };
        var form_data = $("#form_rcm").serialize() + '&' + $.param(obj);
        $.ajax({
          url: '<?= base_url() ?>/perencanaan/rcm/approve_reject/<?= $data_rcm->ID_RCM ?>',
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
      }
    })
  }

  function back(id) {
    if (id) {
      window.location = '<?= base_url() ?>perencanaan/rcm/kotak_masuk'
    } else {
      window.location = '<?= base_url() ?>perencanaan/rcm/kotak_keluar'
    }
  }

  function delete_proses(id, id_rcm) {
    Swal.fire({
      text: 'Yakin menghapus data ini ?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: '<?= base_url() ?>/perencanaan/rcm/delete_proses/' + id + '?ID_RCM=' + id_rcm,
          type: 'get',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(data) {
            $("#tableProses").html(data);
            Swal.fire('Sukses!', 'Berhasil menghapus data!', 'success');
            location.reload();
          },
          error: function(data) {
            Swal.fire("Gagal menyimpan data!", "Pastika semua kolom terisi!", "error");
          }
        });
      }
    })
  }

  function edit_proses(id, id_rcm) {
    console.log(id, id_rcm);
    $.ajax({
      url: '<?= base_url() ?>/perencanaan/rcm/edit_proses/' + id + '?ID_RCM=' + id_rcm,
      type: 'get',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {
        $("input[name='TIPE_KONTROL[]']").prop('checked', false);
        $("input[name='FREKUENSI_KONTROL[]']").prop('checked', false);
        var dt = JSON.parse(data);
        // console.log(dt.ID_RCM_ADD_PROSES);
        var arr_tk, arr_fk;
        if (dt.TIPE_KONTROL == null) arr_tk = '';
        else arr_tk = dt.TIPE_KONTROL;
        if (dt.FREKUENSI_KONTROL == null) arr_fk = '';
        else arr_fk = dt.FREKUENSI_KONTROL;
        console.log(arr_fk);
        console.log(arr_tk);
        arr_tk = arr_tk.split(', ');
        arr_fk = arr_fk.split(', ');

        tk_length = $("input[name='TIPE_KONTROL[]']").length;
        for (let index = 0; index < tk_length; index++) {
          if (arr_tk.includes($("#TIPE_KONTROL" + index).val())) {
            $("#TIPE_KONTROL" + index).prop('checked', true);
          }
        }

        fk_length = $("input[name='FREKUENSI_KONTROL[]']").length;
        for (let index = 0; index < fk_length; index++) {
          if (arr_fk.includes($("#FREKUENSI_KONTROL" + index).val())) {
            $("#FREKUENSI_KONTROL" + index).prop('checked', true);
          }
        }

        document.getElementById('ID_RCM_ADD_PROSES').value = dt.ID_RCM_ADD_PROSES;
        document.getElementById('ID_RCM').value = dt.ID_RCM;

        var select_pr = document.getElementById('PRIORITAS_RESIKO');
        var select_kelemahan = document.getElementById('KELEMAHAN');
        $('#PRIORITAS_RESIKO').val(dt.PRIORITAS_RESIKO);
        $('#KELEMAHAN').val(dt.KELEMAHAN);
        // tinymce.get("DESKRIPSI_PROSES").setContent(dt.DESKRIPSI_PROSES);
        // tinymce.get("DESKRIPSI_RESIKO").setContent(dt.DESKRIPSI_RESIKO);
        // tinymce.get("KONTROL_STANDAR").setContent(dt.KONTROL_STANDAR);
        // tinymce.get("KONTROL_AS_IS").setContent(dt.KONTROL_AS_IS);
        // tinymce.get("KONTROL_SHOULD_BE").setContent(dt.KONTROL_SHOULD_BE);
        // tinymce.get("AUDITEE").setContent(dt.AUDITEE);
        // tinymce.get("AUDIT_PROGRAM").setContent(dt.AUDIT_PROGRAM);
        // tinymce.get("JML_SAMPLE").setContent(dt.JML_SAMPLE);
        // tinymce.get("ANGGARAN_MANDAYS").setContent(dt.ANGGARAN_MANDAYS);
        // tinymce.get("REFERENSI_KKP").setContent(dt.REFERENSI_KKP);

        $("#DESKRIPSI_PROSES").val(dt.DESKRIPSI_PROSES);
        $("#DESKRIPSI_RESIKO").val(dt.DESKRIPSI_RESIKO);
        $("#KONTROL_STANDAR").val(dt.KONTROL_STANDAR);
        $("#KONTROL_AS_IS").val(dt.KONTROL_AS_IS);
        $("#KONTROL_SHOULD_BE").val(dt.KONTROL_SHOULD_BE);
        $("#AUDITEE").val(dt.AUDITEE);
        $("#AUDIT_PROGRAM").val(dt.AUDIT_PROGRAM);
        $("#JML_SAMPLE").val(dt.JML_SAMPLE);
        $("#ANGGARAN_MANDAYS").val(dt.ANGGARAN_MANDAYS);
        $("#REFERENSI_KKP").val(dt.REFERENSI_KKP);
        // var opt_pr = document.createElement('option');
        // opt_pr.value = dt.PRIORITAS_RESIKO;
        // opt_pr.innerHTML = dt.TR_RESIKO;
        // opt_pr.selected = true;
        // select_pr.appendChild(opt_pr);

        // var opt = document.createElement('option');
        // opt.value = dt.KELEMAHAN;
        // opt.innerHTML = dt.KELEMAHAN;
        // opt.selected = true;
        // select_kelemahan.appendChild(opt);


        // var arrIdQuill = ['#editor-a', '#editor-b', '#editor-c', '#editor-d', '#editor-e', '#editor-f', '#editor-g', '#editor-h', '#editor-i', '#editor-j'];
        // var arrKey = ['DESKRIPSI_PROSES', 'DESKRIPSI_RESIKO', 'KONTROL_STANDAR', 'KONTROL_AS_IS', 'KONTROL_SHOULD_BE', 'AUDITEE', 'AUDIT_PROGRAM', 'JML_SAMPLE', 'ANGGARAN_MANDAYS', 'REFERENSI_KKP'];
        // idx = 0;
        // for (var key in dt) {
        //   var myEditor = document.querySelector(arrIdQuill[idx]);
        //   if (dt.hasOwnProperty(arrKey[idx])) {
        //     var html = myEditor.children[0].innerHTML = dt[arrKey[idx]];
        //   }
        //   idx++;
        // };
      },
      error: function(data) {
        Swal.fire("Gagal menyimpan data!", "Pastika semua kolom terisi!", "error");
      }
    });
  }

  function modalOpen() {
    console.log("ID_RCM_ADD_PROSES ", document.getElementById('ID_RCM_ADD_PROSES').value);
    $("input[name='TIPE_KONTROL[]']").prop('checked', false);
    $("input[name='FREKUENSI_KONTROL[]']").prop('checked', false);
    $('#PRIORITAS_RESIKO option:selected').prop('selected', false);
    $('#KELEMAHAN option:selected').prop('selected', false);

    document.getElementById('ID_RCM_ADD_PROSES').value = '';
    document.getElementById('ID_RCM').value = '<?= $data_rcm->ID_RCM ?>';
    // var arrIdQuill = ['#editor-a', '#editor-b', '#editor-c', '#editor-d', '#editor-e', '#editor-f', '#editor-g', '#editor-h', '#editor-i', '#editor-j'];
    // for (var i = 0; i <= arrIdQuill.length; i++) {
    //   var myEditor = document.querySelector(arrIdQuill[i]);
    //   var html = myEditor.children[0].innerHTML = '';
    // };
  }

  //table master
  var KTDatatableResiko = {
    init: function() {
      var t;
      t = $("#table_resiko").KTDatatable({
        data: {
          type: "remote",
          source: '<?= base_url() ?>master/resiko_desc/resiko_desc_json',
          pageSize: 10
        },
        layout: {
          scroll: !1,
          footer: !1
        },
        sortable: !0,
        pagination: !0,
        search: {
          input: $("#datatable_search_query"),
          key: "generalSearch"
        },
        columns: [{
            field: "NAMA_DIVISI",
            title: "Auditee"
          }, {
            field: "KLASIFIKASI",
            title: "Deskripsi Proses"
          },
          {
            field: "DESC",
            title: "Deskripsi Resiko"
          },
          {
            field: "RESIKO",
            title: "Prioritas Resiko"
          },
          {
            field: "KONTROL_STANDAR",
            title: "Kontrol Standar"
          },
          {
            field: "RENCANA_KERJA",
            title: "Kontrol As/Is"
          },
          {
            field: "ID",
            title: "Actions",
            sortable: !1,
            searchable: !1,
            overflow: "visible",
            autoHide: false,
            template: function(t) {
              return '<a href="javascript:;" onclick="pilih(\'' + btoa(t.ID) + '\')" class="btn btn-sm btn-primary" title="Edit">Pilih</a>'
            }
          }
        ]
      });

      $("#datatable_search_status").on("change", (function() {
        t.search($(this).val().toLowerCase(), "STATUS")
      }));
      $("#datatable_search_auditee").on("change", (function() {
        t.search($(this).val().toLowerCase(), "DIVISI_ID")
      }));
      $("#datatable_search_klasifikasi").on("change", (function() {
        t.search($(this).val().toLowerCase(), "KLASIFIKASI_ID")
      }));

      $("#datatable_search_status, #datatable_search_auditee, #datatable_search_klasifikasi").selectpicker()

    }
  };
  jQuery(document).ready((function() {
    KTDatatableResiko.init()

    $('.btn_modal_desc_proses').click(() => {
      $('#kt_master_table').KTDatatable('reload');
    })

  }));

  const pilih = (id) => {
    fetch(`<?= base_url() ?>master/resiko_desc/resiko_desc_json?id=${id}`, {method:'POST'})
      .then(response => response.json())
      .then(data => {
        $('#PRIORITAS_RESIKO').val(data[0]['TINGKAT_RESIKO_ID']);
        $("#DESKRIPSI_PROSES").val(data[0]['KLASIFIKASI']);
        $("#DESKRIPSI_RESIKO").val(data[0]['DESC']);
        $("#KONTROL_STANDAR").val(data[0]['KONTROL_STANDAR']);
        $("#KONTROL_AS_IS").val(data[0]['RENCANA_KERJA']);
        // tinymce.get("DESKRIPSI_PROSES").setContent(data[0]['KLASIFIKASI']);
        // tinymce.get("DESKRIPSI_RESIKO").setContent(data[0]['DESC']);
        // tinymce.get("KONTROL_STANDAR").setContent(data[0]['KONTROL_STANDAR']);
        // tinymce.get("KONTROL_AS_IS").setContent(data[0]['RENCANA_KERJA']);
        // const myEditor1 = document.querySelector('#editor-a');
        // myEditor1.children[0].innerHTML = data[0]['KLASIFIKASI'];
        // const myEditor2 = document.querySelector('#editor-b');
        // myEditor2.children[0].innerHTML = data[0]['DESC'];
        // const myEditor3 = document.querySelector('#editor-d');
        // myEditor3.children[0].innerHTML = data[0]['RENCANA_KERJA'];
        // const myEditor4 = document.querySelector('#editor-c');
        // myEditor4.children[0].innerHTML = data[0]['KONTROL_STANDAR'];
        $('#modal_desc_resiko').modal('hide');
      })
      .catch(err => {
        Swal.fire('Internal Server Error', '', 'error');
      });
  }
</script>