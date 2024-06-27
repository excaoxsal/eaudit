<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <div class="d-flex align-items-center flex-wrap mr-2">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Master</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Divisi / Subdivisi</span>
      </div>
    </div>
  </div>
  <div class="d-flex flex-column-fluid">
    <div class="container">
      <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
          <div class="card-title">
            <h3 class="card-label"><?= $title ?> / Subdivisi</h3>
          </div>
        </div>
        <div class="card-body">

          <div class="accordion accordion-solid accordion-toggle-plus mb-10" id="accordionExample3">
            <div class="card">
              <div class="card-header" id="headingOne3">
                <div class="card-title collapsed" id="accordion-title" data-toggle="collapse" data-target="#collapseOne3" aria-expanded="false">Add Divisi / Subdivisi</div>
              </div>
              <form class="form" id="form" method="post">
              <input type="hidden" name="ID" id="ID">
              <div id="collapseOne3" class="collapse" data-parent="#accordionExample3" style="">
                <div class="card-body">
                  <div class="form-group row">
                    <label class="col-form-label col-3 text-right">Is Divisi? <sup class="text-danger">*</sup></label>
                    <div class="col-9">
                      <div class="form-label">
                        <select class="form-control" id="is_divisi" name="is_divisi" onchange="hiddenFieldText()" required>
                          <option value="">--Pilih--</option>
                          <?php foreach($is_divisi as $is_divisix){ ?>
                              <option value=<?=$is_divisix['IS_DIVISI']?>><?php if ($is_divisix['IS_DIVISI'] == 'Y'){ 
                                echo "Divisi"; } else { echo "Sub Divisi"; } ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div id="divisi" class="form-group row" style="display:none">
                    <label class="col-form-label col-3 text-right">Divisi <sup class="text-danger">*</sup></label>
                    <div class="col-9" style="margin-bottom: 1.75rem;">
                      <div class="form-label">
                        <input type="text" class="form-control" placeholder="Divisi" id="divisi1" name="divisi1" required>
                      </div>
                    </div>
                    <label class="col-form-label col-3 text-right">Kode Divisi <sup class="text-danger">*</sup></label>
                    <div class="col-9" style="margin-bottom: 1.75rem;">
                      <div class="form-label">
                        <input type="text" class="form-control" placeholder="Kode Divisi" id="kode_divisi" name="kode_divisi" required>
                      </div>
                    </div>
                  </div>
                  <div id= "subdiv" class="form-group row" style="display:none">
                    <label class="col-form-label col-3 text-right">Sub Divisi <sup class="text-danger">*</sup></label>
                    <div class="col-9" style="margin-bottom: 1.75rem;">
                      <div class="form-label">
                        <input type="text" class="form-control" placeholder="Sub Divisi" id="sub_divisi" name="sub_divisi" required>
                      </div>
                    </div>
                    <label class="col-form-label col-3 text-right">Kode Sub Divisi <sup class="text-danger">*</sup></label>
                    <div class="col-9" style="margin-bottom: 1.75rem;">
                      <div class="form-label">
                        <input type="text" class="form-control" placeholder="Kode Sub Divisi" id="kode_sub_divisi" name="kode_sub_divisi" required>
                      </div>
                    </div>
                    <label class="col-form-label col-3 text-right">Divisi <sup class="text-danger">*</sup></label>
                    <div class="col-9">
                      <div class="form-label">
                        <select class="form-control" id="id_divisi" name="id_divisi" required>
                          <option value="">--Pilih Divisi--</option>
                          <?php foreach($list_divisi as $divisi){ ?>
                          <option value="<?= $divisi['KODE'] ?>"><?= $divisi['NAMA_DIVISI'] ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-form-label col-3 text-right">Is Cabang? <sup class="text-danger">*</sup></label>
                    <div class="col-9">
                      <span class="switch">
                        <label>
                          <input type="checkbox" checked="checked" id="is_cabang" name="is_cabang">
                          <span></span>
                        </label>
                      </span>
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
                  <div class="col-md-4 my-2 my-md-0">
                    <div class="d-flex align-items-center">
                      <label class="mr-3 mb-0 d-none d-md-block">Lokasi:</label>
                      <select class="form-control" id="datatable_search_status">
                        <option value="">All</option>
                        <option value="Y">Cabang</option>
                        <option value="N">Pusat</option>
                      </select>
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
            prosesDataMaster("<?= base_url('aia/master/divisi/post') ?>").then( function(data){
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

  function hiddenFieldText() {
    var checkBox = document.getElementById("is_divisi").value;
    var divisi = document.getElementById("divisi");
    var subdiv = document.getElementById("subdiv");
    if (checkBox == "Y" && checkBox !== null){
      divisi.style.display = "flex";
      subdiv.style.display = "none";
    } else if (checkBox == "N" && checkBox !== null){
      subdiv.style.display = "flex";
      divisi.style.display = "none";
    } else {
      divisi.style.display = "none";
      subdiv.style.display = "none";
    }
    console.log(checkBox)
  }

  function hapus(id) {
    Toast.fire({
        title: 'Hapus Divisi ini?',
        icon: 'warning',
        showCancelButton: true
    }).then((result) => {
        if (result.isConfirmed) {
            prosesDataMaster(`<?= base_url() ?>aia/master/divisi/hapus?id=${id}`).then( function(data){
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
    $('#form')[0].reset();
    $('input').val('');
    fetch(`<?= base_url() ?>aia/master/divisi/divisi_json?id=${id}`, {method:'POST'})
        .then(response => response.json())
        .then(data => {
            if(data[0]['IS_CABANG'] == 'N')
              $('#is_cabang').prop('checked', false);
            else
              $('#is_cabang').prop('checked', true);

            if(data[0]['IS_DIVISI'] == 'N') {
              $('#divisi').css('display', 'none');
              $('#subdiv').css('display', 'flex');
              $('#is_divisi').val(data[0]['IS_DIVISI']);
              $('#sub_divisi').val(data[0]['nama_sub_divisi']);
              $('#id_divisi').val(data[0]['KODE_PARENT']).trigger('change');
              $('#kode_sub_divisi').val(data[0]['KODE']);
            }
            else{
              $('#subdiv').css('display', 'none');
              $('#divisi').css('display', 'flex');
              $('#is_divisi').val(data[0]['IS_DIVISI']);
              $('#divisi1').val(data[0]['nama_divisi']);
              $('#kode_divisi').val(data[0]['KODE']);
            }
            
            $('#ID').val(btoa(data[0]['ID_DIVISI']));
            $('#accordion-title').html('Update Divisi');
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
    $('#accordion-title').html('Add Divisi');
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
        source: '<?= base_url() ?>aia/master/divisi/divisi_json',
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
        field: "nama_divisi",
        title: "Divisi"
      },{
        field: "nama_sub_divisi",
        title: "SUB DIVISI"
      }, {
        field: "IS_CABANG",
        title: "Lokasi",
        template: function(t) {
          var a = {
            'N': {
              title: "Pusat",
              class: " label-primary"
            },
            'Y': {
              title: "Cabang",
              class: " label-secondary"
            }
          };
          return '<span class="label font-weight-bold label-lg' + a[t.IS_CABANG].class + ' label-inline">' + a[t.IS_CABANG].title + "</span>"
        }
      }, {
        field: "ID_DIVISI",
        title: "Actions",
        class: "text-center",
        sortable: !1,
        searchable: !1,
        overflow: "visible",
        template: function(t) {
          return '<a href="javascript:;" onclick="update(\'' + btoa(t.ID_DIVISI) + '\')" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="fa fa-edit text-dark"></i></a><a href="javascript:;" onclick="hapus(\'' + btoa(t.ID_DIVISI) + '\')" class="btn btn-sm btn-clean btn-icon" title="Delete"><i class="fa fa-trash text-dark"></i></a>'
        }
      }]
    }), $("#datatable_search_status").on("change", (function() {
      t.search($(this).val().toLowerCase(), "IS_CABANG")
    })), $("#datatable_search_status").selectpicker()
  }
};
jQuery(document).ready((function() {
  KTDatatableJsonRemoteDemo.init()
}));
</script>