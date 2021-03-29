<div class="container">
    <div class="row">
        <div class="col-sm-12 mt-2">
            <div class="container text-center">
                <h2>Form Add User</h2>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 offset-md-3 mt-3">
            <div class="container">
                <form action="<?=base_url()?>Access/submit_add_access_user" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select class="form-control selectpicker dropup" name="role" data-header="Select Role" required>
                        <?php foreach($role as $val_role){ ?>
                            <option data-tokens="<?=$val_role->name?>" value="<?=$val_role->id?>?>"><?=$val_role->name?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" onkeypress="return /[a-zA-Z0-9]/i.test(event.key)" placeholder="Masukkan Username" name="username" required>
                    <small class="bg-warning">Username tidak boleh mengandung spasi dan karakter</small>         
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" placeholder="Masukkan Password Akses" name="password" required>
                </div>
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" placeholder="Masukkan Nama Pengguna" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" placeholder="Masukkan Email" name="email" required>
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
        