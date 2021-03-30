</head>
    <body>
        <nav class="navbar navbar-expand-md navbar-light bg-light">
            <a href="<?=base_url()?>/dashboard" class="navbar-brand">
                <img src="<?=config_item('_assets_general')?>favicon/favicon.png" height="28" alt="IRIS">
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <?php if($this->session->has_userdata('has_login')){ ?>
                <div class="navbar-nav">
                    <a href="<?=base_url()?>dashboard" class="nav-item nav-link active">Dashboard</a>
                    <a href="<?=base_url()?>upload-data" class="nav-item nav-link">Upload Data</a>
                    <a href="<?=base_url()?>report" class="nav-item nav-link">Report</a>
                    <?php if($this->session->userdata('role_id') == 1) { ?>
                        <a href="<?=base_url()?>access-user" class="nav-item nav-link">Akses User</a>
                    <?php } else { ?>
                        <a href="<?=base_url()?>change-access/<?=$this->session->userdata('id_user')?>" class="nav-item nav-link">Profile</a>
                    <?php } ?>
                </div>
                <div class="navbar-nav">
                    <a href="#" class="nav-item nav-link">Hi, <?=$this->session->userdata('name_user')?></a>
                    <a href="<?=base_url()?>logout" class="nav-item nav-link"><i class="fa fa-sign-out"></i> Log Out</a>
                </div>
                <?php } ?>
            </div>
        </nav>