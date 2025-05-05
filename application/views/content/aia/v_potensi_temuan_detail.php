<style type="text/css">
  /* Table Scrolling and Styling */
  .table-container {
    max-height: 70vh;
    border: 1px solid #ebedf3;
  }
  
  #potensiTemuanTable {
    min-width: 100%;
    white-space: nowrap;
  }
  
  #potensiTemuanTable thead th {
    position: sticky;
    top: 0;
    background: #f8f9fa;
    z-index: 10;
  }
  
  .badge-group {
    background: #3699ff;
    color: white;
  }
  
  /* Grouping Controls */
  #grouping-controls {
    padding: 15px;
    background: #f8f9fa;
    border-radius: 5px;
    margin-bottom: 20px;
  }
  
  .w-200px {
    width: 200px;
  }
  
  /* Alert Styling */
  .alert {
    margin-bottom: 20px;
  }
</style>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <div class="d-flex align-items-center flex-wrap mr-2">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4"><?= $title ?></span>
      </div>
    </div>
  </div>
  
  <div class="d-flex flex-column-fluid">
    <div class="container">
      <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
          <div class="card-title">
            <h3 class="card-label">List <?= $subtitle ?></h3>
          </div>
        </div>
        
        <div class="card-body">
          <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h4><i class="icon fa fa-ban text-white"></i> Error!</h4>
              <?= $this->session->flashdata('error'); ?>
            </div>
          <?php endif; ?>
          
          <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h6><i class="icon fa fa-check text-white"></i> Success!</h6>
              <?= $this->session->flashdata('success'); ?>
            </div>
          <?php endif; ?>
          
          <!-- Grouping Controls -->
          <div id="grouping-controls" class="mb-5">
            <div class="d-flex align-items-center">
              <select id="group-select" class="form-control form-control-sm w-200px mr-3">
                <option value="">-- Pilih Group --</option>
                <option value="1">Group 1</option>
                <option value="2">Group 2</option>
                <option value="3">Group 3</option>
              </select>
              <button id="assign-group-btn" class="btn btn-sm btn-success">Assign to Group</button>
              <button id="reset-group-btn" class="btn btn-sm btn-danger ml-2">Reset Group</button>
            </div>
          </div>
          
          <!-- Table Container with Scroll -->
          <div class="table-container">
            <table id="potensiTemuanTable" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Potensti Temuan</th>
                  <th>Pertanyaan</th>
                  <th>Kode Klausul</th>
                  <th>Response Auditee</th>
                  <th>Komentar Auditor</th>
                  <th>Komentar Auditee</th>
                  <th>File</th>
                  <?php if ($is_auditor) { ?>
                    <th>Status</th>
                    <th>Klasifikasi</th>
                    <th>Group</th>
                  <?php } ?>
                  <th width="20"><input type="checkbox" id="select-all"></th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  // Initialize DataTable with scroll options
  const table = $('#potensiTemuanTable').DataTable({
    ajax: {
      url: '<?= base_url("aia/Potensi_temuan/get_potensi_temuan/") ?>' + <?= $id_response_header ?>,
      dataSrc: function(json) {
        if (json.status === 'success') {
          json.data.forEach(function(item) {
            item.GROUP_ID = item.GROUP_ID || 0;
          });
          return json.data;
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: json.message
          });
          return [];
        }
      }
    },
    scrollX: true,
    scrollY: '70vh',
    scrollCollapse: true,
    fixedHeader: true,
    columns: [
      {
        data: null,
        title: "No.",
        width: 50,
        render: function(data, type, row, meta) {
          return meta.row + 1;
        }
      },
      {
        data: "ID_POTENSI_TEMUAN",
        title: "POTENSI TEMUAN",
        width: 300,
        render: function(data) {
          return `<span>${data}</span>`;
        }
      },
      {
        data: "PERTANYAAN",
        title: "PERTANYAAN",
        width: 300,
        render: function(data) {
          return `<span>${data}</span>`;
        }
      },
      {
        data: "KODE_KLAUSUL",
        title: "KODE KLAUSUL",
        width: 200,
        render: function(data) {
          return `<span>${data}</span>`;
        }
      },
      {
        data: "RESPONSE_AUDITEE",
        title: "RESPONSE AUDITEE",
        width: 300,
        render: function(data, type, row) {
          return `<input type="text" class="form-control response-auditee-input" 
                  data-id="${row.ID_RE}" value="${data ? data : ''}" />`;
        }
      },
      {
        data: "KOMENTAR_1",
        title: "KOMENTAR AUDITOR",
        width: 300,
        render: function(data, type, row) {
          return `<input type="text" class="form-control response-auditee-input" 
                  data-id="${row.ID_RE}" value="${data ? data : ''}" />`;
        }
      },
      {
        data: "KOMENTAR_2",
        title: "KOMENTAR AUDITEE",
        width: 300,
        render: function(data, type, row) {
          return `<input type="text" class="form-control response-auditee-input" 
                  data-id="${row.ID_RE}" value="${data ? data : ''}" />`;
        }
      },
      {
        data: "FILE",
        title: "FILE",
        width: 200,
        render: function(data, type, row) {
          return `
            <input type="file" class="file-upload-input" data-id="${row.ID_RE}" />
            <a href="${data ? data : '#'}" target="_blank" 
               class="btn btn-sm btn-primary mt-2" 
               ${data ? '' : 'style="display:none"'}>Download</a>
          `;
        }
      },
      <?php if ($is_auditor) { ?>
      {
        data: "STATUS",
        title: "Status",
        width: 150,
        render: function(data, type, row) {
          return `
            <select class="form-control status-select" data-id="${row.ID_RE}">
              <option value="" ${data == null || data === "" ? "selected" : ""}>-- Pilih Status --</option>
              <option value="1" ${data == 1 ? "selected" : ""}>TIDAK DIISI SAMA SEKALI</option>
              <option value="2" ${data == 2 ? "selected" : ""}>JAWABAN TIDAK SESUAI</option>
              <option value="3" ${data == 3 ? "selected" : ""}>JAWABAN BENAR, LAMPIRAN SALAH</option>
              <option value="4" ${data == 4 ? "selected" : ""}>JAWABAN DAN LAMPIRAN SESUAI</option>
            </select>
          `;
        }
      },
      {
        data: "KLASIFIKASI",
        title: "Klasifikasi",
        width: 150,
        render: function(data, type, row) {
          return `
            <select class="form-control" name="KLASIFIKASI" data-id="${row.ID_RE}">
              <option value="" ${data == null || data === "" ? "selected" : ""}>-- Pilih Klasifikasi --</option>
              <option value="MAJOR" ${data == 'MAJOR' ? 'selected' : ''}>MAJOR</option>
              <option value="MINOR" ${data == 'MINOR' ? 'selected' : ''}>MINOR</option>
              <option value="OBSERVASI" ${data == 'OBSERVASI' ? 'selected' : ''}>OBSERVASI</option>
            </select>
          `;
        }
      },
      {
        data: "GROUP_ID",
        title: "Group",
        width: 100,
        render: function(data, type, row) {
          const groupId = data || 0;
          return `
            <span class="badge ${groupId == 0 ? 'badge-light' : 'badge-primary'}">
              ${groupId == 0 ? 'Ungrouped' : 'Group '+groupId}
            </span>
          `;
        }
      },
      <?php } ?>
      {
        data: null,
        title: "<input type='checkbox' id='select-all'>",
        width: 20,
        orderable: false,
        render: function(data, type, row) {
          return `<input type="checkbox" 
                        class="row-checkbox" 
                        data-potensi-id="${row.ID_POTENSI_TEMUAN}">`;
        }
      }
    ],
    createdRow: function(row, data, dataIndex) {
      $(row).attr('data-id', data.ID_RE)
            .attr('data-group-id', data.GROUP_ID || 0);
      
      if (data.GROUP_ID > 0) {
        $(row).addClass('group-' + data.GROUP_ID);
      }
    }
  });
  
  // Grouping Functionality
  <?php if ($is_auditor) { ?>
  $('#select-all').click(function() {
    $('.row-checkbox').prop('checked', this.checked);
  });
  
  $('#assign-group-btn').click(function() {
    const selectedItems = [];
    $('.row-checkbox:checked').each(function() {
      selectedItems.push({
        id_re: $(this).data('id'),                       // ID_RE
        id_potensi_temuan: $(this).data('potensi-id')    // ID_POTENSI_TEMUAN
      });
    });
    
    const groupId = $('#group-select').val();
    
    if (selectedItems.length === 0) {
      Swal.fire('Error', 'Please select at least one item', 'error');
      return;
    }
    
    if (!groupId) {
      Swal.fire('Error', 'Please select a group', 'error');
      return;
    }
    
    assignToGroup(selectedItems, groupId);
  });
  
  $('#reset-group-btn').click(function() {
    const selectedItems = [];
    $('.row-checkbox:checked').each(function() {
      selectedItems.push($(this).data('id'));
    });
    
    if (selectedItems.length === 0) {
      Swal.fire('Error', 'Please select at least one item', 'error');
      return;
    }
    
    assignToGroup(selectedItems, 0);
  });
  
  function assignToGroup(itemIds, groupId) {
    $.ajax({
      url: '<?= base_url("aia/Potensi_temuan/update_group") ?>',
      method: 'POST',
      data: {
        item_ids: itemIds,
        group_id: groupId
      },
      success: function(response) {
        if (response.status === 'success') {
          Swal.fire('Success', 'Items grouped successfully', 'success');
          table.ajax.reload();
        } else {
          Swal.fire('Error', response.message, 'error');
        }
      },
      error: function() {
        Swal.fire('Error', 'Failed to update group', 'error');
      }
    });
  }
  <?php } ?>
});
</script>