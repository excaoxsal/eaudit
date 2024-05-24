<style type="text/css">
  #datatable_paginate {

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
        <span class="text-muted font-weight-bold mr-4">Master Pertanyaan</span>
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
            <a class="btn btn-primary font-weight-bolder" onclick="uploadFile(' + t.ID_TL + ')">
              <i class="fa fa-plus" style="font-size: 12px;"></i>&nbsp;&nbsp;&nbsp;&nbsp;Tambah Data</a>
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
                        <?php foreach ($list_status as $status) { ?>
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
<!-- Modal-->
<div class="modal fade" id="modal_upload" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Master ISO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <form class="form" id="kt_form" method="post" action="<?= base_url() ?>aia/iso/proses_upload" enctype="multipart/form-data">
        <div class="modal-body" style="height: auto">

          <div class="form-group row">
            <div class="col-12">
              <label>Nomor ISO</label>
              
              <input type="text" class="form-control" placeholder="Nomor ISO" name="NOMOR_ISO" id="NOMOR_ISO">
              <input type="hidden" class="form-control" placeholder="Nomor LHA" name="id_tl" id="id_tl">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
              <label>Lampiran</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="file_excel" id="file_excel">
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
  "use strict";
  var KTDatatableJsonRemoteDemo = {
    init: function() {
      var t;
      t = $("#datatable").KTDatatable({
        data: {
          type: "remote",
          source: '<?= base_url() ?>aia/iso/jsonPertanyaanList/<?=$id_iso?>',
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
        columns: [
          {
          field: "NOMOR_ISO",
          title: "NOMOR ISO"
        },
        {
          field: "LV1",
          title: "LV1"
        },
        {
          field: "LV2",
          title: "LV2"
        },
        {
          field: "LV3",
          title: "LV3"
        },
        {
          field: "LV4",
          title: "LV4"
        },
        {
          field: "AUDITEE",
          title: "AUDITEE"
        },
        {
          field: "PERTANYAAN",
          title: "PERTANYAAN"
        },
        


        
        // {
        //   field: "NOMOR_SPA_SEQ",
        //   title: "ID"
        // }, {
        //   field: "NAMA_DIVISI",
        //   title: "Auditee"
        // }, {
        //   field: "NOMOR_SURAT",
        //   title: "Nomor Surat"
        // }, {
        //   field: "STATUS",
        //   title: "Status",
        //   template: function(t) {
        //     if (t.ID_STATUS == 3) {
        //       if(t.APPROVER_COUNT == t.APPROVED_COUNT){
        //         t.STATUS = 'Send';
        //         t.CSS = 'success';
        //         return '<span  style="border-radius:0" class="label font-weight-bold label-lg label-light-' + t.CSS + ' label-inline">' + t.STATUS + ' </span>';						
        //       }else{
        //         return '<span  style="border-radius:0" class="label font-weight-bold label-lg label-light-' + t.CSS + ' label-inline">' + t.STATUS + ' (' + t.APPROVED_COUNT + ' / ' + t.APPROVER_COUNT + ')</span>';
        //       }
        //     }
        //     return '<span class="label font-weight-bold label-lg label-light-' + t.CSS + ' label-inline">' + t.STATUS + '</span>';
        //   }
        // }, 
        
        
        {
          field: "ID_TL",
          title: "Action",
          class: "text-center",
          sortable: !1,
          searchable: !1,
          overflow: "visible",
          template: function(t) {
            return '<a onclick="uploadFile(' + t.ID_TL + ')" class="btn btn-sm btn-clean btn-icon"><i class="text-dark fa fa-upload"></i></a>'
            // return '<a href="<?= base_url() ?>monitoring/entry/tindak_lanjut/' + t.ID_TL + '" class="btn btn-sm btn-clean btn-icon" title="Tindak Lanjut"><i class="text-dark fa fa-file-import"></i></a><a onclick="hapus(' + t.ID_TL + ')" class="btn btn-sm btn-clean btn-icon" title="Hapus"><i class="text-dark fa fa-trash"></i></a><a onclick="preview(' + t.TAHUN + ',' + t.ID_DIVISI + ', ' + t.ID_JENIS_AUDIT + ')" class="btn btn-sm btn-clean btn-icon" title="Preview"><i class="text-dark fa fa-eye"></i></a><a onclick="lha_final(' + t.ID_TL + ')" class="btn btn-sm btn-clean btn-icon" title="LHA Final"><i class="text-dark fa fa-file-word"></i></a>'
            // return '<center><a href="<?= base_url() ?>perencanaan/kotak_masuk/spa/review/'+t.ID_SPA+'" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="fa fa-edit"></i></a></center>'
          }
        }
          
      ]
      }), $("#datatable_search_status").on("change", (function() {
        t.search($(this).val().toLowerCase(), "STATUS")
      })), $("#datatable_search_status").selectpicker()
    }
  };

  function uploadFile(id_tl)
  {
    $.get(`<?= base_url('aia/iso/proses_upload') ?>`+id_tl, function(data, status){
        const obj = JSON.parse(data);
        $('#id_tl').val(id_tl);
        $('#NOMOR_LHA').val(obj.NOMOR_LHA);
        $('#TANGGAL_LHA').val(obj.TANGGAL_LHA);
        // console.log(data.NOMOR_LHA);
    });
    $('#modal_upload').modal('show');
  }
  jQuery(document).ready((function() {
    KTDatatableJsonRemoteDemo.init()
  }));
</script>