<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <div class="d-flex align-items-center flex-wrap mr-2">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Monitoring</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Laporan Hasil Audit</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Tindak Lanjut</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Edit Rekomendasi</span>
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
          <form class="form" id="kt_form" method="post" action="<?= base_url() ?>monitoring/entry/update_rekomendasi/<?= $detail_temuan->ID_TL ?>/<?= $id_rekomendasi ?>" enctype="multipart/form-data">
            <div class="form-group form-label row">
              <label class="col-form-label col-2 text-right">Temuan</label>
              <div class="col-9">
                <textarea class="" id="temuan"></textarea>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-form-label col-2 text-right">PIC Utama</label>
              <div class="col-9">
                <select class="form-control" id="pic_utama" name="pic_utama">
                  <option value="">--Pilih Jabatan--</option>
                  <?php foreach ($list_jabatan as $jabatan) { ?>
                    <option value="<?= $jabatan['ID_JABATAN'] ?>"><?= $jabatan['NAMA_JABATAN'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div id="list_pic">
              <div class="form-group row">
                <label class="col-form-label col-2 text-right">PIC</label>
                <div class="col-9">
                  <select class="form-control" id="pic" name="pic[]">
                    <option value="">--Pilih Jabatan--</option>
                    <?php foreach ($list_jabatan as $jabatan) { ?>
                      <option value="<?= $jabatan['ID_JABATAN'] ?>"><?= $jabatan['NAMA_JABATAN'] ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-1">
                  <span style="cursor: pointer;" name="add_pic" id="add_pic" class="label font-weight-bold label-lg label-success label-inline mb-2 mt-2">+</span><br>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-2 text-right">Batas Waktu</label>
              <div class="col-9">
                <div class="form-label">
                    <div class="input-icon input-icon-right mb-2">
                      <input autocomplete="off" placeholder="Batas Waktu" type="text" id="BATAS_WAKTU" name="BATAS_WAKTU" class="form-control datepicker w-100">
                      <span>
                        <i class="fa fa-calendar"></i>
                      </span>
                    </div>
                 </div>
              </div>
            </div>
            <!-- <div class="form-group row">
              <label class="col-form-label col-2 text-right">Tanggal Penyelesaian</label>
              <div class="col-9">
                <input type="date" class="form-control" id="TGL_PENYELESAIAN" name="TGL_PENYELESAIAN">
              </div>
            </div> -->
            <div class="form-group row">
              <label class="col-form-label col-2 text-right">Rekomendasi</label>
              <div class="col-9">
                <textarea name="REKOMENDASI" id="REKOMENDASI"></textarea>
                <input type="hidden" class="form-control" name="ID_TEMUAN" value="<?= $detail_temuan->ID ?>">
                <input type="hidden" class="form-control" name="STATUS" id="STATUS">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-form-label col-2 text-right"></label>
              <div class="col-9">
                <div id="data_lampiran" style="margin-left: -30px">
                  <ol></ol>
                </div>
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
              <div class="col-9">
                <button type="button" id="send" class="btn btn-light-primary font-weight-bold">Simpan data</button>
                <!-- <button type="button" id="simpan" class="btn btn-warning font-weight-bold">Simpan</button> -->
                <a href="<?= base_url() ?>monitoring/entry/tindak_lanjut/<?= $detail_temuan->ID_TL ?>" class="btn btn-light-danger font-weight-bold">Kembali</a>
              </div>
            </div>
          </form>
          <div class="form-group row">
            <label class="col-form-label col-2 text-right"></label>
            <div class="col-9">
              <div class="mb-7">
                <div class="row align-items-center">
                  <div class="col-lg-9 col-xl-8">
                    <div class="row align-items-center">
                      <div class="col-md-6 my-2 my-md-0">
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
      t = $("#datatable").KTDatatable({
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
          input: $("#datatable_search_query"),
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
          sortable: !1,
          searchable: !1,
          overflow: "visible",
          template: function(t) {
            return '<a href="javascript:;" onclick="hapus(' + t.ID + ')" class="btn btn-sm btn-clean btn-icon" title="Delete"><i class="fa fa-trash"></i></a>'
          }
        }]
      }), $("#datatable_search_status").on("change", (function() {
        t.search($(this).val().toLowerCase(), "IS_CABANG")
      })), $("#datatable_search_status").selectpicker()
    }
  };
  jQuery(document).ready((function() {
    KTDatatableJsonRemoteDemo.init();
  }));
