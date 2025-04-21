<!-- filepath: c:\laragon\www\eaudit\application\views\content\aia\v_response_auditee_detail_grid.php -->
<style type="text/css">
  #kt_datatable_grid_paginate {
    position: absolute;
    right: 10px;
  }
  /*#kt_datatable_grid {
    overflow-x: auto; 
    overflow-y: auto; 
    max-height: 500px;  
  }*/
</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <div class="d-flex align-items-center flex-wrap mr-2">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Detail Respon Auditee</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4"><?= $detail['0']['NOMOR_ISO'] ?></span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4"><?= $detail['0']['KODE'] ?></span>
      </div>
    </div>
  </div>
  <div class="d-flex flex-column-fluid">
    <div class="container">
      <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
          <div class="card-title">
            <h3 class="card-label">List Respon Auditee (Grid View)</h3>
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
            <div class="alert alert-success alert-dismissible" style="width: 100%;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h6><i class="icon fa fa-check text-white"></i> Success!</h6>
              <?= $this->session->flashdata('success'); ?>
            </div>
          <?php } ?>
          <div class="mb-7">
            <div class="row align-items-center">
              <div class="col-lg-9 col-xl-8">
                <div class="row align-items-center">
                  <div class="col-md-4 my-2 my-md-0">
                    <div class="input-icon">
                      <input type="text" class="form-control" placeholder="Search..." id="kt_datatable_grid_search_query" />
                      <span>
                        <i class="fa fa-search"></i>
                      </span>
                    </div>
                  </div>
                  <div class="col-md-4 my-2 my-md-0">
                    <div class="d-flex align-items-center">
                      <label class="mr-3 mb-0 d-none d-md-block">Klausul:</label>
                      <select class="form-control" id="kt_datatable_grid_search_status">
                        <option value="">All</option>
                        <?php foreach ($list_divisi as $status) { ?>
                          <option value="<?= $status['NAMA_DIVISI'] ?>"><?= $status['NAMA_DIVISI'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
            <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable_grid" style="width:1200px;"></div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  "use strict";
  var KTDatatableGrid = {
    init: function () {
      var t;
      t = $("#kt_datatable_grid").KTDatatable({
        data: {
          type: "remote",
          source: '<?= base_url() ?>aia/Response_auditee/jsonResponAuditeeDetail/<?= $kode ?>',
          pageSize: 10
        },
        layout: {
            scroll: true,
            scrollY: 200,
            height: 500,  
            footer: false
        },
        sortable: true,
        pagination: true,
        search: {
          input: $("#kt_datatable_grid_search_query"),
          key: "generalSearch"
        },
        rows: {
          autoHide: false,
        },
        columns: [
          {
            field: "number",
            title: "No.",
            width: 50,
            template: function (row, index) {
              var currentPage = t.getCurrentPage();
              var pageSize = t.getPageSize();
              return (currentPage - 1) * pageSize + (index + 1);
            }
          },
          {
            field: "PERTANYAAN",
            title: "PERTANYAAN",
            width: 300,
            template: function (row) {
              return `<span>${row.PERTANYAAN}</span>`;
            }
          },
          {
            field: "KODE_KLAUSUL",
            title: "KODE KLAUSUL",
            width: 200,
            template: function (row) {
              return `<span>${row.KODE_KLAUSUL}</span>`;
            }
          },
          {
            field: "RESPONSE_AUDITEE",
            title: "RESPONSE AUDITEE",
            width: 300,
            template: function (row) {
              return `<input type="text" class="form-control response-auditee-input" data-id="${row.ID_RE}" value="${row.RESPONSE_AUDITEE ? row.RESPONSE_AUDITEE : ''}" />`;
            }
          },
          {
            field: "KOMENTAR_1",
            title: "KOMENTAR AUDITOR",
            width: 300,
            template: function (row) {
              return `<input type="text" class="form-control response-auditee-input" data-id="${row.ID_RE}" value="${row.KOMENTAR_1 ? row.KOMENTAR_1 : ''}" />`;
            }
          },
          {
            field: "KOMENTAR_2",
            title: "KOMENTAR AUDITEE",
            width: 300,
            template: function (row) {
              return `<input type="text" class="form-control response-auditee-input" data-id="${row.ID_RE}" value="${row.KOMENTAR_2 ? row.KOMENTAR_2 : ''}" />`;
            }
          },
          {
            field: "FILE",
            title: "FILE",
            width: 200,
            template: function (row) {
              return `
                <input type="file" class="file-upload-input" data-id="${row.ID_RE}" />
                <a href="${row.FILE ? row.FILE : '#'}" target="_blank" class="btn btn-sm btn-primary mt-2" ${row.FILE ? '' : 'style="display:none"'}>Download</a>
              `;
            }
          },
          <?php if ($is_auditor) { ?>
          {
            field: "STATUS",
            title: "Status",
            width: 150,
            template: function (row) {
              return `
                <select class="form-control status-select" data-id="${row.ID_RE}">
                  <option value="" ${row.STATUS == null || row.STATUS === "" ? "selected" : ""}>-- Pilih Status --</option>
                  <option value="1" ${row.STATUS == 1 ? "selected" : ""}>TIDAK DIISI SAMA SEKALI</option>
                  <option value="2" ${row.STATUS == 2 ? "selected" : ""}>JAWABAN TIDAK SESUAI</option>
                  <option value="3" ${row.STATUS == 3 ? "selected" : ""}>JAWABAN BENAR, LAMPIRAN SALAH</option>
                  <option value="4" ${row.STATUS == 4 ? "selected" : ""}>JAWABAN DAN LAMPIRAN SESUAI</option>
                </select>
              `;
            }
          },
          {
            field: "KLASIFIKASI",
            title: "Klasifikasi",
            width: 150,
            template: function (row) {
              return `
                <select class="form-control" name="KLASIFIKASI" data-id="${row.ID_RE}" >
                  <option value="" ${row.KLASIFIKASI == null || row.KLASIFIKASI === "" ? "selected" : ""}>-- Pilih Klasifikasi --</option>
                  <option value="MAJOR" <?= $row['KLASIFIKASI'] == 'MAJOR' ? 'selected' : '' ?>>MAJOR</option>
                  <option value="MINOR" <?= $row['KLASIFIKASI'] == 'MINOR' ? 'selected' : '' ?>>MINOR</option>
                  <option value="OBSERVASI" <?= $row['KLASIFIKASI'] == 'OBSERVASI' ? 'selected' : '' ?>>OBSERVASI</option>
              </select>
              `;
            }
          }
          <?php } ?>
        ]
      });
      
      // Event listener for input changes
      $(document).on("change", ".klausul-input, .pertanyaan-input, .status-select", function () {
        var id = $(this).data("id");
        var field = $(this).hasClass("klausul-input")
          ? "KODE_KLAUSUL"
          : $(this).hasClass("pertanyaan-input")
          ? "PERTANYAAN"
          : "STATUS";
        var value = $(this).val();

        // Auto-save via AJAX
        $.ajax({
          url: "<?= base_url('aia/Response_auditee/updateField') ?>",
          type: "POST",
          data: {
            id: id,
            field: field,
            value: value
          },
          success: function (response) {
            console.log("Field updated successfully:", response);
          },
          error: function (xhr, status, error) {
            console.error("Error updating field:", error);
          }
        });
      });
    }
  };
</script>