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
<!-- Start MODAL Entry Commitment -->
<div class="modal fade" id="modal_commitment" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
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
<!-- END MODAL Entry Commitment -->
<!-- Start MODAL View Commitment -->
<div class="modal fade" id="modal_viewCommitment" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">View Commitment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <form class="form" id="kt_form" method="post" action="<?= base_url() ?>aia/temuan/commitment/<?=$kode?>" enctype="multipart/form-data">
        <div class="modal-body" style="height: auto">
          <input type="hidden" name="ID_TEMUAN" id="ID_TEMUAN">
          <div class="form-group row">
            <label class="col-form-label col-md-2">Tindakan Investigasi</label>
            <div class="col-md-10">
              <textarea class="form-control" disabled name="INVESTIGASI[]" id="VIEWINVESTIGASI"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-md-2">Tindakan Perbaikan</label>
            <div class="col-md-10">
              <textarea class="form-control" disabled name="PERBAIKAN[]" id="VIEWPERBAIKAN"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-md-2">Tindakan Korektif</label>
            <div class="col-md-10">
              <textarea class="form-control" disabled name="KOREKTIF[]" id="VIEWKOREKTIF"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-md-2">Tanggal Implementasi</label>
            <div class="col-md-10">
              <input type="date" class="form-control" disabled name="TANGGAL" id="VIEWTANGGAL" placeholder="Select a date">
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- END MODAL View Commitment -->
<!-- Start MODAL Entry Tindak Lanjut -->
<div class="modal fade" id="modal_TL" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tindak Lanjut</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <form class="form" id="kt_form" method="post" action="<?= base_url() ?>aia/Temuan/tindakLanjut/<?=$kode?>" enctype="multipart/form-data">
        <div class="modal-body" style="height: auto">
          <input type="hidden"  name="ID_TEMUAN" id="ID_TEMUAN_ENTRY">
          <div class="form-group row">
            <div class="col-12">
              <label>Keterangan</label>
              <textarea class="form-control" <?= $disabled ?> name="KETERANGAN_TL[]" id="KETERANGAN_TL"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
              <label>Lampiran</label>
              <div class="custom-file" id="FILE_TL">
                <input type="file" class="custom-file-input" name="upload_file" id="upload_file">
                <label class="custom-file-label" for="customFile">Choose file</label>
              </div>
              <label><a id="FILE" href="#" download>Download File</a></label> <a onclick="deletefile()" href="#" class="btn btn-danger h-10" id="btnDelete">X</a>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="submit" id="btnSubmitTL" class="btn btn-primary font-weight-bold" value="Submit">
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End MODAL Entry Tindak Lanjut -->
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
          <input type="hidden"  name="ID_TEMUAN" id="ID_TEMUAN_CHATBOX">
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
<!-- Start Modal Approve Commitment  -->
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
      <form class="form" id="kt_form" method="post" action="<?= base_url() ?>aia/temuan/approval/<?=$kode?>" enctype="multipart/form-data">
        <div class="modal-body" style="height: auto">
          
          <div class="form-group row">
            <label class="col-form-label col-md-2">Tindakan Investigasi</label>
            <div class="col-md-10">
              <textarea class="form-control" disabled name="INVESTIGASI[]" id="APINVESTIGASI"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-md-2">Tindakan Perbaikan</label>
            <div class="col-md-10">
              <textarea class="form-control" disabled name="PERBAIKAN[]" id="APPERBAIKAN"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-md-2">Tindakan Korektif</label>
            <div class="col-md-10">
              <textarea class="form-control" disabled name="KOREKTIF[]" id="APKOREKTIF"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-md-2">Tanggal Implementasi</label>
            <div class="col-md-10">
              <input type="date" class="form-control" disabled name="TANGGAL" id="APTANGGAL" placeholder="Select a date">
            </div>
          </div>
          <input type="hidden"  name="ID_TEMUAN" id="ID_TEMUAN_APPROVAL1">
          <div class="form-group row">
            <div class="col-12">
            <select class="form-control select-dua" id="APPROVAL_COMMITMENT" name="APPROVAL_COMMITMENT">
              <option value="1">Approve</option>
              <option value="0">Reject</option>
            </select>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
            <textarea class="form-control" name="KETERANGAN_ATASAN_AUDITEE" id="KETERANGAN_ATASAN"></textarea>
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
<!-- End Modal Approve Commitment  -->
<!-- Start Modal Approve TL  -->
 <!-- Untuk Approve TL hanya dimunculkan untuk ATASAN -->
