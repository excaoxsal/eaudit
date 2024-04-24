<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <div class="d-flex align-items-center flex-wrap mr-2">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Monitoring</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Entry</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4"><?= $detail_spa->NOMOR_SURAT ?></span>      </div>
    </div>
  </div>
  <div class="d-flex flex-column-fluid">
    <div class="container">
        <div class="card card-custom">
          <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
              <h3 class="card-label">Entry Tindak Lanjut</h3>
            </div>
            
          </div>
          <div class="card-body">
            <form class="form" id="kt_form" method="post" action="<?= base_url() ?>monitoring/entry/add_rekomendasi/<?= $detail_temuan->ID_TL ?>" enctype="multipart/form-data"> 
              <div class="form-group row">
                <label class="col-form-label col-2 text-right">Temuan</label>
                <div class="col-10">
                  <textarea class="form-control form-control-solid" name="temuan" readonly><?= $detail_temuan->TEMUAN ?></textarea>
                  
                </div>
              </div>
              <div id="list_pic">
              <div class="form-group row">
                <label class="col-form-label col-2 text-right">PIC</label>
                <div class="col-9">
                  <select class="form-control" id="" name="pic[]">
                    <option value="">--Pilih Jabatan--</option>
                    <?php foreach($list_jabatan as $jabatan){ ?>
                    <option value="<?= $jabatan['ID_JABATAN'] ?>"><?= $jabatan['NAMA_JABATAN'] ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-1">
                  <span style="cursor: pointer;" name="add_pic" id="add_pic" class="label font-weight-bold label-lg label-success label-inline mb-2 mt-2">+</span><br>
                </div>
              </div>
              </div>
              <!-- <div class="form-group row">
                <label class="col-form-label col-2 text-right">PIC</label>
                <div class="col-10">
                  <select class="form-control" id="" name="PIC" required>
                    <option value="">--Pilih Jabatan--</option>
                    <?php foreach($list_jabatan as $jabatan){ ?>
                    <option value="<?= $jabatan['ID_JABATAN'] ?>"><?= $jabatan['NAMA_JABATAN'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div> -->
              <div class="form-group row">
                <label class="col-form-label col-2 text-right">Batas Waktu</label>
                <div class="col-10">
                  <input type="date" class="form-control" name="BATAS_WAKTU">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-2 text-right">Tanggal Penyelesaian</label>
                <div class="col-10">
                  <input type="date" class="form-control" name="TGL_PENYELESAIAN">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label col-2 text-right">Rekomendasi</label>
                <div class="col-10">
                  <div id="editor-a" style="height: 200px;overflow: auto; <?= $enable_css ?>"></div>
                  <input type="hidden"  name="REKOMENDASI" id="REKOMENDASI">
                  <input type="hidden" class="form-control" name="ID_TEMUAN" value="<?= $detail_temuan->ID ?>">
                </div>
              </div>
              <div id="list_lampiran">
              <div class="form-group row">
                <label class="col-form-label col-2 text-right">Lampiran</label>
                <div class="col-9">
                  <input type="file" class="form-control" placeholder="Lampiran" multiple="" name="lampiran[]" value="">
                </div>
                <div class="col-1">
                  <span style="cursor: pointer;" name="add_lampiran" id="add_lampiran" class="label font-weight-bold label-lg label-success label-inline mb-2 mt-2">+</span><br>
                </div>
              </div>
              </div>
              <div class="separator separator-dashed mb-5"></div>
              <div class="form-group row">
                <label class="col-form-label col-2 text-right"></label>
                <div class="col-10">
                  <input type="submit" class="btn btn-primary font-weight-bold" value="Submit">
                  <a href="<?= base_url() ?>monitoring/entry/tindak_lanjut/<?= $detail_temuan->ID_TL ?>" class="btn btn-light-primary font-weight-bold">Kembali</a>
                </div>
              </div>
            </form>
              <div class="form-group row">
                <label class="col-form-label col-2 text-right"></label>
                <div class="col-10">
                  <div class="mb-7">
                      <div class="row align-items-center">
                        <div class="col-lg-9 col-xl-8">
                          <div class="row align-items-center">
                            <div class="col-md-6 my-2 my-md-0">
                              <!-- <button type="button" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#modal_rekomendasi">
                                  <i class="fa fa-plus" style="font-size: 12px;"></i>&nbsp;&nbsp;&nbsp;Add Rekomendasi
                              </button> -->
                            </div>
                            <!-- Modal-->
                            <div class="modal fade" id="modal_rekomendasi" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Add Rekomendasi</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <i aria-hidden="true" class="ki ki-close"></i>
                                            </button>
                                        </div>
                                          
                                        <div class="modal-body" style="height: 500px;">
                                          <div class="form-group row">
                                            <div class="col-12">
                                              <label>PIC</label>
                                              
                                            </div>
                                          </div>
                                          <div class="form-group row">
                                            <div class="col-6">
                                              <label>Batas Waktu</label>
                                              
                                            </div>
                                            <div class="col-6">
                                              <label>Tanggal Penyelesaian</label>
                                              
                                            </div>
                                          </div>
                                          <div class="form-group row">
                                            <div class="col-12">
                                              <label>Rekomendasi</label>
                                              
                                            </div>
                                          </div>
                                          <!-- <div class="form-group row">
                                            <div class="col-12">
                                              <label>Tingkat Penyelesaian</label>
                                              <div class="col-9 col-form-label">
                                                <div class="radio-inline">
                                                  <label class="radio radio-outline radio-success">
                                                  <input type="radio" value="Selesai" name="TK_PENYELESAIAN">
                                                  <span></span>Selesai</label>
                                                  <label class="radio radio-outline radio-success">
                                                  <input type="radio" value="STL" name="TK_PENYELESAIAN">
                                                  <span></span>STL</label>
                                                  <label class="radio radio-outline radio-success">
                                                  <input type="radio" value="BTL" name="TK_PENYELESAIAN">
                                                  <span></span>BTL</label>
                                                  <label class="radio radio-outline radio-success">
                                                  <input type="radio" value="TPTD" name="TK_PENYELESAIAN">
                                                  <span></span>TPTD</label>
                                                </div>
                                              </div>
                                            </div>
                                          </div> -->
                                          <div class="form-group row" id="form_upload">
                                            <div class="col-12">
                                              <label>Upload</label>
                                              <input type="file" id="upload_file" name="LAMPIRAN" class="form-control">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" class="btn btn-primary font-weight-bold" value="Submit">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end:modal -->
                          </div>
                        </div>
                      </div>
                    </div>
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
                  	<!-- <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div> -->
                </div>
              </div>
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
    t = $("#kt_datatable").KTDatatable({
      data: {
        type: "remote",
        source: '<?= base_url() ?>monitoring/entry/rekomendasi_json',
        pageSize: 10
      },
      layout: {
        scroll: !1,
        footer: !1
      },
      sortable: !0,
      pagination: !0,
      search: {
        input: $("#kt_datatable_search_query"),
        key: "generalSearch"
      },
      columns: [{
        field: "HASIL_MONITORING",
        title: "Rekomendasi"
      }, {
        field: "JUDUL_TEMUAN",
        title: "Judul Temuan"
      }, {
        field: "PEMBUAT",
        title: "Dibuat Oleh"
      }, {
        field: "ID",
        title: "Action",
        class: "text-center",
        sortable: !1,
        searchable: !1,
        overflow: "visible",
        template: function(t) {
          return '<a href="javascript:;" onclick="hapus('+t.ID+')" class="btn btn-sm btn-clean btn-icon" title="Delete"><i class="fa fa-trash text-dark"></i></a>'
        }
      }]
    }), $("#kt_datatable_search_status").on("change", (function() {
      t.search($(this).val().toLowerCase(), "IS_CABANG")
    })), $("#kt_datatable_search_status").selectpicker()
  }
};
jQuery(document).ready((function() {
  KTDatatableJsonRemoteDemo.init()
}));
</script>
<script type="text/javascript">
$('#form_upload').hide();
$('input[type=radio][name=TK_PENYELESAIAN]').change(function() {
    if (this.value == 'Selesai') {
      $('#form_upload').show();
    }
    else
    {
      $('#upload_file').val('');
      $('#form_upload').hide();
    }
});
$(document).ready(function(){
    var i = 1;
    $('#add_pic').click(function(){
      i++;
      $('#list_pic').append('<div class="form-group row" id="row'+i+'"><label class="col-form-label col-2 text-right"></label><div class="col-9"><select class="form-control" id="" name="pic[]"><option value="">--Pilih Jabatan--</option><?php foreach($list_jabatan as $jabatan){ ?><option value="<?= $jabatan['ID_JABATAN'] ?>"><?= $jabatan['NAMA_JABATAN'] ?></option><?php } ?></select></div><div class="col-1"><span style="cursor: pointer;" name="remove" id="'+i+'" class="btn-remove label font-weight-bold label-lg label-danger label-inline mt-2">-</span><br></div></div>');
    });
    $('#add_lampiran').click(function(){
      i++;
      $('#list_lampiran').append('<div class="form-group row" id="row'+i+'"><div class="col-2"></div><div class="col-9"><input type="file" class="form-control" placeholder="Lampiran" name="lampiran[]" value=""></div><div class="col-1"><span style="cursor: pointer;" name="remove" id="'+i+'" class="btn-remove label font-weight-bold label-lg label-danger label-inline mt-2">-</span><br></div></div>');
    });
    $(document).on('click', '.btn-remove', function(){
      var button_id   = $(this).attr("id");
      $("#row"+button_id+"").remove();
    }); 
  });
</script>
<script src="https://cdn.quilljs.com/1.0.0/quill.js"></script>
<script type="text/javascript">
function getValueQuill(id, hiddenId,currentValue,enable=true,placeholder = '') {
    var quill = new Quill(id, {
    modules: {
      toolbar: [
        ['bold', 'italic', 'underline'],
        ['link'],
        [{
          list: 'ordered'
        }, {
          list: 'bullet'
        }]
      ]
    },
    placeholder,
    theme: 'snow'
    });
    quill.enable(enable);
    if (currentValue) {
      var myEditor = document.querySelector(id);
      var html = myEditor.children[0].innerHTML = currentValue;
    }
    quill.on('text-change', function(delta, oldDelta, source) {
      var myEditor = document.querySelector(id);
      var html = myEditor.children[0].innerHTML;
      document.getElementById(hiddenId).value = html;
    });
  }
  getValueQuill('#editor-a','REKOMENDASI', '<?= $spa_detail->REKOMENDASI ?>', '<?= $enable ?>');
</script>