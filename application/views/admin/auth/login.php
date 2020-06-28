<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width initial-scale=1.0">
        <title>User | Login</title>
        <!-- GLOBAL MAINLY STYLES-->
        <link href="<?php echo base_url(); ?>assets/admin/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/admin/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/admin/vendors/line-awesome/css/line-awesome.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/admin/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/admin/vendors/animate.css/animate.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/admin/vendors/toastr/toastr.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/admin/vendors/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" />
        <!-- PLUGINS STYLES-->
        <!-- THEME STYLES-->
        <link href="<?php echo base_url(); ?>assets/admin/css/main.min.css" rel="stylesheet" />
        <!-- PAGE LEVEL STYLES-->
        <style>
            body {
                background-repeat: no-repeat;
                background-size: cover;
                background-image: url('<?php echo base_url(); ?>assets/admin/img/blog/17.jpg');
            }

            .cover {
                position: absolute;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                background-color: rgba(117, 54, 230, .1);
            }

            .login-content {
                max-width: 400px;
                margin: 100px auto 50px;
            }

            .auth-head-icon {
                position: relative;
                height: 60px;
                width: 60px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 30px;
                background-color: #fff;
                color: #5c6bc0;
                box-shadow: 0 5px 20px #d6dee4;
                border-radius: 50%;
                transform: translateY(-50%);
                z-index: 2;
            }
        </style>
    </head>

    <body>
        <div class="cover"></div>
        <div class="ibox login-content">

            <div class="text-center">
                <span class="auth-head-icon"><i class="la la-user"></i></span>
            </div>
            <form class="ibox-body" id="login-form" action="<?php echo base_url(); ?>auth/login" method="POST">
                <h4 class="font-strong text-center mb-5"> LOG IN</h4>
                 <div class="text-center mb-4" style="color: red;text-align: center;">
                        <?php echo $this->session->flashdata("message"); ?>
                    </div>
                <div class="form-group mb-4">
                    <input class="form-control form-control-line" type="text" name="username" placeholder="Username">
                    <div class="text-danger"><?php echo form_error('username'); ?></div>
                </div>
                <div class="form-group mb-4">
                    <input class="form-control form-control-line" type="password" name="password" placeholder="Password">
                 <div class="text-danger"><?php echo form_error('password'); ?></div>
                </div>
                <div class="flexbox mb-5">
                    <span>
                        <label class="mr-2 mb-0">
                            <!--<input type="checkbox" checked="">-->
                            <span></span>
                        </label></span>
                    <a class="text-primary" href="<?php echo base_url(); ?>auth/forget_password">Forgot password?</a>
                </div>
                <div class="text-center mb-4">
                    <button class="btn btn-primary btn-rounded btn-block">LOGIN</button>
                </div>
            </form>
        </div>
        <!-- BEGIN PAGA BACKDROPS-->
        <div class="sidenav-backdrop backdrop"></div>
        <div class="preloader-backdrop">
            <div class="page-preloader">Loading</div>
        </div>
        <!-- CORE PLUGINS-->
        <script src="<?php echo base_url(); ?>assets/admin/vendors/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/vendors/popper.js/dist/umd/popper.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/vendors/metisMenu/dist/metisMenu.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/vendors/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/vendors/jquery-idletimer/dist/idle-timer.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/vendors/toastr/toastr.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/vendors/jquery-validation/dist/jquery.validate.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/vendors/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
        <!-- PAGE LEVEL PLUGINS-->
        <!-- CORE SCRIPTS-->
        <script src="<?php echo base_url(); ?>assets/admin/js/app.min.js"></script>
        <!-- PAGE LEVEL SCRIPTS-->
        <script>
            $(function () {
                $('#login-form').validate({
                    errorClass: "help-block",
                    rules: {
                        username: {
                            required: true,
                            //email: true
                        },
                        password: {
                            required: true
                        }
                    },
                    highlight: function (e) {
                        $(e).closest(".form-group").addClass("has-error")
                    },
                    unhighlight: function (e) {
                        $(e).closest(".form-group").removeClass("has-error")
                    },
                });
            });
        </script>
    </body>
</html>