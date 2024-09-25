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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="shortcut icon" href="<?= base_url('assets/img/logos/favicon-ptp.png') ?>" />
    <style>
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
        td, th {
            text-align: center;
        }

        /* Styling the parent and child rows */
        .parent {
            background-color: #dff0d8; /* Light green for parent row */
            font-weight: bold;
        }

        .child-row1221 {
            background-color: #f2f2f2; /* Light grey for child row */
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

            table, table tbody, table tr, table td {
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
                                    <select class="form-control form-control-solid form-control-lg" id="changegraph" onchange="changegraph()">
                                            <option value="ALL">ALL</option>
                                            <option value="Divisi">Divisi</option>
                                            <option value="Cabang">Cabang</option>
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
                        <hr />
                        <div class="row mb-0 pb-0" id="divisi">
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
                        <div class="row mb-0 pb-0" id="cabang">
                            <!-- <div class="col-12">
                                <div id="charttemuaniso"></div>
                            </div> -->
                            <div class="col-12">
                                <div id="charttemuancabang"></div>
                            </div>
                            <div class="col-12">
                                <div id="charttemuancabang1"></div>
                            </div>
                            <div class="col-12">
                                <div id="charttemuancabang2"></div>
                            </div>
                            <div class="col-12">
                                <div id="charttemuancabang3"></div>
                            </div>
                            
                        </div>
                    
                        <div class="row mb-0 pb-0">
                            <table class="table table-bordered" id="temuanTable">
                                <thead>
                                    <td rowspan="2">Divisi</td>
                                    <th colspan="3"  style="text-align:center;" >ISO 9001</th>
                                    <th colspan="3"  style="text-align:center;">ISO 14001</th>
                                    <th colspan="3"  style="text-align:center;">ISO 37001</th>
                                    <th colspan="3"  style="text-align:center;">ISO 45001</th>
                                    <tr>
                                        <td style="text-align:center;">Sudah Close</td>
                                        <td style="text-align:center;">Belum Close</td>
                                        <td style="text-align:center;">Total Temuan</td>
                                        <td style="text-align:center;">Sudah Close</td>
                                        <td style="text-align:center;">Belum Close</td>
                                        <td style="text-align:center;">Total Temuan</td>
                                        <td style="text-align:center;">Sudah Close</td>
                                        <td style="text-align:center;">Belum Close</td>
                                        <td style="text-align:center;">Total Temuan</td>
                                        <td style="text-align:center;">Sudah Close</td>
                                        <td style="text-align:center;">Belum Close</td>
                                        <td style="text-align:center;">Total Temuan</td>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                
                                <?php foreach ($datadivisi as $ddivisi) { ?>
                                    <?php for ($i=0;$i<=count($datatable[$ddivisi['KODE']]);$i++) { ?>
                                        <?php if(isset($datatable[$ddivisi['KODE']][$i])){ ?>
                                            <?php if($datatable[$ddivisi['KODE']][$i]['tipe']=="Divisi"){ $n+=1 ?>

                                                <tr class="parent" id="row12<?=$n?>" title="Click to expand/collapse" style="cursor: pointer;">  
                                                    <td class="feat-title"><?= $datatable[$ddivisi['KODE']][$i]['namadivisi']?></td>  
                                                    <td><?= $datatable[$ddivisi['KODE']][$i]['iso9001']['open']?></td>
                                                    <td><?= $datatable[$ddivisi['KODE']][$i]['iso9001']['closed']?></td>
                                                    <td><?= $datatable[$ddivisi['KODE']][$i]['iso9001']['total']?></td>
                                                    <td><?= $datatable[$ddivisi['KODE']][$i]['iso14001']['open']?></td>
                                                    <td><?= $datatable[$ddivisi['KODE']][$i]['iso14001']['closed']?></td>
                                                    <td><?= $datatable[$ddivisi['KODE']][$i]['iso14001']['total']?></td>
                                                    <td><?= $datatable[$ddivisi['KODE']][$i]['iso37001']['open']?></td>
                                                    <td><?= $datatable[$ddivisi['KODE']][$i]['iso37001']['closed']?></td>
                                                    <td><?= $datatable[$ddivisi['KODE']][$i]['iso37001']['total']?></td>
                                                    <td><?= $datatable[$ddivisi['KODE']][$i]['iso45001']['open']?></td>
                                                    <td><?= $datatable[$ddivisi['KODE']][$i]['iso45001']['closed']?></td>
                                                    <td><?= $datatable[$ddivisi['KODE']][$i]['iso45001']['total']?></td>
                                                </tr>  
                                                
                                            <?php } ?>
                                            <?php if($datatable[$ddivisi['KODE']][$i]['tipe']=="Subdivisi"){ ?>
                                                <tr class="child-row12<?=$n?>" style="display: table-row;">  
                                                    <td class="feat-title"><?= $datatable[$ddivisi['KODE']][$i]['namadivisi']?></td>  
                                                    <td><?= $datatable[$ddivisi['KODE']][$i]['iso9001']['open']?></td>
                                                    <td><?= $datatable[$ddivisi['KODE']][$i]['iso9001']['closed']?></td>
                                                    <td><?= $datatable[$ddivisi['KODE']][$i]['iso9001']['total']?></td>
                                                    <td><?= $datatable[$ddivisi['KODE']][$i]['iso14001']['open']?></td>
                                                    <td><?= $datatable[$ddivisi['KODE']][$i]['iso14001']['closed']?></td>
                                                    <td><?= $datatable[$ddivisi['KODE']][$i]['iso14001']['total']?></td>
                                                    <td><?= $datatable[$ddivisi['KODE']][$i]['iso37001']['open']?></td>
                                                    <td><?= $datatable[$ddivisi['KODE']][$i]['iso37001']['closed']?></td>
                                                    <td><?= $datatable[$ddivisi['KODE']][$i]['iso37001']['total']?></td>
                                                    <td><?= $datatable[$ddivisi['KODE']][$i]['iso45001']['open']?></td>
                                                    <td><?= $datatable[$ddivisi['KODE']][$i]['iso45001']['closed']?></td>
                                                    <td><?= $datatable[$ddivisi['KODE']][$i]['iso45001']['total']?></td>
                                                </tr>  
                                            <?php } ?>

                                        <?php } ?>
                                    
                                    
                                    <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end content -->
        
    </div>    
</body> 
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js">
        $(document).ready(function() {
	$('[data-toggle="toggle"]').change(function(){
		$(this).parents().next('.hide').toggle();
	});
});
    </script>
<script>
function changegraph() {
  var x = document.getElementById("changegraph").value;
  if(x=="Cabang"){
    document.getElementById("cabang").style.display = "block";
    document.getElementById("divisi").style.display = "none";
  }
  else if((x=="Divisi")){
    document.getElementById("cabang").style.display = "none";
    document.getElementById("divisi").style.display = "block";
  }
  else{
    document.getElementById("cabang").style.display = "block";
    document.getElementById("divisi").style.display = "block";
  }
}


</script>

<script>
  function Cabang() {
    document.getElementById("cabang").style.display = "block";
    document.getElementById("divisi").style.display = "none";
  }
  function Divisi() {
    document.getElementById("cabang").style.display = "none";
    document.getElementById("divisi").style.display = "block";
  }
  function All() {
    document.getElementById("cabang").style.display = "block";
    document.getElementById("divisi").style.display = "block";
  }
</script>

<script> 
document.addEventListener("DOMContentLoaded", function() {
  let parents = document.querySelectorAll("tr.parent");
  
  for (let i = 0; i < parents.length; i++) {
    parents[i].querySelector('.feat-title').setAttribute('data-before','+'); 
    parents[i].style.cursor = "pointer";
    parents[i].setAttribute("title", "Click to expand/collapse");

    
    parents[i].addEventListener("click", function() {
        
      let id = this.id;
      let children = document.querySelectorAll('.child-' + id);       
      
      for (let j = 0; j < children.length; j++) {
        if(children[j].style.display === "none"){
            children[j].style.display = "table-row";
            parents[i].querySelector('.feat-title').setAttribute('data-before','-');     
        }
        else{
            children[j].style.display = "none";
            parents[i].querySelector('.feat-title').setAttribute('data-before','+'); 
        }
         
      } 
    });  
  }
  let children = document.querySelectorAll("tr[class^='child-']");
  for (let i = 0; i < children.length; i++) {
    children[i].style.display = "none";
  }
});

/*$(document).ready(function () {  
            $('tr.parent')  
                .css("cursor", "pointer")  
                .attr("title", "Click to expand/collapse")  
                .click(function () {  
                    $(this).siblings('.child-' + this.id).toggle();  
                });  
            $('tr[@class^=child-]').hide().children('td');  
    }); */ 

</script>

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
                chartData.push(['KODE', 'SUDAH_CLOSED', 'BELUM_CLOSED']);

                $.each(data, function(index, value) {
                    chartData.push([value.KODE, parseInt(value.SUDAH_CLOSED), parseInt(value.BELUM_CLOSED)]);
                });

                var dataTable = google.visualization.arrayToDataTable(chartData);

                var options = {
                    isStacked: 'percent',
                    height: 400,
                    title: 'Jumlah Temuan Sudah Close dan Belum Close Berdasarkan Divisi',
                    hAxis: {
                        title: 'Total Temuan',
                        minValue: 0,
                        ticks: [10, 20]
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
            $.getJSON("<?php echo base_url('aia/Dashboard/getTemuanDataDivisi1'); ?>", {iso: selectedIso}, function(data) {
                var chartData = [];
                chartData.push(['KODE', 'SUDAH_CLOSED', 'BELUM_CLOSED']);

                $.each(data, function(index, value) {
                    chartData.push([value.KODE, parseInt(value.SUDAH_CLOSED), parseInt(value.BELUM_CLOSED)]);
                });

                var dataTable = google.visualization.arrayToDataTable(chartData);

                var options = {
                    isStacked: 'percent',
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
            $.getJSON("<?php echo base_url('aia/Dashboard/getTemuanDataDivisi2'); ?>", {iso: selectedIso}, function(data) {
                var chartData = [];
                chartData.push(['KODE', 'SUDAH_CLOSED', 'BELUM_CLOSED']);

                $.each(data, function(index, value) {
                    chartData.push([value.KODE, parseInt(value.SUDAH_CLOSED), parseInt(value.BELUM_CLOSED)]);
                });

                var dataTable = google.visualization.arrayToDataTable(chartData);

                var options = {
                    isStacked: 'percent',
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
            $.getJSON("<?php echo base_url('aia/Dashboard/getTemuanDataDivisi3'); ?>", {iso: selectedIso}, function(data) {
                var chartData = [];
                chartData.push(['KODE', 'SUDAH_CLOSED', 'BELUM_CLOSED']);

                $.each(data, function(index, value) {
                    chartData.push([value.KODE, parseInt(value.SUDAH_CLOSED), parseInt(value.BELUM_CLOSED)]);
                });

                var dataTable = google.visualization.arrayToDataTable(chartData);

                var options = {
                    isStacked: 'percent',
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


<script type="text/javascript">
        
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawStackedChartCabang);

        function drawStackedChartCabang() {
            var selectedIso = $('#iso').val();
            // Mengambil data dari controller menggunakan AJAX
            $.getJSON("<?php echo base_url('aia/Dashboard/getTemuanDataCabang'); ?>", {iso: selectedIso}, function(data) {
                var chartData = [];
                chartData.push(['KODE', 'SUDAH_CLOSED', 'BELUM_CLOSED']);

                $.each(data, function(index, value) {
                    chartData.push([value.KODE, parseInt(value.SUDAH_CLOSED), parseInt(value.BELUM_CLOSED)]);
                });

                var dataTable = google.visualization.arrayToDataTable(chartData);

                var options = {
                    isStacked: 'percent',
                    height: 400,
                    title: 'Jumlah Temuan Sudah Close dan Belum Close Berdasarkan Cabang',
                    hAxis: {
                        title: 'Total Temuan',
                        minValue: 0,
                    },
                    vAxis: {
                        title: 'ISO 9001'
                    },
                    legend: { position: 'top', maxLines: 3 }
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('charttemuancabang'));
                chart.draw(dataTable, options);
            });
        }
        $('#iso').change(function() {
            drawStackedChartCabang(); // Refresh the chart when the selected province changes
        });
    </script>

    <script type="text/javascript">
        
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawStackedChartCabang1);

        function drawStackedChartCabang1() {
            var selectedIso = $('#iso').val();
            // Mengambil data dari controller menggunakan AJAX
            $.getJSON("<?php echo base_url('aia/Dashboard/getTemuanDataCabang1'); ?>", {iso: selectedIso}, function(data) {
                var chartData = [];
                chartData.push(['KODE', 'SUDAH_CLOSED', 'BELUM_CLOSED']);

                $.each(data, function(index, value) {
                    chartData.push([value.KODE, parseInt(value.SUDAH_CLOSED), parseInt(value.BELUM_CLOSED)]);
                });

                var dataTable = google.visualization.arrayToDataTable(chartData);

                var options = {
                    isStacked: 'percent',
                    height: 400,
                    title: 'Jumlah Temuan Sudah Close dan Belum Close Berdasarkan Cabang',
                    hAxis: {
                        title: 'Total Temuan',
                        minValue: 0,
                    },
                    vAxis: {
                        title: 'ISO 14001'
                    },
                    legend: { position: 'top', maxLines: 3 }
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('charttemuancabang1'));
                chart.draw(dataTable, options);
            });
        }
        $('#iso').change(function() {
            drawStackedChartCabang1(); // Refresh the chart when the selected province changes
        });
    </script>

    <script type="text/javascript">
        
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(getTemuanDataCabang2);

        function getTemuanDataCabang2() {
            var selectedIso = $('#iso').val();
            // Mengambil data dari controller menggunakan AJAX
            $.getJSON("<?php echo base_url('aia/Dashboard/getTemuanDataCabang2'); ?>", {iso: selectedIso}, function(data) {
                var chartData = [];
                chartData.push(['KODE', 'SUDAH_CLOSED', 'BELUM_CLOSED']);

                $.each(data, function(index, value) {
                    chartData.push([value.KODE, parseInt(value.SUDAH_CLOSED), parseInt(value.BELUM_CLOSED)]);
                });

                var dataTable = google.visualization.arrayToDataTable(chartData);

                var options = {
                    isStacked: 'percent',
                    height: 400,
                    title: 'Jumlah Temuan Sudah Close dan Belum Close Berdasarkan Cabang',
                    hAxis: {
                        title: 'Total Temuan',
                        minValue: 0,
                    },
                    vAxis: {
                        title: 'ISO 37001'
                    },
                    legend: { position: 'top', maxLines: 3 }
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('charttemuancabang2'));
                chart.draw(dataTable, options);
            });
        }
        $('#iso').change(function() {
            getTemuanDataCabang2(); // Refresh the chart when the selected province changes
        });
    </script>

    <script type="text/javascript">
        
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawStackedChartCabang3);

        function drawStackedChartCabang3() {
            var selectedIso = $('#iso').val();
            // Mengambil data dari controller menggunakan AJAX
            $.getJSON("<?php echo base_url('aia/Dashboard/getTemuanDataCabang3'); ?>", {iso: selectedIso}, function(data) {
                var chartData = [];
                chartData.push(['KODE', 'SUDAH_CLOSED', 'BELUM_CLOSED']);

                $.each(data, function(index, value) {
                    chartData.push([value.KODE, parseInt(value.SUDAH_CLOSED), parseInt(value.BELUM_CLOSED)]);
                });

                var dataTable = google.visualization.arrayToDataTable(chartData);

                var options = {
                    isStacked: 'percent',
                    height: 400,
                    title: 'Jumlah Temuan Sudah Close dan Belum Close Berdasarkan Cabang',
                    hAxis: {
                        title: 'Total Temuan',
                        minValue: 0,
                    },
                    vAxis: {
                        title: 'ISO 45001'
                    },
                    legend: { position: 'top', maxLines: 3 }
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('charttemuancabang3'));
                chart.draw(dataTable, options);
            });
        }
        $('#iso').change(function() {
            drawStackedChartCabang3(); // Refresh the chart when the selected province changes
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
    
    
</body>

</html>