<div class="modal fade" id="modal_approveTL" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Approve Tindak Lanjut</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <form class="form" id="kt_form" method="post" action="<?= base_url() ?>aia/temuan/approvalTL/<?=$kode?>" enctype="multipart/form-data">
        <div class="modal-body" style="height: auto">
          <input type="hidden"  name="ID_TEMUAN" id="ID_TEMUAN_APPROVALTL">
          <div class="form-group row">
            <div class="col-12">
            <select class="form-control select-dua" id="APPROVAL_TINDAKLANJUT" name="APPROVAL_TINDAKLANJUT">
              <option value="1">Approve</option>
              <option value="0">Reject</option>
            </select>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
            <textarea class="form-control" name="KETERANGAN_TL_ATASAN" id="KETERANGAN_TL_ATASAN"></textarea>
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
<!-- End Modal Approve Commitment  -->
<!-- Start MODAL Log -->
<div class="modal fade" id="logModal" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">LOG HISTORY</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <form class="form" id="log_form" method="post" action="<?= base_url() ?>aia/Temuan/getLog/<?=$kode?>" enctype="multipart/form-data">
        <div class="modal-body" style="height: auto">
          <input type="hidden" name="ID_TARGET" id="ID_TARGET">
          <div class="form-group row">
            <div class="col-12">
              <div id="LOG_KIRIM" class="form-control" style="height: auto; overflow-y: auto;"></div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End MODAL Log -->
 
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
      },{
        field: "TEMUAN",
        title: "Temuan"
      },{
        field: "KATEGORI",
        title: "Kategori"
      },{
        field: "STATUS",
        title: "Status",
        template: function(t) {
          if (t.APPROVAL_COMMITMENT == 0 && t.APPROVAL_TINDAKLANJUT == 0) {
            return '<span>' + t.STATUS + '</span>';
          } else if (t.APPROVAL_COMMITMENT == 3 && t.APPROVAL_TINDAKLANJUT == 3) {
            return '<span class="label font-weight-bold label-lg label-light-default label-inline"style="color:green">'+t.STATUS+'</span>';
          } else if (t.STATUS=="Tindak Lanjut") {
            if (t.APPROVAL_TINDAKLANJUT != 0){
              return '<span>' + t.STATUS + ' (' + t.APPROVAL_TINDAKLANJUT + '/3)</span>';
            }
            else{
              return '<span>' + t.STATUS + '</span>';
            }
          } 
          else if (t.STATUS=="Commitment") {
            return '<span>' + t.STATUS + ' (' + t.APPROVAL_COMMITMENT + '/3)</span>';
          } else if (t.STATUS=="Commitment Approved") {
            return '<span>' + t.STATUS + '</span>';
          } 
        }
      },{
          field: "ID_TEMUAN",
          title: "Action",
          class: "text-center",
          sortable: !1,
          searchable: !1,
          overflow: "visible",
          template: function(t) {
            var buttonTitle = role ==='AUDITOR'  ? 'Lihat"><i class="fa fa-eye text-dark' : 'Respon"><i class="fa fa-upload text-dark';
            
            var approve = t.STATUS == 'CLOSE' ? 'color:green' : 'color:red"hidden="true';
            var iconClass = t.STATUS_KOMEN == 1 ? 'color:red' : 'color:#000';
            var sessionUserId = <?php echo json_encode($_SESSION['ID_USER']); ?>;
            var isAuditor = <?php echo json_encode($is_auditor); ?>;
            var isAuditee = <?php echo json_encode($is_auditee); ?>;
            var isPICAuditor = <?php echo json_encode($list_temuan_header[0]['ID_AUDITOR']); ?>;
            var isLeadPICAuditor = <?php echo json_encode($is_lead_auditor); ?>;
            var is_atasan_auditee = <?php echo json_encode($is_atasan_auditee); ?>;
            var is_lead_auditor = <?php echo json_encode($is_lead_auditor); ?>;
            if(t.KATEGORI=='OBSERVASI'){
              return ''+
              '<a href="<?= base_url() ?>aia/temuan/export_pdf/'+t.ID_TEMUAN+'" class="btn btn-sm btn-clean btn-icon" title="Print LKHA"><i class="fa-solid fa-file-pdf text-dark"></i></a>'+
              '<a onclick="chatbox(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="fa fa-comment" style="' + iconClass + '" title="Chat"></i></a>'+
              '<a onclick="log(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="far fa-file-alt text-dark" title="Logs"></i></a>';
            }
            else{
              if(is_lead_auditor){
              if (t.STATUS == 'OPEN'){
                console.log('a');
                return '<span class="label font-weight-bold label-lg label-light-default label-inline"style="'+approve+'">'+t.STATUS+'</span>'+
                '<a onclick="chatbox(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="fa fa-comment" style="' + iconClass + '" title="Chat"></i></a>'+
                '<a onclick="log(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="far fa-file-alt text-dark" title="Logs"></i></a>';
              }else if(t.STATUS == 'Commitment' && t.APPROVAL_COMMITMENT == 2 && isLeadPICAuditor){
                console.log('b');
                return '<span class="label font-weight-bold label-lg label-light-default label-inline"style="'+approve+'">'+t.STATUS+'</span>'+
                '<a onclick="approve(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="Approve Commitment"><i class="fa fa-file-circle-check text-dark"></i></a>'+
                '<a onclick="viewCommitment(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Commitment"><i class="fa-solid fa-scroll text-dark"></i></a>'+
                '<a onclick="chatbox(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="fa fa-comment" style="' + iconClass + '" title="Chat"></i></a>'+
                '<a href="<?= base_url() ?>aia/temuan/export_pdf/'+t.ID_TEMUAN+'" class="btn btn-sm btn-clean btn-icon" title="Print LKHA"><i class="fa-solid fa-file-pdf text-dark"></i></a>'+
                '<a onclick="log(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="far fa-file-alt text-dark" title="Logs"></i></a>';
              }else if(t.STATUS == 'Commitment' && t.APPROVAL_COMMITMENT !== 2 && isLeadPICAuditor){
                console.log('b');
                return '<span class="label font-weight-bold label-lg label-light-default label-inline"style="'+approve+'">'+t.STATUS+'</span>'+
                '<a onclick="viewCommitment(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Commitment"><i class="fa-solid fa-scroll text-dark"></i></a>'+
                '<a onclick="chatbox(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="fa fa-comment" style="' + iconClass + '" title="Chat"></i></a>'+
                '<a href="<?= base_url() ?>aia/temuan/export_pdf/'+t.ID_TEMUAN+'" class="btn btn-sm btn-clean btn-icon" title="Print LKHA"><i class="fa-solid fa-file-pdf text-dark"></i></a>'+
                '<a onclick="log(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="far fa-file-alt text-dark" title="Logs"></i></a>';
              }else if(t.STATUS == 'Tindak Lanjut' && t.APPROVAL_COMMITMENT == 3 && t.APPROVAL_TINDAKLANJUT == 2 && isLeadPICAuditor){
                return '<span class="label font-weight-bold label-lg label-light-default label-inline"style="'+approve+'">'+t.STATUS+'</span>'+
                '<a onclick="approveTL(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="Approve Tindak Lanjut"><i class="fa fa-file-circle-check text-dark"></i></a>'+
                '<a onclick="viewTL(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Tindak Lanjut"><i class="fa-solid fa-file-alt text-dark"></i></a>'+
                '<a onclick="viewCommitment(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Commitment"><i class="fa-solid fa-scroll text-dark"></i></a>'+
                '<a onclick="chatbox(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="fa fa-comment" style="' + iconClass + '" title="Chat"></i></a>'+
                '<a href="<?= base_url() ?>aia/temuan/export_pdf/'+t.ID_TEMUAN+'" class="btn btn-sm btn-clean btn-icon" title="Print LKHA"><i class="fa-solid fa-file-pdf text-dark"></i></a>'+
                '<a onclick="log(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="far fa-file-alt text-dark" title="Logs"></i></a>';
              }else if(t.STATUS == 'Tindak Lanjut' && t.APPROVAL_COMMITMENT == 3 && t.APPROVAL_TINDAKLANJUT !== 2 && isLeadPICAuditor){
                return ''+
                '<a onclick="viewTL(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Tindak Lanjut"><i class="fa-solid fa-file-alt text-dark"></i></a>'+
                '<a onclick="viewCommitment(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Commitment"><i class="fa-solid fa-scroll text-dark"></i></a>'+
                '<a onclick="chatbox(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="fa fa-comment" style="' + iconClass + '" title="Chat"></i></a>'+
                '<a href="<?= base_url() ?>aia/temuan/export_pdf/'+t.ID_TEMUAN+'" class="btn btn-sm btn-clean btn-icon" title="Print LKHA"><i class="fa-solid fa-file-pdf text-dark"></i></a>'+
                '<a onclick="log(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="far fa-file-alt text-dark" title="Logs"></i></a>';
              }else if(t.STATUS == 'CLOSE' && isLeadPICAuditor){
                console.log('as');
                return ''+
                '<a onclick="viewTL(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Tindak Lanjut"><i class="fa-solid fa-file-alt text-dark"></i></a>'+
                '<a onclick="viewCommitment(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Commitment"><i class="fa-solid fa-scroll text-dark"></i></a>'+
                '<a onclick="chatbox(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="fa fa-comment" style="' + iconClass + '" title="Chat"></i></a>'+
                '<a href="<?= base_url() ?>aia/temuan/export_pdf/'+t.ID_TEMUAN+'" class="btn btn-sm btn-clean btn-icon" title="Print LKHA"><i class="fa-solid fa-file-pdf text-dark"></i></a>'+
                '<a onclick="log(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="far fa-file-alt text-dark" title="Logs"></i></a>';
              }
              
              else{
                console.log('f');
                return '<span class="label font-weight-bold label-lg label-light-default label-inline"style="'+approve+'">'+t.STATUS+'</span>'+
                '<a onclick="viewCommitment(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Commitment"><i class="fa-solid fa-scroll text-dark"></i></a>'+
                '<a onclick="chatbox(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="fa fa-comment" style="' + iconClass + '" title="Chat"></i></a>'+
                '<a onclick="log(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="far fa-file-alt text-dark" title="Logs"></i></a>';
              }
            }else if (isAuditor){
              if (t.STATUS == 'OPEN'){
                console.log('d');
                return '<span class="label font-weight-bold label-lg label-light-default label-inline"style="'+approve+'">'+t.STATUS+'</span>'+
                '<a onclick="chatbox(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="fa fa-comment" style="' + iconClass + '" title="Chat"></i></a>'+
                '<a onclick="log(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="far fa-file-alt text-dark" title="Logs"></i></a>';
              }else if(t.STATUS == 'Commitment' && t.APPROVAL_COMMITMENT == 1 && isPICAuditor == sessionUserId){
                console.log('e');
                return '<span class="label font-weight-bold label-lg label-light-default label-inline"style="'+approve+'">'+t.STATUS+'</span>'+
                '<a onclick="approve(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="Approve Commitment"><i class="fa fa-file-circle-check text-dark"></i></a>'+
                '<a onclick="viewCommitment(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Commitment"><i class="fa-solid fa-scroll text-dark"></i></a>'+
                '<a onclick="chatbox(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="fa fa-comment" style="' + iconClass + '" title="Chat"></i></a>'+
                '<a onclick="log(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="far fa-file-alt text-dark" title="Logs"></i></a>';
              }else if(t.STATUS == 'Tindak Lanjut' && t.APPROVAL_COMMITMENT == 3 && t.APPROVAL_TINDAKLANJUT == 1 && isPICAuditor == sessionUserId){
                return '<span class="label font-weight-bold label-lg label-light-default label-inline"style="'+approve+'">'+t.STATUS+'</span>'+
                '<a onclick="approveTL(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="Approve Tindak Lanjut"><i class="fa fa-file-circle-check text-dark"></i></a>'+
                '<a onclick="viewTL(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Tindak Lanjut"><i class="fa-solid fa-file-alt text-dark"></i></a>'+
                '<a onclick="viewCommitment(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Commitment"><i class="fa-solid fa-scroll text-dark"></i></a>'+
                '<a onclick="chatbox(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="fa fa-comment" style="' + iconClass + '" title="Chat"></i></a>'+
                '<a onclick="log(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="far fa-file-alt text-dark" title="Logs"></i></a>'; 
              }else if(t.STATUS == 'CLOSE' && t.APPROVAL_COMMITMENT == 3 && t.APPROVAL_TINDAKLANJUT == 3 && isPICAuditor == sessionUserId){
                return 'aswd'+
                '<a onclick="viewTL(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Tindak Lanjut"><i class="fa-solid fa-file-alt text-dark"></i></a>'+
                '<a onclick="viewCommitment(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Commitment"><i class="fa-solid fa-scroll text-dark"></i></a>'+
                '<a onclick="chatbox(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="fa fa-comment" style="' + iconClass + '" title="Chat"></i></a>'+
                '<a href="<?= base_url() ?>aia/temuan/export_pdf/'+t.ID_TEMUAN+'" class="btn btn-sm btn-clean btn-icon" title="Print LKHA"><i class="fa-solid fa-file-pdf text-dark"></i></a>'+
                '<a onclick="log(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="far fa-file-alt text-dark" title="Logs"></i></a>'; 
              }else if(t.STATUS == 'Tindak Lanjut' && t.APPROVAL_COMMITMENT == 3 && t.APPROVAL_TINDAKLANJUT !== 1){
              return '<span class="label font-weight-bold label-lg label-light-default label-inline"style="'+approve+'">'+t.STATUS+'</span>'+
              '<a onclick="viewTL(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Tindak Lanjut"><i class="fa-solid fa-file-alt text-dark"></i></a>'+
              '<a onclick="viewCommitment(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Commitment"><i class="fa-solid fa-scroll text-dark"></i></a>'+
              '<a onclick="chatbox(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="fa fa-comment" style="' + iconClass + '" title="Chat"></i></a>'+
              '<a href="<?= base_url() ?>aia/temuan/export_pdf/'+t.ID_TEMUAN+'" class="btn btn-sm btn-clean btn-icon" title="Print LKHA"><i class="fa-solid fa-file-pdf text-dark"></i></a>'+
              '<a onclick="log(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="far fa-file-alt text-dark" title="Logs"></i></a>';
              }else{
                console.log('f');
                return '<span class="label font-weight-bold label-lg label-light-default label-inline"style="'+approve+'">'+t.STATUS+'</span>'+
                '<a onclick="viewCommitment(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Commitment"><i class="fa-solid fa-scroll text-dark"></i></a>'+
                '<a onclick="chatbox(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="fa fa-comment" style="' + iconClass + '" title="Chat"></i></a>'+
                '<a onclick="log(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="far fa-file-alt text-dark" title="Logs"></i></a>';
              }
            }else if(is_atasan_auditee){
              if (t.STATUS == 'OPEN'){
                console.log('g');
                return '<span class="label font-weight-bold label-lg label-light-default label-inline"style="'+approve+'">'+t.STATUS+'</span>'+
                '<a onclick="chatbox(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="fa fa-comment" style="' + iconClass + '" title="Chat"></i></a>'+
                '<a onclick="log(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="far fa-file-alt text-dark" title="Logs"></i></a>';
              }else if(t.STATUS == 'Commitment' && t.APPROVAL_COMMITMENT == 0){
                console.log('h');
                return '<span class="label font-weight-bold label-lg label-light-default label-inline"style="'+approve+'">'+t.STATUS+'</span>'+
                '<a onclick="approve(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="Approve Commitment"><i class="fa fa-file-circle-check text-dark"></i></a>'+
                '<a onclick="viewCommitment(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Commitment"><i class="fa-solid fa-scroll text-dark"></i></a>'+
                '<a onclick="chatbox(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="fa fa-comment" style="' + iconClass + '" title="Chat"></i></a>'+
                '<a onclick="log(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="far fa-file-alt text-dark" title="Logs"></i></a>';
              }else if(t.STATUS == 'Tindak Lanjut' && t.APPROVAL_COMMITMENT == 3 && t.APPROVAL_TINDAKLANJUT == 0){
              return '<span class="label font-weight-bold label-lg label-light-default label-inline"style="'+approve+'">'+t.STATUS+'</span>'+
              '<a onclick="approveTL(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="Approve Tindak Lanjut"><i class="fa fa-file-circle-check text-dark"></i></a>'+
              '<a onclick="viewTL(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Tindak Lanjut"><i class="fa-solid fa-file-alt text-dark"></i></a>'+
              '<a onclick="viewCommitment(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Commitment"><i class="fa-solid fa-scroll text-dark"></i></a>'+
              '<a onclick="chatbox(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="fa fa-comment" style="' + iconClass + '" title="Chat"></i></a>'+
              '<a href="<?= base_url() ?>aia/temuan/export_pdf/'+t.ID_TEMUAN+'" class="btn btn-sm btn-clean btn-icon" title="Print LKHA"><i class="fa-solid fa-file-pdf text-dark"></i></a>'+
              '<a onclick="log(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="far fa-file-alt text-dark" title="Logs"></i></a>';
              }else if(t.STATUS == 'CLOSE' && t.APPROVAL_COMMITMENT == 3 && t.APPROVAL_TINDAKLANJUT == 3){
              return ''+
              '<a onclick="viewTL(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Tindak Lanjut"><i class="fa-solid fa-file-alt text-dark"></i></a>'+
              '<a onclick="viewCommitment(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Commitment"><i class="fa-solid fa-scroll text-dark"></i></a>'+
              '<a onclick="chatbox(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="fa fa-comment" style="' + iconClass + '" title="Chat"></i></a>'+
              '<a href="<?= base_url() ?>aia/temuan/export_pdf/'+t.ID_TEMUAN+'" class="btn btn-sm btn-clean btn-icon" title="Print LKHA"><i class="fa-solid fa-file-pdf text-dark"></i></a>'+
              '<a onclick="log(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="far fa-file-alt text-dark" title="Logs"></i></a>';
              }else if(t.STATUS == 'Tindak Lanjut' && t.APPROVAL_COMMITMENT == 3 && t.APPROVAL_TINDAKLANJUT !== 0){
              return '<span class="label font-weight-bold label-lg label-light-default label-inline"style="'+approve+'">'+t.STATUS+'</span>'+
              '<a onclick="viewTL(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Tindak Lanjut"><i class="fa-solid fa-file-alt text-dark"></i></a>'+
              '<a onclick="viewCommitment(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Commitment"><i class="fa-solid fa-scroll text-dark"></i></a>'+
              '<a onclick="chatbox(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="fa fa-comment" style="' + iconClass + '" title="Chat"></i></a>'+
              '<a href="<?= base_url() ?>aia/temuan/export_pdf/'+t.ID_TEMUAN+'" class="btn btn-sm btn-clean btn-icon" title="Print LKHA"><i class="fa-solid fa-file-pdf text-dark"></i></a>'+
              '<a onclick="log(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="far fa-file-alt text-dark" title="Logs"></i></a>';
              }else{
                console.log('i');
                return '<span class="label font-weight-bold label-lg label-light-default label-inline"style="'+approve+'">'+t.STATUS+'</span>'+
                '<a onclick="viewCommitment(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Commitment"><i class="fa-solid fa-scroll text-dark"></i></a>'+
                '<a onclick="chatbox(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="fa fa-comment" style="' + iconClass + '" title="Chat"></i></a>'+
                '<a onclick="log(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="far fa-file-alt text-dark" title="Logs"></i></a>';
              }
            }else if(isAuditee){
              if (t.STATUS == 'OPEN'){
                console.log('j');
                return '<span class="label font-weight-bold label-lg label-light-default label-inline"style="'+approve+'">'+t.STATUS+'</span>'+
              '<a onclick="entryCommitment(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="Entry Commitment"><i class="fa fa-file-import text-dark"></i></a>'+
              '<a onclick="chatbox(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="fa fa-comment" style="' + iconClass + '" title="Chat"></i></a>'+
              '<a onclick="log(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="far fa-file-alt text-dark" title="Logs"></i></a>';
                }else if(t.STATUS == 'Commitment Approved' && t.APPROVAL_COMMITMENT == 3){
              return '<span class="label font-weight-bold label-lg label-light-default label-inline"style="'+approve+'">'+t.STATUS+'</span>'+
              '<a onclick="entryTL(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="Tindak Lanjut"><i class="fa fa-file-pen text-dark"></i></a>'+
              '<a onclick="viewCommitment(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Commitment"><i class="fa-solid fa-scroll text-dark"></i></a>'+
              '<a onclick="chatbox(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="fa fa-comment" style="' + iconClass + '" title="Chat"></i></a>'+
              '<a href="<?= base_url() ?>aia/temuan/export_pdf/'+t.ID_TEMUAN+'" class="btn btn-sm btn-clean btn-icon" title="Print LKHA"><i class="fa-solid fa-file-pdf text-dark"></i></a>'+
              '<a onclick="log(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="far fa-file-alt text-dark" title="Logs"></i></a>';
              }else if(t.STATUS == 'Tindak Lanjut' && t.APPROVAL_COMMITMENT == 3){
              return '<span class="label font-weight-bold label-lg label-light-default label-inline"style="'+approve+'">'+t.STATUS+'</span>'+
              '<a onclick="viewTL(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Tindak Lanjut"><i class="fa-solid fa-file-alt text-dark"></i></a>'+
              '<a onclick="viewCommitment(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Commitment"><i class="fa-solid fa-scroll text-dark"></i></a>'+
              '<a onclick="chatbox(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="fa fa-comment" style="' + iconClass + '" title="Chat"></i></a>'+
              '<a href="<?= base_url() ?>aia/temuan/export_pdf/'+t.ID_TEMUAN+'" class="btn btn-sm btn-clean btn-icon" title="Print LKHA"><i class="fa-solid fa-file-pdf text-dark"></i></a>'+
              '<a onclick="log(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="far fa-file-alt text-dark" title="Logs"></i></a>';
              }else if(t.STATUS == 'CLOSE' && t.APPROVAL_COMMITMENT == 3 && t.APPROVAL_TINDAKLANJUT == 3){
                return ''+
              '<a onclick="viewTL(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Tindak Lanjut"><i class="fa-solid fa-file-alt text-dark"></i></a>'+
              '<a onclick="viewCommitment(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Commitment"><i class="fa-solid fa-scroll text-dark"></i></a>'+
              '<a onclick="chatbox(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="fa fa-comment" style="' + iconClass + '" title="Chat"></i></a>'+
              '<a href="<?= base_url() ?>aia/temuan/export_pdf/'+t.ID_TEMUAN+'" class="btn btn-sm btn-clean btn-icon" title="Print LKHA"><i class="fa-solid fa-file-pdf text-dark"></i></a>'+
              '<a onclick="log(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="far fa-file-alt text-dark" title="Logs"></i></a>';
              }
              else{
              return '<span class="label font-weight-bold label-lg label-light-default label-inline"style="'+approve+'">'+t.STATUS+'</span>'+
              '<a onclick="viewCommitment(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon" title="View Commitment"><i class="fa-solid fa-scroll text-dark"></i></a>'+
              '<a onclick="chatbox(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="fa fa-comment" style="' + iconClass + '" title="Chat"></i></a>'+
              '<a onclick="log(' + t.ID_TEMUAN + ')" class="btn btn-sm btn-clean btn-icon"><i class="far fa-file-alt text-dark" title="Logs"></i></a>';
              }
            }
            }
            
          }
        }]
    }), $("#kt_datatable_search_status").on("change", (function() {
      t.search($(this).val().toLowerCase(), "NAMA_DIVISI")
    })), $("#kt_datatable_search_status").selectpicker()
  }
};

  function entryCommitment(id_tl)
  {
    var currentID_TL = id_tl;
    $.get(`<?= base_url('aia/Temuan/getCommitment/') ?>`+id_tl, function(data, status){
        const obj = JSON.parse(data);
        $('#ID_TEMUAN').val(id_tl);
        $('#INVESTIGASI').val(obj.INVESTIGASI);
        $('#PERBAIKAN').val(obj.PERBAIKAN);
        $('#KOREKTIF').val(obj.KOREKTIF);
        $('#TANGGAL').val(obj.TANGGAL);
    });
    $('#modal_commitment').modal('show');
  }

  function viewCommitment(id_tl) {
    var currentID_TL = id_tl;
      $.get(`<?= base_url('aia/Temuan/getCommitment/') ?>` + id_tl, function(data, status) {
        const obj = JSON.parse(data);
        $('#ID_TEMUAN').val(id_tl);
        $('#VIEWINVESTIGASI').val(obj.INVESTIGASI);
        $('#VIEWPERBAIKAN').val(obj.PERBAIKAN);
        $('#VIEWKOREKTIF').val(obj.KOREKTIF);
        $('#VIEWTANGGAL').val(obj.TANGGAL);
      });
      $('#modal_viewCommitment').modal('show'); 
  }

  function entryTL(id_tl)
  {
    var currentID_TL;
    currentID_TL = id_tl;
    console.log(currentID_TL);
    $.get(`<?= base_url('aia/Temuan/getFileEntry/') ?>`+id_tl, function(data, status){
        const obj = JSON.parse(data);
        $('#ID_TEMUAN_ENTRY').val(id_tl);
        $('#KETERANGAN_TL').val(obj.KETERANGAN_TL);

        if (obj.FILE && obj.FILE !== 'null') {
          $('#FILE').attr('href', obj.FILE).show();
          $('#FILE_TL').show();
          $('#btnDelete').show();
          $('#btnSubmitTL').show();

        } else {
          $('#FILE').hide();
          $('#btnDelete').hide();
          

        }
        // console.log(data.NOMOR_LHA);
    });
    $('#modal_TL').modal('show');
  }

  function viewTL(id_tl) {
    var currentID_TL = id_tl;
      $.get(`<?= base_url('aia/Temuan/getFileEntry/') ?>` + id_tl, function(data, status) {
        const obj = JSON.parse(data);
        $('#ID_TEMUAN_ENTRY').val(id_tl);
        $('#KETERANGAN_TL').val(obj.KETERANGAN_TL);
        $('#btnSubmitTL').hide();
        $('#FILE_TL').hide();
        $('#btnDelete').hide();

      });
      $('#modal_TL').modal('show'); 
  }

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
            entryCommitment(currentID_TL);
          },
          error: function(data){
            Swal.fire("Gagal menyimpan data!", "Pastika semua kolom terisi!", "error");
          }
        });
      }
    })
  }

