<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <div class="d-flex align-items-center flex-wrap mr-2">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Master</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Jabatan</span>
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
                <div class="card-title collapsed" id="accordion-title" data-toggle="collapse" data-target="#collapseOne3" aria-expanded="false">Add Jabatan</div>
              </div>
              <form class="form" id="form" method="post">
              <input type="hidden" name="ID" id="ID">
              <div id="collapseOne3" class="collapse" data-parent="#accordionExample3" style="">
                <div class="card-body">
                  <div class="form-group row">
                    <label class="col-form-label col-3 text-right">Jabatan <sup class="text-danger">*</sup></label>
                    <div class="col-9">
                      <div class="form-label">
                        <input type="text" class="form-control" placeholder="Jabatan" id="jabatan" name="jabatan" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-form-label col-3 text-right">Atasan</label>
                    <div class="col-9">
                      <div class="form-label">
                        <select class="form-control" id="id_atasan" name="id_atasan">
                          <option value="">--Pilih ATASAN--</option>
                          <?php foreach($list_atasan as $atasan){ ?>
                          <option value="<?= $atasan['ID_JABATAN'] ?>"><?= $atasan['NAMA_JABATAN'] ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-form-label col-3 text-right">Divisi <sup class="text-danger">*</sup></label>
                    <div class="col-9">
                      <div class="form-label">
                        <select class="form-control" id="id_divisi" name="id_divisi" required>
                          <option value="">--Pilih Divisi--</option>
                          <?php foreach($list_divisi as $divisi){ ?>
                          <option value="<?= $divisi['ID_DIVISI'] ?>"><?= $divisi['NAMA_DIVISI'] ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
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
    $('#id_divisi, #datatable_search_divisi').select2().on('change', function (e) {
      $(this).valid();
    } );
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
            prosesDataMaster("<?= base_url('aia/master/jabatan/post') ?>").then( function(data){
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
        title: 'Hapus Jabatan ini?',
        icon: 'warning',
        showCancelButton: true
    }).then((result) => {
        if (result.isConfirmed) {
            prosesDataMaster(`<?= base_url() ?>aia/master/jabatan/hapus?id=${id}`).then( function(data){
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
    fetch(`<?= base_url() ?>aia/master/jabatan/jabatan_json?id=${id}`, {method:'POST'})
        .then(response => response.json())
        .then(data => {
            $('#jabatan').val(data[0]['NAMA_JABATAN']);
            $('#ID').val(btoa(data[0]['ID_JABATAN']));
            $('#id_atasan').val(data[0]['ID_ATASAN']).trigger('change');
            $('#id_divisi').val(data[0]['ID_DIVISI']).trigger('change');

            $('#accordion-title').html('Update Jabatan');
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
    $('#id_divisi, #datatable_search_divisi').trigger('change');
    $('#datatable').KTDatatable('reload');
    $('#collapseOne3').removeClass('show');
    $('#headingOne3 .card-title').addClass('collapsed');
    $('#accordion-title').html('Add Jabatan');
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
        source: '<?= base_url() ?>aia/master/jabatan/jabatan_json',
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
        field: "NAMA_JABATAN",
        title: "Jabatan"
      },{
        field: "NAMA_ATASAN",
        title: "Atasan"
      }, {
        field: "NAMA_DIVISI",
        title: "Divisi"
      }, {
        field: "ID_JABATAN",
        class: "text-center",
        title: "Actions",
        sortable: !1,
        searchable: !1,
        overflow: "visible",
        template: function(t) {
          return '<a href="javascript:;" onclick="update(\'' + btoa(t.ID_JABATAN) + '\')" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="fa fa-edit text-dark"></i></a><a href="javascript:;" onclick="hapus(\'' + btoa(t.ID_JABATAN) + '\')" class="btn btn-sm btn-clean btn-icon" title="Delete"><i class="fa fa-trash text-dark"></i></a>'
        }
      }]
    }), $("#datatable_search_divisi").on("change", (function() {
      t.search($(this).val().toLowerCase(), "NAMA_DIVISI")
    })), $("#datatable_search_type").selectpicker()
  }
};
jQuery(document).ready((function() {
  KTDatatableJsonRemoteDemo.init()
}));
</script>