<style type="text/css">
  /* Table Scrolling and Styling */
  .table-container {
    max-height: 70vh;
    border: 1px solid #ebedf3;
    margin-bottom: 20px;
  }
  
  #potensiTemuanTable, .grouped-master-table {
    min-width: 100%;
  }
  
  #potensiTemuanTable thead th, .grouped-master-table thead th {
    position: sticky;
    top: 0;
    background: #f8f9fa;
    z-index: 10;
  }
  
  .badge-group {
    background: #3699ff;
    color: white;
  }

  .btn-warning {
    color: #212529;
    background-color: #ffc107;
    border-color: #ffc107;
  }

  .btn-warning:hover {
    color: #212529;
    background-color: #e0a800;
    border-color: #d39e00;
  }
  
  /* Group Table Styles */
  .grouped-master-section {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #eee;
  }

  .grouped-master-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 15px;
    color: #3699ff;
  }

  .observasi-container {
    max-height: 120px;
    overflow-y: auto;
    padding: 5px;
    background-color: #f8f9fa;
    border-radius: 4px;
    border: 1px solid #eee;
  }

  .observasi-container ul {
    padding-left: 20px;
    margin-bottom: 0;
  }

  .observasi-container li {
    margin-bottom: 5px;
    font-size: 0.9rem;
  }

  /* Badge Styles */
  .badge {
    font-size: 0.8em;
    font-weight: 500;
    padding: 4px 8px;
  }

  .badge-danger {
    background-color: #dc3545;
  }

  .badge-warning {
    background-color: #ffc107;
    color: #212529;
  }

  .badge-info {
    background-color: #17a2b8;
  }

  .badge-secondary {
    background-color: #6c757d;
  }

  /* Status Select Colors */
  .status-red {
    background-color: #ff4d4f;
    color: white;
  }

  .status-orange {
    background-color: #ffa500;
    color: white;
  }

  .status-green {
    background-color: #28a745;
    color: white;
  }

  .status-blue {
    background-color: #007bff;
    color: white;
  }
  
  /* Responsive adjustments */
  @media (max-width: 768px) {
    .table-container {
      max-height: 50vh;
    }
    
    #grouping-controls .d-flex {
      flex-wrap: wrap;
    }
    
    .group-btn {
      margin-bottom: 8px;
    }
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
        <div class="card-body">
          <!-- Grouping Controls -->
          <div id="grouping-controls" class="mb-5">
            <div class="d-flex align-items-center flex-wrap">
              <select id="group-select" class="form-control form-control-sm w-200px group-btn">
                <option value="">-- Pilih Group --</option>
              </select>
              <button id="add-group-btn" class="btn btn-sm btn-info group-btn">
                <i class="fas fa-plus"></i> Tambah Group
              </button>
              <button id="assign-group-btn" class="btn btn-sm btn-success group-btn">
                <i class="fas fa-object-group"></i> Assign to Group
              </button>
            </div>
          </div>
          
          <!-- Main Table -->
          <div class="d-flex align-items-center flex-wrap">
              <div class="grouped-master-title">TABEL UTAMA</div>
            </div>
          <div class="table-container">
            <table id="potensiTemuanTable" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th width="20"><input type="checkbox" id="select-all"></th>
                  <th>No.</th>
                  <th>HASIL RESPON / VISIT</th>
                  <th>KODE KLAUSUL</th>
                  <?php if ($is_auditor) { ?>
                  <th>STATUS</th>
                  <th>KLASIFIKASI</th>
                  <?php } ?>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
          
          <!-- This div will contain our dynamically added grouped master tables -->
          <div id="groupedMasterContainer"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  class GroupManager {
    constructor() {
      this.groupList = [];
      this.groupedMasterTable = null;
      this.currentGroupedItems = [];
    }

    // Load all available groups
    async loadGroups() {
      try {
        const response = await $.ajax({
          url: '<?= base_url("aia/potensi_temuan/get_groups") ?>',
          method: 'GET',
          dataType: 'json',
          data: { id_response_header: <?= json_encode($id_response_header); ?> }
        });

        if (response.status === 'success') {
          this.groupList = response.data;
          this.updateGroupDropdown();
          return response.data;
        }
        throw new Error(response.message || 'Failed to load groups');
      } catch (error) {
        console.error('Error loading groups:', error);
        throw error;
      }
    }

    // Load grouped items from backend
    async loadGroupedItems() {
      try {
        const response = await $.ajax({
          url: '<?= base_url("aia/potensi_temuan/get_grouped_items") ?>',
          method: 'GET',
          dataType: 'json',
          data: { id_jadwal: <?= json_encode($id_jadwal); ?> }
        });

        if (response.status === 'success') {
          // Pastikan mengakses array dari atribut 'ITEMS'
      this.currentGroupedItems = response.data.ITEMS || []; // Default ke array kosong jika undefined
      return this.currentGroupedItems;
        }
        throw new Error(response.message || 'Failed to load grouped items');
      } catch (error) {
        console.error('Error loading grouped items:', error);
        throw error;
      }
    }

    async resetGroup(groupId) {
        try {
            const response = await $.ajax({
                url: '<?= base_url("aia/potensi_temuan/reset_group") ?>',
                method: 'POST',
                dataType: 'json',
                data: { group_id: groupId }
            });

            if (response.status !== 'success') {
                throw new Error(response.message || 'Failed to reset group');
            }
            return response;
        } catch (error) {
            console.error('Error resetting group:', error);
            throw error;
        }
    }

    // Update group dropdown selector
    updateGroupDropdown() {
      const $groupSelect = $('#group-select')
        .empty()
        .append('<option value="">-- Pilih Group --</option>');
      
      this.groupList.forEach(group => {
        $groupSelect.append(`<option value="${group.ID}">${group.NAME}</option>`);
      });
    }

    // Initialize or refresh the grouped items table
    async initGroupedTable() {
      try {
        await this.loadGroupedItems();
        
        // Destroy existing table if any
        if (this.groupedMasterTable) {
          this.groupedMasterTable.destroy();
          $('#groupedMasterTable').remove();
        }

        // Create table structure
        const tableHTML = `
          <div class="grouped-master-section">
            <div class="d-flex align-items-center flex-wrap">
              <div class="grouped-master-title">TABEL GROUP</div>
            </div>
            <div class="table-container">
              <table id="groupedMasterTable" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>GROUP</th>
                    <th>KLASIFIKASI</th>
                    <th>URAIAN TEMUAN</th>
                    <th>KODE KLAUSUL</th>
                    <th>REFERENSI KLAUSUL</th>
                    <th>AKSI</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        `;
        
        $('#groupedMasterContainer').html(tableHTML);

        // Initialize DataTable
        this.groupedMasterTable = $('#groupedMasterTable').DataTable({
          data: this.prepareTableData(),
          columns: this.getTableColumns(),
          scrollX: true,
          scrollY: '50vh',
          scrollCollapse: true,
          createdRow: (row, data) => {
            $(row).attr('data-group-id', data.groupId);
          }
        });

      } catch (error) {
        console.error('Error initializing grouped table:', error);
        throw error;
      }
    }

    // Prepare data for DataTable
    prepareTableData() {
      // Validasi bahwa currentGroupedItems adalah array
      if (!Array.isArray(this.currentGroupedItems)) {
        console.error('currentGroupedItems is not an array:', this.currentGroupedItems);
        return [];
      }
      console.log('Preparing table data:', this.currentGroupedItems);
      return this.currentGroupedItems.map((group, index) => ({
        id: index + 1,
        groupId: group.GROUP_ID,
        groupName: group.GROUP_NAME,
        klasifikasi: group.KLASIFIKASI,
        itemCount: group.ITEMS ? group.ITEMS.length : 0,
        uraianTemuan: (group.URAIAN_TEMUAN || '-').replace(/\n/g, '<br>'), // Ganti \n dengan <br>
        kodeKlausul: (group.KODE_KLAUSUL || '-').replace(/\n/g, '<br>'),
        referensiKlausul: (group.REFERENSI_KLAUSUL || '-').replace(/\n/g, '<br>')
      }));
    }

    // Define table columns
    getTableColumns() {
      return [
        { 
          data: 'id',
          className: 'text-center',
          width: '50px'
        },
        { 
          data: 'groupName',
          render: (data, type, row) => `<strong>${data}</strong>`
        },
        { 
          data: 'klasifikasi',
          className: 'text-center',
          render: (data) => `
            <span class="badge ${this.getKlasifikasiClass(data)}">
              ${data}
            </span>
          `
        },
        { 
            data: 'uraianTemuan', // Tambahkan kolom ini
            render: (data) => `
                <div class="uraian-temuan-container">
                    ${data || '-'}
                </div>
            `
        },
        { 
          data: 'kodeKlausul',
          className: 'text-justify',
        },
        { 
          data: 'referensiKlausul',
          className: 'text-center'
        },
        { 
          data: 'groupId',
          className: 'text-center',
          render: (data) => `
            <button class="btn btn-sm btn-warning reset-group-btn mr-1" data-group-id="${data}" title="Reset Group">
                <i class="fas fa-undo"></i>
            </button>
            <button class="btn btn-sm btn-danger delete-group-btn" data-group-id="${data}">
              <i class="fas fa-trash"></i>
            </button>
          `,
          orderable: false
        }
      ];
    }

    // Format observasi items as HTML
    formatObservasi(items) {
      if (!items || items.length === 0) return '-';
      
      const limitedItems = items.slice(0, 3); // Show max 3 items
      let html = '<ul class="mb-0">';
      
      limitedItems.forEach(item => {
        html += `<li>${item.URAIAN_TEMUAN}</li>`;
      });
      
      if (items.length > 3) {
        html += `<li class="text-muted">+ ${items.length - 3} item lainnya</li>`;
      }
      
      html += '</ul>';
      return html;
    }

    // Get CSS class for klasifikasi badge
    getKlasifikasiClass(klasifikasi) {
      const classes = {
        'MAJOR': 'badge-danger',
        'MINOR': 'badge-warning',
        'OBSERVASI': 'badge-info'
      };
      return classes[klasifikasi] || 'badge-secondary';
    }

    // Assign items to a group
    async assignToGroup(itemIds, groupId, idJadwal) {
      try {
        if (!itemIds.length) throw new Error('No items selected');
        if (!groupId) throw new Error('No group selected');

        const response = await $.ajax({
          url: '<?= base_url("aia/potensi_temuan/update_group") ?>',
          method: 'POST',
          dataType: 'json',
          data: { 
            item_ids: itemIds, 
            group_id: groupId,
            id_jadwal: idJadwal
          }
        });

        if (response.status !== 'success') {
          throw new Error(response.message || 'Failed to assign items to group');
        }
        return response;
      } catch (error) {
        console.error('Error assigning to group:', error);
        throw error;
      }
    }

    // Delete a group
    async deleteGroup(groupId) {
      try {
          const response = await $.ajax({
              url: '<?= base_url("aia/potensi_temuan/delete_group") ?>',
              method: 'POST',
              dataType: 'json',
              data: { group_id: groupId }
          });

          // Pastikan response memiliki struktur yang konsisten
          if (response && response.status === 'success') {
              return response;
          }
          
          throw new Error(response.message || 'Invalid response from server');
      } catch (error) {
          console.error('Error deleting group:', error);
          throw error;
      }
    }
  }

  class AppController {
    constructor() {
      this.groupManager = new GroupManager();
      this.potensiTemuanTable = null;
      this.currentItemData = [];
    }

    // Initialize the application
    async init() {
      try {
        await this.initDataTables();
        this.setupEventListeners();
        await this.loadInitialData();
      } catch (error) {
        this.showError('Gagal memulai aplikasi: ' + error.message);
      }
    }

    // Initialize main data table
    async initDataTables() {
      try {
        const response = await $.ajax({
          url: `<?= base_url("aia/potensi_temuan/get_potensi_temuan/") ?>${<?= $id_response_header ?>}`,
          method: 'GET',
          dataType: 'json'
        });

        this.currentItemData = this.processItemData(response);
        
        this.potensiTemuanTable = $('#potensiTemuanTable').DataTable({
          data: this.getUngroupedItems(),
          columns: this.getPotensiTemuanColumns(),
          scrollX: true,
          scrollY: '50vh',
          scrollCollapse: true,
          createdRow: (row, data) => {
            $(row).attr('data-id', data.ID_POTENSI_TEMUAN);
          }
        });
      } catch (error) {
        console.error('Error initializing main table:', error);
        throw error;
      }
    }

    // Process item data from backend
    processItemData(response) {
      if (response.status !== 'success') {
        throw new Error(response.message || 'Invalid response format');
      }
      
      return response.data.map(item => ({
        ...item,
        GROUP_ID: item.GROUP_ID || 0
      }));
    }

    // Get ungrouped items only
    getUngroupedItems() {
      return this.currentItemData.filter(item => !item.GROUP_ID || item.GROUP_ID == 0);
    }

    // Load initial data
    async loadInitialData() {
      try {
        await this.groupManager.loadGroups();
        await this.groupManager.initGroupedTable();
      } catch (error) {
        this.showError('Gagal memuat data awal: ' + error.message);
      }
    }

    // Get selected items from main table
    getSelectedItems() {
      return $('.row-checkbox:checked').map(function() {
        return $(this).data('id');
      }).get();
    }

    // Setup all event listeners
    setupEventListeners() {
      // Group management buttons
      $('#add-group-btn').click(() => this.handleAddGroup());
      $('#assign-group-btn').click(() => this.handleAssignToGroup());
      
      // Group table actions
      $(document).on('click', '.delete-group-btn', (e) => this.handleDeleteGroup(e));
      $(document).on('click', '.reset-group-btn', (e) => {
        const groupId = $(e.currentTarget).data('group-id');
        this.handleResetGroup(groupId);
      });
      
      // Checkbox controls
      $('#select-all').change((e) => {
        $('.row-checkbox').prop('checked', e.target.checked);
      });
      
      // Status select styling
      $(document).on('change focus', '.status-select', function() {
        const value = $(this).val();
        $(this).removeClass('status-red status-orange status-green status-blue');
        
        if (value == "1") $(this).addClass('status-red');
        else if (value == "2") $(this).addClass('status-orange');
        else if (value == "3") $(this).addClass('status-green');
        else if (value == "4") $(this).addClass('status-blue');
      });
    }

    // Handle assign to group action
    async handleAssignToGroup() {
      try {
        const selectedItems = this.getSelectedItems();
        const groupId = $('#group-select').val();
        const idJadwal = <?= json_encode($id_jadwal); ?>;
        
        if (!selectedItems.length) {
          throw new Error('Pilih setidaknya satu item');
        }
        if (!groupId) {
          throw new Error('Pilih group terlebih dahulu');
        }
        
        const confirmed = await this.showConfirmation(
          'Konfirmasi',
          `Assign ${selectedItems.length} item ke group ini?`
        );
        
        if (!confirmed) return;

        await this.groupManager.assignToGroup(selectedItems, groupId, idJadwal);
        
        // Update local data
        this.currentItemData.forEach(item => {
          if (selectedItems.includes(item.ID_POTENSI_TEMUAN)) {
            item.GROUP_ID = groupId;
          }
        });

        this.showSuccess(`${selectedItems.length} item berhasil diassign ke group`);
        
        // Refresh main table dengan cara yang benar
        await this.refreshMainTable();
        
        await this.groupManager.initGroupedTable();
      } catch (error) {
        this.showError(error.message);
      }
    }

    async handleResetGroup(groupId) {
        try {
            const confirmed = await this.showConfirmation(
                'Konfirmasi Reset Group',
                'Reset group ini akan menghapus dari daftar group tetapi tetap mempertahankan group di master. Lanjutkan?'
            );
            
            if (!confirmed) return;

            const response = await this.groupManager.resetGroup(groupId);
            
            this.showSuccess('Group berhasil direset');
            
            // Refresh data
            await this.refreshAllData();
            
        } catch (error) {
            this.showError('Gagal mereset group: ' + error.message);
        }
    }

    async refreshAllData() {
        try {
            // Refresh main table
            await this.refreshMainTable();
            
            // Refresh grouped table
            await this.groupManager.initGroupedTable();
            
        } catch (error) {
            console.error('Error refreshing data:', error);
            this.showError('Gagal memuat ulang data');
        }
    }

    // Handle delete group action
    async handleDeleteGroup(e) {
      try {
          const groupId = $(e.currentTarget).data('group-id');
          
          const confirmed = await this.showConfirmation(
              'Konfirmasi',
              'Hapus group ini? Semua item akan dikembalikan ke tabel utama.'
          );
          
          if (!confirmed) return;

          // Kirim request delete
          const response = await this.groupManager.deleteGroup(groupId);
          
          if (response.status === 'success') {
              this.showSuccess('Group berhasil dihapus');
              
              // Refresh grouped table
              await this.groupManager.initGroupedTable();
              
              // Refresh main table dengan cara yang benar
              await this.refreshMainTable();
              
              await this.groupManager.loadGroups();
          } else {
              throw new Error(response.message || 'Gagal menghapus group');
          }
      } catch (error) {
          this.showError(error.message);
      }
    }

    async refreshMainTable() {
      try {
          const response = await $.ajax({
              url: `<?= base_url("aia/potensi_temuan/get_potensi_temuan/") ?>${<?= $id_response_header ?>}`,
              method: 'GET',
              dataType: 'json'
          });

          if (response.status === 'success') {
              this.currentItemData = response.data.map(item => ({
                  ...item,
                  GROUP_ID: item.GROUP_ID || 0
              }));
              
              // Hancurkan dan buat ulang DataTable
              this.potensiTemuanTable.destroy();
              
              this.potensiTemuanTable = $('#potensiTemuanTable').DataTable({
                  data: this.getUngroupedItems(),
                  columns: this.getPotensiTemuanColumns(),
                  scrollX: true,
                  scrollY: '50vh',
                  scrollCollapse: true,
                  createdRow: (row, data) => {
                      $(row).attr('data-id', data.ID_POTENSI_TEMUAN);
                  }
              });
          } else {
              throw new Error(response.message || 'Gagal memuat data');
          }
      } catch (error) {
          console.error('Error refreshing main table:', error);
          this.showError('Gagal memuat ulang data tabel utama');
      }
    }

    // Handle add new group
    async handleAddGroup() {
      try {
        const { value: groupName } = await Swal.fire({
          title: 'Tambah Group Baru',
          input: 'text',
          inputPlaceholder: 'Nama Group',
          showCancelButton: true,
          inputValidator: (value) => !value && 'Nama group tidak boleh kosong!'
        });

        if (!groupName) return;

        const response = await $.ajax({
          url: '<?= base_url("aia/potensi_temuan/add_group") ?>',
          method: 'POST',
          dataType: 'json',
          data: { group_name: groupName, id_response_header: <?= json_encode($id_response_header); ?> }
        });

        if (response.status === 'success') {
          this.showSuccess('Group berhasil ditambahkan');
          await this.groupManager.loadGroups();
        } else {
          throw new Error(response.message);
        }
      } catch (error) {
        this.showError(error.message);
      }
    }

    // Show confirmation dialog
    async showConfirmation(title, text) {
      const result = await Swal.fire({
        title,
        text,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
      });
      return result.isConfirmed;
    }

    // Show success message
    showSuccess(message) {
      Swal.fire({
        title: 'Berhasil',
        text: message,
        icon: 'success',
        timer: 2000,
        showConfirmButton: false
      });
    }

    // Show error message
    showError(message) {
      Swal.fire({
        title: 'Error',
        text: message,
        icon: 'error'
      });
    }

    // Get columns for main table
    getPotensiTemuanColumns() {
      const columns = [
        { 
          data: null,
          title: "<input type='checkbox' id='select-all'>",
          orderable: false,
          width: '20px',
          render: (data) => `
            <input type="checkbox" class="row-checkbox" data-id="${data.ID_POTENSI_TEMUAN}">
          `
        },
        {
          data: null,
          title: "No.",
          width: '50px',
          render: (data, type, row, meta) => meta.row + 1
        },
        {
          data: "HASIL_OBSERVASI",
          title: "HASIL RESPON / VISIT"
        },
        {
          data: "KODE_KLAUSUL",
          title: "KODE KLAUSUL",
          width: '300px'
        },
      ];

      <?php if ($is_auditor) { ?>
      columns.push(
        {
          data: "STATUS",
          title: "STATUS",
          width: '200px',
          render: (data, type, row) => `
            <select class="form-control status-select" data-id="${row.ID_RE}" disabled>
              <option value="" ${!data ? "selected" : ""}>-- Pilih Status --</option>
              <option value="1" ${data == 1 ? "selected" : ""}>TIDAK DIISI SAMA SEKALI</option>
              <option value="2" ${data == 2 ? "selected" : ""}>JAWABAN TIDAK SESUAI</option>
              <option value="3" ${data == 3 ? "selected" : ""}>JAWABAN BENAR, LAMPIRAN SALAH</option>
              <option value="4" ${data == 4 ? "selected" : ""}>JAWABAN DAN LAMPIRAN SESUAI</option>
            </select>
          `
        },
        {
          data: "KLASIFIKASI",
          title: "KLASIFIKASI",
          width: '150px',
          render: (data, type, row) => `
            <select class="form-control klasifikasi-select" data-id="${row.ID_RE}" disabled>
              <option value="" ${!data ? "selected" : ""}>-- Pilih Klasifikasi --</option>
              <option value="MAJOR" ${data == 'MAJOR' ? 'selected' : ''}>MAJOR</option>
              <option value="MINOR" ${data == 'MINOR' ? 'selected' : ''}>MINOR</option>
              <option value="OBSERVASI" ${data == 'OBSERVASI' ? 'selected' : ''}>OBSERVASI</option>
            </select>
          `
        }
      );
      <?php } ?>

      return columns;
    }
  }

  // Initialize the application
  const appController = new AppController();
  appController.init();
});
$(document).on('change focus', '.status-select', function () {
  const selectedValue = $(this).val();

  // Reset semua kelas warna sebelumnya
  $(this).removeClass('status-red status-orange status-green status-blue');

  // Tambahkan warna berdasarkan nilai yang dipilih
  if (selectedValue == "1") {
    $(this).addClass('status-red'); // Warna merah
  } else if (selectedValue == "2") {
    $(this).addClass('status-orange'); // Warna oranye
  } else if (selectedValue == "3") {
    $(this).addClass('status-green'); // Warna hijau
  } else if (selectedValue == "4") {
    $(this).addClass('status-blue'); // Warna biru
  }
});
</script>