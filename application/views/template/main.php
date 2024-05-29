<!DOCTYPE html>

<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>

  <meta charset="utf-8" />
  <title><?= APK_NAME ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

  <link href="<?= base_url('assets/css/custom.css') ?>" rel="stylesheet" type="text/css" />

  <link href="<?= base_url('assets/plugins/global/plugins.bundle7a50.css') ?>" rel="stylesheet" type="text/css" />
  <link href="<?= base_url('assets/plugins/custom/prismjs/prismjs.bundle7a50.css') ?>" rel="stylesheet" type="text/css" />
  <link href="<?= base_url('assets/css/style.bundle7a50.css') ?>" rel="stylesheet" type="text/css" />

  <link href="<?= base_url('assets/css/themes/layout/header/base/light7a50.css') ?>" rel="stylesheet" type="text/css" />
  <link href="<?= base_url('assets/css/themes/layout/header/menu/light7a50.css') ?>" rel="stylesheet" type="text/css" />
  <link href="<?= base_url('assets/css/themes/layout/brand/light7a50.css') ?>" rel="stylesheet" type="text/css" />
  <link href="<?= base_url('assets/css/themes/layout/aside/light7a50.css') ?>" rel="stylesheet" type="text/css" />
  <script src="https://kit.fontawesome.com/158ead05c1.js" crossorigin="anonymous"></script>
  <script src="https://cdn.tiny.cloud/1/jifstdyvbxfuj36bqjivg4fsavgqqvvgoyltmvj5w1pq188t/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
  <!-- <script src="<?= base_url('assets/vendor/tinymce/js/tinymce/tinymce.min.js') ?>"></script> -->
  <script src="<?= base_url('assets/jquery/jquery.min.js') ?>"></script>

  <link rel="shortcut icon" href="<?= base_url('assets/img/logos/favicon-ptp.png') ?>" />
</head>
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">

<div id="loadingDiv" class="text-center"><span class="spinner-grow text-primary"></span></div>

  <div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">

    <a href="#">
      <img alt="Logo" width="120" src="<?= base_url() ?>assets/img/logos/ptp.png" />
    </a>

    <div class="d-flex align-items-center">

      <button class="btn p-0" id="kt_aside_mobile_toggle">
        <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-align-right"><line x1="21" y1="10" x2="7" y2="10"></line><line x1="21" y1="6" x2="3" y2="6"></line><line x1="21" y1="14" x2="3" y2="14"></line><line x1="21" y1="18" x2="7" y2="18"></line></svg></span>
      </button>

      <button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
        <span class="svg-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
        </span>
      </button>
    </div>
  </div>

  <div class="d-flex flex-column flex-root">

    <div class="d-flex flex-row flex-column-fluid page">
      <div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
        <div class="brand flex-column-auto" id="kt_brand">
          <a href="#" class="brand-logo">
            <img alt="Logo" width="150" src="<?= base_url() ?>assets/img/logos/ptp-md.png" />
          </a>
          <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
            <span class="svg-icon svg-icon svg-icon-xl">
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <polygon points="0 0 24 0 24 24 0 24" />
                  <path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
                  <path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
                </g>
              </svg>
            </span>
          </button>
        </div>

        <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">

          <?php $this->load->view('template/sidebar') ?>
        
        </div>

      </div>
      <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

        <div id="kt_header" class="header header-fixed">
          <div class="container-fluid d-flex align-items-stretch justify-content-between">
            <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
              <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                <div class="nav nav-dark">
                  <a href="#" class="nav-link pl-0 pr-5"><?= $this->session->userdata('NAMA_DIVISI') ?></a>
                </div>
              </div>
            </div>
             <div class="topbar">
              <span class="font-size-base d-md-none d-inline mr-5 my-auto"><?= $this->session->userdata('NAMA_DIVISI') ?></span>
              <?php $this->load->view('template/topbar') ?>
             </div>
          </div>
        </div>

      <?php $this->load->view($content) ?>

      <div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
        <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
          <div class="text-dark order-2 order-md-1">
            <p class="nav-link pl-0 pr-5"><?= COMPANY ?></p>
          </div>
          <div class="nav nav-dark">
            <p class="nav-link pl-0 pr-5"><?= APK_NAME ?> <?= APK_VER ?></p>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<div id="kt_scrolltop" class="scrolltop">
 <span class="svg-icon">
   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up text-white"><polyline points="18 15 12 9 6 15"></polyline></svg>
 </span>
