<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <!--begin::Subheader-->
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <!--begin::Info-->
      <div class="d-flex align-items-center flex-wrap mr-2">
        <!--begin::Page Title-->
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Audit Management System</h5>
        <!--end::Page Title-->
        <!--begin::Actions-->
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Master</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Tanda Tangan</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4"><?= $user_detail[0]['NIPP'] ?></span>
        <!--end::Actions-->
      </div>
      <!--end::Info-->
    </div>
  </div>
  <!--end::Subheader-->
  <!--begin::Entry-->
  <div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
      <!--begin::Dashboard-->
      <!--begin::Card-->
        <form class="form" id="form" method="post" action="<?= base_url() ?>master/tanda_tangan/upload/<?= $user_detail[0]['ID_USER'] ?>" enctype="multipart/form-data">  
        <div class="card card-custom">
          <div class="card-header">
            <div class="card-title">
              <h3 class="card-label">Upload Tanda Tangan</h3>
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
          <div class="row">
            <div class="col-xl-2"></div>
            <div class="col-xl-7 my-2">
              <!--begin::Group-->
              <div class="form-group row">
                <label class="col-form-label col-3 text-lg-right text-left">Tanda Tangan</label>
                <div class="col-9">
                  <?php if($user_detail[0]['TANDA_TANGAN'] == '' || $user_detail[0]['TANDA_TANGAN'] == null){ ?>
                  <div class="image-input image-input-empty image-input-outline" id="kt_user_edit_avatar" style="background-image: url(<?= base_url() ?>storage/upload/tanda_tangan/no-image.png);background-position: center;">
                  <?php }else{ ?>
                  <div class="image-input image-input-empty image-input-outline" id="kt_user_edit_avatar" style="background-image: url(<?= base_url() ?>storage/upload/tanda_tangan/<?= $user_detail[0]['TANDA_TANGAN'] ?>)">
                  <?php } ?>
                    <div class="image-input-wrapper"></div>
                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Upload Tanda Tangan">
                      <i class="fa fa-pen icon-sm text-muted"></i>
                      <input type="file" name="file_tanda_tangan" id="file_tanda_tangan" accept=".png, .jpg, .jpeg">
                      <input type="hidden" name="cancel_tanda_tangan">
                    </label>
                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="" data-original-title="Cancel">
                      <i class="ki ki-bold-close icon-xs text-muted"></i>
                    </span>
                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                      <i class="ki ki-bold-close icon-xs text-muted"></i>
                    </span>
                  </div>
                </div>
              </div>
              <!--end::Group-->
              <!--begin::Group-->
              <div class="form-group row">
                <label class="col-form-label col-3 text-lg-right text-left">NIPP</label>
                <div class="col-9">
                  <input class="form-control form-control-lg form-control-solid" type="text" name="nipp" value="<?= $user_detail[0]['NIPP'] ?>">
                </div>
              </div>
              <!--end::Group-->
              <!--begin::Group-->
              <div class="form-group row">
                <label class="col-form-label col-3 text-lg-right text-left">Nama</label>
                <div class="col-9">
                  <input class="form-control form-control-lg form-control-solid" type="text" name="nama" value="<?= $user_detail[0]['NAMA'] ?>">
                </div>
              </div>
              <!--end::Group-->
              <!--begin::Group-->
              <div class="form-group row">
                <label class="col-form-label col-3 text-lg-right text-left">Jabatan</label>
                <div class="col-9">
                  <input class="form-control form-control-lg form-control-solid" type="text" name="jabatan" value="<?= $user_detail[0]['NAMA_JABATAN'] ?>">
                </div>
              </div>
              <!--end::Group-->
              <div class="form-group row">
                <label class="col-form-label col-3 text-lg-right text-left">Divisi</label>
                <div class="col-9">
                  <input class="form-control form-control-lg form-control-solid" type="text" name="divisi" value="<?= $user_detail[0]['NAMA_DIVISI'] ?>">
                </div>
              </div>
            </div>
          </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-light-primary font-weight-bold">Save changes</button>
            <a href="<?= base_url() ?>master/tanda_tangan/" class="btn btn-clean font-weight-bold">Cancel</a>
          </div>
        </div>
        </form>
        <!--end::Card-->
      <!--end::Dashboard-->
    </div>
    <!--end::Container-->
  </div>
  <!--end::Entry-->
</div>
<!--end::Content-->
<script type="text/javascript">
$('#file_tanda_tangan').change(function(){
  var files = this.files;
  $(files).each(function(index, file) {
    // Still don't know why you want this...
    var fakepath = 'C:\\fakepath\\';
    $('#kt_user_edit_avatar').css('background-image', "url("+URL.createObjectURL(file)+")");
  });
});
</script>