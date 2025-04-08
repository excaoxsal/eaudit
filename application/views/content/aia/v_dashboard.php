<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard TL</title>

    <link rel="shortcut icon" href="<?= base_url('assets/img/logos/favicon-ptp.png') ?>" />
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Container to center everything */
    .scoreboard-container {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        /* Align buttons and scoreboard at the top */
        width: 100%;
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Styling for button group (aligned vertically) */
    .button-group {
        display: flex;
        flex-direction: column;
        /* Stack buttons vertically */
        margin-right: 20px;
        /* Space between buttons and scoreboard */
    }

    .button-group button {
        padding: 8px 15px;
        margin-bottom: 10px;
        background-color: #007BFF;
        border: none;
        color: white;
        font-size: 14px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .button-group button:hover {
        background-color: #0056b3;
    }

    .button-group button:focus {
        outline: none;
    }

    /* Styling for the scoreboard */
    #scoreboard {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        /* 5 equal columns */
        gap: 20px;
        /* Space between the boxes */
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Container for each box with its label */
    .box-container {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* Styling for the labels */
    .box-container label {
        font-size: 12px;
        color: #333;
        margin-bottom: 10px;
        font-weight: bold;
    }

    /* Styling for the individual boxes */
    .box {
        background-color: #ffffff;
        padding: 40px;
        width: 100%;
        text-align: center;
        border: 2px solid #dee2e6;
        border-radius: 10px;
        font-size: 80px;
        color: #333;
        font-weight: bold;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Responsive design for smaller screens */
    @media (max-width: 768px) {
        #scoreboard {
            grid-template-columns: 1fr 1fr;
            /* Two columns on smaller screens */
        }
    }

    @media (max-width: 480px) {
        #scoreboard {
            grid-template-columns: 1fr;
            /* Single column on very small screens */
        }
    }

    td.feat-title::before {
        content: attr(data-before);
    }

    td.feat-desc {
        font-size: 1.02em;
        font-weight: 400;
        padding-left: 1.5em;
        border: 0;

    }

    .parent {
        background-color: #D6EEEE;
    }

    /* Responsiveness */
    table {
        width: 100%;
        margin: 0 auto;
    }

    td,
    th {
        text-align: center;
    }

    /* Styling the parent and child rows */
    .parent {
        background-color: #dff0d8;
        /* Light green for parent row */
        font-weight: bold;
    }

    .child-row1221 {
        background-color: #f2f2f2;
        /* Light grey for child row */
    }

    /* Additional Hover effects for interactivity */
    .parent:hover {
        background-color: #c9e2b3;
    }

    .child-row1221:hover {
        background-color: #e0e0e0;
    }

    /* Adjusting title cursor for click effect */
    [title] {
        cursor: pointer;
    }

    /* Making table responsive */
    @media screen and (max-width: 768px) {
        table thead {
            display: none;
        }

        table,
        table tbody,
        table tr,
        table td {
            display: block;
            width: 100%;
        }

        table tr {
            margin-bottom: 10px;
        }

        table td {
            text-align: right;
            padding-left: 50%;
            position: relative;
        }

        table td:before {
            content: attr(data-label);
            position: absolute;
            left: 10px;
            text-align: left;
            font-weight: bold;
        }
    }
    </style>
</head>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                <span class="text-muted font-weight-bold mr-4">Dashboard</span>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column-fluid">
        <div class="container">

            <!-- table & charts -->
            <div class="card card-custom mt-2">
                <div class="card-body">
                    <div class="row" id="divisi">
                        <div class="col-6">
                            <h6>Pre-Audit</h6>
                           
                            <div id="chart-preaudit"></div>
                        </div>
                        <hr />
                        <div class="col-6">
                            <h6>Audit</h6>
                            <div id="chart-audit"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-custom mt-2">
                <div class="card-body py-2">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <div class="row w-25">
                            <div class="col">
                                <select class="form-control form-control-solid form-control-lg" id="year">
                                    <!-- <?php foreach ($years as $year) { ?>
                                        <option value="<?= $year['TAHUN'] ?>"><?= $year['TAHUN'] ?></option>
                                    <?php } ?> -->
                                    <option value="2024">2024</option>
                                </select>
                            </div>
                        </div>
                        <div class="row w-25">
                            <div class="col">
                                <select class="form-control form-control-solid form-control-lg" id="iso"
                                    onchange="changeiso()">
                                    <option value="ALL">ALL ISO</option>
                                    <?php foreach ($iso as $i) { ?>
                                    <option value="<?= $i['ID_ISO'] ?>"><?= $i['NOMOR_ISO'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="row w-25">
                            <div class="col">
                                <select class="form-control form-control-solid form-control-lg" id="changegraph"
                                    onchange="changegraph()">
                                    <option value="ALL">ALL</option>
                                    <option value="Divisi">Divisi</option>
                                    <option value="Cabang">Cabang</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-custom mt-2">
                <div class="card-body">
                    <div class="row" id="divisi">
                        <div class="col-6">
                            <h6>Post-audit</h6>
                           
                            <div id="chart-filterpusat"></div>
                        </div>
                        <hr />
                        <div class="col-6">
                            
                            <div id="chart-filterdivisi"></div>
                        </div>
                    </div>
                    
                </div>
            </div>

            <div class="card card-custom mt-2">
                <div class="card-body">
                    <div class="row" id="divisi">
                        <div class="col-6">
                            <div id="chart-klasifikasi"></div>
                        </div>
                        <div class="col-6">
                            <div id="chart-klausul"></div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card card-custom mt-2">
                <div class="card-body">
                    <div class="row" id="divisi">
                        <div class="col-6">
                            <div id="chart-close"></div>
                        </div>
                        <hr />
                        <div class="col-6">
                            <div id="chart-pie"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- end content -->
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js">
    $(document).ready(function() {
        $('[data-toggle="toggle"]').change(function() {
            $(this).parents().next('.hide').toggle();
        });
    });
</script>

<script>
    google.charts.load('current', {
        'packages': ['corechart', 'bar']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        fetch('<?php echo base_url('aia/Dashboard/get_iso_data'); ?>')
            .then(response => response.json())
            .then(data => {
                var dataTable = new google.visualization.DataTable();
                dataTable.addColumn('string', 'ISO Standard'); // Label kategori
                dataTable.addColumn('number', 'Jumlah Pertanyaan'); // Data batang
                dataTable.addColumn({ type: 'string', role: 'annotation' }); // Label di tengah batang

                // Loop untuk menambahkan data dari API
                data.forEach(item => {
                    dataTable.addRow([item.NOMOR_ISO, parseInt(item.jumlah_pertanyaan), item.jumlah_pertanyaan]);
                });

                var options = {
                    title: 'Jumlah Pertanyaan per ISO',
                    chartArea: { width: '60%' },
                    bars: 'vertical',
                    height: 500,
                    colors: ['#0066cc'], // Warna batang biru
                    annotations: {
                        alwaysOutside: false, // Pastikan label berada di dalam batang
                        textStyle: {
                            fontSize: 16,
                            bold: true,
                            color: 'white' // Warna teks putih agar kontras
                        }
                    },
                    vAxis: {
                        minValue: 0,
                        textStyle: { fontSize: 14 }
                    },
                    hAxis: {
                        textStyle: { fontSize: 14 }
                    }
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('chart-preaudit'));
                chart.draw(dataTable, options);
            })
            .catch(error => console.error('Error fetching data:', error));
    }
</script>
<script>
    google.charts.load("current", {
        packages: ["corechart", "bar"]
    });
    google.charts.setOnLoadCallback(drawChart);

    async function fetchDatarespon() {
        const response = await fetch('<?php echo base_url('aia/Dashboard/get_responded_question'); ?>'); // Ganti URL sesuai backend Anda
            const data = await response.json();
            return data;
    }

    async function drawChart() {
        const rawData = await fetchDatarespon();

        // Format data untuk Google Charts
        const data = new google.visualization.DataTable();
        data.addColumn("string", "Divisi");
        data.addColumn("number", "Open");
        data.addColumn({ type: "string", role: "annotation" }); // Label teks
        data.addColumn("number", "Closed");
        data.addColumn({ type: "string", role: "annotation" }); // Label teks

        // Memasukkan data ke dalam tabel
        rawData.forEach(row => {
            // Pastikan nilai Open dan Closed adalah number
            const openValue = Number(row.Open);
            const closedValue = Number(row.Closed);

            data.addRow([
                row.DIVISI,
                openValue,               // Pastikan ini number
                openValue.toString(),     // Label untuk "Open"
                closedValue,              // Pastikan ini number
                closedValue.toString()    // Label untuk "Closed"
            ]);
        });

        var options = {
            title: "Jumlah pertanyaan terjawab",
            isStacked: true,
            height: 500,
            legend: {
                position: "bottom"
            },
            chartArea: {
                width: "60%"
            },
            bar: {
                groupWidth: "50%"
            },
            annotations: {
                alwaysOutside: false,
                textStyle: {
                    fontSize: 10,
                    bold: false,
                    color: "white",
                },
            },
            hAxis: {
                title: "",
                textStyle: {
                    fontSize: 10
                },
            },
            vAxis: {
                minValue: 0,
                maxValue: 1000,
                format: "#",
            },
            colors: ["#3366cc", "#008000"], // Biru untuk Open, Merah untuk Closed
        };

        var chart = new google.visualization.ColumnChart(
            document.getElementById("chart-audit")
        );
        chart.draw(data, options);
    }
</script>

<!-- ini buat TOTAL TEMUAN AUDIT INTERNAL
KANTOR PUSAT BERDASARKAN ISO -->
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(fetchDatatemuan);

    async function fetchDatatemuan() {
        // Ambil data dari backend Bun
        const response = await fetch('<?php echo base_url('aia/Dashboard/get_temuan_by_iso_div'); ?>');
        const jsonData = await response.json();

        // Proses data untuk Google Charts
        const chartDatatemuan = [['ISO', 'Total Temuan', { role: 'annotation' }]];
        jsonData.forEach((item) => {
            if (item && item.NOMOR_ISO && item.TOTAL_TEMUAN !== undefined) {
                // Konversi TOTAL_TEMUAN ke numerik
                const totalTemuan = parseInt(item.TOTAL_TEMUAN);
                if (!isNaN(totalTemuan)) {
                    chartDatatemuan.push([item.NOMOR_ISO, totalTemuan,item.TOTAL_TEMUAN]);
                } else {
                    console.warn('Data TOTAL_TEMUAN tidak valid:', item.TOTAL_TEMUAN);
                }
            } else {
                console.warn('Data tidak valid:', item);
            }
        });
        // console.log(chartDatatemuan);
        drawCharttemuan(chartDatatemuan);
    }

    function drawCharttemuan(chartDatatemuan) {
        var data = google.visualization.arrayToDataTable(chartDatatemuan);
        console.log(chartDatatemuan);
        var options = {
        title: 'TOTAL TEMUAN AUDIT INTERNAL\nKANTOR PUSAT BERDASARKAN ISO',
        chartArea: { width: '60%' },
        height: 500,
        vAxis: {
            title: 'Total Temuan',
            minValue: 0,
        },
        bar: { groupWidth: '80%' }, // Perbesar batang
        hAxis: {
            title: 'ISO',
        },
        annotations: {
            alwaysOutside: true,
            textStyle: {
            fontSize: 12,
            bold: true,
            color: '#000',
            },
        },
        legend: { position: 'bottom', alignment: 'center' },
        colors: ['#3366cc', '#109618', '#ff9900', '#dc3912'], // Variasi warna untuk setiap ISO
        isStacked: false,
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart-filterpusat'));
        chart.draw(data, options);
    }
</script>
<script>
    google.charts.load('current', {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
        ['Divisi', 'Total', { role: 'annotation' }],
        ['PERENCANAAN STRATEGIS', 5, '5'],
        ['PENGAWASAN INTERNAL &', 4, '4'],
        ['PENGEMBANGAN USAHA', 6, '6'],
        ['OPERASI', 6, '6'],
        ['SISTEM INFORMASI', 12, '12'],
        ['KEUANGAN & MANAJEMEN', 21, '21']
    ]);

    var options = {
        title: 'TOTAL TEMUAN ISO 9001:2015 PER DIVISI',
        chartArea: {width: '60%'},
        height : 500,
        hAxis: {
        title: 'TOTAL',
            minValue: 0
        },
        vAxis: {
           title: 'DIVISI'
        },
        annotations: {
            alwaysOutside: true,
            textStyle: {
            fontSize: 12,
            bold: true,
            color: '#000'
            }
        },
          legend: 'none'
    };

    var chart = new google.visualization.BarChart(document.getElementById('chart-filterdivisi'));
    chart.draw(data, options);
    }
</script>
<script>
      google.charts.load('current', {packages:['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Divisi', 'Mayor', { role: 'annotation' }, 'Minor', { role: 'annotation' }, 'Observasi', { role: 'annotation' }],
            ['Perencanaan', 1, '1', 4, '4', 4, '4'],
            ['Sekretaris', 2, '2', 4, '4', 4, '4'],
            ['Pengawasan', 4, '4', 2, '2', 3, '3'],
            ['Pemasaran', 5, '5', 1, '1', 2, '2'],
            ['Pengembangan', 6, '6', 1, '1', 2, '2'],
            ['Satuan Kerja', 6, '6', 1, '1', 3, '3'],
            ['Operasi', 6, '6', 3, '3', 2, '2'],
            ['Teknik', 4, '4', 4, '4', 4, '4'],
            ['Sistem Informasi', 5, '5', 5, '5', 5, '5'],
            ['SDM & Umum', 6, '6', 6, '6', 6, '6'],
            ['Keuangan', 7, '7', 7, '7', 7, '7']
        ]);

        var options = {
          title: 'Chart Klasifikasi Temuan',
          chartArea: {width: '60%'},
          height : 500,
          isStacked: 'percent',
          hAxis: {
            title: 'Divisi'
          },
          vAxis: {
            title: 'Persentase (%)',
            minValue: 0,
            format: '#%'
          },
          legend: { position: 'top', maxLines: 3 },
          colors: ['#dc3912', '#ffcc00', '#3366cc'],
          annotations: {
            alwaysOutside: false, // Biarkan annotation berada dalam batang
            textStyle: {
                fontSize: 12,
                color: '#000'
            },
            position: 'inside' // Posisikan teks annotation di tengah batang
            }
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart-klasifikasi'));
        chart.draw(data, options);
      }
</script>
<script>
      google.charts.load('current', {packages:['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Klausul', 'Jumlah Temuan', { role: 'annotation' }],
          ['K.4', 5, '5'],
          ['K.5', 4, '4'],
          ['K.6', 3, '3'],
          ['K.7', 2, '2'],
          ['K.8', 1, '1'],
          ['K.9', 2, '2'],
          ['K.10', 1, '1']
        ]);

        var options = {
          title: 'Jumlah Temuan Per Klausul',
          chartArea: { width: '60%' },
          height: 500,
          hAxis: {
            title: 'Klausul',
          },
          vAxis: {
            title: 'Jumlah Temuan',
            minValue: 0
          },
          legend: { position: 'none' },
          colors: ['#1f77b4'],
          annotations: {
            alwaysOutside: false, // Menempatkan angka di dalam batang
            textStyle: {
              fontSize: 14,
              bold: true,
              color: '#fff' // Warna teks putih agar kontras
            }
          }
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart-klausul'));
        chart.draw(data, options);
      }
</script>
<script>
      google.charts.load("current", { packages: ["corechart"] });
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ["Divisi", "Open", { role: "annotation" }, "Closed", { role: "annotation" }],
          ["Div 1", 20, "20", 80, "80"],
          ["Div 2", 30, "30", 70, "70"],
          ["Div 3", 40, "40", 60, "60"],
          ["Div 4", 50, "50", 50, "50"],
          ["Div 5", 55, "55", 45, "45"],
          ["Div 6", 27, "27", 73, "73"],
          ["Div 7", 33, "33", 67, "67"],
          ["Div 8", 58, "58", 42, "42"],
          ["Div 9", 27, "27", 73, "73"],
          ["Div 10", 10, "10", 90, "90"],
          ["Div 11", 12, "12", 88, "88"],
        ]);

        var options = {
          title: "Jumlah Temuan yang sudah ditutup",
          chartArea: { width: "60%" },
          height: 500,
          isStacked: true,
          vAxis: {
            title: "Persentase",
            minValue: 0,
            maxValue: 100,
            format: "#'%'",
          },
          hAxis: {
            title: "Divisi",
          },
          legend: { position: "bottom" },
          bar: { groupWidth: "70%" },
          colors: ["#dc3912", "#3366cc"],
          
          annotations: {
            alwaysOutside: false, // Biarkan annotation berada dalam batang
            textStyle: {
                fontSize: 12,
                color: '#000'
            },
            position: 'inside' // Posisikan teks annotation di tengah batang
            }
        };

        var chart = new google.visualization.ColumnChart(document.getElementById("chart-close"));
        chart.draw(data, options);
      }    
</script>
<script>
      google.charts.load("current", { packages: ["corechart"] });
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ["Clause", "Percentage"],
          ["K.4", 28],
          ["K.5", 22],
          ["K.6", 17],
          ["K.7", 11],
          ["K.8", 5],
          ["K.9", 11],
          ["K.10", 6],
        ]);

        var options = {
          title: "Persentase unresolved clauses",
          pieHole: 0.5, // Membuat pie chart menjadi donut chart
          colors: ["#1F77B4", "#CCC", "#2CA02C", "#98DF8A", "#FFD700", "#FF8C00", "#D62728"], // Warna sesuai gambar
          legend: { position: "bottom" },
          chartArea: { width: "60%" },
          height: 500,
          pieSliceText: "percentage", // Menampilkan angka dalam persen
          pieSliceTextStyle: {
            fontSize: 12,
            bold: true,
          },
        };

        var chart = new google.visualization.PieChart(document.getElementById("chart-pie"));
        chart.draw(data, options);
      }
</script>
<script src="<?= base_url() ?>assets/plugins/global/plugins.bundle7a50.js?v=7.2.7"></script>
<script src="<?= base_url() ?>assets/plugins/custom/prismjs/prismjs.bundle7a50.js?v=7.2.7"></script>
<script src="<?= base_url() ?>assets/js/scripts.bundle7a50.js?v=7.2.7"></script>
<script src="<?= base_url() ?>assets/js/pages/custom/user/edit-user7a50.js?v=7.2.7"></script>
</body>
</html>