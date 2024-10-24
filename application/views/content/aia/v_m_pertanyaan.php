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
        <span class="text-muted font-weight-bold mr-4">Master Pertanyaan</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4"><?=$pertanyaan[0]['NOMOR_ISO']?></span>
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
            <a class="btn btn-primary font-weight-bolder" onclick="insertPertanyaan(' + t.ID_TL + ')">
              <i class="fa fa-plus" style="font-size: 12px;"></i>&nbsp;&nbsp;&nbsp;&nbsp;Tambah Pertanyaan</a>
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
<!-- Modal master pertanyaan-->
<div class="modal fade" id="modal_input_pertanyaan" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">Input Master Pertanyaan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      
        <div class="modal-body" style="height: auto">
        <form class="form" id="insert_form" method="post" action="<?= base_url() ?>aia/iso/insertPertanyaan" enctype="multipart/form-data">
          <div class="form-group row">
            <div class="col-12">
              <label>Klausul</label>
              <input type="text" class="form-control" placeholder="KLAUSUL" name="KLAUSUL" id="KLAUSUL">
              <input type="hidden" class="form-control" placeholder="Nomor LHA" name="ID_ISO" id="ID_ISO" value="<?=$id_iso?>">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
              <label>Lv1</label>
              <input type="text" class="form-control" placeholder="Lv1" name="LV1" id="LV1">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
              <label>Lv2</label>
              <input type="text" class="form-control" placeholder="Lv2" name="LV2" id="LV2">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
              <label>Lv3</label>
              <input type="text" class="form-control" placeholder="Lv3" name="LV3" id="LV3">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
              <label>Lv4</label>
              <input type="text" class="form-control" placeholder="Lv4" name="LV4" id="LV4">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
              <label>Auditee</label>
              <textarea class="form-control" name="AUDITEE" id="AUDITEE"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
              <label>Pertanyaan</label>
              <textarea class="form-control" name="PERTANYAAN" id="PERTANYAAN"></textarea>
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
<div class="modal fade" id="modal_edit_pertanyaan" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Master Pertanyaan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      
        <div class="modal-body" style="height: auto">
        <form class="form" id="update_form" method="post" action="<?= base_url() ?>aia/iso/updatePertanyaan" enctype="multipart/form-data">
          <div class="form-group row">
            <div class="col-12">
              <label>Klausul</label>
              <input type="text" class="form-control" placeholder="KLAUSUL" name="KLAUSUL_EDIT" id="KLAUSUL_EDIT">
              <input type="hidden" class="form-control" name="ID_MASTER_PERTANYAAN" id="ID_MASTER_PERTANYAAN">
              <input type="hidden" class="form-control" name="ID_ISO" id="ID_ISO_EDIT" value="<?=$id_iso?>">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
              <label>Lv1</label>
              <input type="text" class="form-control" placeholder="Lv1" name="LV1_EDIT" id="LV1_EDIT">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
              <label>Lv2</label>
              <input type="text" class="form-control" placeholder="Lv2" name="LV2_EDIT" id="LV2_EDIT">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
              <label>Lv3</label>
              <input type="text" class="form-control" placeholder="Lv3" name="LV3_EDIT" id="LV3_EDIT">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
              <label>Lv4</label>
              <input type="text" class="form-control" placeholder="Lv4" name="LV4_EDIT" id="LV4_EDIT">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
              <label>Auditee</label>
              <textarea class="form-control" name="AUDITEE_EDIT" id="AUDITEE_EDIT"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
              <label>Pertanyaan</label>
              <textarea class="form-control" name="PERTANYAAN_EDIT" id="PERTANYAAN_EDIT"></textarea>
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


<script type="text/javascript">
  "use strict";
  var KTDatatableJsonRemoteDemo = {
    init: function() {
      var t;
      t = $("#datatable").KTDatatable({
        data: {
          type: "remote",
          source: '<?= base_url() ?>aia/Iso/jsonPertanyaanList/<?=$id_iso?>',
          pageSize: 10
        },
        layout: {
          scroll: {
                    x: true, 
                    y: true 
                },
          footer: !1
        },
        sortable: !0,
        pagination: !0,
        
        search: {
          input: $("#datatable_search_query"),
          key: "generalSearch"
        },
        columns: [
          {
          field: "KODE_KLAUSUL",
          title: "KLAUSUL"
        },
        {
          field: "LV1",
          title: "LV1"
        },
        {
          field: "LV2",
          title: "LV2"
        },
        {
          field: "LV3",
          title: "LV3"
        },
        {
          field: "LV4",
          title: "LV4"
        },
        {
          field: "AUDITEE",
          title: "AUDITEE"
        },
        {
          field: "PERTANYAAN",
          title: "PERTANYAAN"
        }, 
        {
          field: "ID_ISO",
          title: "Action",
          class: "text-center",
          sortable: !1,
          searchable: !1,
          overflow: "visible",
          template: function(t) {
            return '<a onclick="editPertanyaan(' + t.ID_MASTER_PERTANYAAN + ')" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="fa fa-edit text-dark"></i></a>'
            }
        }
      ]
      }), $("#datatable_search_status").on("change", (function() {
        t.search($(this).val().toLowerCase(), "STATUS")
      })), $("#datatable_search_status").selectpicker(),$("#kt_datatable").KTDatatable().reload();
    }
  };


  function editPertanyaan(id_tl) {
    $.get(`<?= base_url('aia/Iso/getdatapertanyaan/') ?>` + id_tl, function(data, status) {
        const obj = JSON.parse(data);
        $('#ID_ISO_EDIT').val(obj.ID_ISO);
        $('#ID_MASTER_PERTANYAAN').val(id_tl);
        $('#KLAUSUL_EDIT').val(obj.KODE_KLAUSUL);
        $('#LV1_EDIT').val(obj.LV1);
        $('#LV2_EDIT').val(obj.LV2);
        $('#LV3_EDIT').val(obj.LV3);
        $('#LV4_EDIT').val(obj.LV4);
        $('#AUDITEE_EDIT').val(obj.AUDITEE);
        $('#PERTANYAAN_EDIT').val(obj.PERTANYAAN);
    });
    $('#modal_edit_pertanyaan').modal('show');
  }

  function insertPertanyaan(id_tl)
  {
    
    $('#modal_input_pertanyaan').modal('show');
  }
  jQuery(document).ready((function() {
    KTDatatableJsonRemoteDemo.init()
  }));
</script>