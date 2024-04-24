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
        <span class="text-muted font-weight-bold mr-4">Master</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Tanda Tangan</span>
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
            <h3 class="card-label"><?= $title ?></h3> 
          </div>
        </div>
        <div class="card-body">
          <!--begin::Search Form-->
          <div class="mb-7">
            <div class="row align-items-center">
              <div class="col-lg-9 col-xl-8">
                <div class="row align-items-center">
                  <div class="col-md-4 my-2 my-md-0">
                    <div class="input-icon">
                      <input type="text" class="form-control" placeholder="Search..." id="datatable_search_query" />
                      <span>
                        <i class="fa fa-search text-muted"></i>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--end::Search Form-->
          <!--begin: Datatable-->
          <div class="datatable datatable-bordered datatable-head-custom" id="datatable"></div>
          <!--end: Datatable-->
        </div>
      </div>
      <!--end::Card-->
    </div>
    <!--end::Container-->
  </div>
  <!--end::Entry-->
</div>
<!--end::Content-->

<script type="text/javascript">
 "use strict";
var KTDatatableJsonRemoteDemo = {
  init: function() {
    var t;
    t = $("#datatable").KTDatatable({
      data: {
        type: "remote",
        source: '<?= base_url() ?>master/tanda_tangan/user_json',
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
        field: "NIPP",
        title: "NIPP"
      }, {
        field: "NAMA",
        title: "Nama"
      }, {
        field: "NAMA_JABATAN",
        title: "Jabatan"
      }, {
        field: "NAMA_DIVISI",
        title: "Divisi"
      }, {
        field: "ID_USER",
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
          return '<a href="<?= base_url() ?>master/tanda_tangan/edit?id='+btoa(t.ID_USER)+'" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="fa fa-edit text-dark"></i></a>'
        }
      }]
    }), $("#datatable_search_status").on("change", (function() {
      t.search($(this).val().toLowerCase(), "STATUS")
    })), $("#datatable_search_type").on("change", (function() {
      t.search($(this).val().toLowerCase(), "NAMA_ROLE")
    })), $("#datatable_search_status, #datatable_search_type").selectpicker()
  }
};
jQuery(document).ready((function() {
  KTDatatableJsonRemoteDemo.init()
}));
</script>
