<style type="text/css">
  .offcanvas.offcanvas-right {
    right: -500px;
}
</style>
<div class="topbar-item mr-6">
  <?php // if($is_auditor){ ?>
  <div class="btn btn-icon btn-clean btn-lg mr-1" id="kt_quick_panel_toggle">
    <span class="svg-icon svg-icon-primary">
      <div class="btn btn-icon btn-clean text-dark btn-dropdown btn-lg mr-1 pulse pulse-primary">
        <div>

          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
          <span class="label font-weight-bold label-lg label-light-danger label-inline" style="border-radius: 100%;position: absolute;top: 0; z-index: 1000;">
            <?php
            if ($total_notif > 0) echo $total_notif;
            else echo 0;
            ?>
          </span>
        </div>
        <?php if ($total_notif > 0) { ?>
          <span class="pulse-ring"></span>
        <?php } ?>
      </div>
    </span>
  </div>
  <?php // } ?>
</div>
<div id="kt_quick_panel" style="width:500px;"  class="offcanvas offcanvas-right pt-5 pb-10">

  <div class="offcanvas-header offcanvas-header-navs d-flex align-items-center justify-content-between mb-5">
    <ul class="nav nav-bold nav-tabs nav-tabs-line nav-tabs-line-3x nav-tabs-primary flex-grow-1 px-10" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#log_spa">List Temuan Detail (<?= $total_atasanAuditee ?>)</a>
      </li>
    </ul>
    <div class="offcanvas-close mt-n1 pr-5">
      <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_panel_close">
        <i class="ki ki-close icon-xs text-muted"></i>
      </a>
    </div>
  </div>

  <div class="offcanvas-content px-10" style="height: 85vh;overflow: auto;">
    <div class="tab-content">
      <div class="tab-pane fade show pt-3 pr-5 mr-n5 active" id="log_spa" role="tabpanel">

        <?php if ($total_atasanAuditee < 1) { ?>
          <div class="d-flex align-items-center bg-light-secondary rounded p-5 mb-5">
            <div class="d-flex flex-column flex-grow-1 mr-2">
              <span class="font-weight-normal text-dark-75 font-size-lg mb-1">Tidak ada notifikasi.</span>
            </div>
          </div>
        <?php } ?>

        <?php foreach ($notif_atasanAuditee as $data) { ?>
          <div class="d-flex align-items-center bg-light-success rounded p-5 mb-5">
            <div class="d-flex flex-column flex-grow-1 mr-2">
              <a href="<?= base_url() ?>aia/temuan/detail/<?= $data['ID_RESPONSE'] ?>" class="font-weight-normal text-dark-75 text-hover-primary font-size-lg mb-1">TEMUAN</a>
              <!-- <span class="text-muted font-size-sm"><?= tgl_indo($data['PADA_TANGGAL']) ?></span> -->
            </div>
          </div>
        <?php } ?>
      </div>
      <div class="tab-pane fade show pt-3 pr-5 mr-n5" id="log_apm" role="tabpanel">
        <?php if ($total_apm < 1) { ?>
          <div class="d-flex align-items-center bg-light-secondary rounded p-5 mb-5">
            <div class="d-flex flex-column flex-grow-1 mr-2">
              <span class="font-weight-normal text-dark-75 font-size-lg mb-1">Tidak ada notifikasi.</span>
            </div>
          </div>
        <?php } ?>
        <?php foreach ($notif_apm as $data) { ?>
          <div class="d-flex align-items-center bg-light-primary rounded p-5 mb-5">
            <div class="d-flex flex-column flex-grow-1 mr-2">
              <a href="<?= base_url() ?>perencanaan/apm/review/<?= $data['ID_APM'] ?>?review=true&sts-approver=1" class="font-weight-normal text-dark-75 text-hover-primary font-size-lg mb-1"><?= $data['NAMA_AUDIT'] ?></a>
              <span class="text-muted font-size-sm"><?= tgl_indo($data['TGL_PERIODE_MULAI']) ?> - <?= tgl_indo($data['TGL_PERIODE_SELESAI']) ?></span>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<div class="dropdown">
  <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" aria-expanded="true">
    <div class="btn btn-icon btn-icon-mobile w-auto btn-clean text-dark d-flex align-items-center btn-lg px-2">
      <span class="svg-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
      </span>
      &nbsp;
      <span class="font-size-base d-none d-md-inline mr-1"><?= $this->session->userdata('NAMA') ?>&nbsp;</span>
    </div>
  </div>
  <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-117px, 65px, 0px);">
    <ul class="navi navi-hover py-4">
      <li class="navi-item">
        <a href="<?= base_url() ?>profile" class="navi-link">
          <span class="navi-text"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>&nbsp;&nbsp;&nbsp;My Profile</span>
        </a>
      </li>
      <li class="navi-item">
        <a href="#" onclick="logout()" class="navi-link">
          <span class="navi-text"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>&nbsp;&nbsp;&nbsp;Logout</span>
        </a>
      </li>
    </ul>
  </div>
</div>