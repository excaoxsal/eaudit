<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>

		<meta charset="utf-8" />
		<title><?= APK_NAME ?></title>
		<meta name="description" content="Login page example" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<link href="<?= base_url('assets/css/custom.css') ?>" rel="stylesheet" type="text/css" />
		<link href="<?= base_url() ?>assets/css/pages/login/login-17a50.css" rel="stylesheet" type="text/css" />

		<link href="<?= base_url() ?>assets/plugins/global/plugins.bundle7a50.css" rel="stylesheet" type="text/css" />
		<link href="<?= base_url() ?>assets/plugins/custom/prismjs/prismjs.bundle7a50.css" rel="stylesheet" type="text/css" />
		<link href="<?= base_url() ?>assets/css/style.bundle7a50.css" rel="stylesheet" type="text/css" />

		<link href="<?= base_url() ?>assets/css/themes/layout/header/base/light7a50.css" rel="stylesheet" type="text/css" />
		<link href="<?= base_url() ?>assets/css/themes/layout/header/menu/light7a50.css" rel="stylesheet" type="text/css" />
		<link href="<?= base_url() ?>assets/css/themes/layout/brand/dark7a50.css" rel="stylesheet" type="text/css" />
		<link href="<?= base_url() ?>assets/css/themes/layout/aside/dark7a50.css" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="<?= base_url() ?>assets/img/logos/favicon-ptp.png" />
	</head>

	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">

		<noscript>
			<iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5FS8GGP" height="0" width="0" style="display:none;visibility:hidden"></iframe>
		</noscript>

		<div class="d-flex flex-column flex-root">
			<div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
				
				<div class="login-aside d-flex flex-column flex-row-auto" style="background: url(<?= base_url() ?>assets/img/bg/bg-login-gg.jpg) no-repeat; background-size: cover;">
					<!-- <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
					</div> -->
				</div>
				<div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
		
					<div class="d-flex flex-column-fluid flex-center">
						<div class="login-form login-signin">
	
							<form method="post" id="form">
								<div class="pb-13 pt-lg-0 pt-5">
									<div class="d-flex flex-center mb-5">
									<a href="#">
										<img src="<?= base_url() ?>assets/img/logos/ptp.png" class="max-h-75px" alt="" />
									</a>
								</div>
									<h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg text-center"><?= APK_NAME ?></h3>
								</div>
								<?= $this->session->flashdata('message'); ?>
								<div class="form-label">
									<input required class="form-control form-control-solid h-auto py-5 px-6 rounded-lg" type="text" placeholder="NIPP" name="nipp" id="nipp" autocomplete="off" />
								</div>
								<div class="mb-5"></div>
								<div class="form-label">
									<input required class="form-control form-control-solid h-auto py-5 px-6 rounded-lg" type="password" placeholder="Password" name="password" id="password" autocomplete="off" />
								</div>
									<div class="mb-2"></div>
								<div class="form-label form-inline justify-content-end">
									<label class="font-size-h6 text-dark mr-3">Show Password</label>
									<span class="switch switch-sm">
								    <label>
								     <input type="checkbox" onclick="showPassowrd()" name="select"/>
								     <span></span>
								    </label>
								   </span>
								</div>
								<div class="mb-10"></div>
								<div class="d-flex justify-content-start mt-n5">
								<div class="form-label">
									
								</div>
								</div>
								<div class="pb-lg-0 pb-5">
									<button type="submit" id="btn-login" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Sign In</button>
								</div>
							</form>
						</div>
					</div>
					<div class="d-flex justify-content-lg-start justify-content-center align-items-end py-7 py-lg-0">
						<div class="text-dark-50 font-size-lg font-weight-bolder mr-10">
							<span class="mr-1">2021©</span>
							<a class="text-dark-75 text-hover-primary"><?= COMPANY ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
		
		<script src="<?= base_url() ?>assets/jquery/jquery.min.js"></script>
		<script src="<?= base_url() ?>assets/plugins/global/plugins.bundle7a50.js"></script>
		<script src="<?= base_url() ?>assets/plugins/custom/prismjs/prismjs.bundle7a50.js"></script>
		<script src="<?= base_url() ?>assets/js/scripts.bundle7a50.js"></script>
		<script src="<?= base_url() ?>assets/vendor/validate/jquery.validate.js"></script>

		<script type="text/javascript">
			window.onload = function() {
			    $('#nipp').focus();
			    
			    var $recaptcha = document.querySelector('#g-recaptcha-response');

			    if($recaptcha) {
			        $recaptcha.setAttribute("required", "required");
			    }
			};
			function showPassowrd() {
			  var x = document.getElementById("password");
			  if (x.type === "password") {
			    x.type = "text";
			  } else {
			    x.type = "password";
			  }
			}
			$(document).ready(function() {
			  $("#form").validate({
			    errorClass: 'text-danger is-invalid',
			    submitHandler: function () {
			      $.ajax({
		              url : "<?= base_url('auth/verify') ?>",
		              method : "POST",
		              data : $('#form').serialize(),
		              async : true,
		              beforeSend: function() {
				        $('#btn-login').text('Please wait');
				        $('#btn-login').addClass('pr-15 spinner spinner-white spinner-right');
				      },
		              success: function(data){ 
		              	$('#btn-login').text('Sign In');
				        $('#btn-login').removeClass('pr-15 spinner spinner-white spinner-right'); 
		              	if(data=='OK')
		              	{
		              		icon = 'success';
		              		title = 'Login Berhasil'; 
		              		text = ''; 
		              		timer = 1500;
		              	}else{
		                	icon = 'error';
		              		title = 'Login Gagal'; 
		              		text = data;
		              		timer = 3000; 
		              	}
		              	let timerInterval
		                Swal.fire({
		                  position: 'center',
		                  icon: icon,
		                  title: title,
		                  text: text,
		                  showConfirmButton: false,
		                  timer: timer,
		                  onBeforeOpen: () => {
		                    timerInterval = setInterval(() => {
		                      const content = Swal.getContent()
		                      if (content) {
		                        const b = content.querySelector('b')
		                        if (b) {
		                          b.textContent = Swal.getTimerLeft()
		                        }
		                      }
		                    }, 100)
		                  },
		                  onClose: () => {
		                    clearInterval(timerInterval)
		                  }
		                }).then((result) => {
		                  if (result.dismiss) {
		                    location.reload();
		                  }
		                })
		              },
		              error: function(data) { 
					      var status = data.status+' '+ data.statusText;
					      Swal.fire(status,'Login Gagal! Silakan hubungi Admin.', 'error');
					      $('#btn-login').text('Sign In');
				          $('#btn-login').removeClass('pr-15 spinner spinner-white spinner-right'); 
					  }
		          });  
			    }
			  });

			});
		</script>
	</body>
</html>