</div>

<script>
 var KTAppSettings = {"breakpoints":{"sm":576,"md":768,"lg":992,"xl":1200,"xxl":1400},"colors":{"theme":{"base":{"white":"#ffffff","primary":"#3699FF","secondary":"#E5EAEE","success":"#1BC5BD","info":"#8950FC","warning":"#FFA800","danger":"#F64E60","light":"#E4E6EF","dark":"#181C32"},"light":{"white":"#ffffff","primary":"#E1F0FF","secondary":"#EBEDF3","success":"#C9F7F5","info":"#EEE5FF","warning":"#FFF4DE","danger":"#FFE2E5","light":"#F3F6F9","dark":"#D6D6E0"},"inverse":{"white":"#ffffff","primary":"#ffffff","secondary":"#3F4254","success":"#ffffff","info":"#ffffff","warning":"#ffffff","danger":"#ffffff","light":"#464E5F","dark":"#ffffff"}},"gray":{"gray-100":"#F3F6F9","gray-200":"#EBEDF3","gray-300":"#E4E6EF","gray-400":"#D1D3E0","gray-500":"#B5B5C3","gray-600":"#7E8299","gray-700":"#5E6278","gray-800":"#3F4254","gray-900":"#181C32"}},"font-family":"Poppins"};
</script>


<script src="<?= base_url('assets/plugins/global/plugins.bundle7a50.js') ?>"></script>
<script src="<?= base_url('assets/plugins/custom/prismjs/prismjs.bundle7a50.js') ?>"></script>
<script src="<?= base_url('assets/js/scripts.bundle7a50.js') ?>"></script>

<script src="<?= base_url('assets/plugins/custom/datatables/datatables.bundle7a50.js') ?>"></script>
<script src="<?= base_url('assets/js/dateFormat.js') ?>"></script>
<script src="<?= base_url('assets/vendor/validate/jquery.validate.js') ?>"></script>
<script type="text/javascript">
    $(document).on('change', '.custom-file-input', function() {
      var fileName = $(this).val().split("\\").pop();
      $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>
<script type="text/javascript">
  'use strict';
 
Promise.allSettled = Promise.allSettled || ((promises) => Promise.all(promises.map(p => p
  .then(v => ({
    status: 'fulfilled',
    value: v,
  }))
  .catch(e => ({
    status: 'rejected',
    reason: e,
  }))
)));

</script>
<script type="text/javascript">

const Toast = Swal.mixin({
  toast: true
})

const ToastTopRightTimer = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

selectRefresh();
// $('.select-dua').select2().on('change', function (e) {} );
function selectRefresh() {
  $('.select-dua').select2({
    //-^^^^^^^^--- update here
    // tags: true,
    placeholder: "Select an Option",
    allowClear: true,
    width: '100%'
  });
}

$('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    clearBtn: true,
    // todayBtn: 'linked',
    todayHighlight: true
}).on("focus", function() {
    $(this).prop('readonly', true);
}).on("change", function() {
    // $(this).valid();
});

$('.datepicker-year').datepicker({
    autoclose: true,
    clearBtn: true,
    format: "yyyy",
    weekStart: 1,
    orientation: "bottom",
    language: "{{ app.request.locale }}",
    keyboardNavigation: false,
    viewMode: "years",
    minViewMode: "years"
}).on("focus", function() {
    $(this).prop('readonly', true);
}).on("change", function() {
    // $(this).valid();
});

function logout() {
  Swal.fire({
    text: 'Apakah Anda yakin akan logout?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.value) {
      let timerInterval
      Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Logout Berhasil',
        showConfirmButton: false,
        timer: 1500,
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
        if (result.dismiss === Swal.DismissReason.timer) {
          window.location.href = "<?= base_url('home/logout') ?>";
        }
      })
    }
  })
}

