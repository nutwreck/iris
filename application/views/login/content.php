</head>
    <body>
        <div class="container">
            <div class="row">
                <div class="Absolute-Center is-Responsive">
                <div class="col-sm-12 col-md-10 col-md-offset-1">
                <form action="<?=base_url()?>Login/submit_login" method="post" enctype="multipart/form-data">
                <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input class="form-control" type="text" name='username' placeholder="username"/>          
                    </div>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input class="form-control" type="password" name='password' placeholder="password"/>     
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-secondary">Login</button>
                    </div>
                </form>        
                </div>  
                </div>    
            </div>
        </div>