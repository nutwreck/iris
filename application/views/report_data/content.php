<div class="container">
    <div class="row">
        <div class="col-sm-12 mt-2">
            <div class="container text-center">
                <h2>Report Data</h2>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 mt-3">
            <div class="container">
                <h4>Filter Data</h4>
                <form id="formsearch" name="formsearch" action="<?=base_url()?>search-report" method="POST" onsubmit="return(validate_searchform());">
                <table class="table-bordered text-center p-1">
                    <tr>
                        <td class="bg-primary text-white" width="30%">Region : </td>
                        <td>
                            <select class="form-control selectpicker dropup" data-header="Select Region" data-live-search ="true" id="region_name" name="region_name" onchange="open_export()">
                                <option value="-1">Pilih</option>
                                <?php foreach($region as $val_region){ ?>
                                    <option data-tokens="<?=$val_region->name?>" value="<?=$val_region->id?>|<?=$val_region->name?>"><?=$val_region->name?></option>
                                <?php } ?>
                            </select>
                            <small for="region_name" id="region_name_er" class="bg-danger text-white"></small>
                        </td>
                    </tr>
                    <tr>
                        <td class="bg-primary text-white" width="30%">Report Date : </td>
                        <td>
                            <div id="reportrange">
                                <input type="text" id="daterange" class="form-control text-center" name="daterange"/>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">
                            <div class="btn-group">
                                <input type="hidden" id="typebutton" class="form-control text-center" name="typebutton" value="1"/>
                                <button id="exportexcel" class="btn btn-sm btn-success m-1" onclick="export_excel()">Export Excel</button>
                                <button type="submit" class="btn btn-sm btn-primary m-1">Search</button>
                            </div>
                        </td>
                    </tr>
                </table>
                </form>
            </div>
        </div>
        <div class="col-sm-12 col-md-6" style="margin-top:4.5%;">
            <div class="alert alert-info">
                <p class="m-0">
                    Export excel & view data hanya bisa dilakukkan dengan memilih salah satu <b>Region</b>.
                </p>
            </div>
        </div>
        <div class="col-sm-12 mt-3">
            <div class="container">
                <div class="table-report">
                    <table class="tg">
                        <colgroup>
                            <col style="width: 56px">
                            <col style="width: 110px">
                            <col style="width: 47px">
                            <col style="width: 85px">
                            <col style="width: 364px">
                            <col style="width: 89px">
                            <col style="width: 275px">
                            <col style="width: 110px">
                            <col style="width: 426px">
                            <col style="width: 48px">
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="tg-wp8o" colspan="10">Report Documentation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="tg-4d37">Region</td>
                                <td class="tg-moisi" colspan="7">Banjarmasin</td>
                                <td class="tg-iks7" colspan="2" rowspan="3"><img src="<?=config_item('_assets_general')?>favicon/favicon.png" alt="iris-logo" class="img-thumbnail"></td>
                            </tr>
                            <tr>
                                <td class="tg-4d37">Week</td>
                                <td class="tg-moisi" colspan="7">5</td>
                            </tr>
                            <tr>
                                <td class="tg-4d37">Month</td>
                                <td class="tg-moisi" colspan="7">Februari 2021</td>
                            </tr>
                            <tr>
                                <td class="tg-4d37">Day</td>
                                <td class="tg-j3py">Date</td>
                                <td class="tg-4d37">Time</td>
                                <td class="tg-09cm">Brand</td>
                                <td class="tg-4d37">Name</td>
                                <td class="tg-09cm">Type Activity</td>
                                <td class="tg-4d37">Detail Activity</td>
                                <td class="tg-09cm">Agenda</td>
                                <td class="tg-4d37">Remarks</td>
                                <td class="tg-j3py">Photo</td>
                            </tr>
                            <tr>
                                <td class="tg-jbyd" rowspan="3">Selasa</td>
                                <td class="tg-mois" rowspan="3">2 Februari 2021</td>
                                <td class="tg-iks7">07:00</td>
                                <td class="tg-mois">FORTIGRO</td>
                                <td class="tg-iks7">NOVISA (SPV) &amp; TEAM FORTIGRO ( Ranti, Dheny, Alisia )</td>
                                <td class="tg-mois">DOR</td>
                                <td class="tg-iks7">BRIEF FORTIGRO RESIDENTIAL</td>
                                <td class="tg-mois">SAFETY</td>
                                <td class="tg-iks7">Berkoordinasi Dengan TEAM agar tetap mengikuti prokes covid</td>
                                <td class="tg-mois"></td>
                            </tr>
                            <tr>
                                <td class="tg-iks7">12:00</td>
                                <td class="tg-mois">FORTIGRO</td>
                                <td class="tg-iks7">TEAM FORTIGRO ( Ranti, Dheny, Alisia )</td>
                                <td class="tg-mois">DOR</td>
                                <td class="tg-iks7">BRIEF TEAM MILO &amp; FORTIGRO TRADE</td>
                                <td class="tg-mois">KPI Review</td>
                                <td class="tg-iks7">Menanyakan Kendala Saat di Lapangan</td>
                                <td class="tg-mois"></td>
                            </tr>
                            <tr>
                                <td class="tg-iks7">15:00</td>
                                <td class="tg-mois">FORTIGRO</td>
                                <td class="tg-iks7">TEAM MILO</td>
                                <td class="tg-mois">DOR</td>
                                <td class="tg-iks7">BRIEF FORTIGRO RESIDENTIAL</td>
                                <td class="tg-mois">FOOD SAFETY</td>
                                <td class="tg-iks7">Tim perlu pembekalan Q-Card</td>
                                <td class="tg-mois"></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="m-1 text-left">
                        <small><i>Showing 10 of 100 Data</i></small>
                    </div>
                    <div class="links">
                        <a href="#">&laquo;</a> <a class="active" href="#">1</a> <a href="#">2</a> <a href="#">3</a> <a href="#">4</a> <a href="#">&raquo;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>