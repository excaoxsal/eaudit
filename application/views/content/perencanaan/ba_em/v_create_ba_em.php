<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <div class="d-flex align-items-center flex-wrap mr-2">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Perencanaan</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Notulen Entrance Meeting</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Create</span>
      </div>
    </div>
  </div>
  <div class="d-flex flex-column-fluid">
    <div class="container">

        <form class="form" id="form" method="post" enctype="multipart/form-data">  
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

					<div class="form-group row">
                    	<label class="col-form-label col-3 text-right">Nomor SPA</label>
	                    <div class="col-8">
	                      	<div class="form-label">
								<select <?= $disabled ?> class="form-control" id="id_spa" name="ID_SPA" required>
				                    <option value="">--Pilih Nomor--</option>
				                    <?php 
				                    foreach ($nomor_spa as $nomor) { ?>
				                      <option <?= $nomor['ID_SPA'] == $id_spa ? 'selected' : '' ; ?> value="<?= $nomor['ID_SPA'] ?>"><?= $nomor['NOMOR_SURAT'] ?></option>
				                    <?php } ?>
				                </select>
							</div>
	                    </div>
	                </div>
					<div class="form-group row">
			            <label class="col-form-label col-3 text-right">Tanggal</label>
			            <div class="col-8">
			              <div class="form-label">
			                <div class="input-icon input-icon-right mb-2">
			                  <input autocomplete="off" placeholder="Tanggal" type="text" value="<?= $data_ba_em->TANGGAL ?>" name="TANGGAL" required class="form-control datepicker w-100">
			                  <span>
			                    <i class="fa fa-calendar"></i>
			                  </span>
			                </div>
			              </div>
			            </div>
					</div>
			        <div class="form-group row">
			            <label class="col-form-label col-3 text-right">Waktu</label>
			            <div class="col-8">
			              <input type="text" class="form-control" placeholder="Waktu"  name="WAKTU" id="WAKTU"  value="<?= $data_ba_em->WAKTU ?>">
			            </div>
			        </div>
					<div class="form-group row">
						<label class="col-form-label col-3 text-right">Tempat</label>
						<div class="col-8">
              				<input type="text" class="form-control" placeholder="Tempat"  name="TEMPAT" id="TEMPAT"  value="<?= $data_ba_em->TEMPAT ?>">
						</div>
					</div>

					<div id="list_pengawas">
						<div class="form-group row">
							<label class="col-form-label col-3 text-right">Penyelenggara Rapat</label>
							<div class="col-8">
								<div class="form-label">
									<select class="form-control" id="id_divisi" name="ID_DIVISI" required>
			                          <option value="">--Pilih Auditee--</option>
			                          <?php foreach($list_divisi as $divisi){ ?>
			                          <option <?= $divisi['ID_DIVISI'] == $data_ba_em->ID_DIVISI ? 'selected' : '' ; ?> value="<?= $divisi['ID_DIVISI'] ?>"><?= $divisi['NAMA_DIVISI'] ?></option>
			                          <?php } ?>
			                        </select>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-3 text-right">Judul Rapat</label>
						<div class="col-8">
              				<input type="text" class="form-control" placeholder="Judul Rapat"  name="JUDUL" id="JUDUL"  value="<?= $data_ba_em->TEMPAT ?>">
						</div>
					</div>
					<div id="list_auditee">
            			<div class="form-group row">
             	 		<label class="col-form-label col-3 text-right">Peserta Rapat</label>
							<div class="col-8">
								<input type="text" class="form-control" placeholder="Peserta Rapat" name="PESERTA[]" id="nama_auditee" value="<?= $peserta[0]['NAMA']  ?>">
              				</div>
             			 	<div class="col-1">
                				<span style="cursor: pointer;" name="add_auditee" id="add_auditee" class="label font-weight-bold label-lg label-success label-inline mt-2">+</span><br>
							</div>
							
            			</div>
					</div>

					<div class="form-group row">
						<label class="col-form-label col-3 text-right">Pokok-Pokok Bahasan Rapat</label>
						<div class="col-8">
							<textarea id="DETAIL_A" name="DETAIL_A"></textarea>
						</div>
					</div>

					<?php if(isset($_GET['review'])){ ?>
						<div class="form-group row">
							<label class="col-form-label col-3 text-right">Komentar</label>
							<div class="col-8">
								<div id="editor-k" style="height: 100px;overflow: auto;"></div>
								<input type="hidden"  name="KOMENTAR" id="KOMENTAR">
							</div>
						</div>
					<?php } ?>
					<div class="separator separator-dashed mb-5"></div>
					<div class="form-group row">
						<label class="col-form-label col-3 text-right"></label>
						<div class="col-8">
						<button type="submit" class="btn btn-light-primary font-weight-bold">Generate</button>
              			<a href="<?= base_url() ?>/perencanaan/ba_em" class="btn btn-light-danger font-weight-bold">Kembali</a>
						</div>
					</div>
				</div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">

