<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-2">
          <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
          <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
          <span class="text-muted font-weight-bold mr-4">Browse File</span>
        </div>
    </div>
  </div>

  <div class="d-flex flex-column-fluid">
    <div class="container">
      <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
          <div class="card-title">
            <h3 class="card-label">Browse File</h3>
          </div>
        </div>
        <div class="card-body">
        <div class="tree row">

        <ul class="col-lg-6">
          <?php foreach ($kolom_1 as $val_unit) { ?>
          <li class="col-lg-12 mb-2">
            <span>
              <a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#<?= 'UNIT_'.$val_unit[ID_DIVISI] ?>" aria-expanded="false" class="collapsed" aria-controls="<?= 'UNIT_'.$val_unit[ID_DIVISI] ?>">
                <i class="collapsed"><i class="fas fa-caret-right mr-2"></i><i class="fas fa-folder"></i></i>
                <i class="expanded"><i class="fas fa-caret-down mr-2"></i><i class="far fa-folder-open"></i></i> 
                <?= $val_unit['NAMA_DIVISI'] ?>
              </a>
            </span>

            <div id="<?= 'UNIT_'.$val_unit[ID_DIVISI] ?>" class="collapse">
              <ul>
                <?php 
                foreach ($matrix as $val_matrix) { ?>
                <li>
                  <span>
                    <a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#<?= 'MATRIX_'.$val_unit[ID_DIVISI].$val_matrix['ID'] ?>" class="collapsed" aria-expanded="false" aria-controls="<?= 'MATRIX_'.$val_unit[ID_DIVISI].$val_matrix['ID'] ?>">
                      <i class="collapsed"><i class="fas fa-caret-right mr-2"></i><i class="fas fa-folder"></i></i>
                      <i class="expanded"><i class="fas fa-caret-down mr-2"></i><i class="far fa-folder-open"></i></i> 
                        <?= $val_matrix['NAMA'] ?>
                    </a>
                  </span>
                  <ul>
                    <div id="<?= 'MATRIX_'.$val_unit[ID_DIVISI].$val_matrix['ID'] ?>" class="collapse">
                      <?php 
                        $file = './storage/images/draft.png';
                      ?>
                      <li class="d-none">
                        <span><i class="far fa-file"></i><a target='_blank' download='download' href="<?= $file ?>"> <?= get_file_info($file)['name'] ?> - <?= date('d/m/Y H:i:s', get_file_info($file)['date']) ?> - <?= number_format(get_file_info($file)['size'] / 1048576, 2) . ' MB'; ?></a></span>
                      </li>
                      <li>
                        <span><a target='_blank' class="text-dark" href="<?= base_url('file/input?id=').base64_encode($val_unit[ID_DIVISI]).'&mx='.base64_encode($val_matrix['ID']) ?>"><i class="fas fa-file-circle-plus mr-1 text-dark"></i>Tambah File Baru</a></span>
                      </li>     
                      </div>
                    </ul>
                  </li>
                  <?php } ?>
                </ul>
              </div>
            </li>
          <?php } ?>
          </ul>
          <ul class="col-lg-6">
          <?php foreach ($kolom_2 as $val_unit) { ?>
          <li class="col-lg-12 mb-2">
            <span>
              <a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#<?= 'UNIT_'.$val_unit[ID_DIVISI] ?>" aria-expanded="false" class="collapsed" aria-controls="<?= 'UNIT_'.$val_unit[ID_DIVISI] ?>">
                <i class="collapsed"><i class="fas fa-caret-right mr-2"></i><i class="fas fa-folder"></i></i>
                <i class="expanded"><i class="fas fa-caret-down mr-2"></i><i class="far fa-folder-open"></i></i> 
                <?= $val_unit['NAMA_DIVISI'] ?>
              </a>
            </span>

            <div id="<?= 'UNIT_'.$val_unit[ID_DIVISI] ?>" class="collapse">
              <ul>
                <?php 
                foreach ($matrix as $val_matrix) { ?>
                <li>
                  <span>
                    <a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#<?= 'MATRIX_'.$val_unit[ID_DIVISI].$val_matrix['ID'] ?>" class="collapsed" aria-expanded="false" aria-controls="<?= 'MATRIX_'.$val_unit[ID_DIVISI].$val_matrix['ID'] ?>">
                      <i class="collapsed"><i class="fas fa-caret-right mr-2"></i><i class="fas fa-folder"></i></i>
                      <i class="expanded"><i class="fas fa-caret-down mr-2"></i><i class="far fa-folder-open"></i></i> 
                        <?= $val_matrix['NAMA'] ?>
                    </a>
                  </span>
                  <ul>
                    <div id="<?= 'MATRIX_'.$val_unit[ID_DIVISI].$val_matrix['ID'] ?>" class="collapse">
                      <?php 
                        $file = './storage/images/draft.png';
                      ?>
                      <li class="d-none">
                        <span><i class="far fa-file mr-2"></i><a target='_blank' download='download' href="<?= $file ?>"> <?= get_file_info($file)['name'] ?> - <?= date('d/m/Y H:i:s', get_file_info($file)['date']) ?> - <?= number_format(get_file_info($file)['size'] / 1048576, 2) . ' MB'; ?></a></span>
                      </li> 
                      <li>
                        <span><a target='_blank' class="text-dark" href="#"><i class="fas fa-file-circle-plus mr-1 text-dark"></i>Tambah File Baru</a></span>
                      </li>   
                      </div>
                    </ul>
                  </li>
                  <?php } ?>
                </ul>
              </div>
            </li>
          <?php } ?>
          </ul>
        </div>
          </div>
      </div>
    </div>
  </div>
</div>
