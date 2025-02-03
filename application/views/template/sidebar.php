<!-- <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500"> -->

  <ul class="menu-nav">
  <li class="menu-section">
      <h4 id="toggleButton" class="menu-text" >Menu</h4>
      <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
    </li>
    
    <li class="menu-item <?= isset($menu) ? $menu == 'home' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
      <a href="<?= base_url('home') ?>" class="menu-link rounded mx-5 my-1">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" class="mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
        <span class="menu-text">Home</span>
      </a>
    </li>

    <!-- <li class="menu-section">
      <h4 class="menu-text">Menu</h4>
      <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
    </li> -->
    
    <?php if ($is_auditor) { ?>

      <li class="menu-item menu-item-submenu <?= isset($menu) ? $menu == 'master' ? 'menu-item-open menu-item-here' : '' : ''; ?>" aria-haspopup="true" data-menu-toggle="hover">

        <a href="javascript:;" class="menu-link menu-toggle mx-5 my-1 rounded">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" class="mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
          <span class="menu-text">Master</span>
          <i class="menu-arrow"></i>
        </a>

        <div class="menu-submenu">
          <i class="menu-arrow"></i>

          <ul class="menu-subnav">

            <li class="menu-item <?= isset($sub_menu) ? $sub_menu == 'user' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
              <a href="<?= base_url() ?>master/user" class="menu-link mx-5 my-1 rounded">

                <span class="menu-text">User</span>
              </a>
            </li>

            <li class="menu-item <?= isset($sub_menu) ? $sub_menu == 'jabatan' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
              <a href="<?= base_url() ?>master/jabatan" class="menu-link mx-5 my-1 rounded">

                <span class="menu-text">Jabatan</span>
              </a>
            </li>

            <li class="menu-item <?= isset($sub_menu) ? $sub_menu == 'divisi' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
              <a href="<?= base_url() ?>master/divisi" class="menu-link mx-5 my-1 rounded">

                <span class="menu-text">Divisi</span>
              </a>
            </li>
            
            <li class="menu-item <?= isset($sub_menu) ? $sub_menu == 'tanda_tangan' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
              <a href="<?= base_url() ?>master/tanda_tangan" class="menu-link mx-5 my-1 rounded">

                <span class="menu-text">Tanda Tangan</span>
              </a>
            </li>
            
            <li class="menu-item <?= isset($sub_menu) ? $sub_menu == 'jenis_audit' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
              <a href="<?= base_url() ?>master/jenis_audit" class="menu-link mx-5 my-1 rounded">

                <span class="menu-text">Jenis Audit</span>
              </a>
            </li>
            
            <li class="menu-item <?= isset($sub_menu) ? $sub_menu == 'tingkat_resiko' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
              <a href="<?= base_url() ?>master/tingkat_resiko" class="menu-link mx-5 my-1 rounded">

                <span class="menu-text">Tingkat Resiko</span>
              </a>
            </li>
            
            <li class="menu-item <?= isset($sub_menu) ? $sub_menu == 'resiko_desc' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
              <a href="<?= base_url() ?>master/resiko_desc" class="menu-link mx-5 my-1 rounded">

                <span class="menu-text">Resiko</span>
              </a>
            </li>
            
            <li class="menu-item <?= isset($sub_menu) ? $sub_menu == 'tipe_kontrol' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
              <a href="<?= base_url() ?>master/tipe_kontrol" class="menu-link mx-5 my-1 rounded">

                <span class="menu-text">Tipe Kontrol</span>
              </a>
            </li>
            
            <li class="menu-item <?= isset($sub_menu) ? $sub_menu == 'frekuensi_kontrol' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
              <a href="<?= base_url() ?>master/frekuensi_kontrol" class="menu-link mx-5 my-1 rounded">

                <span class="menu-text">Frekuensi Kontrol</span>
              </a>
            </li>

          </ul>
        </div>
      </li>
      
        <!-- <li class="menu-item <?= isset($menu) ? $menu == 'file' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
          <a href="<?= base_url('file') ?>" class="menu-link mx-5 my-1 rounded">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" class="mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
            <span class="menu-text">Browse File</span>
          </a>
        </li> -->
        
      <li class="menu-item <?= isset($menu) ? $menu == 'setting_ttd_spa' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
        <a href="<?= base_url('setting_ttd_spa') ?>" class="menu-link mx-5 my-1 rounded">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" class="mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
          <span class="menu-text">Setting TTD SPA</span>
        </a>
      </li>
    <?php } ?>
  </ul>
<!-- </div> -->