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
            <a href="<?= base_url() ?>monitoring/entry" class="btn btn-light-danger font-weight-bolder">
              Kembali</a>
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
          <div class="form-group row">
            <label class="col-form-label col-2 text-right">Nomor SPA</label>
            <div class="col-10">
              <input type="text" class="form-control form-control-solid" placeholder="[autocomplete] [nomor_spa]" name="" value="<?= $detail_lha[0][NOMOR_SPA] ?>" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-2 text-right">Jenis Audit</label>
            <div class="col-10">
              <input type="text" class="form-control form-control-solid" placeholder="[autocomplete] [auditee]" name="" value="<?= $detail_lha[0][JENIS_AUDIT] ?>" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-2 text-right">Auditee</label>
            <div class="col-10">
              <input type="text" class="form-control form-control-solid" placeholder="[autocomplete] [auditee]" name="" value="<?= $detail_lha[0][NAMA_DIVISI] ?>" readonly>
            </div>
          </div>
          <!-- <div class="form-group row">
                <label class="col-form-label col-2 text-right">Jenis Audit</label>
                <div class="col-10">
                  <input type="text" class="form-control form-control-solid" placeholder="[autocomplete] [jenis_audit]" name="" value="<?= $detail_lha[0][JENIS_AUDIT] ?>" readonly>
                </div>
              </div> -->
          <div class="form-group row">
            <label class="col-form-label col-2 text-right">Tahun Audit</label>
            <div class="col-10">
              <input type="text" class="form-control form-control-solid" placeholder="[autocomplete] [tahun_audit]" name="" value="<?= $detail_lha[0][TAHUN] ?>" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-2 text-right">Periode Audit</label>
            <div class="col-3">
              <input class="form-control form-control-solid" disabled type="date" value="<?= $detail_lha[0][TGL_PERIODE_MULAI] ?>" name="TGL_PERIODE_MULAI">
            </div>
            <p class="my-auto">s/d</p>
            <div class="col-3">
              <input class="form-control form-control-solid" disabled type="date" value="<?= $detail_lha[0][TGL_PERIODE_SELESAI] ?>" name="TGL_PERIODE_SELESAI">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-2 text-right">Masa Audit</label>
            <div class="col-3">
              <input class="form-control form-control-solid" disabled type="date" value="<?= $detail_lha[0][MASA_AUDIT_AWAL] ?>" name="MASA_AUDIT_AWAL">
            </div>
            <p class="my-auto">s/d</p>
            <div class="col-3">
              <input class="form-control form-control-solid" disabled type="date" value="<?= $detail_lha[0][MASA_AUDIT_AKHIR] ?>" name="MASA_AUDIT_AKHIR">
            </div>
          </div>
          <div class="separator separator-dashed mb-5 d-none"></div>
          


          <div class="separator separator-dashed mb-5 d-none"></div>
          <div class="form-group row">
            <label class="col-form-label col-2 text-right"></label>
            <!-- <div class="col-10">
                  <button type="submit" class="btn btn-warning font-weight-bold">Preview</button>
                  <?php
                  $status = array(2, 3);
                  if (!in_array($detail_lha[0][STATUS_TL], $status)) {
                  ?>
                  <button type="submit" class="btn btn-primary font-weight-bold">Simpan</button>
                  <button type="submit" class="btn btn-success font-weight-bold">Kirim</button>
                  <?php } ?>
                </div> -->
          </div>
        </div>
      </div>
    </div>

  </div>
  <div class="d-flex flex-column-fluid mt-5">
    <div class="container">
      <div class="row mb-5">
        <div class="col-lg-12">
          <div class="card card-custom">
        <div class="card-header card-header-tabs-line nav-tabs-line-3x">
          <div class="card-toolbar">
            <ul class="nav nav-tabs nav-bold nav-tabs-line nav-tabs-line-3x">
              <li class="nav-item mr-3">
                <a class="nav-link active" data-toggle="tab" href="#tab_temuan">
                  
                  <span class="nav-text font-size-lg">Temuan dan Rekomendasi Audit</span>
                </a>
              </li>
              <li class="nav-item mr-3">

                <a class="nav-link" data-toggle="tab" href="#tab_perhatian">
                  
                  <span class="nav-text font-size-lg">Hal-hal yang Perlu Diperhatikan</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
        <div class="card-body">
            <div class="tab-content">

              <div class="tab-pane show px-7 active" id="tab_temuan" role="tabpanel">
                <div class="form-group row">
                  <label class="col-form-label col-2 text-right">Temuan</label>
                  <div class="col-10">
                    <div class="mb-7">
                      <div class="row align-items-center">
                        <div class="col-lg-9 col-xl-8">
                          <div class="row align-items-center">
                            <div class="col-md-4 my-2 my-md-0">
                              <div class="input-icon">
                                <input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query" />
                                <span>
                                  <i class="fa fa-search"></i>
                                </span>
                              </div>
                            </div>
                            <div class="col-md-6 my-2 my-md-0">
                              <button type="button" class="btn btn-primary font-weight-bolder btn-add-temuan" data-toggle="modal" data-target="#modal_temuan">
                                <i class="fa fa-plus" style="font-size: 12px;"></i>&nbsp;&nbsp;&nbsp;Add Temuan
                              </button>
                              <button class="btn btn-light-success font-weight-bold" type="button" id="kt_datatable_reload">Reload Data</button>
                            </div>
                            <!-- Modal-->
                            <div class="modal fade" id="modal_temuan" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabeltemuan">Add Temuan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <i aria-hidden="true" class="ki ki-close"></i>
                                    </button>
                                  </div>
                                  <form class="form" id="kt_form" method="post" action="<?= base_url() ?>monitoring/entry/add_temuan/<?= $detail_lha[0][ID_TL] ?>" enctype="multipart/form-data">
                                    <div class="modal-body" style="height: 70vh">
                                      <div class="form-group row">
                                        <div class="col-12">
                                          <label>No Urut</label>
                                          <input type="number" min="1" onkeyup="checkNoUrut()" class="form-control" placeholder="No Urut" name="NO_URUT" id="NO_URUT">
                                          <small id="urut_msg" class="text-danger d-none">Nomor urut sudah ada</small>
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <div class="col-12">
                                          <label>Judul Temuan</label>
                                          <input type="text" class="form-control" placeholder="Judul Temuan" name="JUDUL_TEMUAN" id="JUDUL_TEMUAN">
                                          <input type="hidden" class="form-control form-control-solid" id="id_tl" name="id_tl" value="<?= $detail_lha[0][ID_TL] ?>" readonly>
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <div class="col-12">
                                          <label>Kondisi</label>
                                          <textarea name="temuan" id="temuan"></textarea>
                                        </div>
                                      </div>

                                      <div class="form-group row">
                                        <div class="col-12">
                                          <label>Kriteria</label>
                                          <textarea name="kriteria" id="kriteria"></textarea>
                                        </div>
                                      </div>

                                      <div class="form-group row">
                                        <div class="col-12">
                                          <label>Root Cause</label>
                                          <textarea name="root_cause" id="root_cause"></textarea>
                                        </div>
                                      </div>

                                      <div class="form-group row">
                                        <div class="col-12">
                                          <label>Implikasi Terhadap Bisnis</label>
                                          <textarea name="implikasi" id="implikasi"></textarea>
                                        </div>
                                      </div>

                                      <div class="form-group row">
                                        <div class="col-12">
                                          <label>Komentar Auditi</label>
                                          <textarea name="komentar_auditi" id="komentar_auditi"></textarea>
                                        </div>
                                      </div>

                                      <div class="form-group row">
                                        <div class="col-12">
                                          <label>Prioritas</label>
                                          <input type="number" min="1" class="form-control" placeholder="Prioritas" name="PRIORITAS_TEMUAN" id="PRIORITAS_TEMUAN">
                                        </div>
                                      </div>

                                      <div id="data_lampiran">
                                        <ol></ol>
                                      </div>

                                      <div id="list_lampiran">
                                        <div class="form-group row">
                                          <label class="col-form-label col-12">Lampiran</label>
                                          <div class="col-11">
                                            <div class="custom-file">
                                              <input type="file" class="custom-file-input" multiple="" name="lampiran[]" />
                                              <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                          </div>
                                          <div class="col-1">
                                            <span style="cursor: pointer;" name="add_lampiran" id="add_lampiran" class="label font-weight-bold label-lg label-success label-inline mb-2 mt-2">+</span><br>
                                          </div>
                                        </div>
                                      </div>

                                      <!-- <div class="form-group row">
                                                  <div class="col-12">
                                                    <label>Attachment</label>
                                                    <input type="file" class="form-control" name="LAMPIRAN" id="LAMPIRAN">
                                                  </div>
                                                </div> -->
                                    </div>
                                    <div class="modal-footer">
                                      <input type="submit" class="btn btn-primary font-weight-bold" value="Submit">
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <!-- end:modal -->
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="col-12">
                    <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
                  </div>
                </div>
              </div>

              <div class="tab-pane px-7" id="tab_perhatian" role="tabpanel">
                <div class="form-group row">
                  <label class="col-form-label col-2 text-right">Hal</label>
                  <div class="col-10">
                    <div class="mb-7">
                      <div class="row align-items-center">
                        <div class="col-lg-9 col-xl-8">
                          <div class="row align-items-center">
                            <div class="col-md-4 my-2 my-md-0">
                              <div class="input-icon">
                                <input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query_hal" />
                                <span>
                                  <i class="fa fa-search"></i>
                                </span>
                              </div>
                            </div>
                            <div class="col-md-6 my-2 my-md-0">
                              <button type="button" class="btn btn-primary font-weight-bolder btn-add-hal" data-toggle="modal" data-target="#modal_hal">
                                <i class="fa fa-plus" style="font-size: 12px;"></i>&nbsp;&nbsp;&nbsp;Add Hal
                              </button>
                              <button class="btn btn-light-success font-weight-bold" type="button" id="kt_datatable_reload_hal">Reload Data</button>
                            </div>
                            <!-- Modal-->
                            <div class="modal fade" id="modal_hal" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title_hal" id="exampleModalLabelhal">Add Hal</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <i aria-hidden="true" class="ki ki-close"></i>
                                    </button>
                                  </div>
                                  <form class="form" id="kt_form_hal" method="post" action="<?= base_url() ?>monitoring/entry/add_hal/<?= $detail_lha[0][ID_TL] ?>" enctype="multipart/form-data">
                                    <div class="modal-body" style="height: 400px">
                                      <div class="form-group row">
                                        <div class="col-12">
                                          <label>No Urut</label>
                                          <input type="number" min="1" class="form-control" placeholder="No Urut" name="NO_URUT_HAL" id="NO_URUT_HAL">
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <div class="col-12">
                                          <label>Judul Observasi</label>
                                          <input type="text" class="form-control" placeholder="Judul Observasi" name="JUDUL_OBSERVASI" id="JUDUL_OBSERVASI">
                                          <input type="hidden" class="form-control form-control-solid" id="id_tl_hal" name="id_tl_hal" value="<?= $detail_lha[0][ID_TL] ?>" readonly>
                                        </div>
                                      </div>
                                      <div class="form-group row">
                                        <div class="col-12">
                                          <label>Uraian Observasi</label>
                                          <textarea name="OBSERVASI" id="OBSERVASI"></textarea>
                                        </div>
                                      </div>

                                      <div class="form-group row">
                                        <div class="col-12">
                                          <label>Rekomendasi</label>
                                          <textarea name="REKOMENDASI" id="REKOMENDASI"></textarea>
                                        </div>
                                      </div>

                                      <div class="form-group row">
                                        <div class="col-12">
                                          <label>Prioritas</label>
                                          <input type="number" min="1" class="form-control" placeholder="Prioritas" name="PRIORITAS" id="PRIORITAS">
                                        </div>
                                      </div>

                                      <div class="form-group row">
                                        <div class="col-12">
                                          <label>PIC</label>
                                          <div class="form-label">
                                            <select class="form-control select-dua" id="PIC" name="PIC" required>
                                            <option value="">--Pilih--</option>
                                            <?php foreach ($list_jabatan as $data) { ?>
                                              <option <?= $data[ID_JABATAN] == $data_ba->PIC ? 'selected' : '' ; ?> value="<?= $data['ID_JABATAN'] ?>"><?= $data['NAMA_JABATAN'] ?></option>
                                            <?php } ?>
                                          </select>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group row">
                                        <div class="col-12">
                                          <label>Batas Waktu</label>
                                          <div class="form-label">
                                            <div class="input-icon input-icon-right mb-2">
                                              <input autocomplete="off" placeholder="Batas Waktu" class="form-control datepicker w-100" type="text" id="BATAS_WAKTU" name="BATAS_WAKTU" required>
                                              <span>
                                                <i class="fa fa-calendar cursor-pointer"></i>
                                              </span>
                                            </div>
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
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="col-12">
                    <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable_hal"></div>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-titles" id="exampleModalLabel">Detil Temuan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <div class="modal-body" id="read_more">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
            source: '<?= base_url() ?>monitoring/entry/temuan_json/<?= $detail_lha[0][ID_TL] ?>',
            pageSize: 10
          },
          layout: {
            scroll: !1,
            footer: !1
          },

          detail: {
            title: "Load sub table",
            content: tableDetail,
          },

          sortable: !0,
          pagination: !0,
          search: {
            input: $("#kt_datatable_search_query"),
            key: "generalSearch"
          },
          columns: [{
            field: "ID",
            title: "",
            sortable: !1,
            searchable: !1,
            width: 30,
            textAlign: "center",
          }, {
            field: "NO_URUT",
            title: "No",
            width:30
          }, {
            field: "JUDUL_TEMUAN",
            title: "Judul Temuan"
          }, {
            field: "TEMUAN2",
            title: "Temuan",
            template: function(t) {
              var data  = t.TEMUAN2;
              var text  = $(data).text();
              var len   = text.length;
              var limit = 50;
              if(len>limit)
                return `<span style='display:none;'>`+data+`</span>`+text.substr(0,limit)+`<a href="javascript:void(0)" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="read_more(this)">...Selengkapnya</a>`;
              else
                return data;
            }
          }, {
            field: "Actions",
            class: "texgt-center",
            title: "Actions",
            sortable: !1,
            searchable: !1,
            overflow: "visible",
            width: 100,
            template: function(t) {
          //     return `
          //     <a href="<?= base_url() ?>monitoring/entry/temuan/${t.ID}" class="btn btn-sm btn-clean btn-icon" title="Entry rekomendasi"><i class="fa fa-plus-square"></i></a>
          //     <div class="dropdown dropdown-inline">
          // <a href="javascript:;" class="btn btn-sm btn-clean btn-icon mr-2" data-toggle="dropdown">
          // <i class="fa fa-cog"></i>
          // </a>
          // <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
          // <ul class="navi flex-column navi-hover py-2">
          // <li class="navi-header font-weight-bolder text-uppercase font-size-xs text-primary pb-2">Pengaturan:</li>
          // <li class="navi-item">
          // <a href="javascript:void(0)" onclick="show_modal_edit_temuan(${t.ID})" class="navi-link"><span class="navi-icon">
          // <i class="fa fa-edit"></i></span><span class="navi-text">Edit Data</span>
          // </a>
          // </li>
          // <li class="navi-item">
          // <a href="javascript:void(0)" onclick=action() class="navi-link"><span class="navi-icon">
          // <i class="fa fa-chevron-up"></i></span><span class="navi-text">Pindah ke atas</span>
          // </a>
          // </li>
          // <li class="navi-item">
          // <a href="javascript:void(0)" onclick=action() class="navi-link"><span class="navi-icon">
          // <i class="fa fa-chevron-down"></i></span><span class="navi-text">Pindah ke bawah</span>
          // </a>
          // </li>
          // </ul></div></div>
          //     <a href="javascript:;" onclick="delete_temuan_rekom(\'TEMUAN\', ${t.ID})" class="btn btn-sm btn-clean btn-icon" title="Delete"><i class="fa fa-trash"></i></a>
          //     `;
              return '<a href="<?= base_url() ?>monitoring/entry/temuan/' + t.ID + '" class="btn btn-sm btn-clean btn-icon" title="Entry rekomendasi"><i class="fa fa-plus-square text-dark"></i></a>' +
                '<a href="javascript:;" onclick="show_modal_edit_temuan(' + t.ID + ')" title="Edit" class="btn btn-sm btn-clean btn-icon"><i class="fa fa-edit text-dark"></i></a>' +
                '<a href="javascript:;" onclick="delete_temuan_rekom(\'TEMUAN\',' + t.ID + ')" class="btn btn-sm btn-clean btn-icon" title="Delete"><i class="fa fa-trash text-dark"></i></a>'
            }
          }]
        }), $("#kt_datatable_search_status").on("change", (function() {
          t.search($(this).val().toLowerCase(), "IS_CABANG")
        })), $("#kt_datatable_search_status").selectpicker(),
        $('#kt_datatable_reload').on('click', function() {
          $('#kt_datatable').KTDatatable('reload');
        });
    }
  };

    var KTDatatableJsonRemoteDemo_hal = {
    init: function() {
      var t;
      t = $("#kt_datatable_hal").KTDatatable({
          data: {
            type: "remote",
            source: '<?= base_url() ?>monitoring/entry/hal_json/<?= $detail_lha[0][ID_TL] ?>',
            pageSize: 10
          },
          layout: {
            scroll: !1,
            footer: !1
          },

          sortable: !0,
          pagination: !0,
          search: {
            input: $("#kt_datatable_search_query_hal"),
            key: "generalSearch"
          },
          columns: [{
            field: "NO_URUT",
            title: "No Urut",
            width:30
          }, {
            field: "JUDUL_OBSERVASI",
            title: "Judul Temuan"
          }, {
            field: "TEMUAN2",
            title: "Temuan"
          }, {
            field: "Actions",
            class: "texgt-center",
            title: "Actions",
            sortable: !1,
            searchable: !1,
            overflow: "visible",
            width: 100,
            template: function(t) {
              return '<a href="javascript:;" onclick="show_modal_edit_hal(' + t.ID + ')" title="Edit" class="btn btn-sm btn-clean btn-icon"><i class="fa fa-edit text-dark"></i></a>' +
                '<a href="javascript:;" onclick="delete_hal(' + t.ID + ')" class="btn btn-sm btn-clean btn-icon" title="Delete"><i class="fa fa-trash text-dark"></i></a>'
            }
          }]
        }), $('#kt_datatable_reload_hal').on('click', function() {
          $('#kt_datatable_hal').KTDatatable('reload');
        });
    }
  };

  function read_more(data)
  {
    $('#read_more').html($(data).prev().html());
  }

  function checkNoUrut()
  {
    $.get("<?= base_url('monitoring/entry/cek_no_urut/').$detail_lha[0][ID_TL].'/' ?>"+$('#NO_URUT').val(), function(data, status){
      if(data==1) $('#urut_msg').removeClass('d-none');
      else $('#urut_msg').addClass('d-none');
    });
  }

  const tableDetail = (e) => {
    $("<div/>")
      .attr("id", "child_data_ajax_" + e.data.ID)
      .appendTo(e.detailCell)
      .KTDatatable({
        data: {
          type: "remote",
          source: `<?= base_url() ?>monitoring/entry/rekomendasi_json_/${e.data.ID}`,
          pageSize: 10
        },
        // layout definition
        layout: {
          scroll: false,
          footer: false,

          // enable/disable datatable spinner.
          spinner: {
            type: 1,
            theme: "default",
          },
        },

        sortable: true,

        search: {
          input: $("#kt_datatable_search_query2"),
          key: "generalSearch"
        },

        // columns definition
        columns: [{
            field: "REKOMENDASI2",
            title: "Rekomendasi",
          }, {
            field: "BATAS_WAKTU",
            title: "Batas Waktu",
            template: (t) => {
              return `${dateFormat(t.BATAS_WAKTU)}`
            }
          }, {
            field: "pic",
            title: "PIC",
            template: (t) => {
              return `<ol style="padding-left: 1em;">${t.pic}</ol>`;
            }
          },
          {
            field: "ID",
            title: "Action",
            sortable: !1,
            searchable: !1,
            overflow: "visible",
            width: 70,
            template: function(t) {
              return `<a href="<?= base_url() ?>monitoring/entry/edit_rekomendasi/${t.ID_TEMUAN}/${t.ID}" class="btn btn-sm btn-clean btn-icon" title="Edit rekomendasi"><i class="fa fa-edit"></i></a><a href="javascript:;" onclick="delete_temuan_rekom('REKOM',${t.ID})" class="btn btn-sm btn-clean btn-icon" title="Delete"><i class="fa fa-trash"></i></a>`
            }
          }
        ]
      });
  }

  jQuery(document).ready((function() {
    KTDatatableJsonRemoteDemo.init();
    KTDatatableJsonRemoteDemo_hal.init();
  }));
  $(document).ready(function() {

    set_tinymce('temuan', `<?= $spa_detail->temuan ?>`);
    set_tinymce('komentar_auditi', `<?= $spa_detail->komentar_auditi ?>`);
    set_tinymce('root_cause', `<?= $spa_detail->root_cause ?>`);
    set_tinymce('implikasi', `<?= $spa_detail->implikasi ?>`);
    set_tinymce('kriteria', `<?= $spa_detail->kriteria ?>`);
    set_tinymce('REKOMENDASI', `<?= $spa_detail->REKOMENDASI ?>`);
    set_tinymce('OBSERVASI', `<?= $spa_detail->OBSERVASI ?>`);

    var i = 1;
    $('#add_lampiran').click(function() {
      i++;
      $('#list_lampiran')
      .append(`<div class="form-group row" id="row${i}">
                <div class="col-11">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" multiple="" name="lampiran[]" />
                    <label class="custom-file-label" for="customFile">Choose file</label>
                  </div>
                </div>
                <div class="col-1">
                <span style="cursor: pointer;" name="remove" id="${i}" class="btn-remove label font-weight-bold label-lg label-danger label-inline mt-2">-</span>
                <br>
                </div>
                </div>`);
    });
    $(document).on('click', '.btn-remove', function() {
      var button_id = $(this).attr("id");
      $("#row" + button_id + "").remove();
    });

    $('.btn-add-temuan').click(() => {
      $('.modal-title').html('Add Temuan');
      $('#kt_form').attr('action', `<?= base_url() ?>monitoring/entry/add_temuan/`+<?= $detail_lha[0][ID_TL]  ?>);
      $('#JUDUL_TEMUAN').val('');
      $('#NO_URUT').val('');
      $('#PRIORITAS_TEMUAN').val('');
      tinymce.get("temuan").setContent('');
      tinymce.get("kriteria").setContent('');
      tinymce.get("root_cause").setContent('');
      tinymce.get("implikasi").setContent('');
      tinymce.get("komentar_auditi").setContent('');
    });

    $('.btn-add-hal').click(() => {
      $('.modal-title_hal').html('Add Hal');
      $('#kt_form_hal').attr('action', `<?= base_url() ?>monitoring/entry/add_hal/`+<?= $detail_lha[0][ID_TL]  ?>);
      $('#JUDUL_OBSERVASI').val('');
      $('#NO_URUT_HAL').val('');
      $('#PRIORITAS').val('');
      $("#PIC").val('').change();
      $('#BATAS_WAKTU').val('');
      tinymce.get("OBSERVASI").setContent('');
      tinymce.get("REKOMENDASI").setContent('');
      // tinymce.get("root_cause").setContent('');
      // tinymce.get("implikasi").setContent('');
      // tinymce.get("komentar_auditi").setContent('');
    });

  });
