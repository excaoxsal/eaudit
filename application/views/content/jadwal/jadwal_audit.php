<style type="text/css">
  #datatable_paginate {
    position: absolute;
    right: 10px;
  }

  #loadingScreen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7); /* Semi-transparent background */
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999; /* Make sure it's on top of other elements */
    color: white;
    font-size: 24px;
    font-weight: bold;
}

.loading-content {
    text-align: center;
    animation: fadeIn 1s ease-in-out infinite alternate;
}

@keyframes fadeIn {
    from {
        opacity: 0.5;
    }
    to {
        opacity: 1;
    }
}

.fa-spinner {
    font-size: 48px;
    margin-bottom: 10px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}
</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <div class="d-flex align-items-center flex-wrap mr-2">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Perencanaan</span>
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
          <!-- Dynamic Loading Screen -->
          <div id="loadingScreen" style="display: none;">
              <div class="loading-content">
                  <i class="fa fa-spinner fa-spin"></i> <span id="loadingText">Loading, please wait...</span>
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
                      '<a id="syncButton_' + t.ID_JADWAL + '" onclick="save(' + t.ID_JADWAL + ')" class="btn btn-sm btn-clean btn-icon" title="Sinkronisasi"><i class="fa fa-refresh text-dark"></i></a>'+
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
    });
    }  
  };
  jQuery(document).ready((function() {
    KTDatatableJsonRemoteDemo.init()
  }));

  // Global flag to track if a synchronization is in progress
  let isSyncInProgress = false;

  function save(id) {
    // Check if a synchronization process is already running
    if (isSyncInProgress) {
        Swal.fire({
            text: 'Sinkronisasi sedang berjalan. Harap tunggu hingga selesai.',
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
        return;
    }

    // Set the flag to indicate that a synchronization is in progress
    isSyncInProgress = true;

    // Show the confirmation dialog
    Swal.fire({
        text: 'Apakah Anda yakin sinkronisasi data ini?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Show the dynamic loading screen when the user confirms
            document.getElementById("loadingScreen").style.display = "flex";

            // Optionally update the loading text periodically
            let loadingText = document.getElementById("loadingText");
            let messages = [
                "Synchronizing data...",
                "Please be patient..."
            ];
            let index = 0;

            // Change the loading message every 2 seconds
            let interval = setInterval(() => {
                index = (index + 1) % messages.length;
                loadingText.textContent = messages[index];
            }, 3000);

            // Redirect to the synchronization URL
            window.location.href = '<?= base_url() ?>aia/Response_auditee/generate/' + id;

            // Clear the interval when the page is about to unload
            window.onbeforeunload = () => clearInterval(interval);
        } else {
            isSyncInProgress = false;
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

