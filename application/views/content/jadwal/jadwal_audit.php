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
        <span class="text-muted font-weight-bold mr-4">List Jadwal Audit ISO</span>
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
            <a href="<?= base_url() ?>aia/jadwal/create" class="btn btn-primary font-weight-bolder">
              <i class="fa fa-plus" style="font-size: 12px;"></i>&nbsp;&nbsp;&nbsp;&nbsp;Tambah Jadwal</a>
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
          source: '<?= base_url() ?>aia/Jadwal/jsonJadwalList',
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
          title: "CABANG/DIVISI"
        },
        {
          field: "WAKTU_AUDIT_AWAL",
          title: "Waktu Mulai",
           
        },
        {
          field: "WAKTU_AUDIT_SELESAI",
          title: "Waktu Selesai",
           
        },
          {
          field: "NAMA_AUDITOR",
          title: "Auditor"
        },
        {
          field: "NAMA_LEAD_AUDITOR",
          title: "Lead Auditor"
        },
        {
          field: "Action",
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
            if (t.ID_STATUS == 1 || t.ID_STATUS == 4) {			
              return 0;
            }else {
              return (
                      '<a onclick="save(' + t.ID_JADWAL + ')" class="btn btn-sm btn-clean btn-icon" title="Sinkronisasi"><i class="fa fa-refresh text-dark"></i></a>'+
                      
                      '<a href="<?= base_url() ?>aia/Jadwal/update/'+t.ID_JADWAL+'" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="fa fa-edit text-dark"></i></a>'+
                      '<a onclick="hapus(' + t.ID_JADWAL + ')" class="btn btn-sm btn-clean btn-icon" title="Hapus"><i class="fa fa-trash text-dark"></i></a>');
            }
          },
          
          
          
        },
        
        
        
          
      ]
      }), $("#datatable_search_status").on("change", (function() {
        t.search($(this).val().toLowerCase(), "STATUS")
      })), $("#datatable_search_status").selectpicker();
      t.on('datatable-on-init', function() {
      t.gotoPage(1); // Set default to page 1
      $("#kt_datatable").KTDatatable().reload();
    });
    }
    
  };
  jQuery(document).ready((function() {
    KTDatatableJsonRemoteDemo.init()
  }));

  function save(id) {
    Swal.fire({
      text: 'Apakah Anda yakin sinkronisasi data ini ?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        // Redirect user to the desired URL
        window.location.href = '<?= base_url() ?>aia/Response_auditee/generate/' + id;
      }
    });
}
  function hapus(id) {
    Swal.fire({
      text: 'Apakah Anda yakin menghapus jadwal ini ?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '<?= base_url() ?>aia/Jadwal/hapus/' + id,
          type: 'post',
          data: { id: id },
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(data) {
            window.location = data; 
          },
          error: function(data) {
            // console.log(data)
            Swal.fire("Gagal menghapus jadwal!", "Terjadi kesalahan, silakan coba lagi.", "error");
          }
        });
      }
    });
  }
  
</script>
<script>
  
</script>

