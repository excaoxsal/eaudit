<style type="text/css">
  #kt_datatable_paginate{

    position: absolute;
    right: 10px;
  }
</style>
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <!--begin::Subheader-->
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <!--begin::Info-->
      <div class="d-flex align-items-center flex-wrap mr-2">
        <!--begin::Page Title-->
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
        <!--end::Page Title-->
        <!--begin::Actions-->
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Perencanaan</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Kotak Masuk</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">BA EM</span>
        <!--end::Actions-->
      </div>
      <!--end::Info-->
    </div>
  </div>
  <!--end::Subheader-->
  <!--begin::Entry-->
  <div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
      <!--begin::Card-->
      <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
          <div class="card-title">
            <h3 class="card-label">Entrance Meeting
          </div>
          <div class="card-toolbar">
          </div>
        </div>
        <div class="card-body">
          <!--begin::Search Form-->
          <div class="mb-7">
            <div class="row align-items-center">
              <div class="col-lg-9 col-xl-8">
                <div class="row align-items-center">
                  <div class="col-md-4 my-2 my-md-0">
                    <div class="input-icon">
                      <input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query" />
                      <span>
                        <i class="fa fa-search"></i>
                      </span>
                    </div>
                  </div>
                  <div class="col-md-4 my-2 my-md-0">
                    <div class="d-flex align-items-center">
                      <label class="mr-3 mb-0 d-none d-md-block">Status:</label>
                      <select class="form-control" id="kt_datatable_search_status">
                        <option value="">All</option>
                        <option value="">Approved</option>
                        <option value="">Periksa</option>
                        <option value="">Reject</option>
                        <option value="">Draft</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--end::Search Form-->
          <!--begin: Datatable-->
          <table class="table table-bordered table-hover table-checkable dataTable no-footer dtr-inline">
            <thead>
              <th>No</th>
              <th>Nama Audit</th>
              <th>Tanggal Audit</th>
              <th>Status</th>
              <th class="text-center">Actions</th>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Audit A</td>
                <td>01 Januari 2021</td>
                <td><span class="label font-weight-bold label-lg label-light-success label-inline">Approved</span></td>
                <td class="text-center"><a href="#" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="fa fa-edit"></i></a></td>
              </tr>
              <tr>
                <td>2</td>
                <td>Audit B</td>
                <td>01 Januari 2021</td>
                <td><span class="label font-weight-bold label-lg label-light-info label-inline">Periksa</span></td>
                <td class="text-center"><a href="#" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="fa fa-edit"></i></a></td>
              </tr>
              <tr>
                <td>3</td>
                <td>Audit C</td>
                <td>01 Januari 2021</td>
                <td><span class="label font-weight-bold label-lg label-light-danger label-inline">Reject</span></td>
                <td class="text-center"><a href="#" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="fa fa-edit"></i></a></td>
              </tr>
            </tbody>
          </table>
          <div class="row"><div class="col-sm-12 col-md-5"><div class="dataTables_info" id="kt_datatable_info" role="status" aria-live="polite">Showing 1 to 10 of 350 entries</div></div><div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers" id="kt_datatable_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="kt_datatable_previous"><a href="#" aria-controls="kt_datatable" data-dt-idx="0" tabindex="0" class="page-link"><i class="ki ki-arrow-back"></i></a></li><li class="paginate_button page-item active"><a href="#" aria-controls="kt_datatable" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="kt_datatable" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item "><a href="#" aria-controls="kt_datatable" data-dt-idx="3" tabindex="0" class="page-link">3</a></li><li class="paginate_button page-item "><a href="#" aria-controls="kt_datatable" data-dt-idx="4" tabindex="0" class="page-link">4</a></li><li class="paginate_button page-item "><a href="#" aria-controls="kt_datatable" data-dt-idx="5" tabindex="0" class="page-link">5</a></li><li class="paginate_button page-item disabled" id="kt_datatable_ellipsis"><a href="#" aria-controls="kt_datatable" data-dt-idx="6" tabindex="0" class="page-link">…</a></li><li class="paginate_button page-item "><a href="#" aria-controls="kt_datatable" data-dt-idx="7" tabindex="0" class="page-link">35</a></li><li class="paginate_button page-item next" id="kt_datatable_next"><a href="#" aria-controls="kt_datatable" data-dt-idx="8" tabindex="0" class="page-link"><i class="ki ki-arrow-next"></i></a></li></ul></div></div></div>
          <!--end: Datatable-->
        </div>
      </div>
      <!--end: Datatable-->
    <!--end::Card-->
    </div>
    <!--end::Container-->
  </div>
  <!--end::Entry-->
</div>
<!--end::Content-->
