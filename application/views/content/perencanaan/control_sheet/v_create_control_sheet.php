<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <div class="d-flex align-items-center flex-wrap mr-2">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Perencanaan</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Control Sheet</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Create</span>
      </div>
    </div>
  </div>
  <div class="d-flex flex-column-fluid">
    <div class="container">
		
        <form class="form" id="form_cs" method="post" enctype="multipart/form-data">  
			<div class="card card-custom">
				<div class="card-header">
		          <div class="card-title">
		            <h3 class="card-label"><?= $title ?></h3>
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
					<h6 class="text-left my-5 mb-10">Header</h6>
					<div class="form-group row">
						<label class="col-form-label col-3 text-left">Nama Audit</label>
						<div class="col-8">
							<input type="text" class="form-control" placeholder="Nama Audit" name="NAMA_AUDIT" value="<?= $data_cs->NAMA_AUDIT ?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-3 text-left">Auditee</label>
						<div class="col-8">
							<!-- <input type="text" class="form-control" placeholder="Auditee" name="AUDITEE" value="<?= $data_cs->AUDITEE ?>"> -->
							<select class="form-control select-dua" id="id_divisi" name="AUDITEE" required>
	                          <option value="">--Pilih Auditee--</option>
	                          <?php foreach($list_divisi as $divisi){ ?>
	                          <option <?= $divisi['NAMA_DIVISI'] == $data_cs->AUDITEE ? 'selected' : '' ; ?> value="<?= $divisi['NAMA_DIVISI'] ?>"><?= $divisi['NAMA_DIVISI'] ?></option>
	                          <?php } ?>
	                        </select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-3 text-left">Periode Audit</label>
						<div class="col-lg-4">
							<div class="form-label">
				                <div class="input-icon input-icon-right mb-2">
				                  <input autocomplete="off" placeholder="Periode Awal" type="text" name="TGL_PERIODE_MULAI" value="<?= $data_cs->TGL_PERIODE_MULAI ?>" class="form-control datepicker w-100">
				                  <span>
				                    <i class="fa fa-calendar"></i>
				                  </span>
				                </div>
				            </div>
						</div>
						<!-- <p class="my-auto">s/d</p> -->
						<div class="col-lg-4">
							<div class="form-label">
				                <div class="input-icon input-icon-right mb-2">
				                  <input autocomplete="off" placeholder="Periode Selesai" type="text" name="TGL_PERIODE_SELESAI" value="<?= $data_cs->TGL_PERIODE_SELESAI ?>" class="form-control datepicker w-100">
				                  <span>
				                    <i class="fa fa-calendar"></i>
				                  </span>
				                </div>
				            </div>
						</div>
					</div>
					<h6 class="text-left my-10 mt-20">Detail</h6>
					<div class="form-group row">
						<div class="col-lg-12">
							<p class="ml-1">A. Surat Perintah Audit telah disusun dan disetujui.</p>
						</div>
						<div class="col-lg-4">
							<input type="text" class="form-control" placeholder="PIC" value="<?= $data_cs->PIC_DISETUJUI == '' ? $ketua_tim : $data_cs->PIC_DISETUJUI;?>" name="PIC_DISETUJUI" id="PIC_DISETUJUI">
						</div>
						<div class="col-lg-4">
							<div class="form-label">
				                <div class="input-icon input-icon-right mb-2">
				                  <input autocomplete="off" placeholder="Tanggal" type="text" name="TGL_DISETUJUI" value="<?= $data_cs->TGL_DISETUJUI ?>" class="form-control datepicker w-100">
				                  <span>
				                    <i class="fa fa-calendar"></i>
				                  </span>
				                </div>
				            </div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-lg-12">
							<p class="ml-1">B. Surat Perintah Audit telah didistribusikan ke auditee, paling tidak pada 4 (empat) hari kerja sebelum penugasan audit dimulai.</p>
						</div>
						<div class="col-lg-4">
							<input type="text" class="form-control" placeholder="PIC" value="<?= $data_cs->PIC_DIDISTRIBUSI ?>" name="PIC_DIDISTRIBUSI" id="PIC_DIDISTRIBUSI">
						</div>
						<div class="col-lg-4">
							<div class="form-label">
				                <div class="input-icon input-icon-right mb-2">
				                  <input autocomplete="off" placeholder="Tanggal" type="text" name="TGL_DIDISTRIBUSI" value="<?= $data_cs->TGL_DIDISTRIBUSI ?>" class="form-control datepicker w-100">
				                  <span>
				                    <i class="fa fa-calendar"></i>
				                  </span>
				                </div>
				            </div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-lg-12">
							<p class="ml-1">C. Audit Planning Memorandum telah disusun, diperbaharui sesuai dengan informasi yang diperoleh selama penugasan audit, direview, dan disetujui.</p>
						</div>
						<div class="col-lg-4">
							<input type="text" class="form-control" placeholder="PIC" name="PIC_APM_DISUSUN" value="<?= $data_cs->PIC_APM_DISUSUN == '' ? $ketua_tim : $data_cs->PIC_APM_DISUSUN;?>" id="PIC_APM_DISUSUN">
						</div>
						<div class="col-lg-4">
							<div class="form-label">
				                <div class="input-icon input-icon-right mb-2">
				                  <input autocomplete="off" placeholder="Tanggal" type="text" name="TGL_APM_DISUSUN" value="<?= $data_cs->TGL_APM_DISUSUN ?>" class="form-control datepicker w-100">
				                  <span>
				                    <i class="fa fa-calendar"></i>
				                  </span>
				                </div>
				            </div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-lg-12">
							<p class="ml-1">D. Risk and Control Matrix termasuk audit program dan pemilihan sampel telah disusun, diperbaharui sesuai dengan informasi yang diperoleh selama penugasan audit, direview, dan disetujui.</p>
						</div>
						<div class="col-lg-4">
							<input type="text" class="form-control" placeholder="PIC" value="<?= $data_cs->PIC_RCM_DISUSUN == '' ? $ketua_tim : $data_cs->PIC_RCM_DISUSUN;?>" name="PIC_RCM_DISUSUN" id="PIC_RCM_DISUSUN">
						</div>
						<div class="col-lg-4">
							<div class="form-label">
				                <div class="input-icon input-icon-right mb-2">
				                  <input autocomplete="off" placeholder="Tanggal" type="text" name="TGL_RCM_DISUSUN" value="<?= $data_cs->TGL_RCM_DISUSUN ?>" class="form-control datepicker w-100">
				                  <span>
				                    <i class="fa fa-calendar"></i>
				                  </span>
				                </div>
				            </div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-lg-12">
							<p class="ml-1">E. Notulen Entrance Meeting telah disusun.</p>
						</div>
						<div class="col-lg-4">
							<input type="text" class="form-control" placeholder="PIC" value="<?= $data_cs->PIC_ENTRANCE_DISUSUN == '' ? $ketua_tim : $data_cs->PIC_ENTRANCE_DISUSUN;?>" name="PIC_ENTRANCE_DISUSUN" id="PIC_ENTRANCE_DISUSUN">
						</div>
						<div class="col-lg-4">
							<div class="form-label">
				                <div class="input-icon input-icon-right mb-2">
				                  <input autocomplete="off" placeholder="Tanggal" type="text" name="TGL_ENTRANCE_DISUSUN" value="<?= $data_cs->TGL_ENTRANCE_DISUSUN ?>" class="form-control datepicker w-100">
				                  <span>
				                    <i class="fa fa-calendar"></i>
				                  </span>
				                </div>
				            </div>
						</div>
					</div>

					<div class="separator separator-dashed mb-5 mt-20"></div>
					<div class="form-group row text-right">
						<div class="col-12">
						<a target="_blank" href="<?= base_url() ?>perencanaan/control_sheet/cetak_preview/<?= $data_cs->ID_SPA ?>" class="btn btn-light-primary font-weight-bold">Preview</a>
						<a onclick="update()" class="btn btn-light-success font-weight-bold">Update</a>
						<a onclick="window.history.go(-1)" class="btn btn-light-danger font-weight-bold">Kembali</a>
						</div>
					</div>
				</div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	function update()
	{
		Swal.fire({
		text: 'Apakah Anda yakin mengupdate data ini ?',
		icon: 'question',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya',
		cancelButtonText: 'Batal'
		}).then((result) => {
		if (result.value) {
			$.ajax({
				url: '<?= base_url() ?>/perencanaan/control_sheet/update?id=<?= json_encode($data_cs->ID_SPA) ?>',
				type: 'post',
				data: $("#form_cs").serialize(),
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success: function(data) {
					window.location = data;
				},
				error: function(data){
					Swal.fire("Gagal menyimpan data!", "Pastikan kebutuhan data terpenuhi!", "error");
				}
			});
			// });
		}
		})
	}
</script>

