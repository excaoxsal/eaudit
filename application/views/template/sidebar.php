<!-- <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500"> -->

  <ul class="menu-nav">
    
    <li class="menu-item <?= isset($menu) ? $menu == 'home' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
      <a href="<?= base_url('home') ?>" class="menu-link rounded mx-5 my-1">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" class="mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
        <span class="menu-text">Home</span>
      </a>
    </li>
    
    <li class="menu-section">
      <h4 class="menu-text">Menu AMS</h4>
      <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
    </li>
    <?php if ($is_auditor) { ?>
    <li class="menu-item menu-item-submenu <?= isset($menu) ? $menu == 'perencanaan' ? 'menu-item-open menu-item-here' : '' : ''; ?>" aria-haspopup="true" data-menu-toggle="hover">

      <a href="javascript:;" class="menu-link menu-toggle mx-5 my-1 rounded">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" class="mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>
        <span class="menu-text">Perencanaan</span>
        <i class="menu-arrow"></i>
      </a>

      <div class="menu-submenu">
        <i class="menu-arrow"></i>

        <ul class="menu-subnav">

          <li class="menu-item menu-item-submenu <?= isset($sub_menu) ? $sub_menu == 'kotak_masuk' ? 'menu-item-open menu-item-here' : '' : ''; ?>" aria-haspopup="true" data-menu-toggle="hover">

            <a href="javascript:;" class="menu-link menu-toggle mx-5 my-1 rounded">
              <span class="menu-text">Kotak Masuk</span>
              <span class="menu-label">
              </span>
              <i class="menu-arrow"></i>
            </a>

            <div class="menu-submenu">
              <i class="menu-arrow"></i>

              <ul class="menu-subnav">

                <li class="menu-item <?= isset($sub_menu_2) ? $sub_menu_2 == 'kotak_masuk_spa' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
                  <a href="<?= base_url() ?>perencanaan/spa/kotak_masuk" class="menu-link mx-5 my-1 rounded">
                    <i class="menu-bullet menu-bullet-dot">
                      <span></span>
                    </i>
                    <span class="menu-text">List Pertanyaan Audit</span>
                    <span class="menu-label">
                      <?php if ($total_spa > 0) { ?>
                        <span class="label label-rounded label-success label-inline"><?= $total_spa ?> new</span>
                      <?php } ?>
                    </span>
                  </a>
                </li>

                <li class="menu-item <?= isset($sub_menu_2) ? $sub_menu_2 == 'kotak_masuk_apm' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
                  <a href="<?= base_url() ?>perencanaan/apm/kotak_masuk" class="menu-link mx-5 my-1 rounded">
                    <i class="menu-bullet menu-bullet-dot">
                      <span></span>
                    </i>
                    <span class="menu-text">List Audit ISO</span>
                    <span class="menu-label">
                      <?php if ($total_apm > 0) { ?>
                        <span class="label label-rounded label-primary label-inline"><?= $total_apm ?> new</span>
                      <?php } ?>
                    </span>
                  </a>
                </li>

                <li class="menu-item <?= isset($sub_menu_2) ? $sub_menu_2 == 'kotak_masuk_rcm' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
                  <a href="<?= base_url() ?>perencanaan/rcm/kotak_masuk" class="menu-link mx-5 my-1 rounded">
                    <i class="menu-bullet menu-bullet-dot">
                      <span></span>
                    </i>
                    <span class="menu-text">RCM</span>
                    <span class="menu-label">
                      <?php if ($total_rcm > 0) { ?>
                        <span class="label label-rounded label-warning label-inline"><?= $total_rcm ?> new</span>
                      <?php } ?>
                    </span>
                  </a>
                </li>

                <li class="menu-item <?= isset($sub_menu_2) ? $sub_menu_2 == 'kotak_masuk_pka' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
                  <a href="<?= base_url() ?>perencanaan/pka/kotak_masuk" class="menu-link mx-5 my-1 rounded">
                    <i class="menu-bullet menu-bullet-dot">
                      <span></span>
                    </i>
                    <span class="menu-text">PKA</span>
                    <span class="menu-label">
                      <?php if ($total_pka > 0) { ?>
                        <span class="label label-rounded label-info label-inline"><?= $total_pka ?> new</span>
                      <?php } ?>
                    </span>
                  </a>
                </li>

              </ul>

            </div>
          </li>
          <li class="menu-item menu-item-submenu <?= isset($sub_menu) ? $sub_menu == 'kotak_keluar' ? 'menu-item-open menu-item-here' : '' : ''; ?>" aria-haspopup="true" data-menu-toggle="hover">

            <a href="javascript:;" class="menu-link menu-toggle mx-5 my-1 rounded">
              <span class="menu-text">Kotak Keluar</span>
              <i class="menu-arrow"></i>
            </a>

            <div class="menu-submenu">
              <i class="menu-arrow"></i>

              <ul class="menu-subnav">

                <li class="menu-item <?= isset($sub_menu_2) ? $sub_menu_2 == 'kotak_keluar_spa' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
                  <a href="<?= base_url() ?>perencanaan/spa/kotak_keluar" class="menu-link mx-5 my-1 rounded">
                    <i class="menu-bullet menu-bullet-dot">
                      <span></span>
                    </i>
                    <span class="menu-text">SPA</span>
                  </a>
                </li>

                <li class="menu-item <?= isset($sub_menu_2) ? $sub_menu_2 == 'kotak_keluar_apm' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
                  <a href="<?= base_url() ?>perencanaan/apm/kotak_keluar" class="menu-link mx-5 my-1 rounded">
                    <i class="menu-bullet menu-bullet-dot">
                      <span></span>
                    </i>
                    <span class="menu-text">APM</span>
                  </a>
                </li>

                <li class="menu-item <?= isset($sub_menu_2) ? $sub_menu_2 == 'kotak_keluar_rcm' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
                  <a href="<?= base_url() ?>perencanaan/rcm/kotak_keluar" class="menu-link mx-5 my-1 rounded">
                    <i class="menu-bullet menu-bullet-dot">
                      <span></span>
                    </i>
                    <span class="menu-text">Tanggapan Pertanyaan Audit</span>
                  </a>
                </li>

                <li class="menu-item <?= isset($sub_menu_2) ? $sub_menu_2 == 'kotak_keluar_pka' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
                  <a href="<?= base_url() ?>perencanaan/pka/kotak_keluar" class="menu-link mx-5 my-1 rounded">
                    <i class="menu-bullet menu-bullet-dot">
                      <span></span>
                    </i>
                    <span class="menu-text">PKA</span>
                  </a>
                </li>

              </ul>
            </div>
          </li>

          <li class="menu-item menu-item-submenu <?= isset($sub_menu) ? $sub_menu == 'ba_em' ? 'menu-item-open menu-item-here' : '' : ''; ?>" aria-haspopup="true">
            <a href="<?= base_url() ?>perencanaan/ba_em" class="menu-link mx-5 my-1 rounded">

              <span class="menu-text">Notulen Entrance Meeting</span>
            </a>
          </li>

          <li class="menu-item menu-item-submenu <?= isset($sub_menu) ? $sub_menu == 'control_sheet' ? 'menu-item-open menu-item-here' : '' : ''; ?>" aria-haspopup="true">
            <a href="<?= base_url() ?>perencanaan/control_sheet" class="menu-link mx-5 my-1 rounded">

              <span class="menu-text">Control Sheet</span>
            </a>
          </li>

          <li class="menu-item menu-item-submenu <?= isset($sub_menu) ? $sub_menu == 'peminjaman' ? 'menu-item-open menu-item-here' : '' : ''; ?>" aria-haspopup="true">
            <a href="<?= base_url() ?>perencanaan/peminjaman" class="menu-link mx-5 my-1 rounded">
              <span class="menu-text">Peminjaman</span>
            </a>
          </li>

        </ul>
      </div>
    </li>
    <li class="menu-item menu-item-submenu <?= isset($menu) ? $menu == 'pelaksanaan' ? 'menu-item-open menu-item-here' : '' : ''; ?>" aria-haspopup="true" data-menu-toggle="hover">

      <a href="javascript:;" class="menu-link menu-toggle mx-5 my-1 rounded">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" class="mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-briefcase"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
        <span class="menu-text">Pelaksanaan</span>
        <i class="menu-arrow"></i>
      </a>

      <div class="menu-submenu">
        <i class="menu-arrow"></i>

        <ul class="menu-subnav">

 

          <li class="menu-item menu-item-submenu <?= isset($sub_menu) ? $sub_menu == 'entry' ? 'menu-item-open menu-item-here' : '' : ''; ?>" aria-haspopup="true">
            <a href="<?= base_url() ?>monitoring/entry" class="menu-link mx-5 my-1 rounded">

              <span class="menu-text">Laporan Hasil Audit</span>
            </a>
          </li>

        </ul>
      </div>
    </li>
    <?php } ?>

    <li class="menu-item menu-item-submenu <?= isset($menu) ? $menu == 'monitoring' ? 'menu-item-open menu-item-here' : '' : ''; ?>" aria-haspopup="true" data-menu-toggle="hover">

      <a href="javascript:;" class="menu-link menu-toggle mx-5 my-1 rounded">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" class="mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg>
        <span class="menu-text">Monitoring</span>
        <i class="menu-arrow"></i>
      </a>

      <div class="menu-submenu">
        <i class="menu-arrow"></i>

        <ul class="menu-subnav">
          <?php if ($is_auditor) { ?>
          <li class="menu-item  <?= isset($sub_menu) ? $sub_menu == 'entry' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
            <a href="<?= base_url() ?>monitoring/entry" class="menu-link mx-5 my-1 rounded">

              <span class="menu-text">Entry LHA</span>
            </a>
          </li>
          <?php  } ?>
          <li class="menu-item  <?= isset($sub_menu) ? $sub_menu == 'update_hasil_monitoring' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
            <a href="<?= base_url() ?>monitoring/update_hasil_monitoring" class="menu-link mx-5 my-1 rounded">
              <span class="menu-text">Update Hasil Monitoring</span>
            </a>
          </li>
          <li class="menu-item  <?= isset($sub_menu) ? $sub_menu == 'berita_acara' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
            <a href="<?= base_url() ?>monitoring/berita_acara" class="menu-link mx-5 my-1 rounded">
              <span class="menu-text">Berita Acara</span>
            </a>
          </li>
          <?php if ($is_auditor) { ?>

          <li class="menu-item menu-item-submenu <?= isset($sub_menu) ? $sub_menu == 'rekap' ? 'menu-item-open menu-item-here' : '' : ''; ?>" aria-haspopup="true" data-menu-toggle="hover">

            <a href="javascript:;" class="menu-link menu-toggle mx-5 my-1 rounded">

              <span class="menu-text">Rekap</span>
              <span class="menu-label">
                <span class="label label-rounded label-primary">20</span>
              </span>
              <i class="menu-arrow"></i>
            </a>

            <div class="menu-submenu">
              <i class="menu-arrow"></i>

              <ul class="menu-subnav">

                <li class="menu-item <?= isset($sub_menu_2) ? $sub_menu_2 == 'keseluruhan' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
                  <a href="<?= base_url() ?>monitoring/rekap" class="menu-link mx-5 my-1 rounded">
                    <i class="menu-bullet menu-bullet-dot">
                      <span></span>
                    </i>
                    <span class="menu-text">Rekap Bulanan Monitoring TL SPI</span>
                    <span class="menu-label">
                    </span>
                  </a>
                </li>

                <li class="menu-item <?= isset($sub_menu_2) ? $sub_menu_2 == 'auditee' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
                  <a href="<?= base_url() ?>monitoring/status_tl" class="menu-link mx-5 my-1 rounded">
                    <i class="menu-bullet menu-bullet-dot">
                      <span></span>
                    </i>
                    <span class="menu-text">Rekap Monitoring Hasil Audit</span>
                    <span class="menu-label">
                    </span>
                  </a>
                </li>

                <li class="menu-item <?= isset($sub_menu_2) ? $sub_menu_2 == 'dashboard-tl' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
                  <a href="<?= base_url() ?>monitoring/dashboardtl" class="menu-link mx-5 my-1 rounded" target="_blank">
                    <i class="menu-bullet menu-bullet-dot">
                      <span></span>
                    </i>
                    <span class="menu-text">Dashboard TL</span>
                    <span class="menu-label">
                    </span>
                  </a>
                </li>

              </ul>
            </div>

          </li>
          <?php  } ?>
        </ul>
      </div>
    </li>
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
      
        <li class="menu-item <?= isset($menu) ? $menu == 'file' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
          <a href="<?= base_url('file') ?>" class="menu-link mx-5 my-1 rounded">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" class="mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
            <span class="menu-text">Browse File</span>
          </a>
        </li>
        
      <li class="menu-item <?= isset($menu) ? $menu == 'setting_ttd_spa' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
        <a href="<?= base_url('setting_ttd_spa') ?>" class="menu-link mx-5 my-1 rounded">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" class="mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
          <span class="menu-text">Setting TTD SPA</span>
        </a>
      </li>
    <?php } ?>
  </ul>
<!-- </div> -->