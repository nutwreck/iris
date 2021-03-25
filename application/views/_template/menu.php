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
                <div class="navbar-nav">
                    <a href="<?=base_url()?>dashboard" class="nav-item nav-link active">Dashboard</a>
                    <a href="<?=base_url()?>upload-data" class="nav-item nav-link">Upload Data</a>
                    <a href="<?=base_url()?>report" class="nav-item nav-link">Report</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Messages</a>
                        <div class="dropdown-menu">
                            <a href="#" class="dropdown-item">Inbox</a>
                            <a href="#" class="dropdown-item">Sent</a>
                            <a href="#" class="dropdown-item">Drafts</a>
                        </div>
                    </div>
                </div>
                <div class="navbar-nav">
                    <a href="#" class="nav-item nav-link">Hi, Candra</a>
                    <a href="<?=base_url()?>logout" class="nav-item nav-link"><i class="fa fa-sign-out"></i> Log Out</a>
                </div>
            </div>
        </nav>