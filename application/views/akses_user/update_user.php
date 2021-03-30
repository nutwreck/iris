<div class="container">
    <div class="row">
        <div class="col-sm-12 mt-2">
            <div class="container text-center">
                <h2>Form Edit Profile</h2>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 offset-md-3 mt-3">
            <div class="container">
                <form action="<?=base_url()?>Access/submit_update_profile_user" method="post" enctype="multipart/form-data">
                <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                <input type="hidden" id="id" name="id" value="<?=$access_data->id_user?>" style="display: none">
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select class="form-control selectpicker dropup" name="role" data-header="Select Role" readonly required>
                        <option data-tokens="<?=$access_data->role_name?>" value="<?=$access_data->role_id?>?>"><?=$access_data->role_name?></option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" readonly id="username" onkeypress="return /[a-zA-Z0-9]/i.test(event.key)" placeholder="Masukkan Username" name="username" value="<?=$access_data->username?>" required>
                    <small class="bg-warning">Username tidak bisa diganti</small>         
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" placeholder="Masukkan Password Akses" name="password" value="<?=$password?>" required>
                </div>
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" placeholder="Masukkan Nama Pengguna" name="name" value="<?=$access_data->name_user?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" placeholder="Masukkan Email" name="email" value="<?=$access_data->email?>" required>
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
        