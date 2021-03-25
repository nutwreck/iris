<div class="container">
    <div class="row">
        <div class="col-sm-12 mt-2">
            <div class="container text-center">
                <h2>Form Upload Data</h2>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 mt-3">
            <div class="container">
                <form action="/action_page.php" class="needs-validation" novalidate>
                    <div class="form-group">
                        <label for="uname">Region:</label>
                        <select class="form-control selectpicker dropup" name="region" data-header="Select Region" data-live-search="true" required>
                            <?php foreach($region_data as $val_region){ ?>
                                <option data-tokens="<?=$val_region->name?>" value="<?=$val_region->id?>|<?=$val_region->name?>"><?=$val_region->name?></option>
                            <?php } ?>
                        </select>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Harus pilih type aktifitas.</div>
                    </div>
                    <div class="form-group">
                        <label for="uname">Activity Type:</label>
                        <select class="form-control selectpicker dropup" data-header="Select Activity Type" name="activity_type" required>
                            <?php foreach($activity_type_data as $val_at){ ?>
                                <option value="<?=$val_at->id?>|<?=$val_at->name?>"><?=$val_at->name?></option>
                            <?php } ?>
                        </select>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Harus pilih type aktifitas.</div>
                    </div>
                    <div class="form-group">
                        <label for="pwd">DateTime:</label>
                        <input type="text" class="form-control datetimepicker-input" id="datetimepicker5" data-toggle="datetimepicker" data-target="#datetimepicker5" name="datetime" placeholder="Pilih tanggal dan waktu" required/>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Datetime tidak boleh kosong.</div>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Agenda:</label>
                        <input type="text" class="form-control" id="agenda" placeholder="Masukkan Agenda" name="agenda" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Agenda tidak boleh kosong.</div>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Activity:</label>
                        <input type="text" class="form-control" id="activity" placeholder="Masukkan Aktifitas" name="activity" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Activity tidak boleh kosong.</div>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Brand:</label>
                        <input type="text" class="form-control" id="brand" placeholder="Masukkan Brand" name="brand" required>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Brand tidak boleh kosong.</div>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Note:</label>
                        <textarea class="form-control" id="note" name="note" rows="3" placeholder="Masukkan Catatan" required></textarea>
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Note tidak boleh kosong.</div>
                    </div>
                </div>
            </div>
        <div class="col-sm-12 col-md-6 mt-3">
            <div class="container" style="margin-top:15%">
                <div class="text-center">
                    <img src="<?=config_item('_assets_general')?>images/upload_data.png" class="rounded" alt="upload_data">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFile">
                        <label class="custom-file-label" for="customFile" name="photo">Select Photo</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 mt-3">
            <div class="container text-center">
                <div class="col-sm-6 offset-sm-3">
                        <button type="submit" class="btn btn-md btn-block btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
        