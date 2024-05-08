<!-- <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500"> -->

<ul class="menu-nav">
  <li class="menu-section">
    <h4 id="toggleButton" class="menu-text" >Menu AIA</h4>
    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
  </li>
  
  <?php if ($is_auditor) { ?>
  <li  id="myList"  class="menu-item menu-item-submenu <?= isset($menu) ? $menu == 'perencanaana' ? 'menu-item-open menu-item-here' : '' : ''; ?>" aria-haspopup="true" data-menu-toggle="hover">

    <a href="javascript:;" class="menu-link menu-toggle mx-5 my-1 rounded">
      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" class="mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>
      <span class="menu-text">Perencanaan</span>
      <i class="menu-arrow"></i>
    </a>

    <div class="menu-submenu">
      <i class="menu-arrow"></i>

      <ul class="menu-subnav">
        <li class="menu-item menu-item-submenu <?= isset($sub_menu) ? $sub_menu == 'jadwal' ? 'menu-item-open menu-item-here' : '' : ''; ?>" aria-haspopup="true">
          <a href="<?= base_url() ?>aia/jadwal/jadwal_audit" class="menu-link mx-5 my-1 rounded">
          
            <span class="menu-text">Penjadwalan Audit</span>
          </a>
        </li>
      </ul>
    </div>
  </li>

  <li class="menu-item <?= isset($menu) ? $menu == 'response_auditee' ? 'menu-item-active' : '' : ''; ?>" aria-haspopup="true">
    <a href="<?= base_url('aia/response_auditee') ?>" class="menu-link mx-5 my-1 rounded">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
      <span class="menu-text">Respon Auditee</span>
    </a>
  </li> 
  
  <?php } ?>
</ul>
<!-- </div> -->