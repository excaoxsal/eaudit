<style type="text/css">
  #kt_datatable_paginate{

    position: absolute;
    right: 10px;
  }
</style>
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <!--begin::Subheader-->
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <!--begin::Info-->
      <div class="d-flex align-items-center flex-wrap mr-2">
        <!--begin::Page Title-->
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
        <!--end::Page Title-->
        <!--begin::Actions-->
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Perencanaan</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Kotak Masuk</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Control Sheet</span>
        <!--end::Actions-->
      </div>
      <!--end::Info-->
    </div>
  </div>
  <!--end::Subheader-->
  <!--begin::Entry-->
  <div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
      <!--begin::Card-->
      <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
          <div class="card-title">
            <h3 class="card-label">Control Sheet
          </div>
          <div class="card-toolbar">
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
          <!--begin::Search Form-->
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
          <!--end::Search Form-->
          <!--begin: Datatable-->
         
          <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
          <!--end: Datatable-->
        </div>
      </div>
      <!--end: Datatable-->
    <!--end::Card-->
    </div>
    <!--end::Container-->
  </div>
  <!--end::Entry-->
</div>
<!--end::Content-->

<script src="<?= base_url() ?>assets/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
 "use strict";
var KTDatatableJsonRemoteDemo = {
  init: function() {
    var t;
    t = $("#kt_datatable").KTDatatable({
      data: {
        type: "remote",
        source: '<?= base_url() ?>perencanaan/kotak_masuk/control_sheet/control_sheet_json',
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
        field: "JUDUL",
        title: "Nama Audit"
      }, {
        field: "UPDATED_AT",
        title: "Last Update"
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