function chatbox(id_tl) {
    $.post('<?= base_url('aia/temuan/updateStatus/') ?>'+id_tl, function(response) {
        
    });
    $.get(`<?= base_url('aia/temuan/getdatadetail/') ?>` + id_tl, function(data, status) {
        const obj = JSON.parse(data);
        console.log(obj);
        $('#ID_TEMUAN_CHATBOX').val(id_tl);
        $('#KOMENTAR_AUDITOR').val(obj.KOMENTAR_AUDITOR);
        $('#KOMENTAR_AUDITEE').val(obj.KOMENTAR_AUDITEE);
    });
    $('#modal_chat').modal('show');
}

// $('#log_form').submit(function(event) {
//     event.preventDefault(); // Prevent the default form submission
//     var id_tl = $('#ID_TEMUAN_CHATBOX').val();
//     $.post('<?= base_url('aia/temuan/updateStatus/') ?>' + id_tl, function(response) {
//     });
// });

  function approve(id_tl){
    console.log(id_tl);
    $('#ID_TEMUAN_APPROVAL1').val(id_tl);
    $.get(`<?= base_url('aia/Temuan/getCommitment/') ?>` + id_tl, function(data, status) {
        const obj = JSON.parse(data);
        $('#ID_TEMUAN').val(id_tl);
        $('#APINVESTIGASI').val(obj.INVESTIGASI);
        $('#APPERBAIKAN').val(obj.PERBAIKAN);
        $('#APKOREKTIF').val(obj.KOREKTIF);
        $('#APTANGGAL').val(obj.TANGGAL);
      });
    $('#modal_approve').modal('show');
  }
  function approveTL(id_tl){
    console.log(id_tl);
    $('#ID_TEMUAN_APPROVALTL').val(id_tl);
    $('#modal_approveTL').modal('show');
  }
  function entry_tl(id_tl)
  {
    currentID_TL = id_tl;
    $.get(`<?= base_url('aia/temuan/getFileEntry/') ?>`+id_tl, function(data, status){
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
    $('#modal_entry_tl').modal('show');
  }

  function log(id_tl) 
  {
      var currentID_TL = id_tl;
    console.log(currentID_TL);
    $.get(`<?= base_url('aia/Temuan/getLog/') ?>` + id_tl, function(data, status) {
        const obj = JSON.parse(data);
        console.log(obj);
        $('#ID_TARGET').val(id_tl);
        
        // Clear previous log entries
        $('#LOG_KIRIM').empty();
        
        // Append new log entries
        obj.forEach(log => {
            $('#LOG_KIRIM').append(`<p>${log.LOG_KIRIM} [ ${log.formatted_timestamp} ]</p>`);
        });
    });
    $('#logModal').modal('show');
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

  $('#modal_TL').on('hidden.bs.modal', function() {
    $("#kt_datatable").KTDatatable().reload();
  });
});
</script>
