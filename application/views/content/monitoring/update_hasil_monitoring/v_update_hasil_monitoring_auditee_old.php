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
        <span class="text-muted font-weight-bold mr-4">Monitoring</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Update Hasil Monitoring</span>
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
              <div class="col">
                <div class="row align-items-center">
                  <div class="col-md-3 my-2 my-md-0">
                    <div class="input-icon">
                      <input type="text" class="form-control" placeholder="Search..." id="datatable_search_query" />
                      <span>
                        <i class="fa fa-search"></i>
                      </span>
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

<script type="text/javascript">
  "use strict";
  var KTDatatableJsonRemoteDemo = {
    init: function() {
      var t;
      t = $("#datatable").KTDatatable({
        data: {
          type: "remote",
          source: '<?= base_url() ?>monitoring/update_hasil_monitoring/list_rekomendasi_json',
          pageSize: 10
        },
        layout: {
          scroll: !1,
          footer: !1
        },
        sortable: !1,
        pagination: !0,
        search: {
          input: $("#datatable_search_query"),
          key: "generalSearch"
        },
        columns: [{
          field: "NO_URUT",
          title: "No Temuan",
          width: "20px"
        }, {
          field: "JUDUL_TEMUAN",
          title: "Judul Temuan"
        }, {
          field: "REKOMENDASI",
          title: "Rekomendasi"
        }, {
          field: "BATAS_WAKTU",
          title: "Batas Waktu"
        }, {
          field: "TK_PENYELESAIAN",
            title: "Status",
            width: 60,
            template: (t) => {
              const status = (e) => {
                switch (e) {
                  case 'STL':
                    return 'label-light-info'
                  case 'BTL':
                    return 'label-light-warning'
                  case 'TPTD':
                    return 'label-light-danger'
                  default:
                    return 'label-light-success'
                }
              }
              if (t.TK_PENYELESAIAN) {
                return '<span class="label font-weight-bold label-lg ' + status(t.TK_PENYELESAIAN) + ' label-inline">' + t.TK_PENYELESAIAN + '</span>'
              } else {
                return '-'
              }
            }
        }, {
          field: "ID",
          title: "Action",
          class: "text-center",
          sortable: !1,
          searchable: !1,
          overflow: "visible",
          template: function(t) {
            return `<a href="<?= base_url() ?>monitoring/update_hasil_monitoring/hasil_monitoring/${t.ID_TL}/${t.ID_REKOMENDASI}" class="btn btn-sm btn-clean btn-icon" title="Update Hasil Monitoring"><i class="text-dark fa fa-file-import"></i></a>`
          }
        }]
      });

      $("#datatable_search_jenis_audit, #datatable_search_auditee, #datatable_search_tahun, datatable_search_start_periode, datatable_search_end_periode").selectpicker();
    }

  };
  jQuery(document).ready((function() {
    KTDatatableJsonRemoteDemo.init()
  }));

</script>