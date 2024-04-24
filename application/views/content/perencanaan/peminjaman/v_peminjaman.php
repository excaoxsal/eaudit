<style type="text/css">
  #datatable_paginate{

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
        <span class="text-muted font-weight-bold mr-4">Perencanaan</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Kotak Keluar</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Peminjaman</span>
      </div>
    </div>
  </div>
  <div class="d-flex flex-column-fluid">
    <div class="container">
      <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
          <div class="card-title">
            <h3 class="card-label"><?= $title ?></h3>
          </div>
          <div class="card-toolbar">
            <a href="<?= base_url() ?>perencanaan/peminjaman/create" class="btn btn-primary font-weight-bolder">
            <i class="fa fa-plus" style="font-size: 12px;"></i>&nbsp;&nbsp;&nbsp;&nbsp;Create Form</a>
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
                      <input type="text" class="form-control" placeholder="Search..." id="datatable_search_query" />
                      <span>
                        <i class="fa fa-search"></i>
                      </span>
                    </div>
                  </div>
                  <div class="col-md-4 my-2 my-md-0">
                    <div class="d-flex align-items-center">
                      <label class="mr-3 mb-0 d-none d-md-block">Status:</label>
											<select class="form-control" id="datatable_search_status">
                        <option value="">All</option>
                        <?php foreach($list_status as $status){ ?>
                        <option value="<?= $status['STATUS'] ?>"><?= $status['STATUS'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="datatable datatable-bordered datatable-head-custom" id="datatable"></div>        
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modal_upload" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload Lampiran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
              <form class="form" id="form" method="post" enctype="multipart/form-data"> 
            <div class="modal-body"  style="height: auto">

              <div class="form-group row">
                <div class="col-12">
                  <label>Lampiran</label>
                  <input type="file" class="form-control" name="LAMPIRAN" id="LAMPIRAN">
                  <input type="hidden" class="form-control" name="id_peminjaman" id="id_peminjaman">
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
  init: function() {
    var t;
    t = $("#datatable").KTDatatable({
      data: {
        type: "remote",
        source: "<?= base_url('perencanaan/peminjaman/peminjaman_json') ?>",
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
        title: "Kepada"
      }, {
        field: "NAMA",
        title: "Ketua Tim"
      }, {
        field: "TANGGAL",
        title: "Tanggal"
      }, {
        field: "FILE_TTD",
        title: "File Tanda Tangan",
        template: function(t) {
          if (t.FILE_TTD == '' || t.FILE_TTD == null) {   
            return 'File tidak ditemukan.'; 
          }else{
            return '<a download href="<?= base_url() ?>storage/peminjaman/'+t.FILE_TTD+'">Download File.</a>'; 
          }
        }
      }, {
        field: "ID_PEMINJAMAN",
        title: "<center>Action</center>",
        sortable: !1,
        searchable: !1,
        overflow: "visible",
        template: function(t) {
          // return '<center><a download href="<?= base_url() ?>perencanaan/peminjaman/cetak_preview/'+t.ID_PEMINJAMAN+'" class="btn btn-sm btn-clean btn-icon" title="Download"><i class="fa fa-download"></i></a><a href="<?= base_url() ?>perencanaan/peminjaman/create/'+t.ID_PEMINJAMAN+'" class="btn btn-sm btn-clean btn-icon" title="Upload File TTD"><i class="fa fa-edit"></i></a></center>'
          return '<center><a download href="<?= base_url() ?>perencanaan/peminjaman/cetak_preview/'+t.ID_PEMINJAMAN+'" class="btn btn-sm btn-clean text-dark btn-icon" title="Download"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg></a><a onclick="modal_ttd('+t.ID_PEMINJAMAN+')" data-toggle="modal" data-target="#modal_upload" class="btn btn-sm btn-clean text-dark btn-icon" title="Upload File TTD"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-upload-cloud"><polyline points="16 16 12 12 8 16"></polyline><line x1="12" y1="12" x2="12" y2="21"></line><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"></path><polyline points="16 16 12 12 8 16"></polyline></svg></a></center>'
        }
      }]
    }), $("#datatable_search_status").on("change", (function() {
      t.search($(this).val().toLowerCase(), "STATUS")
    })), $("#datatable_search_status").selectpicker()
  }
};
jQuery(document).ready((function() {
  KTDatatableJsonRemoteDemo.init()
}));

function modal_ttd(id){
  $('#id_peminjaman').val(id);
  $('#form').attr("action", '<?= base_url() ?>perencanaan/peminjaman/upload_lampiran/'+id);
}
</script>
