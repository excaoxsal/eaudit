
<style type="text/css">
  #kt_datatable_paginate{

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
        <span class="text-muted font-weight-bold mr-4">Temuan Detail</span>
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
            <h3 class="card-label">List Temuan Detail 
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
                      <input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query" />
                      <span>
                        <i class="fa fa-search"></i>
                      </span>
                    </div>
                  </div>
                  <div class="col-md-4 my-2 my-md-0">
                    <div class="d-flex align-items-center">
                      <label class="mr-3 mb-0 d-none d-md-block">Klausul:</label>
                      <select class="form-control" id="kt_datatable_search_status">
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
          <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- MODAL Respon -->
<?php if ($is_auditee) { ?>
<div class="modal fade" id="modal_upload" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Entry Commitment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <form class="form" id="kt_form" method="post" action="<?= base_url() ?>aia/temuan/commitment/<?=$kode?>" enctype="multipart/form-data">
        <div class="modal-body" style="height: auto">
          <input type="hidden"  name="ID_TEMUAN" id="ID_TEMUAN">
          <div class="form-group row">
            <label class="col-form-label col-md-2">Tindakan Investigasi</label>
            <div class="col-md-10">
              <textarea class="form-control" <?= $disabled ?> name="INVESTIGASI[]" id="INVESTIGASI"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-md-2">Tindakan Perbaikan</label>
            <div class="col-md-10">
              <textarea class="form-control" <?= $disabled ?> name="PERBAIKAN[]" id="PERBAIKAN"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-md-2">Tindakan Korektif</label>
            <div class="col-md-10">
              <textarea class="form-control" <?= $disabled ?> name="KOREKTIF[]" id="KOREKTIF"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-md-2">Tanggal Implementasi</label>
            <div class="col-md-10">
              <input type="date" class="form-control" name="TANGGAL" id="TANGGAL" placeholder="Select a date">
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
      <form class="form" id="kt_form" method="post" action="<?= base_url() ?>aia/temuan/commitment/<?=$kode?>" enctype="multipart/form-data">
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
      <form class="form" id="kt_form" method="post" action="<?= base_url() ?>aia/temuan/chatbox/<?=$kode?>" enctype="multipart/form-data">
        <div class="modal-body" style="height: auto">
          <input type="hidden"  name="ID_TEMUAN" id="ID_TEMUAN">
          <div class="form-group row">
            <div class="col-12">
            <?php if ($is_auditor) { ?>
              <label>Message Auditor</label>
              <textarea class="form-control" name="KOMENTAR_AUDITOR" id="KOMENTAR_AUDITOR"></textarea>
            <?php } else {?>
            
              <label>Message Auditor</label>
              <textarea readonly class="form-control" <?= $disabled ?> name="KOMENTAR_AUDITOR" id="KOMENTAR_AUDITOR"></textarea>
            <?php } ?>
              
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
            <?php if ($is_auditee) { ?>
              <label>Message Auditee</label>
              <textarea class="form-control" <?= $disabled ?> name="KOMENTAR_AUDITEE" id="KOMENTAR_AUDITEE"><?= $detail[0]['KOMENTAR_AUDITEE']  ?></textarea>
            <?php } else {?>
            
              <label>Message Auditee</label>
              <textarea readonly class="form-control" <?= $disabled ?> name="KOMENTAR_AUDITEE" id="KOMENTAR_AUDITEE"><?= $detail[0]['KOMENTAR_AUDITEE']  ?></textarea>
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
<!-- Modal Approve Commitment  -->
 <!-- Untuk Approve Commitment hanya dimunculkan untuk ATASAN -->
<div class="modal fade" id="modal_approve" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Approve Commitment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <form class="form" id="kt_form" method="post" action="<?= base_url() ?>aia/temuan/chatbox/<?=$kode?>" enctype="multipart/form-data">
        <div class="modal-body" style="height: auto">
          <input type="hidden"  name="ID_TEMUAN" id="ID_TEMUAN">
          <div class="form-group row">
            <div class="col-12">
            <select class="form-control select-dua" id="id_temuan" name="APPROVE_COMMITMENT">
              <option value="1">Approve</option>
              <option value="0">Reject</option>
            </select>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
            <textarea class="form-control" name="ALASAN_KOMITMENT" id="ALASAN_KOMITMEN"></textarea>
            </div>
          </div>
          
          <div class="form-group row">
            <div class="col-12">
            <?php if ($is_auditor) { ?>
              <label>Message Auditor</label>
              <textarea class="form-control" name="KOMENTAR_AUDITOR" id="KOMENTAR_AUDITOR"></textarea>
            <?php } else {?>
            
              <label>Message Auditor</label>
              <textarea readonly class="form-control" <?= $disabled ?> name="KOMENTAR_AUDITOR" id="KOMENTAR_AUDITOR"></textarea>
            <?php } ?>
              
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
            <?php if ($is_auditee) { ?>
              <label>Message Auditee</label>
              <textarea class="form-control" <?= $disabled ?> name="KOMENTAR_AUDITEE" id="KOMENTAR_AUDITEE"><?= $detail[0]['KOMENTAR_AUDITEE']  ?></textarea>
            <?php } else {?>
            
              <label>Message Auditee</label>
              <textarea readonly class="form-control" <?= $disabled ?> name="KOMENTAR_AUDITEE" id="KOMENTAR_AUDITEE"><?= $detail[0]['KOMENTAR_AUDITEE']  ?></textarea>
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
<?= $is_auditee ?>
<script type="text/javascript">
 "use strict";
var KTDatatableJsonRemoteDemo = {
  init: function() 
  {
    var role = '<?= $role ?>';
    var t;
    t = $("#kt_datatable").KTDatatable({
      data: {
        type: "remote",
        source: '<?= base_url() ?>aia/Temuan/jsonTemuanDetail/<?=$kode?>',
        pageSize: 10
      },
      layout: {
        scroll: !1,
        footer: !1
      },
      sortable: !0,
      pagination: !0,
      search: {
        input: $("#kt_datatable_search_query"),
        key: "generalSearch"
      },
      columns: [{
        field: "KLAUSUL",
        title: "Klausul"
      },
      {
        field: "TEMUAN",
        title: "Temuan"
      },
      {
        field: "ID_RESPONSE",
        title: "ID"
      },
      {
        field: "STATUS",
        title: "Status"
      },{
          field: "ID_TEMUAN",
          title: "Action",
          class: "text-center",
          sortable: !1,
          searchable: !1,
          overflow: "visible",
          template: function(t) {
            var buttonTitle = role ==='AUDITOR'  ? 'Lihat"><i class="fa fa-eye text-dark' : 'Respon"><i class="fa fa-upload text-dark';
            
            var approve = t.STATUS == 'Approved' ? 'color:green' : 'color:red"hidden="true';
            var iconClass = t.STATUS_KOMEN == 1 ? 'color:red' : 'color:#000';
            
            return '<span class="label font-weight-bold label-lg label-light-default label-inline"style="'+approve+'">'+t.STATUS+'</span>'+
            '<a onclick="approve(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="Approve Commitment"><i class="fa fa-file-circle-check text-dark"></i></a>'+
            '<a onclick="uploadFile(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="Entry Commitment"><i class="fa fa-file-import text-dark"></i></a>'+
            '<a onclick="uploadFile(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="Download"><i class="fa fa-file-pdf text-dark"></i></a>'+
            '<a onclick="chatbox(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="fa fa-comment" style="' + iconClass + '" title="Chat"></i></a>';
        }
        }]
    }), $("#kt_datatable_search_status").on("change", (function() {
      t.search($(this).val().toLowerCase(), "NAMA_DIVISI")
    })), $("#kt_datatable_search_status").selectpicker()
  }
};
var currentID_TL;
function uploadFile(id_tl)
  {
    currentID_TL = id_tl;
    $.get(`<?= base_url('aia/Temuan/getFileUpload/') ?>`+id_tl, function(data, status){
        const obj = JSON.parse(data);
        $('#ID_TEMUAN').val(id_tl);
        $('#INVESTIGASI').val(obj.INVESTIGASI);
        $('#PERBAIKAN').val(obj.PERBAIKAN);
        $('#KOREKTIF').val(obj.KOREKTIF);
        $('#TANGGAL').val(obj.TANGGAL);

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
        
        var form_data = $("#kt_form").serialize() + '&' + $.param(obj);
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
    $.post('<?= base_url('aia/temuan/updateStatus/') ?>'+id_tl, function(response) {
        
    });
    $.get(`<?= base_url('aia/temuan/getdatadetail/') ?>`+id_tl, function(data,status){
        const obj = JSON.parse(data);
  console.log(obj);
        $('#ID_TEMUAN').val(id_tl);
        $('#KOMENTAR_AUDITOR').val(obj.KOMENTAR_AUDITOR);
        $('#KOMENTAR_AUDITEE').val(obj.KOMENTAR_AUDITEE);
        
    });
    $('#modal_chat').modal('show');
  }
  function approve(id_tl){
    $.get(`<?= base_url('aia/temuan/getdatadetail/') ?>`+id_tl, function(data,status){
        const obj = JSON.parse(data);
  console.log(obj);
        $('#ID_TEMUAN').val(id_tl);
    });
    $('#modal_approve').modal('show');
  }
jQuery(document).ready((function() {
  KTDatatableJsonRemoteDemo.init()
}));
$(document).ready(function() {
  // Inisialisasi datatable
  KTDatatableJsonRemoteDemo.init();

  // Event handler untuk refresh halaman ketika modal ditutup
  $('#modal_chat').on('hidden.bs.modal', function() {
    $("#kt_datatable").KTDatatable().reload();
  });

  $('#modal_upload').on('hidden.bs.modal', function() {
    $("#kt_datatable").KTDatatable().reload();
  });
});
</script>
