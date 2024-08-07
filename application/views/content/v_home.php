<div class="d-flex flex-row-fluid bgi-size-cover bgi-position-center h-100" style="background: url(<?= base_url('assets/img/bg/auditor.jpg') ?>) no-repeat;background-size: cover;">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center border-bottom border-white py-7">
      <h3 class="h4 text-white mb-0">Hi, <?= $this->session->userdata('NAMA') ?>.</h3>
    </div>
    <div class="d-flex align-items-stretch text-center flex-column py-40">
      <h1 class="text-white font-weight-bolder mb-12">Selamat Datang di <?= APK_NAME ?></h1>
      <!-- <a target="_blank" href="<?= base_url('storage/file/Buku Panduan Penggunaan Aplikasi E-Audit PTP.pdf') ?>" class="btn btn-outline-white px-10 mx-auto font-weight-bolder" style="border:2px solid #fff!important;"><i class="fa fa-file-pdf mr-2"></i>User Guide </a> -->
      <a target="_blank" href="#" class="btn btn-outline-white px-10 mx-auto font-weight-bolder" style="border:2px solid #fff!important;"><i class="fa fa-file-pdf mr-2"></i>User Guide </a>
    </div>
  </div>
</div>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <div class="d-flex align-items-center flex-wrap mr-2">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Home</span>
      </div>
    </div>
  </div>
  <div class="d-flex flex-column-fluid">
    <!-- <form method="post" action="<?= base_url('home/test_send_email') ?>">
      <input type="email" class="form-control" name="email">
      <button type="submit" class="btn btn-primary">Test Send Email</button>
    </form> -->
  </div>
</div>

<?php if($total_notif>0){ ?>
<div class="modal fade" id="modal_notif" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Pemberitahuan</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>Anda memiliki <b><?= $total_notif ?></b> notifikasi yang perlu dikonfirmasi. <br>Klik ikon <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg> untuk memeriksa.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<?php } ?>

<script type="text/javascript">
$(document).ready(function() {
  $('#modal_notif').modal();
})
</script>