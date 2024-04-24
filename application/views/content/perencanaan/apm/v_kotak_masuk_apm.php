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
        <span class="text-muted font-weight-bold mr-4">Perencanaan</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Kotak Masuk</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">APM</span>
      </div>
    </div>
  </div>
  <div class="d-flex flex-column-fluid">
    <div class="container">
      <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
          <div class="card-title">
            <h3 class="card-label">List Audit ISO
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
                      <label class="mr-3 mb-0 d-none d-md-block">Status:</label>
                      <select class="form-control" id="kt_datatable_search_status">
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
          <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
        </div>
      </div>
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
        source: '<?= base_url() ?>perencanaan/apm/jsonKotakKeluarApm',
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
        field: "NAMA_AUDIT",
        title: "Nama Audit"
      }, {
        field: "PERIODE_AUDIT",
        title: "Periode Audit"
      }, {
        field: "STATUS",
        title: "Status",
        template: function(t) {
					if (t.ID_STATUS == 3) {
						if(t.APPROVER_COUNT == t.APPROVED_COUNT){
              t.STATUS = 'Send';
              t.CSS = 'success';
              return '<span  style="border-radius:0" class="label font-weight-bold label-lg label-light-' + t.CSS + ' label-inline">' + t.STATUS + '</span>'; 
            }else{
              return '<span  style="border-radius:0" class="label font-weight-bold label-lg label-light-' + t.CSS + ' label-inline">' + t.STATUS + ' ('+ t.APPROVED_COUNT + ' / ' + t.APPROVER_COUNT + ')</span>';    
            }
					}
          return '<span class="label font-weight-bold label-lg label-light-' + t.CSS + ' label-inline">' + t.STATUS + "</span>";
        }
      },{
        field: "ID_APM",
        title: "Action",
        class: "text-center",
        sortable: !1,
        searchable: !1,
        overflow: "visible",
        template: function(t) {
          var aksi, teks, fa;
          if (t.STATUS == 1) {
            aksi  = "nonaktif";
            teks  = "Non-Aktifkan";
            fa    = "user-alt-slash";
          }else{
            aksi  = "aktif";
            teks  = "Aktifkan";
            fa    = "check-circle";
          }
					if (t.STATUS_APPROVER == 1) {
						return '<a href="<?= base_url() ?>perencanaan/apm/review/'+t.ID_APM+'?review=true&sts-approver='+t.STATUS_APPROVER+'" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="fa fa-edit text-dark"></i></a>';
					} else if (t.STATUS_APPROVER == 2) {
            return '<a href="<?= base_url() ?>perencanaan/apm/review/'+t.ID_APM+'?review=true&sts-approver='+t.STATUS_APPROVER+'" class="btn btn-sm btn-clean btn-icon" title="View"><i class="fa fa-eye text-dark"></i></a>';
          } else if (t.APPROVER_COUNT == t.APPROVED_COUNT) {
            return '<a href="<?= base_url() ?>perencanaan/apm/review/'+t.ID_APM+'?review=true&sts-approver='+t.STATUS_APPROVER+'" class="btn btn-sm btn-clean btn-icon" title="View"><i class="fa fa-eye text-dark"></i></a>';
					}else {
						return '';
					}
        }
      }]
    }), $("#kt_datatable_search_status").on("change", (function() {
      t.search($(this).val().toLowerCase(), "STATUS")
    })), $("#kt_datatable_search_status").selectpicker()
  }
};
jQuery(document).ready((function() {
  KTDatatableJsonRemoteDemo.init()
}));
</script>
