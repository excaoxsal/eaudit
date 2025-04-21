<style type="text/css">
  #kt_datatable_popup_paginate{

    position: absolute;
    right: 10px;
  }
</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <div class="d-flex align-items-center flex-wrap mr-2">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Detail Respon Auditee</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4"><?=$detail['0']['NOMOR_ISO']?></span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4"><?=$detail['0']['KODE']?></span>
      </div>
    </div>
  </div>
  <div class="d-flex flex-column-fluid">
    <div class="container">
      <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
          <div class="card-title">
            <h3 class="card-label">List Respon Auditee 
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
          <div class="mb-7">
            <div class="row align-items-center">
              <div class="col-lg-9 col-xl-8">
                <div class="row align-items-center">
                  <div class="col-md-4 my-2 my-md-0">
                    <div class="input-icon">
                      <input type="text" class="form-control" placeholder="Search..." id="kt_datatable_popup_search_query" />
                      <span>
                        <i class="fa fa-search"></i>
                      </span>
                    </div>
                  </div>
                  <div class="col-md-4 my-2 my-md-0">
                    <div class="d-flex align-items-center">
                      <label class="mr-3 mb-0 d-none d-md-block">Klausul:</label>
                      <select class="form-control" id="kt_datatable_popup_search_status">
                        <option value="">All</option>
                        <?php foreach($list_divisi as $status){ ?>
                        <option value="<?= $status['NAMA_DIVISI'] ?>"><?= $status['NAMA_DIVISI'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable_popup"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- MODAL Respon -->
<?php if ($is_auditee && (strpos($this->session->NAMA_JABATAN, 'SM') === false || strpos($this->session->NAMA_JABATAN, 'ASM') !== false) && (strpos($this->session->NAMA_JABATAN, 'Branch Manager') === false)) { ?>
<div class="modal fade" id="modal_upload" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Respon Auditee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <form class="form" id="kt_form_popup" method="post" action="<?= base_url() ?>aia/Response_auditee/respon/<?=$kode?>" enctype="multipart/form-data">
        <div class="modal-body" style="height: auto">
          <input type="hidden"  name="ID_RE" id="ID_RE">
          <div class="form-group row">
            <div class="col-12">
              <label>Respon</label>
              <textarea class="form-control" <?= $disabled ?> name="RESPON[]" id="RESPONSE_AUDITEE"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
              <label>Lampiran 
                <span style="color: red;">(Ukuran File Maksimal 15 MB)</span>
              </label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="file_excel" id="file_excel">
                <label class="custom-file-label" for="customFile">Choose file</label>
              </div>
              <label><a id="FILE" href="#" download>Download File</a></label> <a onclick="deletefile()" href="#" class="btn btn-danger h-10" id="btnDelete">X</a>
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
<?php }else{?>
  <div class="modal fade" id="modal_upload" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Respon Auditee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <form class="form" id="kt_form_popup" method="post" action="<?= base_url() ?>aia/Response_auditee/respon/<?=$kode?>" enctype="multipart/form-data">
        <div class="modal-body" style="height: auto">
          <input type="hidden"  name="ID_RE" id="ID_RE">
          <div class="form-group row">
            <div class="col-12">
              <label>Respon</label>
              <textarea class="form-control" <?= $disabled ?> name="RESPON[]" id="RESPONSE_AUDITEE" readonly></textarea>
              <label><a id="FILE" href="#" download>Download File</a></label> 
            </div>
          </div>
        </div>
        <div class="modal-footer">
          
        </div>
      </form>
    </div>
  </div>
</div>
<?php }?>
<!-- Modal Chat box -->
<div class="modal fade" id="modal_chat" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Chatbox</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <form class="form" id="kt_form_popup" method="post" action="<?= base_url() ?>aia/Response_auditee/chatbox/<?=$kode?>" enctype="multipart/form-data">
        <div class="modal-body" style="height: auto">
          <input type="hidden"  name="ID_RE_CHAT" id="ID_RE_CHAT">
          <div class="form-group row">
            <div class="col-12">
            <?php if ($is_auditor) { ?>
              <label>Message Auditor</label>
              <textarea class="form-control" name="KOMENTAR_1" id="KOMENTAR_1"></textarea>
            <?php } else {?>
            
              <label>Message Auditor</label>
              <textarea readonly class="form-control" <?= $disabled ?> name="KOMENTAR_1" id="KOMENTAR_1"></textarea>
            <?php } ?>
              
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
            <?php if ($is_auditee){ ?>
              <label>Message Auditee</label>
              <textarea class="form-control" <?= $disabled ?> name="KOMENTAR_2" id="KOMENTAR_2"><?= $detail[0]['KOMENTAR_2']  ?></textarea>
            <?php } else {?>
            
              <label>Message Auditee</label>
              <textarea readonly class="form-control" <?= $disabled ?> name="KOMENTAR_2" id="KOMENTAR_2"><?= $detail[0]['KOMENTAR_2']  ?></textarea>
            <?php } ?>
              
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
<!-- MODAL Penilaian -->
<div class="modal fade" id="modal_penilaian" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Penilaian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <form class="form" id="kt_form_popup" method="post" action="<?= base_url() ?>aia/Response_auditee/submit_penilaian/<?=$kode?>" enctype="multipart/form-data">
        <div class="modal-body" style="height: auto">
          <input type="hidden"  name="ID_RE_PENILAIAN" id="ID_RE_PENILAIAN">
          <div class="form-group row">
            <div class="col-12">
            <?php if ($is_auditor) { ?>
              <label>Penilaian Jawaban</label>
                <select class="form-control status-select" data-id="${row.ID_RE}" name="PENILAIAN" id="PENILAIAN">
                    <option value="" <?= empty($row['STATUS']) ? "selected" : "" ?>>-- Pilih Status --</option>
                    <option value="1" <?= $row['STATUS'] == 1 ? "selected" : "" ?>>TIDAK DIISI SAMA SEKALI</option>
                    <option value="2" <?= $row['STATUS'] == 2 ? "selected" : "" ?>>JAWABAN TIDAK SESUAI</option>
                    <option value="3" <?= $row['STATUS'] == 3 ? "selected" : "" ?>>JAWABAN BENAR, LAMPIRAN SALAH</option>
                    <option value="4" <?= $row['STATUS'] == 4 ? "selected" : "" ?>>JAWABAN SALAH, LAMPIRAN BENAR</option>
                    <option value="5" <?= $row['STATUS'] == 5 ? "selected" : "" ?>>JAWABAN DAN LAMPIRAN SESUAI</option>
                </select>
            <?php } else {?>
            
              <label>Message Auditor</label>
              <textarea readonly class="form-control" <?= $disabled ?> name="KOMENTAR_1" id="KOMENTAR_1"></textarea>
            <?php } ?>
              
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
            <?php if ($is_auditee){ ?>
              <label>Status</label>
              <select class="form-control" name="KLASIFIKASI" id="KLASIFIKASI" readonly>
                  <option value="" <?= empty($item['klasifikasi']) ? "selected" : "" ?>>-- Pilih Klasifikasi --</option>
                  <option value="MAJOR" <?= $item['klasifikasi'] == 'MAJOR' ? 'selected' : '' ?>>MAJOR</option>
                  <option value="MINOR" <?= $item['klasifikasi'] == 'MINOR' ? 'selected' : '' ?>>MINOR</option>
                  <option value="OBSERVASI" <?= $item['klasifikasi'] == 'OBSERVASI' ? 'selected' : '' ?>>OBSERVASI</option>
              </select>
            <?php } else {?>
              <label>Status</label>
              <select class="form-control" name="KLASIFIKASI" id="KLASIFIKASI" readonly>
                  <option value="" <?= empty($item['klasifikasi']) ? "selected" : "" ?>>-- Pilih Klasifikasi --</option>
                  <option value="MAJOR" <?= $item['klasifikasi'] == 'MAJOR' ? 'selected' : '' ?>>MAJOR</option>
                  <option value="MINOR" <?= $item['klasifikasi'] == 'MINOR' ? 'selected' : '' ?>>MINOR</option>
                  <option value="OBSERVASI" <?= $item['klasifikasi'] == 'OBSERVASI' ? 'selected' : '' ?>>OBSERVASI</option>
              </select>
            <?php } ?>
              
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

<script type="text/javascript">
"use strict";
var KTDatatableJsonRemoteDemo = {
  init: function() 
  {
    var role = '<?= $role ?>';
    var t;
    t = $("#kt_datatable_popup").KTDatatable({
      data: {
        type: "remote",
        source: '<?= base_url() ?>aia/Response_auditee/jsonResponAuditeeDetail/<?=$kode?>',
        pageSize: 10
      },
      layout: {
        scroll: !1,
        footer: !1,
        height: "auto",
      },
      sortable: !0,
      pagination: !0,
      search: {
        input: $("#kt_datatable_popup_search_query"),
        key: "generalSearch"
      },
      columns: [
      {
        field: "number",
        title: "No.",
        width: 50, // Lebar tetap 50px
        autoHide: false, // Pastikan kolom selalu terlihat
        template: function(row, index) {
          var currentPage = t.getCurrentPage();
          var pageSize = t.getPageSize();
          return (currentPage - 1) * pageSize + (index + 1);
        }
      },
      {
        field: "KODE_KLAUSUL",
        title: "Klausul",
        width: 80,
        autoHide: false
      },
      {
        field: "NAMA_DIVISI",
        title: "SUB DIVISI",
        width: "auto",
        minWidth: 50,
      },
      {
        field: "PERTANYAAN",
        title: "Pertanyaan",
        width: "auto",
        minWidth: 50,
        template: function(t) {
          return `<div style="white-space: pre-wrap; word-wrap: break-word; min-height: 40px; display: flex; align-items: center;">${t.PERTANYAAN}</div>`;
        }
      },
      {
        field: "ID_ISO",
        title: "Action",
        class: "text-center",
        sortable: !1,
        searchable: !1,
        overflow: "auto",
        template: function(t) {
          if(t.RESPONSE_AUDITEE==""||t.RESPONSE_AUDITEE==null){
            var buttonTitle = 'Respon"><i class="fa fa-upload text-dark';
          }
          else if(t.RESPONSE_AUDITEE!=""||t.RESPONSE_AUDITEE!=null){
            var buttonTitle = 'Koreksi"><i class="fa fa-edit text-danger';
          }
          
          var iconClass = t.STATUS == 1 ? 'color:red' : 'color:#000';
          return '<a onclick="uploadFile(' + t.ID_RE + ')" class="btn btn-sm btn-clean btn-icon" title="' + buttonTitle 
        + '"></i></a><a onclick="chatbox(' + t.ID_RE + ')" class="btn btn-sm btn-clean btn-icon"><i class="fa fa-comment" style="' 
        + iconClass + '" title="Chat"></i></a>'
        <?php echo $is_auditor ? " + '<a onclick=\"penilaian(' + t.ID_RE + ')\" class=\"btn btn-sm btn-clean btn-icon\"><i class=\"fa fa-star\" style=\"' + iconClass + '\" title=\"Penilaian\"></i></a>'" : "''"; ?>;
}
      }]
    }), $("#kt_datatable_popup_search_status").on("change", (function() {
      t.search($(this).val().toLowerCase(), "NAMA_DIVISI")
    })), $("#kt_datatable_popup_search_status").selectpicker(),
    // Ensure datatable is fully initialized before calling gotoPage
    $("#kt_datatable_popup").KTDatatable().on('datatable-on-init', function() {
      $("#kt_datatable_popup").KTDatatable().gotoPage(1); // Set default to page 1
    });
  }
};


  
var currentID_TL;
function uploadFile(id_tl)
  {
    currentID_TL = id_tl;
    $.get(`<?= base_url('aia/Response_auditee/getFileUpload/') ?>`+id_tl, function(data, status){
        const obj = JSON.parse(data);
        $('#ID_RE').val(id_tl);
        $('#RESPONSE_AUDITEE').val(obj.RESPONSE_AUDITEE);

        if (obj.FILE && obj.FILE !== 'null') {
          $('#FILE').attr('href', obj.FILE).show();
          $('#btnDelete').show();
        } else {
          $('#FILE').hide();
          $('#btnDelete').hide();
        }
        // console.log(data.NOMOR_LHA);
    });
    $('#modal_upload').modal('show');
  }


  function deletefile(id, action)
  {
    Swal.fire({
      text: 'Apakah Anda yakin menghapus file ini ?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.value) {
        var obj = {ACTION: 'delete'};
        
        var form_data = $("#kt_form_popup").serialize() + '&' + $.param(obj);
        $.ajax({
          url: '<?= base_url() ?>aia/Response_auditee/deletefile/',
          type: 'post',
          data: form_data,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(data) {
            Swal.fire("Sukses!", "File berhasil terhapus", "success");
            uploadFile(currentID_TL);
          },
          error: function(data){
            Swal.fire("Gagal menyimpan data!", "Pastika semua kolom terisi!", "error");
          }
        });
      }
    })
  }

  function chatbox(id_tl)
  {
    $.post('<?= base_url('aia/Response_auditee/updateStatus/') ?>'+id_tl, function(response) {
        
    });
    $.get(`<?= base_url('aia/Response_auditee/getdatadetail/') ?>`+id_tl, function(data,status){
        const obj = JSON.parse(data);
    console.log(obj);
        $('#ID_RE_CHAT').val(id_tl);
        $('#KOMENTAR_1').val(obj.KOMENTAR_1);
        $('#KOMENTAR_2').val(obj.KOMENTAR_2);
        
    });
    $('#modal_chat').modal('show');
  }
  function penilaian(id_tl)
  {
    $.post('<?= base_url('aia/Response_auditee/submit_penilaian/') ?>'+id_tl, function(response) {
        
    });
    $.get(`<?= base_url('aia/Response_auditee/getpenilaian/') ?>`+id_tl, function(data,status){
        const obj = JSON.parse(data);
        $('#ID_RE_PENILAIAN').val(id_tl);
        $('#PENILAIAN').val(obj.PENILAIAN);
        $('#KLASIFIKASI').val(obj.KLASIFIKASI);
        
    });
    $('#modal_penilaian').modal('show');
  }
jQuery(document).ready((function() {
  KTDatatableJsonRemoteDemo.init()
}));
$(document).ready(function() {
  // Inisialisasi datatable
  KTDatatableJsonRemoteDemo.init();

  // Event handler untuk refresh halaman ketika modal ditutup
  $('#modal_chat').on('hidden.bs.modal', function() {
    $("#kt_datatable_popup").KTDatatable().reload();
  });

  $('#modal_upload').on('hidden.bs.modal', function() {
    $("#kt_datatable_popup").KTDatatable().reload();
  });
  $('#modal_penilaian').on('hidden.bs.modal', function() {
    $("#kt_datatable_popup").KTDatatable().reload();
  });
});
</script>
