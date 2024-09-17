<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard TL</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="<?= base_url() ?>assets/plugins/custom/datatables/datatables.bundle7a50.css?v=7.2.7" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/css/custom.css') ?>" rel="stylesheet" type="text/css" />

    <link href="<?= base_url() ?>assets/plugins/global/plugins.bundle7a50.css?v=7.2.7" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/plugins/custom/prismjs/prismjs.bundle7a50.css?v=7.2.7" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/css/style.bundle7a50.css?v=7.2.7" rel="stylesheet" type="text/css" />

    <link href="<?= base_url() ?>assets/css/themes/layout/header/base/light7a50.css?v=7.2.7" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/css/themes/layout/header/menu/light7a50.css?v=7.2.7" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/css/themes/layout/brand/dark7a50.css?v=7.2.7" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/css/themes/layout/aside/dark7a50.css?v=7.2.7" rel="stylesheet" type="text/css" />

    <script src="<?= base_url('assets/jquery/jquery.min.js') ?>"></script>

    <link rel="shortcut icon" href="<?= base_url('assets/img/logos/favicon-ptp.png') ?>" />
</head>

<body>
    <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
        <div id="kt_header" class="header header-fixed">
            <div class="container-fluid d-flex align-items-stretch justify-content-center">
                <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
                    <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default d-flex">
                        <div class="nav nav-dark">
                            <a href="#" class="nav-link pl-0 pr-5">
                                <h3 style="color: #3F4254; margin-bottom: -1px;">DASHBOARD MONITORING AUDIT INTERNAL</h3>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content d-flex flex-column flex-column-fluid mt-19" id="kt_content">
            <div class="container-fluid">
                <div class="card card-custom">
                    <div class="card-body py-2">
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <div class="row w-25">
                                <div class="col">
                                    <select class="form-control form-control-solid form-control-lg" id="year">
                                        <?php foreach ($years as $year) { ?>
                                            <option value="<?= $year['TAHUN'] ?>"><?= $year['TAHUN'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row w-25">
                                <div class="col">
                                    <select class="form-control form-control-solid form-control-lg" id="iso">
                                            <option value="ALL">ALL ISO</option>
                                            <?php foreach ($iso as $i) { ?>
                                            <option value="<?= $i['ID_ISO'] ?>"><?= $i['NOMOR_ISO'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row w-25">
                                <div class="col">
                                    <select class="form-control form-control-solid form-control-lg" id="auditee">
                                        <option value="">-- All Auditee --</option>
                                        <?php foreach ($list_divisi as $divisi) { ?>
                                            <option value="<?= $divisi['ID_DIVISI'] ?>"><?= $divisi['NAMA_DIVISI'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- filter -->
                

                <!-- table & charts -->
                <div class="card card-custom mt-2">
                    <div class="card-body">
                        <h4>SUMMARY MONITORING TINDAK LANJUT</h4>
                        <table class="table table-bordered" id="temuanTable">
                            <thead>
                                <td rowspan="2">Divisi</td>
                                <th colspan="3">ISO 9001</th>
                                <th colspan="3">ISO 14001</th>
                                <th colspan="3">ISO 37001</th>
                                <th colspan="3">ISO 45001</th>
                                <tr>
                                    <td>Sudah Close</td>
                                    <td>Belum Close</td>
                                    <td>Total Temuan</td>
                                    <td>Sudah Close</td>
                                    <td>Belum Close</td>
                                    <td>Total Temuan</td>
                                    <td>Sudah Close</td>
                                    <td>Belum Close</td>
                                    <td>Total Temuan</td>
                                    <td>Sudah Close</td>
                                    <td>Belum Close</td>
                                    <td>Total Temuan</td>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <hr />
                        <div class="row mb-0 pb-0">
                            <!-- <div class="col-12">
                                <div id="charttemuaniso"></div>
                            </div> -->
                            <div class="col-12">
                                <div id="charttemuandivisi"></div>
                            </div>
                            <div class="col-12">
                                <div id="charttemuandivisi1"></div>
                            </div>
                            <div class="col-12">
                                <div id="charttemuandivisi2"></div>
                            </div>
                            <div class="col-12">
                                <div id="charttemuandivisi3"></div>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- end content -->
        </div>
        
    </div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


    <script>
        // Mengambil data dari controller menggunakan AJAX
        function loadData() {
            $.getJSON("<?php echo base_url('aia/Dashboard/getTemuanDataTable'); ?>", function(data) {
                var tableBody = $("#temuanTable tbody");
                tableBody.empty();

                $.each(data, function(index, row) {
                    var html = `
                        <tr class="main-row">
                            <td><a href="#" class="toggle-sub" data-index="${index}">${row.divisi}</a></td>
                            <td>${row.iso9001.closed}</td>
                            <td>${row.iso9001.open}</td>
                            <td>${row.iso9001.total}</td>
                            <td>${row.iso14001.closed}</td>
                            <td>${row.iso14001.open}</td>
                            <td>${row.iso14001.total}</td>
                            <td>${row.iso37001.closed}</td>
                            <td>${row.iso37001.open}</td>
                            <td>${row.iso37001.total}</td>
                            <td>${row.iso45001.closed}</td>
                            <td>${row.iso45001.open}</td>
                            <td>${row.iso45001.total}</td>
                        </tr>`;

                    tableBody.append(html);

                    // Cek jika ada sub-divisi
                    
                });

                // Tambahkan event listener untuk membuka sub-divisi
                $(".toggle-sub").click(function(event) {
                    event.preventDefault();
                    var index = $(this).data("index");
                    $(".sub-row-" + index).toggle(); // Toggle visibilitas sub-divisi
                });
            });
        }

        $(document).ready(function() {
            loadData();
        });
    </script>

    <script type="text/javascript">
        
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawStackedChartIso);

        function drawStackedChartIso() {
            var selectedIso = $('#iso').val();
            // Mengambil data dari controller menggunakan AJAX
            $.getJSON("<?php echo base_url('aia/Dashboard/getTemuanDataIso'); ?>", {iso: selectedIso}, function(data) {
                var chartData = [];
                chartData.push(['NOMOR_ISO', 'SUDAH_CLOSED', 'BELUM_CLOSED']);

                $.each(data, function(index, value) {
                    chartData.push([value.NOMOR_ISO, parseInt(value.SUDAH_CLOSED), parseInt(value.BELUM_CLOSED)]);
                });

                var dataTable = google.visualization.arrayToDataTable(chartData);

                var options = {
                    isStacked: true,
                    height: 400,
                    title: 'Jumlah Temuan Sudah Close dan Belum Close Berdasarkan ISO',
                    hAxis: {
                        title: 'Total Temuan',
                        minValue: 0,
                    },
                    vAxis: {
                        title: 'ISO 9001'
                    },
                    legend: { position: 'top', maxLines: 3 }
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('charttemuaniso'));
                chart.draw(dataTable, options);
            });
        }
        $('#iso').change(function() {
            drawStackedChartIso(); // Refresh the chart when the selected province changes
        });
    </script>
    

    <script type="text/javascript">
        
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawStackedChartDivisi);

        function drawStackedChartDivisi() {
            var selectedIso = $('#iso').val();
            // Mengambil data dari controller menggunakan AJAX
            $.getJSON("<?php echo base_url('aia/Dashboard/getTemuanDataDivisi'); ?>", {iso: selectedIso}, function(data) {
                var chartData = [];
                chartData.push(['NAMA_DIVISI', 'SUDAH_CLOSED', 'BELUM_CLOSED']);

                $.each(data, function(index, value) {
                    chartData.push([value.NAMA_DIVISI, parseInt(value.SUDAH_CLOSED), parseInt(value.BELUM_CLOSED)]);
                });

                var dataTable = google.visualization.arrayToDataTable(chartData);

                var options = {
                    isStacked: true,
                    height: 400,
                    title: 'Jumlah Temuan Sudah Close dan Belum Close Berdasarkan Divisi',
                    hAxis: {
                        title: 'Total Temuan',
                        minValue: 0,
                    },
                    vAxis: {
                        title: 'ISO 9001'
                    },
                    legend: { position: 'top', maxLines: 3 }
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('charttemuandivisi'));
                chart.draw(dataTable, options);
            });
        }
        $('#iso').change(function() {
            drawStackedChartDivisi(); // Refresh the chart when the selected province changes
        });
    </script>

    <script type="text/javascript">
        
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawStackedChartDivisi1);

        function drawStackedChartDivisi1() {
            var selectedIso = $('#iso').val();
            // Mengambil data dari controller menggunakan AJAX
            $.getJSON("<?php echo base_url('aia/Dashboard/getTemuanDataDivisi'); ?>", {iso: selectedIso}, function(data) {
                var chartData = [];
                chartData.push(['NAMA_DIVISI', 'SUDAH_CLOSED', 'BELUM_CLOSED']);

                $.each(data, function(index, value) {
                    chartData.push([value.NAMA_DIVISI, parseInt(value.SUDAH_CLOSED), parseInt(value.BELUM_CLOSED)]);
                });

                var dataTable = google.visualization.arrayToDataTable(chartData);

                var options = {
                    isStacked: true,
                    height: 400,
                    title: 'Jumlah Temuan Sudah Close dan Belum Close Berdasarkan Divisi',
                    hAxis: {
                        title: 'Total Temuan',
                        minValue: 0,
                    },
                    vAxis: {
                        title: 'ISO 14001'
                    },
                    legend: { position: 'top', maxLines: 3 }
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('charttemuandivisi1'));
                chart.draw(dataTable, options);
            });
        }
        $('#iso').change(function() {
            drawStackedChartDivisi1(); // Refresh the chart when the selected province changes
        });
    </script>

    <script type="text/javascript">
        
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawStackedChartDivisi2);

        function drawStackedChartDivisi2() {
            var selectedIso = $('#iso').val();
            // Mengambil data dari controller menggunakan AJAX
            $.getJSON("<?php echo base_url('aia/Dashboard/getTemuanDataDivisi'); ?>", {iso: selectedIso}, function(data) {
                var chartData = [];
                chartData.push(['NAMA_DIVISI', 'SUDAH_CLOSED', 'BELUM_CLOSED']);

                $.each(data, function(index, value) {
                    chartData.push([value.NAMA_DIVISI, parseInt(value.SUDAH_CLOSED), parseInt(value.BELUM_CLOSED)]);
                });

                var dataTable = google.visualization.arrayToDataTable(chartData);

                var options = {
                    isStacked: true,
                    height: 400,
                    title: 'Jumlah Temuan Sudah Close dan Belum Close Berdasarkan Divisi',
                    hAxis: {
                        title: 'Total Temuan',
                        minValue: 0,
                    },
                    vAxis: {
                        title: 'ISO 37001'
                    },
                    legend: { position: 'top', maxLines: 3 }
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('charttemuandivisi2'));
                chart.draw(dataTable, options);
            });
        }
        $('#iso').change(function() {
            drawStackedChartDivisi2(); // Refresh the chart when the selected province changes
        });
    </script>

    <script type="text/javascript">
        
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawStackedChartDivisi3);

        function drawStackedChartDivisi3() {
            var selectedIso = $('#iso').val();
            // Mengambil data dari controller menggunakan AJAX
            $.getJSON("<?php echo base_url('aia/Dashboard/getTemuanDataDivisi'); ?>", {iso: selectedIso}, function(data) {
                var chartData = [];
                chartData.push(['NAMA_DIVISI', 'SUDAH_CLOSED', 'BELUM_CLOSED']);

                $.each(data, function(index, value) {
                    chartData.push([value.NAMA_DIVISI, parseInt(value.SUDAH_CLOSED), parseInt(value.BELUM_CLOSED)]);
                });

                var dataTable = google.visualization.arrayToDataTable(chartData);

                var options = {
                    isStacked: true,
                    height: 400,
                    title: 'Jumlah Temuan Sudah Close dan Belum Close Berdasarkan Divisi',
                    hAxis: {
                        title: 'Total Temuan',
                        minValue: 0,
                    },
                    vAxis: {
                        title: 'ISO 45001'
                    },
                    legend: { position: 'top', maxLines: 3 }
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('charttemuandivisi3'));
                chart.draw(dataTable, options);
            });
        }
        $('#iso').change(function() {
            drawStackedChartDivisi3(); // Refresh the chart when the selected province changes
        });
    </script>

    <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                borderWidth: 1
            }]
            },
            options: {
            scales: {
                y: {
                beginAtZero: true
                }
            }
            }
        });
    </script>


    <script src="<?= base_url() ?>assets/plugins/global/plugins.bundle7a50.js?v=7.2.7"></script>
    <script src="<?= base_url() ?>assets/plugins/custom/prismjs/prismjs.bundle7a50.js?v=7.2.7"></script>
    <script src="<?= base_url() ?>assets/js/scripts.bundle7a50.js?v=7.2.7"></script>

    <script src="<?= base_url() ?>assets/js/pages/custom/user/edit-user7a50.js?v=7.2.7"></script>
    
    <script type="text/javascript">
      $(document).ready(function() {
        $('#year, #auditee').select2().on('change', function (e) {} );
      });
    </script>
    <script>
        "use strict";
        var KTAppSettings = {"breakpoints":{"sm":576,"md":768,"lg":992,"xl":1200,"xxl":1400},"colors":{"theme":{"base":{"white":"#ffffff","primary":"#3699FF","secondary":"#E5EAEE","success":"#1BC5BD","info":"#8950FC","warning":"#FFA800","danger":"#F64E60","light":"#E4E6EF","dark":"#181C32"},"light":{"white":"#ffffff","primary":"#E1F0FF","secondary":"#EBEDF3","success":"#C9F7F5","info":"#EEE5FF","warning":"#FFF4DE","danger":"#FFE2E5","light":"#F3F6F9","dark":"#D6D6E0"},"inverse":{"white":"#ffffff","primary":"#ffffff","secondary":"#3F4254","success":"#ffffff","info":"#ffffff","warning":"#ffffff","danger":"#ffffff","light":"#464E5F","dark":"#ffffff"}},"gray":{"gray-100":"#F3F6F9","gray-200":"#EBEDF3","gray-300":"#E4E6EF","gray-400":"#D1D3E0","gray-500":"#B5B5C3","gray-600":"#7E8299","gray-700":"#5E6278","gray-800":"#3F4254","gray-900":"#181C32"}},"font-family":"Poppins"};

        var KTGoogleChartsDemo = (function() {
            // Private functions
            var main = function() {
                // GOOGLE CHARTS INIT
                google.charts.load('current', {
                    'packages': ['corechart']
                });

                google.setOnLoadCallback(function() {
                    KTGoogleChartsDemo.runDemos();
                });
            };

            const chartTemuan = function() {
                var data = google.visualization.arrayToDataTable([
                    ['Task', 'Temuan'],
                    <?= $rekap['CHARTS']['TEMUAN'] ?>
                ]);

                var options = {
                    title: 'ISO 9001',
                    'isStacked' : true,
                    'width':400,
                        'height':300
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('charttemuan'));

                chart.draw(data, options);
            };

            const chartRekomendasi = function() {
                var data = google.visualization.arrayToDataTable([
                    ['Task', 'Hours per Day'],
                    <?= $rekap['CHARTS']['REKOMENDASI'] ?>
                ]);

                var options = {
                    title: 'Prosentasi Jumlah Rekomendasi',
                    pieHole: 0.4,
                    pieSliceTextStyle: {
                        color: 'black',
                    }
                };

                var chart = new google.visualization.PieChart(document.getElementById('chartrekomendasi'));

                chart.draw(data, options);
            };

            const chartPenyelesaian = function() {
                var data = google.visualization.arrayToDataTable([
                    ['Task', 'Hours per Day'],
                    ['SELESAI', <?= $rekap['TOTAL']['SELESAI'] ?>],
                    ['STL', <?= $rekap['TOTAL']['STL'] ?>],
                    ['BTL', <?= $rekap['TOTAL']['BTL'] ?>],
                    ['TPTD', <?= $rekap['TOTAL']['TPTD'] ?>]
                ]);

                var options = {
                    title: 'Prosentasi Penyelesaian Tindak Lanjut',
                    pieHole: 0.4,
                    pieSliceTextStyle: {
                        color: 'black',
                    }

                };

                var chart = new google.visualization.PieChart(document.getElementById('chartpenyelesaian'));

                chart.draw(data, options);
            };

            return {
                // public functions
                init: function() {
                    main();
                },

                runDemos: function() {
                    chartTemuan();
                    chartRekomendasi();
                    chartPenyelesaian();
                },
            };
        })();

        jQuery(document).ready((function() {
            KTGoogleChartsDemo.init();

            $('#year').val('<?= $year_filter ?>');
            $('#auditee').val(<?= $auditee ?>);

            $('#year').change(() => {
                const val = $('#year option:selected').val();
                const auditee = $('#auditee option:selected').val();
                const url = `<?= base_url() ?>monitoring/dashboardtl?year=${val}&auditee=`;
                document.location = url;
            })

            $('#auditee').change(() => {
                reload();
            })
        }));

        const reload = () => {
            const val = $('#year option:selected').val();
            const auditee = $('#auditee option:selected').val();
            const url = `<?= base_url() ?>monitoring/dashboardtl?year=${val}&auditee=${auditee}`;
            document.location = url;
        }
    </script>
</body>

</html>