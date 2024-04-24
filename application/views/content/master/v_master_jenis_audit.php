<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <div class="d-flex align-items-center flex-wrap mr-2">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Master</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Jenis Audit</span>
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

          <div class="accordion accordion-solid accordion-toggle-plus mb-10" id="accordionExample3">
            <div class="card">
              <div class="card-header" id="headingOne3">
                <div class="card-title collapsed" id="accordion-title" data-toggle="collapse" data-target="#collapseOne3" aria-expanded="false">Add Jenis Audit</div>
              </div>
              <form class="form" id="form" method="post">
              <input type="hidden" name="ID" id="ID">
              <div id="collapseOne3" class="collapse" data-parent="#accordionExample3" style="">
                <div class="card-body">
                  <div class="form-group row">
                    <label class="col-form-label col-3 text-right">Jenis Audit <sup class="text-danger">*</sup></label>
                    <div class="col-9">
                      <div class="form-label">
                        <input type="text" class="form-control" placeholder="Jenis Audit" id="jenis_audit" name="jenis_audit" required>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="separator separator-dashed mb-10"></div> -->
                  <div class="form-group row">
                    <label class="col-form-label col-3 text-right"></label>
                    <div class="col-9">
                      <button type="submit" id="save" class="btn btn-light-primary font-weight-bold">Simpan data</button>
                      <a href="javascript:;" class="btn btn-light-danger font-weight-bold" onclick="_reloadData()">Batal</a>
                    </div>
                  </div>
                </div>  
              </div>
              </form>
            </div>
          </div>
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
          <div class="datatable datatable-bordered datatable-head-custom" id="datatable"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {

    $("#form").validate({
      errorClass: 'text-danger is-invalid',
      invalidHandler: function(event, validator) {
        KTUtil.scrollTop();
      },
      submitHandler: function () {
        var id, title;
        id = $('#ID').val();
        if(id=='') title = 'Simpan data?';
        else title = 'Simpan perubahan?';
        Toast.fire({
          title: title,
          icon: 'question',
          showCancelButton: true
        }).then((result) => {
          if (result.isConfirmed) {
            prosesDataMaster("<?= base_url('master/jenis_audit/post') ?>").then( function(data){
              var obj = JSON.parse(data); 
              if(obj.status=='OK'){
                ToastTopRightTimer.fire({ icon: 'success', title: 'Proses Berhasil! '+obj.msg })
                _reloadData();
              }
            } )
          }
        })
      }
    });
  });

  function hapus(id) {
    Toast.fire({
        title: 'Hapus Jenis Audit ini?',
        icon: 'warning',
        showCancelButton: true
    }).then((result) => {
        if (result.isConfirmed) {
            prosesDataMaster(`<?= base_url() ?>master/jenis_audit/hapus?id=${id}`).then( function(data){
              var obj = JSON.parse(data); 
              if(obj.status=='OK'){
                ToastTopRightTimer.fire({ icon: 'success', title: 'Proses Berhasil! '+obj.msg })
                _reloadData();
              }
            } )
        }
    })
  }

  const update = (id) => {
    fetch(`<?= base_url() ?>master/jenis_audit/jenis_audit_json?id=${id}`, {method:'POST'})
        .then(response => response.json())
        .then(data => {
            $('#jenis_audit').val(data[0]['JENIS_AUDIT']);
            $('#ID').val(btoa(data[0]['ID_JENIS_AUDIT']));

            $('#accordion-title').html('Update Jenis Audit');
            $('#save').html('Simpan perubahan');
            $('#collapseOne3').collapse('show');
            KTUtil.scrollTop();
        })
        .catch(err => {
            Swal.fire('Proses Gagal!', '' , 'error')
        });
  }

  function _reloadData()
  {
    KTUtil.scrollTop();
    $('#form')[0].reset(); 
    $('input').val('');
    $('#datatable').KTDatatable('reload');
    $('#collapseOne3').removeClass('show');
    $('#headingOne3 .card-title').addClass('collapsed');
    $('#accordion-title').html('Add Jenis Audit');
    $('#save').html('Simpan data');
  }
</script>
<script type="text/javascript">
"use strict";
var KTDatatableJsonRemoteDemo = {
  init: function() {
    var t;
    t = $("#datatable").KTDatatable({
      data: {
        type: "remote",
        source: '<?= base_url() ?>master/jenis_audit/jenis_audit_json',
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
        field: "JENIS_AUDIT",
        title: "Jenis Audit"
      }, {
        field: "ID_JENIS_AUDIT",
        title: "Actions",
        class: "text-center",
        sortable: !1,
        searchable: !1,
        overflow: "visible",
        template: function(t) {
          return '<a href="javascript:;" onclick="update(\'' + btoa(t.ID_JENIS_AUDIT) + '\')" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="fa fa-edit text-dark"></i></a><a href="javascript:;" onclick="hapus(\'' + btoa(t.ID_JENIS_AUDIT) + '\')" class="btn btn-sm btn-clean btn-icon" title="Delete"><i class="fa fa-trash text-dark"></i></a>'
        }
      }]
    })
  }
};
jQuery(document).ready((function() {
  KTDatatableJsonRemoteDemo.init()
}));
</script>