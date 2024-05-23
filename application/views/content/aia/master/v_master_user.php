<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <div class="d-flex align-items-center flex-wrap mr-2">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Master</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">User</span>
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
                <div class="card-title collapsed" id="accordion-title" data-toggle="collapse" data-target="#collapseOne3" aria-expanded="false">Add User</div>
              </div>
              <form class="form" id="form" method="post">
                <input type="hidden" name="ID" id="ID">
                <div id="collapseOne3" class="collapse" data-parent="#accordionExample3" style="">
                <div class="card-body">
                  <div class="form-group row">
                    <label class="col-form-label col-3 text-right">NIPP <sup class="text-danger">*</sup></label>
                    <div class="col-9">
                      <div class="form-label">
                        <input type="text" class="form-control" id="nipp" placeholder="NIPP" name="nipp" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-form-label col-3 text-right">Nama <sup class="text-danger">*</sup></label>
                    <div class="col-9">
                      <div class="form-label">
                        <input type="text" class="form-control" id="NAMA" placeholder="Nama" name="nama" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-form-label col-3 text-right">Jabatan <sup class="text-danger">*</sup></label>
                    <div class="col-9">
                      <div class="form-label">
                        <select class="form-control" id="id_jabatan" name="id_jabatan" required>
                          <option value="">--Pilih Jabatan--</option>
                          <?php foreach($list_jabatan as $jabatan){ ?>
                          <option value="<?= $jabatan['ID_JABATAN'] ?>"><?= $jabatan['NAMA_JABATAN'] ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-form-label col-3 text-right">Email</label>

                    <div class="col-9">
                      <div class="form-label">
                        <div class="input-icon input-icon-right mb-2">
                          <input type="email" class="form-control" id="EMAIL" placeholder="Email" name="email">
                          <span>
                            <i class="fa fa-at text-muted"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-form-label col-3 text-right">Role <sup class="text-danger">*</sup></label>
                    <div class="col-9">
                      <div class="form-label">
                        <select class="form-control" id="id_role" name="id_role" required>
                          <option value="">--Pilih Role--</option>
                          <?php foreach($list_role as $role){ ?>
                          <option value="<?= $role['ID_ROLE'] ?>"><?= $role['NAMA_ROLE'] ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-form-label col-3 text-right">Menu <sup class="text-danger">*</sup></label>
                    <div class="col-9">
                      <div class="form-label">
                        <select class="form-control" id="id_menu" name="id_menu" required>
                          <option value="">--Pilih Menu--</option>
                          <?php foreach($list_menu as $menu){ ?>
                          <option value="<?= $menu['MENU'] ?>"><?php if ($menu['MENU'] == '1') { echo "AMS"; } else if ($menu['MENU'] == '2') { echo "AIA"; } else {echo "ALL";} ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-form-label col-3 text-right">Atasan I <sup class="text-danger">*</sup></label>
                    <div class="col-9">
                      <div class="form-label">
                        <select class="form-control" id="atasan_i" name="atasan_i" required>
                          <option value="">--Pilih Atasan--</option>
                          <?php foreach($list_user as $user){ ?>
                          <option value="<?= $user['ID_USER'] ?>"><?= $user['NAMA'] ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-form-label col-3 text-right">Atasan II</label>
                    <div class="col-9">
                      <div class="form-label">
                        <select class="form-control" id="atasan_ii" name="atasan_ii">
                          <option value="">--Pilih Atasan--</option>
                          <?php foreach($list_user as $user){ ?>
                          <option value="<?= $user['ID_USER'] ?>"><?= $user['NAMA'] ?></option>
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
            <div class="col-lg-12 col-xl-12">
              <div class="row align-items-center">
                <div class="col-md-3 my-2 my-md-0">
                  <div class="input-icon">
                    <input type="text" class="form-control" placeholder="Search..." id="datatable_search_query" />
                    <span>
                      <i class="fa fa-search text-muted"></i>
                    </span>
                  </div>
                </div>
                <div class="col-md-3 my-2 my-md-0">
                  <div class="d-flex align-items-center">
                    <label class="mr-3 mb-0 d-none d-md-block">Status:</label>
                    <select class="form-control" id="datatable_search_status">
                      <option value="">All</option>
                      <option value="1">Aktif</option>
                      <option value="2">Non-Aktif</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3 my-2 my-md-0">
                  <div class="d-flex align-items-center">
                    <label class="mr-3 mb-0 d-none d-md-block">Role:</label>
                    <select class="form-control" id="datatable_search_type">
                      <option value="">All</option>
                      <?php foreach($list_role as $role){ ?>
                      <option value="<?= $role['NAMA_ROLE'] ?>"><?= $role['NAMA_ROLE'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3 my-2 my-md-0">
                  <div class="d-flex align-items-center">
                    <label class="mr-3 mb-0 d-none d-md-block">Divisi:</label>
                    <select class="form-control" id="datatable_search_divisi">
                      <option value="">All</option>
                      <?php foreach($list_divisi as $divisi){ ?>
                      <option value="<?= $divisi['NAMA_DIVISI'] ?>"><?= $divisi['NAMA_DIVISI'] ?></option>
                      <?php } ?>
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
    $('#id_jabatan, #id_role, #atasan_i, #atasan_ii, #datatable_search_divisi').select2().on('change', function (e) {
      $(this).valid();
    });
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
            prosesDataMaster("<?= base_url('aia/master/user/post') ?>").then( function(data){
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

  function action(act, id_user) 
  {
    if(act=='reset_password') {
      url       = "<?= base_url() ?>aia/master/user/action/reset_password?id="+id_user;
      msg_conf  = 'Reset password user ini?';
    }
    else if(act=='aktif') {
      url ="<?= base_url() ?>aia/master/user/action/aktif?id="+id_user;
      msg_conf  = 'Aktifkan user ini?';
    }
    else if(act=='nonaktif') {
      url ="<?= base_url() ?>aia/master/user/action/nonaktif?id="+id_user;
      msg_conf  = 'Nonaktifkan user ini?';
    }
    Toast.fire({
      title: msg_conf,
      icon: 'question',
      showCancelButton: true
    }).then((result) => {
      if (result.isConfirmed) {
        prosesDataMaster(url).then( function(data){ 
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
    fetch(`<?= base_url() ?>aia/master/user/user_json?id=${id}`, {method:'POST'})
        .then(response => response.json())
        .then(data => {
            $('#ID').val(btoa(data[0]['ID_USER']));
            $('#nipp').val(data[0]['NIPP']);
            $("#nipp").attr("disabled", "disabled"); 
            $('#NAMA').val(data[0]['NAMA']);
            $('#EMAIL').val(data[0]['EMAIL']);
            $('#id_jabatan').val(data[0]['ID_JABATAN']).trigger('change');
            $('#id_role').val(data[0]['ID_ROLE']).trigger('change');
            $('#id_menu').val(data[0]['MENU']).trigger('change');
            $('#atasan_i').val(data[0]['ID_ATASAN_I']).trigger('change');
            $('#atasan_ii').val(data[0]['ID_ATASAN_II']).trigger('change');

            $('#accordion-title').html('Update User');
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
    $("#nipp").removeAttr("disabled"); 
    $('#id_jabatan, #id_role, #atasan_i, #atasan_ii').trigger('change');
    $('#datatable').KTDatatable('reload');
    $('#collapseOne3').removeClass('show');
    $('#headingOne3 .card-title').addClass('collapsed');
    $('#accordion-title').html('Add User');
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
        source: '<?= base_url('aia/master/user/user_json') ?>',
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
        field: "STATUS",
        title: "Status",
        template: function(t) {
          var a = {
            2: {
              title: "Non-Aktif",
              class: " label-light-danger"
            },
            1: {
              title: "Aktif",
              class: " label-light-success"
            }
          };
          return '<span class="label font-weight-bold label-lg' + a[t.STATUS].class + ' label-inline">' + a[t.STATUS].title + "</span>"
        }
      }, {
        field: "NAMA_ROLE",
        title: "Role"
      },{
        field: "MENU",
        title: "Menu",
        template: function(t) {
          var a = {
            3: {
              title: "ALL"
            },
            2: {
              title: "AIA"
            },
            1: {
              title: "AMS"
            }
          };
          return '<span >' + a[t.MENU].title + "</span>"
        }
      }, {
        field: "LAST_LOGIN",
        title: "Last Login"
      }, {
        field: "ID_USER",
        title: "Actions",
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
          return `<div class="dropdown dropdown-inline">
          <a href="javascript:;" class="btn btn-sm btn-clean btn-icon mr-2" data-toggle="dropdown">
          <i class="fa fa-cog text-dark"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
          <ul class="navi flex-column navi-hover py-2">
          <li class="navi-header font-weight-bolder text-uppercase font-size-xs text-primary pb-2">Pengaturan:</li>
          <li class="navi-item">
          <a href="javascript:void(0)" onclick="update(\'` + btoa(t.ID_USER) + `\')" class="navi-link"><span class="navi-icon">
          <i class="fa fa-edit text-dark"></i></span><span class="navi-text">Edit Data</span>
          </a>
          </li>
          <li class="navi-item">
          <a href="javascript:void(0)" onclick=action("reset_password",\'` + btoa(t.ID_USER) + `\') class="navi-link"><span class="navi-icon">
          <i class="fa fa-sync-alt text-dark"></i></span><span class="navi-text">Reset Password</span>
          </a>
          </li>
          <li class="navi-item">
          <a href="javascript:void(0)" onclick=action("`+aksi+`",\'` + btoa(t.ID_USER) + `\') class="navi-link"><span class="navi-icon"><i class="fa fa-`+fa+` text-dark"></i></span><span class="navi-text">`+teks+`</span></li></ul></div></div>
          `
          // return '<a href="javascript:;" onclick="update(\'' + btoa(t.ID_USER) + '\')" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="fa fa-edit"></i></a><a href="javascript:;" onclick="hapus(\'' + btoa(t.ID_USER) + '\')" class="btn btn-sm btn-clean btn-icon" title="Delete"><i class="fa fa-trash"></i></a>'
        }
      }]
    }), $("#datatable_search_status").on("change", (function() {
      t.search($(this).val().toLowerCase(), "STATUS")
    })), $("#datatable_search_type").on("change", (function() {
      t.search($(this).val().toLowerCase(), "NAMA_ROLE")
    })), $("#datatable_search_divisi").on("change", (function() {
      t.search($(this).val().toLowerCase(), "NAMA_DIVISI")
    })), $("#datatable_search_status, #datatable_search_type").selectpicker()
  }
};
jQuery(document).ready((function() {
  KTDatatableJsonRemoteDemo.init()
}));
</script>