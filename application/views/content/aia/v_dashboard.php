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

            <!-- table & charts -->
            <div class="card card-custom mt-2">
                <div class="card-body">
                    <div class="row" id="divisi">
                        <div class="col-12">
                            <h6>Pre-Audit</h6>
                            <div id="chart-preaudit"></div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="card card-custom mt-2">
                <div class="card-body">
                    <div class="row" id="divisi">
                        <div class="col-12">
                            <h6>Audit</h6>
                            <div id="chart-audit" style="width:100%; height:500px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-custom mt-2">
                <div class="card-body">
                    <div class="row" id="divisi">
                        <div class="col-6">
                            <h6>Post-audit</h6>
                           
                            <div id="chart-filterpusat" style="width:100%; height:500px;"></div>
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
                        <div class="col-12">
                            <div id="chart-klasifikasi"></div>
                        </div>
                        

                    </div>
                </div>
            </div>
            <div class="card card-custom mt-2">
                <div class="card-body">
                    <div class="row" id="divisi">
                        
                        <div class="col-12">
                            <div id="chart-klausul"></div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card card-custom mt-2">
                <div class="card-body">
                    <div class="row" id="divisi">
                        <div class="col-12">
                            <div id="chart-close" style="width:100%; height:500px;"></div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="card card-custom mt-2">
                <div class="card-body">
                    <div class="row" id="divisi">

                        <div class="col-12">
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