function set_tinymce(tmce_id, value='', mode='')
{
  tinymce.init({
    selector: 'textarea#'+tmce_id,
    height : "200",
    plugins: "image link lists charmap table preview importcss searchreplace autolink directionality visualblocks image link codesample code table charmap pagebreak nonbreaking insertdatetime advlist lists help charmap quickbars", 
    toolbar: "formatgroup editgroup paragraphgroup insertgroup",
    toolbar_groups: {
        formatgroup: {
            icon: 'format',
            tooltip: 'Formatting',
            items: 'bold italic underline strikethrough | bullist numlist | forecolor backcolor | superscript subscript | preview removeformat'
        },
        editgroup: {
            icon: 'edit-block',
            tooltip: 'Edit',
            items: 'undo redo | copy paste cut pastetext | selectall searchreplace'
        },
        paragraphgroup: {
            icon: 'paragraph',
            tooltip: 'Paragraph format',
            items: 'h1 h2 h3 h4 h5 h6 | alignleft aligncenter alignright alignjustify | indent outdent | ltr rtl'
        },
        insertgroup: {
            icon: 'plus',
            tooltip: 'Insert',
            items: 'table image charmap pagebreak hr insertdatetime | link codesample code'
        }
    },
    // skin: 'naked',
    // content_style: "ol, ul { padding-left: 15px!important; }",
    // toolbar_location: 'bottom',
    menubar: false,
    file_picker_callback: function (cb, value, meta) {
      var input = document.createElement('input');
      input.setAttribute('type', 'file');
      input.setAttribute('accept', 'image/*');
      input.onchange = function () {
        var file = this.files[0];
        var reader = new FileReader();
        reader.onload = function () {
        var id = 'blobid' + (new Date()).getTime();
        var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
        var base64 = reader.result.split(',')[1];
        var blobInfo = blobCache.create(id, file, base64);
        blobCache.add(blobInfo);
        cb(blobInfo.blobUri(), { title: file.name });
      };
      reader.readAsDataURL(file);
      };
      input.click();
    },
    setup: function(editor) {
      editor.on('init', function(e) {
        editor.setContent(value);
        editor.mode.set(mode);
      }).on('change', function(e) {
          validateTinyMCE(editor);
          editor.save();
      }).on('submit', function(e) {
          validateTinyMCE(editor);
      });
    }
  });
}

function validateTinyMCE(selector)
{
  if($('#'+selector.id).prop('required') == true)
  {
    if(selector.getContent()=='')
    {
      $('#'+selector.id).next().addClass('is-invalid text-danger');
      $('#'+selector.id).parent().next().html("<small class='text-danger'>This field is required.</small>");
    }else{
      $('#'+selector.id).next().removeClass('is-invalid text-danger');
      $('#'+selector.id).parent().next().html("<div></div>");
    }
  }
}

async function prosesDataMaster(url)
{
  const proses = $.ajax({
    url : url,
    method : "POST",
    data : $('#form').serialize(),
    success: function(data){ 
      if(data=='OK')
        return true;
      else if(data=='exists')
        ToastTopRightTimer.fire({ icon: 'error', title: 'Proses Gagal! NIPP'+$('#nipp').val()+' telah terdaftar.' })
      else
        ToastTopRightTimer.fire({ icon: 'error', title: 'Proses Gagal! Internal Server Error.' })
    }, 
    error: function(data) { 
      var status = data.status+' '+ data.statusText;
      ToastTopRightTimer.fire({ icon: 'error', title: 'Proses Gagal! '+status+'.' });
    }
  });
  return proses;
}
</script>
</body>
</html>
       