</script>
<script type="text/javascript">
  $('#form_upload').hide();
  $('input[type=radio][name=TK_PENYELESAIAN]').change(function() {
    if (this.value == 'Selesai') {
      $('#form_upload').show();
    } else {
      $('#upload_file').val('');
      $('#form_upload').hide();
    }
  });
  $(document).ready(function() {

    $('#pic, #pic_utama').select2().on('change', function (e) {
      $(this).valid();
    });
    set_tinymce('temuan' ,`<?= $detail_temuan->TEMUAN ?>`, 'readonly');
    var i = 1;
    $('#add_pic').click(function() {
      i++;
      $('#list_pic').append('<div class="form-group row" id="row' + i + '"><label class="col-form-label col-2 text-right"></label><div class="col-9"><select class="form-control" id="" name="pic[]"><option value="">--Pilih Jabatan--</option><?php foreach ($list_jabatan as $jabatan) { ?><option value="<?= $jabatan['ID_JABATAN'] ?>"><?= $jabatan['NAMA_JABATAN'] ?></option><?php } ?></select></div><div class="col-1"><span style="cursor: pointer;" name="remove" id="' + i + '" class="btn-remove label font-weight-bold label-lg label-danger label-inline mt-2">-</span><br></div></div>');
    });
    $('#add_lampiran').click(function() {
      i++;
      $('#list_lampiran').append('<div class="form-group row" id="row' + i + '"><div class="col-2"></div><div class="col-9"><input type="file" class="form-control" placeholder="Lampiran" name="lampiran[]" value=""></div><div class="col-1"><span style="cursor: pointer;" name="remove" id="' + i + '" class="btn-remove label font-weight-bold label-lg label-danger label-inline mt-2">-</span><br></div></div>');
    });
    $(document).on('click', '.btn-remove', function() {
      var button_id = $(this).attr("id");
      $("#row" + button_id + "").remove();
    });

    $('#simpan').click(async () => {
      await $('#STATUS').val(3);
      await $('#kt_form').submit();
    })

    $('#send').click(() => {
      Swal.fire({
        text: 'Apakah Anda yakin mengupdate data ini ?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal'
      }).then((result) => {
        result.isConfirmed && $('#kt_form').submit();
      })
    })

    // get rekomendasi 
    fetch(`<?= base_url() ?>monitoring/entry/get_rekomendasi_byId/<?= $id_rekomendasi ?>`, {method: 'post'})
      .then(response => response.json())
      .then(data => {
        console.log('data recomendasi', data);

        $('#BATAS_WAKTU').val(data.rekomendasi.BATAS_WAKTU);
        $('#TGL_PENYELESAIAN').val(data.rekomendasi.TGL_PENYELESAIAN);
        $('#STATUS').val(1);

        let first_data = false;
        data.pic.map(pic => {
          i++;
          if (pic.PRIMARY === 'Y') {
            $('#pic_utama').val(pic.PIC).change();
          } else {
            if (first_data === false) {
              $('#pic').val(pic.PIC).change();
              first_data = true;
            } else {
              $('#list_pic').append('<div class="form-group row" id="row' + i + '"><label class="col-form-label col-2 text-right"></label><div class="col-9"><select class="form-control" id="pic' + i + '" name="pic[]"><option value="">--Pilih Jabatan--</option><?php foreach ($list_jabatan as $jabatan) { ?><option value="<?= $jabatan['ID_JABATAN'] ?>"><?= $jabatan['NAMA_JABATAN'] ?></option><?php } ?></select></div><div class="col-1"><span style="cursor: pointer;" name="remove" id="' + i + '" class="btn-remove label font-weight-bold label-lg label-danger label-inline mt-2">-</span><br></div></div>');
              $(`#pic${i}`).val(pic.PIC).change();
            }
          }
        });

        const lampiran = [];
        let z = 1;
        data.lampiran.map(item => {
          const file_name = item.FILE_NAME ? item.FILE_NAME : `Lampiran ${z}`;
          lampiran.push(`<li id="att-${z}"><a href="<?= base_url() ?>storage/upload/lampiran/rekomendasi/${item.ATTACHMENT}" target="_BLANK">${file_name}</a> | <a href="javascript:delete_att(${item.ID}, 'att-${z}')" class="text-danger">Hapus</a></li>`);
          z++;
        });
        $('#data_lampiran ol').append(lampiran.join(" "));

        // insert data to editor
        set_tinymce('REKOMENDASI', data.rekomendasi.REKOMENDASI);
      })
      .catch(err => {
        alert('gagal load data...')
      })

  });
</script>
<script src="https://cdn.quilljs.com/1.0.0/quill.js"></script>
<script type="text/javascript">

  const delete_att = (key, id) => {
    Swal.fire({
      text: 'Apakah Anda yakin ?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Batal'
    }).then((result) => {
      result.isConfirmed && (
        fetch(`<?= base_url() ?>monitoring/entry/delete_att_rekom/${key}`, {method: 'post'})
        .then(() => {
          $(`#${id}`).remove();
        })
        .catch(err => {
          alert('Gagal hapus data')
        })
      );
    })
  }
</script>