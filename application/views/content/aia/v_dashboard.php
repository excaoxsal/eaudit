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
    align-items: flex-start; /* Align buttons and scoreboard at the top */
    width: 100%;
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
}

/* Styling for button group (aligned vertically) */
.button-group {
    display: flex;
    flex-direction: column; /* Stack buttons vertically */
    margin-right: 20px; /* Space between buttons and scoreboard */
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
    grid-template-columns: repeat(5, 1fr); /* 5 equal columns */
    gap: 20px; /* Space between the boxes */
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
        grid-template-columns: 1fr 1fr; /* Two columns on smaller screens */
    }
}

@media (max-width: 480px) {
    #scoreboard {
        grid-template-columns: 1fr; /* Single column on very small screens */
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


    <div class="content d-flex flex-column flex-column-fluid mt-19" id="kt_content">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                <span class="text-muted font-weight-bold mr-4">Dashboard</span>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="card card-custom">
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
                                <select class="form-control form-control-solid form-control-lg" id="iso" onchange="changeiso()">
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
                        <div class="col-12" id="divisi9001">
                            <div id="charttemuandivisi"></div>
                        </div>
                        <div class="col-12" id="divisi14001">
                            <div id="charttemuandivisi1"></div>
                        </div>
                        <div class="col-12" id="divisi37001">
                            <div id="charttemuandivisi2"></div>
                        </div>
                        <div class="col-12" id="divisi45001">
                            <div id="charttemuandivisi3"></div>
                        </div>
                        
                    </div>
                    <div class="row mb-0 pb-0" id="cabang">
                        <div class="col-12" id="cabang9001">
                            <div id="charttemuancabang"></div>
                        </div>
                        <div class="col-12" id="cabang14001">
                            <div id="charttemuancabang1"></div>
                        </div>
                        <div class="col-12" id="cabang37001">
                            <div id="charttemuancabang2"></div>
                        </div>
                        <div class="col-12" id="cabang45001">
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
                                                <td class="feat-title" style="text-align:left;"><?= $datatable[$ddivisi['KODE']][$i]['namadivisi']?></td>  
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
                                                <td class="feat-title"style="text-align:left;"><?= $datatable[$ddivisi['KODE']][$i]['namadivisi']?></td>  
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

                                    <?php $datatotal1 = $datatable[$ddivisi['KODE']][$i]['iso9001']['total'];$datatotal2 += $datatable[$ddivisi['KODE']][$i]['iso9001']['total']; } ?>
                                
                                
                                <?php } ?>
                                <?php } ?>
                                <tr >
                                    <td class="feat-title">Total Per-ISO</td>
                                    <td colspan="3"><?= $temuan_1['0']['TOTALALL']?></td>
                                    <td colspan="3"><?= $temuan_2['0']['TOTALALL']?></td>
                                    <td colspan="3"><?= $temuan_3['0']['TOTALALL']?></td>
                                    <td colspan="3"><?= $temuan_4['0']['TOTALALL']?></td>
                                </tr>
                                <tr >
                                    <td class="feat-title">Total Semua Temuan</td>
                                    <td colspan="12"><?= $temuan_1['0']['TOTALALL']+$temuan_2['0']['TOTALALL']+$temuan_3['0']['TOTALALL']+$temuan_4['0']['TOTALALL']?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row mb-0 pb-0">
                        <div class="table-responsive"> <!-- Tambahkan div ini untuk membuat tabel responsif -->
                            <table class="table table-bordered" id="temuanTable">
                                <thead>
                                    <tr>
                                        <td rowspan="2">Cabang</td>
                                        <th colspan="3" style="text-align:center;">ISO 9001</th>
                                        <th colspan="3" style="text-align:center;">ISO 14001</th>
                                        <th colspan="3" style="text-align:center;">ISO 37001</th>
                                        <th colspan="3" style="text-align:center;">ISO 45001</th>
                                        <th colspan="3" rowspan="3" style="text-align:center;">TOTAL</th>
                                    </tr>
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
                                    <?php foreach ($datacabang as $cabang) { ?>
                                        <?php for ($i=0; $i < count($datatablecabang[$cabang['KODE']]); $i++) { ?>
                                            <?php if(isset($datatablecabang[$cabang['KODE']][$i])) { ?>
                                                <?php if($datatablecabang[$cabang['KODE']][$i]['tipe']=="Divisi") { $n+=1 ?>
                                                    <tr class="parent" id="row12<?=$n?>" title="Click to expand/collapse" style="cursor: pointer;">  
                                                        <td class="feat-title" style="text-align:left;"><?= $datatablecabang[$cabang['KODE']][$i]['namadivisi']?></td>  
                                                        <td><?= $datatablecabang[$cabang['KODE']][$i]['iso9001']['open']?></td>
                                                        <td><?= $datatablecabang[$cabang['KODE']][$i]['iso9001']['closed']?></td>
                                                        <td><?= $datatablecabang[$cabang['KODE']][$i]['iso9001']['total']?></td>
                                                        <td><?= $datatablecabang[$cabang['KODE']][$i]['iso14001']['open']?></td>
                                                        <td><?= $datatablecabang[$cabang['KODE']][$i]['iso14001']['closed']?></td>
                                                        <td><?= $datatablecabang[$cabang['KODE']][$i]['iso14001']['total']?></td>
                                                        <td><?= $datatablecabang[$cabang['KODE']][$i]['iso37001']['open']?></td>
                                                        <td><?= $datatablecabang[$cabang['KODE']][$i]['iso37001']['closed']?></td>
                                                        <td><?= $datatablecabang[$cabang['KODE']][$i]['iso37001']['total']?></td>
                                                        <td><?= $datatablecabang[$cabang['KODE']][$i]['iso45001']['open']?></td>
                                                        <td><?= $datatablecabang[$cabang['KODE']][$i]['iso45001']['closed']?></td>
                                                        <td><?= $datatablecabang[$cabang['KODE']][$i]['iso45001']['total']?></td>
                                                        <td><?= $datatablecabang[$cabang['KODE']][$i]['iso45001']['total'] + $datatablecabang[$cabang['KODE']][$i]['iso9001']['total'] + $datatablecabang[$cabang['KODE']][$i]['iso14001']['total'] + $datatablecabang[$cabang[' KODE']][$i]['iso37001']['total']?></td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="scoreboard-container">
                    <div style="max-width: 1200px; margin: auto; background: white; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); padding: 20px;">
                        <div style="display: flex; justify-content: center; margin-bottom: 20px;">
                            <button id="all" style="flex: 1; padding: 10px; margin: 0 5px; border: none; border-radius: 5px; background-color: #007bff; color: white; cursor: pointer; transition: background-color 0.3s;">ALL</button>
                            <button id="btn_divisi" style="flex: 1; padding: 10px; margin: 0 5px; border: none; border-radius: 5px; background-color: #007bff; color: white; cursor: pointer; transition: background-color 0.3s;">DIVISI</button>
                            <button id="btn_cabang" style="flex: 1; padding: 10px; margin: 0 5px; border: none; border-radius: 5px; background-color: #007bff; color: white; cursor: pointer; transition: background-color 0.3s;">CABANG</button>
                        </div>

                        <div id="scoreboard" style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                            
                            <div style="flex: 1 1 calc(20% - 10px); margin: 5px; background: #e9ecef; border-radius: 5px; padding: 15px; text-align: center;">
                                <label for="box2">ISO 9001</label>
                                <div class="box" id="box2" style="font-size: 24px; font-weight: bold; margin-top: 10px;">0</div>
                            </div>
                            <div style="flex: 1 1 calc(20% - 10px); margin: 5px; background: #e9ecef; border-radius: 5px; padding: 15px; text-align: center;">
                                <label for="box3">ISO 14001</label>
                                <div class="box" id="box3" style="font-size: 24px; font-weight: bold; margin-top: 10px;">0</div>
                            </div>
                            <div style="flex: 1 1 calc(20% - 10px); margin: 5px; background: #e9ecef; border-radius: 5px; padding: 15px; text-align: center;">
                                <label for="box4">ISO 37001</label>
                                <div class="box" id="box4" style="font-size: 24px; font-weight: bold; margin-top: 10px;">0</div>
                            </div>
                            <div style="flex: 1 1 calc(20% - 10px); margin: 5px; background: #e9ecef; border-radius: 5px; padding: 15px; text-align: center;">
                                <label for="box5">ISO 45001</label>
                                <div class="box" id="box5" style="font-size: 24px; font-weight: bold; margin-top: 10px;">0</div>
                            </div>
                            <div style="flex: 1 1 calc(20% - 10px); margin: 5px; background: #e9ecef; border-radius: 5px; padding: 15px; text-align: center;">
                                <label for="box1">Kantor Pusat & Cabang</label>
                                <div class="box" id="box1" style="font-size: 24px; font-weight: bold; margin-top: 10px;">0</div>
                            </div>
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
        function changeiso() {
        var x = document.getElementById("iso").value;
        if(x=="1"){
            document.getElementById("divisi9001").style.display = "block";
            document.getElementById("divisi14001").style.display = "none";
            document.getElementById("divisi37001").style.display = "none";
            document.getElementById("divisi45001").style.display = "none";
            document.getElementById("cabang9001").style.display = "block";
            document.getElementById("cabang14001").style.display = "none";
            document.getElementById("cabang37001").style.display = "none";
            document.getElementById("cabang45001").style.display = "none";
        }
        else if((x=="2")){
            document.getElementById("divisi9001").style.display = "none";
            document.getElementById("divisi14001").style.display = "block";
            document.getElementById("divisi37001").style.display = "none";
            document.getElementById("divisi45001").style.display = "none";
            document.getElementById("cabang9001").style.display = "none";
            document.getElementById("cabang14001").style.display = "block";
            document.getElementById("cabang37001").style.display = "none";
            document.getElementById("cabang45001").style.display = "none";
        }
        else if((x=="3")){
            document.getElementById("divisi9001").style.display = "none";
            document.getElementById("divisi14001").style.display = "none";
            document.getElementById("divisi37001").style.display = "block";
            document.getElementById("divisi45001").style.display = "none";
            document.getElementById("cabang9001").style.display = "none";
            document.getElementById("cabang14001").style.display = "none";
            document.getElementById("cabang37001").style.display = "block";
            document.getElementById("cabang45001").style.display = "none";
        }
        else if((x=="4")){
            document.getElementById("divisi9001").style.display = "none";
            document.getElementById("divisi14001").style.display = "none";
            document.getElementById("divisi37001").style.display = "none";
            document.getElementById("divisi45001").style.display = "block";
            document.getElementById("cabang9001").style.display = "none";
            document.getElementById("cabang14001").style.display = "none";
            document.getElementById("cabang37001").style.display = "none";
            document.getElementById("cabang45001").style.display = "block";
        }
        else{
            document.getElementById("divisi9001").style.display = "block";
            document.getElementById("divisi14001").style.display = "block";
            document.getElementById("divisi37001").style.display = "block";
            document.getElementById("divisi45001").style.display = "block";
            document.getElementById("cabang9001").style.display = "block";
            document.getElementById("cabang14001").style.display = "block";
            document.getElementById("cabang37001").style.display = "block";
            document.getElementById("cabang45001").style.display = "block";
        }
        }

    </script>

    <script> 
        document.addEventListener("DOMContentLoaded", function() {
            let parents = document.querySelectorAll("tr.parent");
            
            for (let i = 0; i < parents.length; i++) {
                // Set the color based on the row index (odd/even)
                if (i % 2 === 0) {
                    parents[i].style.backgroundColor = "#d4edda"; // Even index (0, 2, 4, ...) - soft pastel green
                } else {
                    parents[i].style.backgroundColor = "#c3e6cb"; // Odd index (1, 3, 5, ...) - muted green
                }

                parents[i].querySelector('.feat-title').setAttribute('data-before', '+'); 
                parents[i].style.cursor = "pointer";
                parents[i].setAttribute("title", "Click to expand/collapse");

                parents[i].addEventListener("click", function() {
                    let id = this.id;
                    let children = document.querySelectorAll('.child-' + id);       
                    
                    for (let j = 0; j < children.length; j++) {
                        if (children[j].style.display === "none") {
                            children[j].style.display = "table-row";
                            parents[i].querySelector('.feat-title').setAttribute('data-before', '-');     
                        } else {
                            children[j].style.display = "none";
                            parents[i].querySelector('.feat-title').setAttribute('data-before', '+'); 
                        }
                    } 
                });  
            }

            let children = document.querySelectorAll("tr[class^='child-']");
            for (let i = 0; i < children.length; i++) {
                children[i].style.display = "none";
            }
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
                chartData.push(['NOMOR ISO', 'SUDAH CLOSED', 'BELUM CLOSED']);

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
                chartData.push(['KODE', 'SUDAH CLOSED', 'BELUM CLOSED']);

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

        // Resize chart on window resize
        $(window).resize(function() {
            drawStackedChartDivisi();
        });
    </script>

    <style>
        #charttemuandivisi {
            width: 100%; /* Set width to 100% */
            height: 400px; /* Set a fixed height */
        }
    </style>

    <script type="text/javascript">
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawStackedChartDivisi1);

        function drawStackedChartDivisi1() {
            var selectedIso = $('#iso').val();
            // Mengambil data dari controller menggunakan AJAX
            $.getJSON("<?php echo base_url('aia/Dashboard/getTemuanDataDivisi1'); ?>", {iso: selectedIso}, function(data) {
                var chartData = [];
                chartData.push(['KODE', 'SUDAH CLOSED', 'BELUM CLOSED']);

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

        // Resize chart on window resize
        $(window).resize(function() {
            drawStackedChartDivisi1();
        });
    </script>

    <style>
        #charttemuandivisi1 {
            width: 100%; /* Set width to 100% */
            height: 400px; /* Set a fixed height */
        }
    </style>


<script type="text/javascript">
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawStackedChartDivisi2);

        function drawStackedChartDivisi2() {
            var selectedIso = $('#iso').val();
            // Mengambil data dari controller menggunakan AJAX
            $.getJSON("<?php echo base_url('aia/Dashboard/getTemuanDataDivisi2'); ?>", {iso: selectedIso}, function(data) {
                var chartData = [];
                chartData.push(['KODE', 'SUDAH CLOSED', 'BELUM CLOSED']);

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

        // Resize chart on window resize
        $(window).resize(function() {
            drawStackedChartDivisi2();
        });
    </script>

    <style>
        #charttemuandivisi2 {
            width: 100%; /* Set width to 100% */
            height: 400px; /* Set a fixed height */
        }
    </style>

<script type="text/javascript">
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawStackedChartDivisi3);

        function drawStackedChartDivisi3() {
            var selectedIso = $('#iso').val();
            // Mengambil data dari controller menggunakan AJAX
            $.getJSON("<?php echo base_url('aia/Dashboard/getTemuanDataDivisi3'); ?>", {iso: selectedIso}, function(data) {
                var chartData = [];
                chartData.push(['KODE', 'SUDAH CLOSED', 'BELUM CLOSED']);

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

        // Resize chart on window resize
        $(window).resize(function() {
            drawStackedChartDivisi3();
        });
    </script>

    <style>
        #charttemuandivisi3 {
            width: 100%; /* Set width to 100% */
            height: 400px; /* Set a fixed height */
        }
    </style>

    <script type="text/javascript">
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawStackedChartCabang);

        function drawStackedChartCabang() {
            var selectedIso = $('#iso').val();
            // Mengambil data dari controller menggunakan AJAX
            $.getJSON("<?php echo base_url('aia/Dashboard/getTemuanDataCabang'); ?>", {iso: selectedIso}, function(data) {
                var chartData = [];
                chartData.push(['KODE', 'SUDAH CLOSED', 'BELUM CLOSED']);

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
                        ticks: [10, 20]
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

        // Resize chart on window resize
        $(window).resize(function() {
            drawStackedChartCabang();
        });
    </script>

    <style>
        #charttemuancabang {
            width: 100%; /* Set width to 100% */
            height: 400px; /* Set a fixed height */
        }
    </style>

<script type="text/javascript">
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawStackedChartCabang1);

        function drawStackedChartCabang1() {
            var selectedIso = $('#iso').val();
            // Mengambil data dari controller menggunakan AJAX
            $.getJSON("<?php echo base_url('aia/Dashboard/getTemuanDataCabang1'); ?>", {iso: selectedIso}, function(data) {
                var chartData = [];
                chartData.push(['KODE', 'SUDAH CLOSED', 'BELUM CLOSED']);

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
                        ticks: [10, 20]
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

        // Resize chart on window resize
        $(window).resize(function() {
            drawStackedChartCabang1();
        });
    </script>

    <style>
        #charttemuancabang {
            width: 100%; /* Set width to 100% */
            height: 400px; /* Set a fixed height */
        }
    </style>

<script type="text/javascript">
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawStackedChartCabang2);

        function drawStackedChartCabang2() {
            var selectedIso = $('#iso').val();
            // Mengambil data dari controller menggunakan AJAX
            $.getJSON("<?php echo base_url('aia/Dashboard/getTemuanDataCabang2'); ?>", {iso: selectedIso}, function(data) {
                var chartData = [];
                chartData.push(['KODE', 'SUDAH CLOSED', 'BELUM CLOSED']);

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
                        ticks: [10, 20]
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
            drawStackedChartCabang2(); // Refresh the chart when the selected province changes
        });

        // Resize chart on window resize
        $(window).resize(function() {
            drawStackedChartCabang2();
        });
    </script>

    <style>
        #charttemuancabang2 {
            width: 100%; /* Set width to 100% */
            height: 400px; /* Set a fixed height */
        }
    </style>

<script type="text/javascript">
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawStackedChartCabang3);

        function drawStackedChartCabang3() {
            var selectedIso = $('#iso').val();
            // Mengambil data dari controller menggunakan AJAX
            $.getJSON("<?php echo base_url('aia/Dashboard/getTemuanDataCabang3'); ?>", {iso: selectedIso}, function(data) {
                var chartData = [];
                chartData.push(['KODE', 'SUDAH CLOSED', 'BELUM CLOSED']);

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
                        ticks: [10, 20]
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

        // Resize chart on window resize
        $(window).resize(function() {
            drawStackedChartCabang3();
        });
    </script>

    <style>
        #charttemuancabang {
            width: 100%; /* Set width to 100% */
            height: 400px; /* Set a fixed height */
        }
    </style>

    

    <script>
        $(document).ready(function() {
            let responseData; // Variabel untuk menyimpan data response

            // Saat halaman selesai dimuat, lakukan permintaan AJAX
            $.ajax({
                url: '<?= base_url('aia/Dashboard/getReportData'); ?>', // URL controller untuk mengambil data
                type: 'GET', // Tipe requestnya GET
                dataType: 'json', // Data yang diharapkan sebagai JSON
                success: function(response) {
                    
                    responseData = response; // Simpan data response

                    // Tampilkan data default (ALL)
                    updateScoreboard('all');
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });

            // Fungsi untuk memperbarui scoreboard berdasarkan pilihan
            function updateScoreboard(type) {
                if (type === 'all') {
                    $('#box1').text(responseData.total_semua);
                    $('#box2').text(parseInt(responseData.total_divisi_iso1) + parseInt(responseData.total_cabang_iso1));
                    $('#box3').text(parseInt(responseData.total_divisi_iso2) + parseInt(responseData.total_cabang_iso2));
                    $('#box4').text(parseInt(responseData.total_divisi_iso3) + parseInt(responseData.total_cabang_iso3));
                    $('#box5').text(parseInt(responseData.total_divisi_iso4) + parseInt(responseData.total_cabang_iso4));
                } else if (type === 'divisi') {
                    $('#box1').text(responseData.total_pusat); // Misalkan ini untuk total divisi
                    $('#box2').text(parseInt(responseData.total_divisi_iso1));
                    $('#box3').text(parseInt(responseData.total_divisi_iso2));
                    $('#box4').text(parseInt(responseData.total_divisi_iso3));
                    $('#box5').text(parseInt(responseData.total_divisi_iso4));
                } else if (type === 'cabang') {
                    $('#box1').text(responseData.total_cabang); // Misalkan ini untuk total cabang
                    $('#box2').text(responseData.total_cabang_iso1);
                    $('#box3').text(responseData.total_cabang_iso2);
                    $('#box4').text(responseData.total_cabang_iso3);
                    $('#box5').text(responseData.total_cabang_iso4);
                }
            }

            // Event listener untuk tombol
            $('#all').click(function() {
                updateScoreboard('all');
                
            });

            $('#btn_divisi').click(function() {
                updateScoreboard('divisi');
                
            });

            $('#btn_cabang').click(function() {
                updateScoreboard('cabang');
                
            });
        });
    </script>


    <script src="<?= base_url() ?>assets/plugins/global/plugins.bundle7a50.js?v=7.2.7"></script>
    <script src="<?= base_url() ?>assets/plugins/custom/prismjs/prismjs.bundle7a50.js?v=7.2.7"></script>
    <script src="<?= base_url() ?>assets/js/scripts.bundle7a50.js?v=7.2.7"></script>

    <script src="<?= base_url() ?>assets/js/pages/custom/user/edit-user7a50.js?v=7.2.7"></script>
    
    
</body>

</html>