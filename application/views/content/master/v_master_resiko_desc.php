<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                <span class="text-muted font-weight-bold mr-4">Master</span>
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                <span class="text-muted font-weight-bold mr-4">Resiko</span>
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
                                <div class="card-title collapsed" id="accordion-title" data-toggle="collapse" data-target="#collapseOne3" aria-expanded="false">Add Resiko</div>
                            </div>
                            <form class="form" id="form" method="post">
                                <input type="hidden" name="ID" id="ID">
                                <div id="collapseOne3" class="collapse" data-parent="#accordionExample3" style="">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-form-label col-3 text-right">Auditee <sup class="text-danger">*</sup></label>
                                            <div class="col-9">
                                                <div class="form-label">
                                                    <select class="form-control" id="DIVISI" name="DIVISI" required>
                                                        <option value="">--Select--</option>
                                                        <?php foreach ($divisi as $item) { ?>
                                                            <option value="<?= $item['ID_DIVISI'] ?>"><?= $item['NAMA_DIVISI'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-3 text-right">Deskripsi Proses <sup class="text-danger">*</sup></label>
                                            <div class="col-9">
                                                <div class="form-label">
                                                    <select class="form-control" id="KLASIFIKASI" name="KLASIFIKASI" required>
                                                        <option value="">--Select--</option>
                                                        <?php foreach ($klasifikasi as $item) { ?>
                                                            <option value="<?= $item['ID'] ?>"><?= $item['KLASIFIKASI'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-3 text-right">Deskripsi Resiko <sup class="text-danger">*</sup></label>
                                            <div class="col-9">
                                                <div class="form-label">
                                                    <textarea name="DESKRIPSI" class="csd" id="DESKRIPSI" required></textarea>
                                                </div>
                                                <div></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-3 text-right">Prioritas Resiko <sup class="text-danger">*</sup></label>
                                            <div class="col-9">
                                                <div class="form-label">
                                                    <select class="form-control" id="TINGKAT_RESIKO" name="TINGKAT_RESIKO" required>
                                                        <option value="">--Select--</option>
                                                        <?php foreach ($tingkat_resiko as $item) { ?>
                                                            <option value="<?= $item['ID_RESIKO'] ?>"><?= $item['RESIKO'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-3 text-right">Kontrol Standar <sup class="text-danger">*</sup></label>
                                            <div class="col-9">
                                                <div class="form-label">
                                                    <textarea name="KONTROL_STANDAR" id="KONTROL_STANDAR" required></textarea>
                                                </div>
                                                <div></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-3 text-right">Kontrol As/Is <sup class="text-danger">*</sup></label>
                                            <div class="col-9">
                                                <div class="form-label">
                                                    <textarea name="RENCANA_KERJA" id="RENCANA_KERJA" required></textarea>
                                                </div>
                                                <div></div>
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
    $('#DIVISI, #KLASIFIKASI, #TINGKAT_RESIKO').select2().on('change', function (e) {
        $(this).valid()
    } );
    set_tinymce('DESKRIPSI');
    set_tinymce('KONTROL_STANDAR');
    set_tinymce('RENCANA_KERJA');

    $("#form").validate({
      errorClass: 'text-danger is-invalid',
      invalidHandler: function(event, validator) {
        KTUtil.scrollTop();
      },
      submitHandler: function () {
        $('textarea').each(
            function(index){  
                // console.log(index);
                var selector = $(this);
                if($('#'+selector.attr('id')).prop('required')==true)
                {
                    if (tinymce.get(selector.attr('id')).getContent()=='') {
                        KTUtil.scrollTop();
                        return false;
                    }
                }else{
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
                        prosesDataMaster("<?= base_url('master/resiko_desc/post') ?>").then( function(data){
                          var obj = JSON.parse(data); 
                          // console.log(obj.status);
                          if(obj.status=='OK'){
                            ToastTopRightTimer.fire({ icon: 'success', title: 'Proses Berhasil! '+obj.msg })
                            _reloadData();
                          }
                        } )
                      }
                    })
                }
            }
        );
      }
    });
  });

  function hapus(id) {
    Toast.fire({
        title: 'Hapus Resiko ini?',
        icon: 'warning',
        showCancelButton: true
    }).then((result) => {
        if (result.isConfirmed) {
            prosesDataMaster(`<?= base_url() ?>master/resiko_desc/hapus?id=${id}`).then( function(data){
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
    fetch(`<?= base_url() ?>master/resiko_desc/resiko_desc_json?id=${id}`, {method:'POST'})
        .then(response => response.json())
        .then(data => {
            $('#DIVISI').val(data[0]['DIVISI_ID']).trigger('change');
            $('#TINGKAT_RESIKO').val(data[0]['TINGKAT_RESIKO_ID']).trigger('change');
            $('#KLASIFIKASI').val(data[0]['KLASIFIKASI_ID']).trigger('change');
            $('#ID').val(btoa(data[0]['ID']));

            tinymce.get("DESKRIPSI").setContent(data[0]['DESC']);
            tinymce.get("KONTROL_STANDAR").setContent(data[0]['KONTROL_STANDAR']);
            tinymce.get("RENCANA_KERJA").setContent(data[0]['RENCANA_KERJA']);

            $('#accordion-title').html('Update Resiko');
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
    $('#DIVISI, #KLASIFIKASI, #TINGKAT_RESIKO').trigger('change');
    $('#datatable').KTDatatable('reload');
    $('#collapseOne3').removeClass('show');
    $('#headingOne3 .card-title').addClass('collapsed');
    $('#accordion-title').html('Add Resiko');
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
                    source: '<?= base_url() ?>master/resiko_desc/resiko_desc_json',
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
                        title: "Auditee"
                    }, {
                        field: "KLASIFIKASI",
                        title: "Deskripsi Proses"
                    },
                    {
                        field: "DESC",
                        title: "Deskripsi Resiko"
                    },
                    {
                        field: "RESIKO",
                        title: "Prioritas Resiko"
                    },
                    {
                        field: "KONTROL_STANDAR",
                        title: "Kontrol Standar"
                    },
                    {
                        field: "RENCANA_KERJA",
                        title: "Kontrol As/Is"
                    },
                    {
                        field: "ID",
                        title: "Actions",
                        class: "text-center",
                        sortable: !1,
                        searchable: !1,
                        overflow: "visible",
                        template: function(t) {
                            return '<a href="javascript:;" onclick="update(\'' + btoa(t.ID) + '\')" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="fa fa-edit text-dark"></i></a><a href="javascript:;" onclick="hapus(\'' + btoa(t.ID) + '\')" class="btn btn-sm btn-clean btn-icon" title="Delete"><i class="fa fa-trash text-dark"></i></a>'
                        }
                    }
                ]
            });
            $("#datatable_search_status").on("change", (function() {
                t.search($(this).val().toLowerCase(), "IS_CABANG")
            })), $("#datatable_search_status").selectpicker()
        }
    };
    jQuery(document).ready((function() {
        KTDatatableJsonRemoteDemo.init();
    }));

</script>