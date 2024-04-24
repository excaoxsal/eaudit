<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <div class="d-flex align-items-center flex-wrap mr-2">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Monitoring</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Tindak Lanjut LHA</span>
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
            <a href="<?= base_url() ?>monitoring/update_hasil_monitoring" class="btn btn-light-danger font-weight-bolder">
              Kembali</a>
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
          <div class="form-group row">
            <label class="col-form-label col-2 text-right">Nomor SPA</label>
            <div class="col-10">
              <input type="text" class="form-control form-control-solid" placeholder="[autocomplete] [nomor_spa]" name="" value="<?= $detail_lha[0][NOMOR_SPA] ?>" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-2 text-right">Jenis Audit</label>
            <div class="col-10">
              <input type="text" class="form-control form-control-solid" placeholder="[autocomplete] [auditee]" name="" value="<?= $detail_lha[0][JENIS_AUDIT] ?>" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-2 text-right">Auditee</label>
            <div class="col-10">
              <input type="text" class="form-control form-control-solid" placeholder="[autocomplete] [auditee]" name="" value="<?= $detail_lha[0][NAMA_DIVISI] ?>" readonly>
            </div>
          </div>
          <!-- <div class="form-group row">
                <label class="col-form-label col-2 text-right">Jenis Audit</label>
                <div class="col-10">
                  <input type="text" class="form-control form-control-solid" placeholder="[autocomplete] [jenis_audit]" name="" value="<?= $detail_lha[0][JENIS_AUDIT] ?>" readonly>
                </div>
              </div> -->
          <div class="form-group row">
            <label class="col-form-label col-2 text-right">Tahun Audit</label>
            <div class="col-10">
              <input type="text" class="form-control form-control-solid" placeholder="[autocomplete] [tahun_audit]" name="" value="<?= $detail_lha[0][TAHUN] ?>" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-2 text-right">Periode Audit</label>
            <div class="col-3">
              <input class="form-control form-control-solid" disabled type="date" value="<?= $detail_lha[0][TGL_PERIODE_MULAI] ?>" name="TGL_PERIODE_MULAI">
            </div>
            <p>s/d</p>
            <div class="col-3">
              <input class="form-control form-control-solid" disabled type="date" value="<?= $detail_lha[0][TGL_PERIODE_SELESAI] ?>" name="TGL_PERIODE_SELESAI">
            </div>
          </div>
          <!-- <div class="form-group row">
                <label class="col-form-label col-2 text-right">Tahun Tindak Lanjut</label>
                <div class="col-10">
                  <input type="text" class="form-control form-control-solid" placeholder="[autocomplete] [tahun_audit +1]" name="" value="<?= $detail_lha[0][TAHUN_AUDIT] + 1 ?>" readonly>
                </div>
              </div> -->
          <div class="separator separator-dashed mb-5"></div>
          <div class="form-group row">
            <label class="col-form-label col-2 text-right">Temuan</label>
            <div class="col-10">
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
                      <div class="col-md-6 my-2 my-md-0">
                        <button class="btn btn-light-success font-weight-bold" type="button" id="kt_datatable_reload">Reload Data</button>
                      </div>
                      <!-- Modal-->
                      <!-- end:modal -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
            </div>
          </div>

          <div class="separator separator-dashed mb-5"></div>
          <div class="form-group row">
            <label class="col-form-label col-2 text-right"></label>
            <!-- <div class="col-10">
                  <button type="submit" class="btn btn-warning font-weight-bold">Preview</button>
                  <?php
                  $status = array(2, 3);
                  if (!in_array($detail_lha[0][STATUS_TL], $status)) {
                  ?>
                  <button type="submit" class="btn btn-primary font-weight-bold">Simpan</button>
                  <button type="submit" class="btn btn-success font-weight-bold">Kirim</button>
                  <?php } ?>
                </div> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detil Temuan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <div class="modal-body" id="read_more">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
            source: '<?= base_url() ?>monitoring/entry/temuan_json/<?= $detail_lha[0][ID_TL] ?>',
            pageSize: 10
          },
          layout: {
            scroll: !1,
            footer: !1
          },

          detail: {
            title: "Load sub table",
            content: tableDetail,
          },

          sortable: !0,
          pagination: !0,
          search: {
            input: $("#kt_datatable_search_query"),
            key: "generalSearch"
          },
          columns: [{
            field: "ID",
            title: "",
            sortable: !1,
            searchable: !1,
            width: 30,
            textAlign: "center",
          }, {
            field: "NO_URUT",
            title: "No",
            width: 30,
          }, {
            field: "JUDUL_TEMUAN",
            title: "Judul Temuan"
          }, {
            field: "TEMUAN2",
            title: "Temuan",
            template: function(t) {
              var data  = t.TEMUAN2;
              var text  = $(data).text();
              var len   = text.length;
              var limit = 50;
              if(len>limit)
                return `<span style='display:none;'>`+data+`</span>`+text.substr(0,limit)+`<a href="javascript:void(0)" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="read_more(this)">...Selengkapnya</a>`;
              else
                return data;
            }
          }]
        }), $("#kt_datatable_search_status").on("change", (function() {
          t.search($(this).val().toLowerCase(), "IS_CABANG")
        })), $("#kt_datatable_search_status").selectpicker(),
        $('#kt_datatable_reload').on('click', function() {
          $('#kt_datatable').KTDatatable('reload');
        });
    }
  };
  function read_more(data)
  {
    $('#read_more').html($(data).prev().html());
  }

  const tableDetail = (e) => {
    $("<div/>")
      .attr("id", "child_data_ajax_" + e.data.ID)
      .appendTo(e.detailCell)
      .KTDatatable({
        data: {
          type: "remote",
          source: `<?= base_url() ?>monitoring/entry/rekomendasi_json_/${e.data.ID}`,
          pageSize: 10
        },
        // layout definition
        layout: {
          scroll: false,
          footer: false,

          // enable/disable datatable spinner.
          spinner: {
            type: 1,
            theme: "default",
          },
        },

        sortable: true,

        search: {
          input: $("#kt_datatable_search_query2"),
          key: "generalSearch"
        },

        // columns definition
        columns: [{
            field: "REKOMENDASI2",
            title: "Rekomendasi",
          }, {
            field: "BATAS_WAKTU",
            title: "Batas Waktu",
            template: (t) => {
              return `${dateFormat(t.BATAS_WAKTU)}`
            }
          }, {
            field: "pic",
            title: "PIC",
            template: (t) => {
              return `<ol style="padding-left: 1em;">${t.pic}</ol>`;
            }
          },
          {
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
          },
          {
            field: "ID",
            title: "Action",
            class: "text-center",
            sortable: !1,
            searchable: !1,
            overflow: "visible",
            width: 70,
            template: function(t) {
              return `<a href="<?= base_url() ?>monitoring/update_hasil_monitoring/hasil_monitoring/<?= $detail_lha[0][ID_TL] ?>/${t.ID}" class="btn btn-sm btn-clean btn-icon" title="Update hasil monitoring"><i class="fa fa-file-import text-dark"></i></a>`
            }
          }
        ]
      });
  }

  jQuery(document).ready((function() {
    KTDatatableJsonRemoteDemo.init();
  }));
  $(document).ready(function() {});
</script>