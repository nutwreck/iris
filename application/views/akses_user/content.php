<div class="container">
    <div class="row">
        <div class="col-sm-12 mt-2">
            <div class="container text-center">
                <h2>User Akses Data</h2>
            </div>
        </div>
        <div class="col-sm-12 mt-2">
            <div class="container text-left">
                <button class="btn btn-md btn-primary text-white" onclick="add_data()">Add User</button>
            </div>
        </div>
        <div class="col-sm-12 mt-3">
            <div class="table-responsive bg-white">
                <table id="table_user" class="display text-center">
                    <thead>
                        <tr>
                            <th width="20px">No</th>
                            <th>Role User</th>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status Data</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                            foreach($akses_user as $value){ ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $value->role_name; ?></td>
                            <td><?php echo $value->username; ?></td>
                            <td><?php echo $value->name_user; ?></td>
                            <td><?php echo $value->email; ?></td>
                            <td><?php echo $value->status_data_user; ?></td>
                            <td>
                                <?php if($value->is_enable == 1) { ?>
                                <div>
                                    <a href="<?php echo base_url(); ?>edit-user/<?php echo $value->id_user; ?>" class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a href="<?php echo base_url(); ?>disable-user/<?php echo $value->id_user; ?>" class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                                <?php } else { ?>
                                <div>
                                    <a href="<?php echo base_url(); ?>active-user/<?php echo $value->id_user; ?>" class="item" data-toggle="tooltip" data-placement="top" title="Active">
                                        <i class="fa fa-check"></i>
                                    </a>
                                </div>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>