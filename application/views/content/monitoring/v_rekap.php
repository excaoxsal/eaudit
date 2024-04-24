    <link href="<?= base_url() ?>assets/css/pages/wizard/wizard-27a50.css" rel="stylesheet" type="text/css" />

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <div class="d-flex align-items-center flex-wrap mr-2">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Monitoring</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Rekap</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Rekap Bulanan Monitoring TL SPI</span>
      </div>
    </div>
  </div>
  <div class="d-flex flex-column-fluid">
    <div class="container">
      <div class="card card-custom">
        <div class="card-body p-0">
          <div class="wizard wizard-2" id="kt_wizard" data-wizard-state="step-first" data-wizard-clickable="false">

            <div class="wizard-nav border-right py-8 px-8 py-lg-20 px-lg-10">
              <div class="wizard-steps">
                <div class="wizard-step" data-wizard-type="step">
                  <div class="wizard-wrapper">
                    <div class="wizard-icon">
                      <i class="fa fa-file-alt" style="font-size: 20px;"></i>
                    </div>
                    <div class="wizard-label">
                      <h3 class="wizard-title">Data Audit</h3>
                      <div class="wizard-desc">Rekap Bulanan Monitoring TL SPI</div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <div class="wizard-body py-8 px-8 py-lg-20 px-lg-10">
              <div class="row">
                <div class="offset-xxl-1 col-xxl-10">
                  <form class="form" id="kt_form">
                    <div class="pb-5" data-wizard-type="step-content">
                      <h4 class="mb-10 font-weight-bold text-dark"><?= $title ?></h4>
                      <h6 class="font-weight-bolder mb-3">Data Rekap:</h6>
                      <div class="text-dark-50 line-height-lg">
                        <table border="0">
                          <tr>
                            <td>Tahun </td>
                            <td><div class="ml-3 mr-2">: </div></td>
                            <td><div id="tahun"></div></td>
                          </tr>
                          <tr>
                            <td>Bulan</td>
                            <td><div class="ml-3 mr-2">: </div></td>
                            <td><div id="bulan"></div></td>
                          </tr>
                          <tr class="d-none">
                            <td>Status</td>
                            <td><div class="ml-3 mr-2">: </div></td>
                            <td>
                              <select class="form-control cursor-pointer" id="status" style="height: 20px;font-size: 12px;padding: 0;">
                                <option value="">All</option>
                                <option value="SELESAI">Selesai</option>
                              </select>
                            </td>
                          </tr>
                        </table>
                      </div>
                      <div class="separator separator-dashed my-5"></div>
                      <h6 class="font-weight-bolder mb-3">File:</h6>
                      <div class="text-dark-50 line-height-lg">
                        <div class="form-inline">
                          <div id="nama_file"></div>
                          <div>.pdf</div>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex justify-content-between border-top mt-5 pt-10">
                      <div class="mr-2">
                      </div>
                      <div>
                        <button type="button" onclick="cetak()" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-submit">Download</button>
                        <button type="button" onclick="cetakPersen()" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-submit">Download (%)</button>
                        <button type="button" onclick="next()" class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-next">Next</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
 <script src="<?= base_url() ?>assets/js/pages/custom/user/edit-user7a50.js"></script>
 <script src="<?= base_url() ?>assets/js/pages/custom/wizard/wizard-27a50.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    const date = new Date();
    const tahun_val = date.getFullYear();
    const bulan_val = date.getMonth() + 1;
    var bulan_str
    if (bulan_val == 1) bulan_str = 'Januari';
    if (bulan_val == 2) bulan_str = 'Februari';
    if (bulan_val == 3) bulan_str = 'Maret';
    if (bulan_val == 4) bulan_str = 'April';
    if (bulan_val == 5) bulan_str = 'Mei';
    if (bulan_val == 6) bulan_str = 'Juni';
    if (bulan_val == 7) bulan_str = 'Juli';
    if (bulan_val == 8) bulan_str = 'Agustus';
    if (bulan_val == 9) bulan_str = 'September';
    if (bulan_val == 10) bulan_str = 'Oktober';
    if (bulan_val == 11) bulan_str = 'November';
    if (bulan_val == 12) bulan_str = 'Desember';
    bulan.innerHTML = bulan_str;
    tahun.innerHTML = tahun_val;
    var nama_file = document.getElementById('nama_file');
    nama_file.innerHTML = 'REKAP_TL_' + bulan_val + '_' + tahun_val;
  })

  function next() {
    var bulan = document.getElementById('bulan');
    var bulan_val = document.getElementById('bulan_val').value;
    var tahun = document.getElementById('tahun');
    var tahun_val = document.getElementById('tahun_val').value;
    if (bulan_val == '') {
      Swal.fire("Proses Data Gagal!", "Bulan tidak boleh kosong!", "error").then((result) => {
        if (result.value) {
          location.reload();
        }
      })
    }
    if (tahun_val == '') {
      Swal.fire("Proses Data Gagal!", "Tahun tidak boleh kosong!", "error").then((result) => {
        if (result.value) {
          location.reload();
        }
      })
    }
    var bulan_str
    if (bulan_val == 1) bulan_str = 'Januari';
    if (bulan_val == 2) bulan_str = 'Februari';
    if (bulan_val == 3) bulan_str = 'Maret';
    if (bulan_val == 4) bulan_str = 'April';
    if (bulan_val == 5) bulan_str = 'Mei';
    if (bulan_val == 6) bulan_str = 'Juni';
    if (bulan_val == 7) bulan_str = 'Juli';
    if (bulan_val == 8) bulan_str = 'Agustus';
    if (bulan_val == 9) bulan_str = 'September';
    if (bulan_val == 10) bulan_str = 'Oktober';
    if (bulan_val == 11) bulan_str = 'November';
    if (bulan_val == 12) bulan_str = 'Desember';
    bulan.innerHTML = bulan_str;
    tahun.innerHTML = tahun_val;
    var nama_file = document.getElementById('nama_file');
    nama_file.innerHTML = 'REKAP_TL_' + bulan_val + '_' + tahun_val;
  }

  function download() {
    const date = new Date();
    const tahun_val = date.getFullYear();
    const bulan_val = date.getMonth() + 1;
    window.location.href = '<?= base_url() ?>monitoring/rekap/export/' + bulan_val + '/' + tahun_val;
  }

  function cetak() {
    const date = new Date();
    const tahun_val = date.getFullYear();
    const bulan_val = date.getMonth() + 1;
    const status    = $('#status').val();
    window.open("<?php echo base_url() ?>" + 'monitoring/rekap/cetak/' + bulan_val + '/' + tahun_val + '/'+ status, '_blank');
  }
  function cetakPersen() {
    const date = new Date();
    const tahun_val = date.getFullYear();
    const bulan_val = date.getMonth() + 1;
    const status    = $('#status').val();
    window.open("<?php echo base_url() ?>" + 'monitoring/rekap/cetak_persen/' + bulan_val + '/' + tahun_val + '/'+ status, '_blank');
  }
</script>