<!-- Start Jumlah Pertanyaan Terjawab -->
<script>
  google.charts.load('current',{packages:['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  async function fetchDatarespon() {
    const resp = await fetch('<?= base_url("aia/Dashboard/get_responded_question") ?>');
    return resp.json();
  }

  async function drawChart() {
    const raw = await fetchDatarespon();

    // 1) Build DataTable with TWO annotation columns
    const dt = new google.visualization.DataTable();
    dt.addColumn('string', 'Divisi');
    dt.addColumn('number', 'Open');
    dt.addColumn({ type: 'string', role: 'annotation' });   // openAnn
    dt.addColumn('number', 'Closed');
    dt.addColumn({ type: 'string', role: 'annotation' });   // closedAnn

    // 2) Fill rows, apply 12% threshold
    const threshold = 0.12;
    raw.forEach(r => {
      const open   = +r.Open   || 0;
      const closed = +r.Closed || 0;
      const sum    = open + closed || 1;
      const pctO   = open   / sum;
      const pctC   = closed / sum;

      const openAnn   = pctO  >= threshold ? open.toString()   : null;
      const closedAnn = pctC >= threshold ? closed.toString() : null;

      dt.addRow([ r.DIVISI, open, openAnn, closed, closedAnn ]);
    });

    // 3) Draw as 100%-stacked with END‐INSIDE annotations
    const options = {
      title: 'Jumlah Pertanyaan Terjawab',
      isStacked: 'percent',
      chartArea: { width:'70%', height:'80%' },
      bar: { groupWidth:'40px' },
      colors: ['#3366cc','#008000'],
      legend:{ position:'bottom' },
      hAxis:{ textStyle:{ fontSize:10 } },
      vAxis:{
        format:'percent',
        viewWindow:{ min:0, max:1 },
        ticks:[0, .25, .5, .75, 1]
      },
      annotations:{
        // force inside‐end of segment:
        alwaysOutside: false,
        position: 'insideEnd',
        textStyle:{
          fontSize: 10,
          color: '#fff',     // white for contrast
          auraColor: 'none'  // no halo
        }
      }
    };

    new google.visualization.ColumnChart(
      document.getElementById('chart-audit')
    ).draw(dt, options);
  }
</script>
<!-- End Jumlah Petanyaan Terjawab -->

<!-- ini buat TOTAL TEMUAN AUDIT INTERNAL
KANTOR PUSAT BERDASARKAN ISO -->
<script type="text/javascript">
    google.charts.load('current',{packages:['corechart']});
    google.charts.setOnLoadCallback(fetchDatatemuan);

    async function fetchDatatemuan() {
        const resp     = await fetch('<?= base_url("aia/Dashboard/get_temuan_by_iso_div") ?>');
        const jsonData = await resp.json();

        // 1) Daftar ISO & peta warna (beri urutan yang konsisten!)
        const isoList   = jsonData.map(r => r.NOMOR_ISO);
        const colorMap  = {
        'ISO 9001':   '#3366cc',
        'ISO 45001':  '#109618',
        'ISO 14001':  '#ff9900',
        'ISO 37001':  '#dc3912'
        };
        const colors    = isoList.map(iso => colorMap[iso] || '#888');

        // 2) Header pivot: ["ISO", iso1, annotation, iso2, annotation, ...]
        const header = ['ISO'];
        isoList.forEach(iso => {
        header.push(iso, { role: 'annotation', type: 'string' });
        });
        const chartDatatemuan = [ header ];

        // 3) Baris per ISO category
        isoList.forEach(cat => {
        // cari value untuk this ISO
        const rec = jsonData.find(r => r.NOMOR_ISO === cat) || {};
        const val = Number(rec.TOTAL_TEMUAN) || 0;
        const ann = val > 0 ? val.toString() : null;

        // bangun row: [ cat,  valOrNull, annOrNull,  ... ]
        const row = [ cat ];
        isoList.forEach(iso => {
            if (iso === cat) row.push(val, ann);
            else              row.push(null, null);
        });
        chartDatatemuan.push(row);
        });

        drawCharttemuan(chartDatatemuan, colors);
    }

    function drawCharttemuan(chartDatatemuan, colors) {
        // 4) Buat DataTable
        const data = google.visualization.arrayToDataTable(chartDatatemuan);

        // 5) Opsi chart
        const options = {
        title: 'TOTAL TEMUAN AUDIT INTERNAL\nKANTOR PUSAT BERDASARKAN ISO',
        chartArea: { width: '60%', height: '75%' },
        height: 500,
        isStacked: false,
        bar: { groupWidth: '60%' },
        colors: colors,
        legend: { position: 'bottom', alignment: 'center' },
        hAxis: {
            title: 'ISO',
            slantedText: true,
            slantedTextAngle: 45,
            textStyle: { fontSize: 12 }
        },
        vAxis: {
            title: 'Total Temuan',
            minValue: 0
        },
        annotations: {
            alwaysOutside: true,
            position: 'center',
            textStyle: { fontSize: 12, bold: true, color: '#000' }
        }
        };

        // 6) Render
        const chart = new google.visualization.ColumnChart(
        document.getElementById('chart-filterpusat')
        );
        chart.draw(data, options);
    }
</script>
<!-- End -->

<!-- Start TOTAL TEMUAN ISO 9001:2015 PER DIVISI -->
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
<!-- End TOTAL TEMUAN ISO 9001:2015 PER DIVISI -->


<!--Start Chart Klasifikasi Temuan -->
<script>
    google.charts.load('current',{ packages:['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        fetch('<?= base_url("aia/Dashboard/chartKlasifikasi") ?>')
        .then(r => r.json())
        .then(raw => {
            // 1) Build DataTable manual
            const dt = new google.visualization.DataTable();
            dt.addColumn('string','Divisi');
            dt.addColumn('number','Major');
            dt.addColumn({ type:'string', role:'annotation' });
            dt.addColumn('number','Minor');
            dt.addColumn({ type:'string', role:'annotation' });
            dt.addColumn('number','Observasi');
            dt.addColumn({ type:'string', role:'annotation' });

            // 2) Isi baris dengan threshold 12%
            raw.slice(1).forEach(row => {
            const div   = row[0];
            const maj   = Number(row[1]);
            const min   = Number(row[3]);
            const obs   = Number(row[5]);
            const sum   = maj + min + obs || 1;
            const pct   = v => v/sum;

            // hanya jika ≥12%
            const annMaj = (maj>0 && pct(maj)>=0.05) ? maj.toString() : null;
            const annMin = (min>0 && pct(min)>=0.05) ? min.toString() : null;
            const annObs = (obs>0 && pct(obs)>=0.05) ? obs.toString() : null;

            dt.addRow([ div, maj, annMaj, min, annMin, obs, annObs ]);
            });

            // 3) Opsi chart: annotation selalu di dalam, di‐center
            const options = {
            title: 'Chart Klasifikasi Temuan',
            chartArea: { width:'60%' },
            height: 500,
            isStacked: 'percent',
            bar: { groupWidth:'40px' },
            hAxis: { title:'Divisi' },
            vAxis: {
                title: 'Persentase',
                format: 'percent',
                viewWindowMode: 'explicit',
                viewWindow: { min:0, max:1 },
                ticks: [0,0.25,0.5,0.75,1]
            },
            legend: { position:'top', maxLines:3 },
            colors: ['#dc3912','#ffcc00','#3366cc'],
            annotations: {
                alwaysOutside: false,   // pastikan dalam batang
                position: 'center',     // tepat di tengah segmen
                textStyle: {
                fontSize: 10,
                color: '#000',
                auraColor: 'none'     // hilangkan outline putih
                }
            }
            };

            // 4) Gambar chart
            new google.visualization.ColumnChart(
            document.getElementById('chart-klasifikasi')
            ).draw(dt, options);
        });
    }
</script>
<!-- End Chart Klasifikasi Temuan -->


<!-- Start Jumlah Temuan -->
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
<!-- End Jumlah Temuan -->


<!-- Start Jumlah Temuan yang Sudah Ditutup -->
<script>
    google.charts.load("current", { packages: ["corechart"] });
    google.charts.setOnLoadCallback(drawChart);

    async function drawChart() {
        // 1) Ambil array-of-arrays dari endpoint
        const resp = await fetch('<?= base_url("aia/Dashboard/chartClose") ?>');
        const raw  = await resp.json();
        // raw[0] = ['Divisi','Open',{role:'annotation'},'Closed',{role:'annotation'}]
        // raw[1…] = [ divisi, openCount, openAnn, closedCount, closedAnn ]

        // 2) Definisi DataTable manual
        const dt = new google.visualization.DataTable();
        dt.addColumn('string','Divisi');
        dt.addColumn('number','Open');
        dt.addColumn({ type:'string', role:'annotation' });
        dt.addColumn('number','Closed');
        dt.addColumn({ type:'string', role:'annotation' });

        // 3) Isi baris dengan threshold annotation ≥10%
        for (let i = 1; i < raw.length; i++) {
        const [ div, oVal, , cVal ] = raw[i];
        const open   = Number(oVal) || 0;       // benar: raw[i][1]
        const closed = Number(cVal) || 0;       // benar: raw[i][3]
        const sum    = open + closed || 1;
        const pct    = v => v / sum;

        // hanya annotation jika ≥10%
        const annOpen   = pct(open)   >= 0.07 ? open.toString()   : null;
        const annClosed = pct(closed) >= 0.07 ? closed.toString() : null;

        dt.addRow([ div, open, annOpen, closed, annClosed ]);
        }

        // 4) Gambar chart
        const options = {
        title: "Jumlah Temuan yang Sudah Ditutup",
        chartArea: { width: "80%" },
        height: 500,
        isStacked: 'percent',
        bar: { groupWidth: '40px' },
        hAxis: { title: 'Divisi' },
        vAxis: {
            title: 'Persentase',
            format: 'percent',
            viewWindowMode: 'explicit',
            viewWindow: { min: 0, max: 1 },
            ticks: [0, 0.25, 0.5, 0.75, 1]
        },
        legend: { position: 'bottom' },
        colors: ['#dc3912','#3366cc'],  // merah=open, biru=closed
        annotations: {
            alwaysOutside: false,   // di dalam batang
            position: 'center',     // tepat di tengah segmen
            textStyle: {
            fontSize: 12,
            color: '#fff',
            auraColor: 'none'
            }
        }
        };

        new google.visualization.ColumnChart(
        document.getElementById("chart-close")
        ).draw(dt, options);
    }
</script>
<!-- End Chart Jumlah Temuan yang Sudah Ditutup -->
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