$(document).ready(function(){
	set_tinymce('DETAIL_A','<?= trim(preg_replace('/\s\s+/', ' ', $data_ba_em->DETAIL_A)) ?>');
	$('#id_divisi, #id_spa').select2().on('change', function (e) { $(this).valid() } );
	$("#form").validate({
  		errorClass: 'text-danger is-invalid',
  		submitHandler: function () {
	    	Swal.fire({
				text: 'Apakah Anda yakin generate data ini?',
				icon: 'question',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya',
				cancelButtonText: 'Batal'
				}).then((result) => {
				if (result.value) {
					$.ajax({
						url: '<?= base_url() ?>perencanaan/ba_em/generate?id=<?= base64_encode($data_ba_em->ID_BA_EM) ?>',
						type: 'post',
						data: $("#form").serialize(),
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						success: function(data) {
							if(data == "error"){
								Swal.fire("Gagal menyimpan data!", "Pastikan kebutuhan data terpenuhi!", "error");
							}else{
								window.open("<?php echo base_url() ?>"+'perencanaan/ba_em/cetak_preview?id='+btoa(data), '_blank');
								window.location = '<?= base_url() ?>/perencanaan/ba_em/';
							}
						},
						error: function(data){
							Swal.fire("Gagal menyimpan data!", "Pastikan kebutuhan data terpenuhi!", "error");
						}
					});
				}
			}) 
  		}
	});

	var i = 1;
	var peserta = '<?= json_encode($peserta) ?>';
	peserta = JSON.parse(peserta);
	if (peserta) {
		peserta.splice(0, 1);
		peserta.forEach(element => {
			i++
			$('#list_auditee').append('<div class="form-group row" id="row'+i+'"><label class="col-form-label col-3 text-right"></label><div class="col-8"><input type="text" class="form-control" placeholder="Peserta Rapat" value="'+element.NAMA+'" name="PESERTA[]" id="nama_auditee" value=""></div><div class="col-1"><span style="cursor: pointer;" name="remove" id="'+i+'" class="btn-remove label font-weight-bold label-lg label-danger label-inline mt-2">-</span><br></div></div>');
		});
	}

	$('#add_auditee').click(function(){
	  i++;
	  $('#list_auditee').append('<div class="form-group row" id="row'+i+'"><label class="col-form-label col-3 text-right"></label><div class="col-8"><input type="text" class="form-control" placeholder="Peserta Rapat" name="PESERTA[]" id="nama_auditee" value=""></div><div class="col-1"><span style="cursor: pointer;" name="remove" id="'+i+'" class="btn-remove label font-weight-bold label-lg label-danger label-inline mt-2">-</span><br></div></div>');
	});
	
	$(document).on('click', '.btn-remove', function(){
	  var button_id   = $(this).attr("id");
	  $("#row"+button_id+"").remove();
	}); 
});

</script>
