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
        <span class="text-muted font-weight-bold mr-4">Hasil Temuan</span>
      </div>
    </div>
  </div>
  <div class="d-flex flex-column-fluid">
    <div class="container">
      <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
          <div class="card-title">
            <h3 class="card-label">List Hasil Temuan
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
                      <label class="mr-3 mb-0 d-none d-md-block">Divisi:</label>
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
<!-- MODAL Upload temuan -->

<div class="modal fade" id="modal_upload" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Respon Auditee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <form class="form" id="kt_form" method="post" action="<?= base_url() ?>aia/Temuan/proses_upload<?=$kode?>" enctype="multipart/form-data">
        <div class="modal-body" style="height: auto">
          <input type="hidden"  name="ID_RE" id="ID_RE">
          
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

  
<script type="text/javascript">
 "use strict";
var KTDatatableJsonRemoteDemo = {
  init: function() {
    var t;
    t = $("#kt_datatable").KTDatatable({
      data: {
        type: "remote",
        source: '<?= base_url() ?>aia/Temuan/jsonResponAuditee',
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
        field: "NOMOR_ISO",
        title: "ISO"
      },{
        field: "NAMA_DIVISI",
        title: "DIVISI"
      }, {
        field: "WAKTU_AUDIT_AWAL",
        title: "Waktu Awal Audit",
        width: 100
      },{
        field: "WAKTU_AUDIT_SELESAI",
        title: "Waktu Akhir Audit",
        width: 100
      },{
        field: "AUDITOR",
        title: "Auditor"
      }, {
        field: "LEAD_AUDITOR",
        title: "Lead Auditor"
      },{
        field: "TOTAL",
        title: "Total",
        width: 50
      },
      {
          field: "ID_HEADER",
          title: "Action",
          class: "text-center",
          sortable: !1,
          searchable: !1,
          overflow: "visible",
          template: function(t) {
              var isAuditor = <?php echo json_encode($is_auditor); ?>;
              var isAuditee = <?php echo json_encode($is_auditee); ?>;

              if (isAuditor){
                return '<a  href="<?= base_url() ?>aia/temuan/detail/'+t.ID_HEADER+'" class="btn btn-sm btn-clean btn-icon" title="Lihat"><i class="fa fa-eye text-dark"></i></a><a onclick="uploadFile(' + t.ID_HEADER + ')" class="btn btn-sm btn-clean btn-icon" title="Upload Temuan"><i class="fa fa-upload text-dark"></i></a>'
              }else{
                return '<a  href="<?= base_url() ?>aia/temuan/detail/'+t.ID_HEADER+'" class="btn btn-sm btn-clean btn-icon" title="Lihat"><i class="fa fa-eye text-dark"></i></a>'
              }
            }
        }
        ]
    }), $("#kt_datatable_search_status").on("change", (function() {
      t.search($(this).val().toLowerCase(), "NAMA_DIVISI")
    })), $("#kt_datatable_search_status").selectpicker()
  }
};
jQuery(document).ready((function() {
  KTDatatableJsonRemoteDemo.init()
}));

var currentID_TL;
function uploadFile(id_tl)
{
  Swal.fire({
    text: 'Apakah Anda mengunggah file ulang dan menghapus data yang sudah ada ?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      currentID_TL = id_tl;
      $.get(`<?= base_url('aia/Response_auditee/getFileUpload/') ?>` + id_tl, function(data, status) {
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
  });
}
</script>