</script>
<script type="text/javascript">

  const show_modal_edit_temuan = (id) => {
    $('.modal-title').html('Edit Temuan');
    $('#kt_form').attr('action', `<?= base_url() ?>monitoring/entry/update_temuan/${id}`)
    $('#data_lampiran ol').empty();

    fetch(`<?= base_url() ?>/monitoring/entry/get_temuan_by_id/${id}`, {method: 'post'})
      .then(response => response.json())
      .then(data => {
        // console.log('res temuan ', data);
        $('#JUDUL_TEMUAN').val(data.JUDUL_TEMUAN);
        $('#NO_URUT').val(data.NO_URUT);
        $('#PRIORITAS_TEMUAN').val(data.PRIORITAS);
        tinymce.get("temuan").setContent(`${data.TEMUAN}`);
        tinymce.get("kriteria").setContent(`${data.KRITERIA}`);
        tinymce.get("root_cause").setContent(`${data.ROOT_CAUSE}`);
        tinymce.get("implikasi").setContent(`${data.IMPLIKASI}`);
        tinymce.get("komentar_auditi").setContent(`${data.KOMENTAR_AUDITI}`);
      })

    fetch(`<?= base_url() ?>/monitoring/entry/get_lampiran_temuan/${id}`, {method: 'post'})
      .then(response => response.json())
      .then(data => {
        const lampiran = [];
        let i = 1;
        data.map(item => {
          const file_name = item.FILE_NAME ? item.FILE_NAME : `Lampiran ${i}`;
          lampiran.push(`<li id="att-${i}"><a href="<?= base_url() ?>storage/upload/lampiran/temuan/${item.ATTACHMENT}" target="_BLANK">${file_name}</a> | <a href="javascript:delete_att(${item.ID}, 'att-${i}')" class="text-danger">Hapus</a></li>`);
          i++;
        });
        $('#data_lampiran ol').append(lampiran.join(" "))
        $('#modal_temuan').modal('show');
      })
      .catch(err => {
        alert('gagal load data, tutup dan coba lagi');
      });
  }

  const show_modal_edit_hal= (id) => {
    $('.modal-title_hal').html('Edit Hal');
    $('#kt_form_hal').attr('action', `<?= base_url() ?>monitoring/entry/update_hal/${id}`)

    fetch(`<?= base_url() ?>/monitoring/entry/get_hal_by_id/${id}`, {method: 'post'})
      .then(response => response.json())
      .then(data => {
        // console.log('res temuan ', data);
        $('#modal_hal').modal('show');
        $('#JUDUL_OBSERVASI').val(data.JUDUL_OBSERVASI);
        $('#NO_URUT_HAL').val(data.NO_URUT);
        $('#PRIORITAS').val(data.PRIORITAS);
        $('#BATAS_WAKTU').val(data.BATAS_WAKTU);
        tinymce.get("OBSERVASI").setContent(`${data.OBSERVASI}`);
        tinymce.get("REKOMENDASI").setContent(`${data.REKOMENDASI}`);
        $("#PIC").val(data.PIC).change();
        // tinymce.get("root_cause").setContent(`${data.ROOT_CAUSE}`);
        // tinymce.get("implikasi").setContent(`${data.IMPLIKASI}`);
        // tinymce.get("komentar_auditi").setContent(`${data.KOMENTAR_AUDITI}`);
      })
  }

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
        fetch(`<?= base_url() ?>monitoring/entry/delete_att_temuan/${key}`, {method: 'post'})
        .then(() => {
          $(`#${id}`).remove();
        })
        .catch(err => {
          alert('Gagal hapus data')
        })
      );
    })
  }

  const delete_temuan_rekom = (type, id) => {
    Swal.fire({
      text: 'Apakah Anda yakin akan menghapus data ini ?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Batal'
    }).then((result) => {
      result.isConfirmed && (
        fetch(`<?= base_url() ?>monitoring/entry/delete_temuan_rekom/${type}/${id}`, {method: 'post'})
        .then(() => {
          location.reload();
        })
        .catch(err => {
          alert('Gagal hapus data')
        })
      );
    })
  }

  const delete_hal = (id) => {
    Swal.fire({
      text: 'Apakah Anda yakin akan menghapus data ini ?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Batal'
    }).then((result) => {
      result.isConfirmed && (
        fetch(`<?= base_url() ?>monitoring/entry/delete_hal/${id}`, {method: 'post'})
        .then(() => {
          location.reload();
        })
        .catch(err => {
          alert('Gagal hapus data')
        })
      );
    })
  }
</script>