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
        <span class="text-muted font-weight-bold mr-4">Berita Acara</span>
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
            <?php if($is_auditor){ ?>
            <a href="<?= base_url('monitoring/berita_acara/create') ?>" class="btn btn-primary font-weight-bolder">
              <i class="fa fa-plus" style="font-size: 12px;"></i>&nbsp;&nbsp;&nbsp;&nbsp;Buat Berita Acara</a>
              <?php } ?>
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
                  <?php if($is_auditor){ ?>
                  <div class="col-md-6 my-2 my-md-0">
                    <div class="d-flex align-items-center">
                      <label class="mr-3 mb-0 d-none d-md-block">Auditee:</label>
                      <select class="form-control select-dua" id="datatable_search_auditee" name="AUDITEE" required>
                        <option value="">--Pilih--</option>
                        <?php foreach ($list_divisi as $data) { ?>
                          <option value="<?= $data['ID_DIVISI'] ?>"><?= $data['NAMA_DIVISI'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                <?php } ?>
                  <div class="col-md-3 my-2 my-md-0">
                    <div class="d-flex align-items-center">
                      <label class="mr-3 mb-0 d-none d-md-block">Tahun Audit:</label>
                      <div class="input-icon input-icon-right mb-2">
                        <input autocomplete="off" placeholder="Tahun" type="text" class="form-control datepicker-year" id="datatable_search_tahun" name="ID_TAHUN" placeholder="Tahun">
                        <span>
                          <i class="fa fa-calendar"></i>
                        </span>
                      </div>  
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
        <h5 class="modal-title" id="exampleModalLabel">Update File BA TTD</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <form class="form" id="kt_form" method="post" action="<?= base_url() ?>monitoring/berita_acara/upload_lampiran" enctype="multipart/form-data">
        <div class="modal-body" style="height: auto">

          <!-- <div class="form-group row">
            <div class="col-12">
              <label>Nomor LHA</label>
              <input type="text" class="form-control" placeholder="Nomor LHA" name="NOMOR_LHA" id="NOMOR_LHA">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
              <label>Tanggal</label>
              <div class="form-label">
                <div class="input-icon input-icon-right mb-2">
                  <input autocomplete="off" placeholder="Tanggal" type="text" name="TANGGAL_LHA" id="TANGGAL_LHA" required class="form-control datepicker w-100">
                  <span>
                    <i class="fa fa-calendar"></i>
                  </span>
                </div>
              </div>
            </div>
          </div> -->
          <input type="hidden" class="form-control" placeholder="Nomor LHA" name="id_ba" id="id_ba">
          <div class="form-group row">
            <div class="col-12">
              <label>File BA TTD</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="LAMPIRAN" id="LAMPIRAN" />
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
          source: '<?= base_url() ?>monitoring/berita_acara/ba_json',
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
          field: "NOMOR",
          title: "Nomor"
        }, {
          field: "NAMA_DIVISI",
          title: "Auditee"
        }, {
          field: "NAMA_JABATAN",
          title: "PIC"
		}, {
          field: "TAHUN_AUDIT",
          title: "Tahun Audit"
        }, {
          field: "FILE_TTD",
          title: "File Berita Acara",
		  template: function(t) {
            if (t.FILE_TTD == '' || t.FILE_TTD == null) {
              return 'File tidak ditemukan.';
            } else {
              return '<a href="<?= base_url() ?>storage/berita_acara/' + t.FILE_TTD + '" download>Download File BA.</a>';
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
            <?php if($is_auditor){ ?>
            return '<a href="<?= base_url() ?>monitoring/berita_acara/create?id=' + btoa(t.ID) + '" class="btn btn-sm btn-clean btn-icon" title="Edit data"><i class="text-dark fa fa-edit"></i></a><a onclick="hapus(' + t.ID + ')" class="btn btn-sm btn-clean btn-icon" title="Hapus"><i class="text-dark fa fa-trash"></i></a><a onclick="preview(' + t.ID + ')" class="btn btn-sm btn-clean btn-icon" title="Preview"><i class="text-dark fa fa-eye"></i></a><a onclick="uploadFile(' + t.ID + ')" class="btn btn-sm btn-clean btn-icon"><i class="text-dark fa fa-upload"></i></a>'
            <?php }else{ ?>
            return '<a onclick="preview(' + t.ID + ')" class="btn btn-sm btn-clean btn-icon" title="Preview"><i class="text-dark fa fa-eye"></i></a>'
            <?php } ?>
          }
        }]
      });

      $("#datatable_search_auditee").on("change", function() {
        t.search($(this).val().toLowerCase(), "AUDITEE");
      });

      $("#datatable_search_tahun").on("change", function() {
        t.search($(this).val().toLowerCase(), "TAHUN_AUDIT");
      });

      $("#datatable_search_auditee, #datatable_search_tahun").selectpicker();
    }
  };
  jQuery(document).ready((function() {
    KTDatatableJsonRemoteDemo.init()
  }));

  function hapus(id) {
    Swal.fire({
      text: 'Hapus Berita Acara ini ?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: "<?= base_url('monitoring/berita_acara/hapus') ?>",
          type: 'post',
          data: {id: btoa(id)},
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(data) {
            if (data == "OK")
            {
              let timerInterval
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Berita Acara telah dihapus.',
                showConfirmButton: false,
                timer: 1500,
                onBeforeOpen: () => {
                  timerInterval = setInterval(() => {
                    const content = Swal.getContent()
                    if (content) {
                      const b = content.querySelector('b')
                      if (b) {
                        b.textContent = Swal.getTimerLeft()
                      }
                    }
                  }, 100)
                },
                onClose: () => {
                  clearInterval(timerInterval)
                }
              }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                  location.reload(); 
                }
              })
            }
            else
              Swal.fire("Proses Gagal!", "Data tidak terhapus", "error")
          },
          error: function(data) {
            Swal.fire("Error!", "Server Error!", "error")
          }
        });
      }
    })
  }

  function preview(id) {
    window.open(`<?php echo base_url() ?>monitoring/berita_acara/cetak?id=${btoa(id)}`, '_blank');
  }

  function uploadFile(id_ba)
  {
    // $.get(`<?= base_url('monitoring/entry/getFileUpload/') ?>`+id_tl, function(data, status){
    //     const obj = JSON.parse(data);
    //     $('#id_tl').val(id_tl);
    //     $('#NOMOR_LHA').val(obj.NOMOR_LHA);
    //     $('#TANGGAL_LHA').val(obj.TANGGAL_LHA);
    // });
    $('#id_ba').val(id_ba);
    $('#modal_upload').modal('show');
  }
</script>