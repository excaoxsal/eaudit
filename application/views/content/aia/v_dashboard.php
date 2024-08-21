<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dahboard TL</title>

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
                                <h3 style="color: #3F4254; margin-bottom: -1px;">DASHBOARD MONITORING TINDAK LANJUT AUDIT</h3>
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
                <div class="card card-custom mt-2">
                    <div class="card-body py-5">
                        <div class="row">
                            <div class="col-2 text-center">
                                <h4>TOTAL TEMUAN</h4>
                                <h1><?= $rekap['TOTAL']['TEMUAN'] ?></h1>
                            </div>
                            <div class="col-2 text-center">
                                <h4>TOTAL REKOMENDASI</h4>
                                <h1><?= $rekap['TOTAL']['REKOMENDASI'] ?></h1>
                            </div>
                            <div class="col-2 text-center">
                                <h4>TOTAL SELESAI</h4>
                                <h1><?= $rekap['TOTAL']['SELESAI'] ?></h1>
                            </div>
                            <div class="col-2 text-center">
                                <h4>TOTAL STL</h4>
                                <h1><?= $rekap['TOTAL']['STL'] ?></h1>
                            </div>
                            <div class="col-2 text-center">
                                <h4>TOTAL BTL</h4>
                                <h1><?= $rekap['TOTAL']['BTL'] ?></h1>
                            </div>
                            <div class="col-2 text-center">
                                <h4>TOTAL TPTD</h4>
                                <h1><?= $rekap['TOTAL']['TPTD'] ?></h1>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- table & charts -->
                <div class="card card-custom mt-2">
                    <div class="card-body">
                        <h4>SUMMARY MONITORING TINDAK LANJUT</h4>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">UNIT AUDITEE</th>
                                    <th scope="col">TEMUAN</th>
                                    <th scope="col">REKOMENDASI</th>
                                    <th scope="col">SELESAI</th>
                                    <th scope="col">SUDAH TINDAK LANJUT (STL)</th>
                                    <th scope="col">BELUM TINDAK LANJUT (BTL)</th>
                                    <th scope="col">TEMUAN TIDAK DAPAT DITINDAKLANJUTI (TPTD)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rekap['REKAP'] as $item) { ?>
                                    <tr>
                                        <th scope="row"><?= $item['DIVISI'] ?></th>
                                        <td><?= $item['TEMUAN'] ?></td>
                                        <td><?= $item['REKOMENDASI'] ?></td>
                                        <td><?= $item['SELESAI'] ?></td>
                                        <td><?= $item['STL'] ?></td>
                                        <td><?= $item['BTL'] ?></td>
                                        <td><?= $item['TPTD'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <hr />
                        <div class="row mb-0 pb-0">
                            <div class="col-4">
                                <div id="charttemuan" class="w-100" style="height:300px"></div>
                            </div>
                            <div class="col-4">
                                <div id="chartrekomendasi" class="w-100" style="height:300px"></div>
                            </div>
                            <div class="col-4">
                                <div id="chartpenyelesaian" class="w-100" style="height:300px"></div>
                            </div>
                        </div>
                        <div class="row" style="margin-top:-46px">
                            <div class="col">
                                <hr />
                                <table class="table table-striped table-bordered">
                                    <thead>

                                        <tr>
                                            <th scope="col" style="vertical-align:middle">UNIT AUDITEE</th>
                                            <th scope="col" style="vertical-align:middle">TEMUAN</th>
                                            <th scope="col" style="vertical-align:middle">REKOMENDASI</th>
                                            <th scope="col" style="vertical-align:middle">PIC</th>
                                            <th scope="col" style="vertical-align:middle">BATAS WAKTU</th>
                                            <th scope="col" style="vertical-align:middle">TANGGAL PENYELESAIAN</th>
                                            <th scope="col" style="vertical-align:middle">HASIL MONITORING</th>
                                            <th scope="col" style="vertical-align:middle">STATUS TL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data_table as $item) {
                                            $i = 0;
                                            $data_temuan = "<strong>" . $item['JUDUL_TEMUAN'] . "</strong><br><br>" . $item['TEMUAN'];
                                            $temuan = str_replace('<img src=', '<img width="300" src=', $data_temuan);
                                            if ($item['TOTAL_REKOMENDASI'] != 0) {
                                                foreach ($item['REKOMENDASI'] as $rek) {

                                                    $rekom = str_replace('<img src=', '<img width="300" src=', $rek['REKOMENDASI']);
                                                    $hasil = str_replace('<img src=', '<img width="300" src=', $rek['HASIL_MONITORING']);

                                                    if ($i == 0) {
                                                        echo '<tr>';
                                                        echo '<th scope="row"  rowspan="' . $item['TOTAL_REKOMENDASI'] . '">' . $item['AUDITEE'] . '</th>';
                                                        echo '<td rowspan="' . $item['TOTAL_REKOMENDASI'] . '">' . $temuan . '</td>';
                                                        echo '<td>' . $rekom . '</td>';
                                                        echo '<td>' . join("<br/><br>", json_decode($rek['PIC'])) . '</td>';
                                                        echo '<td>' . $rek['BATAS_WAKTU'] . '</td>';
                                                        echo '<td>' . $rek['TGL_PENYELESAIAN'] . '</td>';
                                                        echo '<td>' . $hasil . '</td>';
                                                        echo '<td>' . $rek['TK_PENYELESAIAN'] . '</td>';
                                                        echo '</tr>';
                                                    } else {
                                                        echo '<tr>';
                                                        echo '<td>' . $rekom . '</td>';
                                                        echo '<td>' . join("<br/><br>", json_decode($rek['PIC'])) . '</td>';
                                                        echo '<td>' . $rek['BATAS_WAKTU'] . '</td>';
                                                        echo '<td>' . $rek['TGL_PENYELESAIAN'] . '</td>';
                                                        echo '<td>' . $hasil . '</td>';
                                                        echo '<td>' . $rek['TK_PENYELESAIAN'] . '</td>';
                                                        echo '</tr>';
                                                    }
                                                    $i++;
                                                }
                                            } else {
                                                echo '<tr>';
                                                echo '<th scope="row"> ' . $item['AUDITEE'] . '</th>';
                                                echo '<td>' . $temuan . '</td>';
                                                echo '<td colspan="6"></td>';
                                                echo '</tr>';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end content -->
        </div>
    </div>

    <script src="<?= base_url() ?>assets/plugins/global/plugins.bundle7a50.js?v=7.2.7"></script>
    <script src="<?= base_url() ?>assets/plugins/custom/prismjs/prismjs.bundle7a50.js?v=7.2.7"></script>
    <script src="<?= base_url() ?>assets/js/scripts.bundle7a50.js?v=7.2.7"></script>

    <script src="<?= base_url() ?>assets/js/pages/custom/user/edit-user7a50.js?v=7.2.7"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
                    ['Task', 'Hours per Day'],
                    <?= $rekap['CHARTS']['TEMUAN'] ?>
                ]);

                var options = {
                    title: 'Prosentasi Jumlah Temuan',
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