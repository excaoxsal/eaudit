<!-- filepath: c:\laragon\www\eaudit\application\views\content\aia\v_response_auditee_detail.php -->
<div class="container mt-4">
    <div class="card-header" style="background-color: transparent; padding-bottom: 0;">
        <ul class="nav nav-tabs flex-grow-1" id="viewTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="popup-view-tab" data-toggle="tab" href="#popup-view" role="tab" aria-controls="popup-view" aria-selected="true">Pop Up View</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="grid-view-tab" data-toggle="tab" href="#grid-view" role="tab" aria-controls="grid-view" aria-selected="false">Grid View</a>
            </li>
        </ul>
    </div>
    <div class="tab-content" id="viewTabsContent">
        <!-- Pop Up View Tab -->
        <div class="tab-pane fade show active" id="popup-view" role="tabpanel" aria-labelledby="popup-view-tab">
            <?php include 'v_response_auditee_detail_popup.php'; ?>
            <?php
            // Debugging
            echo "<script>console.log('v_response_auditee_detail_popup.php loaded');</script>";
            ?>
        </div>
        <!-- Grid View Tab -->
        <div class="tab-pane fade" id="grid-view" role="tabpanel" aria-labelledby="grid-view-tab">
            <?php include 'v_response_auditee_detail_grid.php'; ?>
        </div>
    </div>
</div>

<script type="text/javascript">
  $(document).ready(function () {
    function initializeDatatable(target) {
      if (target === "#popup-view" && typeof KTDatatablePopup !== "undefined") {
        console.log("Initializing KTDatatablePopup");
        if (!$.fn.dataTable.isDataTable("#kt_datatable_popup")) {
          KTDatatablePopup.init();
        }
      } else if (target === "#grid-view" && typeof KTDatatableGrid !== "undefined") {
        console.log("Initializing KTDatatableGrid");
        if (!$.fn.dataTable.isDataTable("#kt_datatable_grid")) {
          KTDatatableGrid.init();
        }
      }
    }

    // Inisialisasi awal berdasarkan tab aktif
    if ($("#popup-view").hasClass("show active")) {
      initializeDatatable("#popup-view");
    } else if ($("#grid-view").hasClass("show active")) {
      initializeDatatable("#grid-view");
    }

    // Event listener ketika tab berubah
    $('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
      var target = $(e.target).attr("href"); // Dapatkan tab yang aktif
      initializeDatatable(target);
    });
  });
</script>