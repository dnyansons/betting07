<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width initial-scale=1.0">
        <title>Betting 07 ! Admin</title>
        <!-- GLOBAL MAINLY STYLES-->
        <link href="<?php echo base_url(); ?>assets/admin/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/admin/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/admin/vendors/line-awesome/css/line-awesome.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/admin/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/admin/vendors/animate.css/animate.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/admin/vendors/toastr/toastr.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/admin/vendors/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/admin/vendors/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/admin/vendors/select2/dist/css/select2.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/admin/vendors/ion.rangeSlider/css/ion.rangeSlider.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/admin/vendors/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/admin/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/admin/vendors/smalot-bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/admin/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/admin/vendors/clockpicker/dist/bootstrap-clockpicker.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/admin/vendors/jquery-minicolors/jquery.minicolors.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/admin/vendors/multiselect/css/multi-select.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/admin/vendors/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/admin/vendors/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
        <!-- THEME STYLES-->
        <script src="<?php echo base_url(); ?>assets/admin/vendors/jquery/dist/jquery.min.js"></script>
        <link href="<?php echo base_url(); ?>assets/admin/vendors/dataTables/datatables.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/admin/css/main.min.css" rel="stylesheet" />

        <script src="<?php echo base_url(); ?>assets/admin/vendors/jquery-validation/dist/jquery.validate.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/vendors/dataTables/datatables.min.js"></script>

        <!-- START PAGE CONTENT-->


        <style>
            .on-up{
                margin-top: -55px;
            }

            /*Turn off input type arrow*/
            input[type=number]::-webkit-inner-spin-button, 
            input[type=number]::-webkit-outer-spin-button { 
                -webkit-appearance: none; 
                margin: 0; 
            }
            p {
                color: #f75a5f;
            }
            .error {
                color: #f75a5f;
                margin-left: 5px;
            }
            .back{
                background-color: #fff!important;
            }
        </style>
    </head>
    <body class="fixed-navbar">
        <div class="page-wrapper">
            <!-- START HEADER-->
            <header class="header">
                <div class="page-brand">
                    <a href="<?php echo base_url(); ?>dashboard">
                        <span class="brand"><img src="<?php echo base_url(); ?>assets/admin/img/logo.png" style="width:150px;"></span>
                        <span class="brand-mini">07</span>
                    </a>
                </div>
                <div class="flexbox flex-1">
                    <!-- START TOP-LEFT TOOLBAR-->
                    <ul class="nav navbar-toolbar">
                        <li>
                            <a class="nav-link sidebar-toggler js-sidebar-toggler" href="javascript:;">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </a>
                        </li>
                    </ul>
                    <!-- END TOP-LEFT TOOLBAR-->
                    <!-- START TOP-RIGHT TOOLBAR-->
                    <ul class="nav navbar-toolbar">
                        <li class="dropdown dropdown-inbox">
                            <a class="nav-link dropdown-toggle toolbar-icon" data-toggle="dropdown" href="javascript:;"><i class="ti-email"></i>
                                <span class="envelope-badge"><?php echo count($noti); ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-media">
                                <div class="dropdown-arrow"></div>
                                <div class="dropdown-header text-center">
                                    <div>
                                        <span class="font-18"><strong><?php echo count($noti); ?> New</strong> Messages</span>
                                    </div>
                                    <a class="text-muted font-13" href="<?php echo base_url(); ?>notification">view all</a>
                                </div>
                                <div class="p-3">
                                    <div class="media-list media-list-divider scroller" data-height="350px" data-color="#71808f">
                                        <?php
                                        foreach ($noti as $noti_dat) {
                                            ?>
                                            <a class="media p-3">
                                                <div class="media-img">
                                                    <i class="ti ti-bell"></i>
                                                </div>
                                                <div class="media-body">
                                                    <div class="media-heading"><?php echo $noti_dat->title; ?><small class="text-muted float-right"><?php echo date('d M', strtotime($noti_dat->created_at)); ?></small></div>
                                                    <div class="font-13 text-muted"><?php echo $noti_dat->message; ?></div>

                                                </div>
                                            </a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="dropdown dropdown-user">
                            <a class="nav-link dropdown-toggle link" data-toggle="dropdown">
                                <span><?php echo $this->session->userdata("user_name"); ?></span>
                                <img src="<?php echo base_url(); ?>assets/admin/img/user.png" alt="image" />
                            </a>
                            <div class="dropdown-menu dropdown-arrow dropdown-menu-right admin-dropdown-menu">
                                <div class="dropdown-arrow"></div>
                                <div class="dropdown-header">
                                    <div class="admin-avatar">
                                        <img src="<?php echo base_url(); ?>assets/admin/img/user.png" alt="image" />
                                    </div>
                                    <div>
                                        <h5 class="font-strong text-white"><?php echo $this->session->userdata("user_name"); ?></h5>
                                        <div>
                                            <?php
                                            if($this->session->userdata("user_role")==1){
                                                $urole='Admin';
                                            }elseif($this->session->userdata("user_role")==2){
                                                $urole='Agent';
                                            }else{
                                                $urole='Operator';
                                            }
                                            ?>
                                            <span class="admin-badge"><i class="ti-lock mr-2"></i>Role : <?php echo $urole; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="admin-menu-features">

                                    <a title="All Notification" class="admin-features-item" href="<?php echo base_url(); ?>notification" ><i class="ti-bell"></i>
                                        <span>NOTI</span>
                                    </a>
                                    <a title="My Profile" class="admin-features-item" data-toggle="modal" data-target="#profile_model" href="javascript:;"><i class="ti-user"></i>
                                        <span>PROFILE</span>
                                    </a>
                                    <a title="Change Password" class="admin-features-item" href="javascript:;"><i class="ti-settings"></i>
                                        <span>SETTINGS</span>
                                    </a>
                                </div>
                                <div class="admin-menu-content">
                                    <div class="admin-features-item">Your Wallet</div>
                                    <?php if (!empty($tot_wallet_bal[0]->total_bal)) { ?>
                                        <div><i class="ti-wallet h1 mr-3 text-light"></i>
                                            <span class="h1 text-success">$ <?php echo $tot_wallet_bal[0]->total_bal ?></span>
                                        </div>
                                    <?php } else { ?>
                                        <div><i class="ti-wallet h1 mr-3 text-light"></i>
                                            <span class="h1 text-success"><i class="la la-inr"></i>0.00</span>
                                        </div>
                                    <?php } ?>
                                    <div class="d-flex justify-content-between mt-2">
                                        <a class="text-muted" href="<?php echo base_url(); ?>wallet">Wallet Master</a>
                                        <a class="d-flex align-items-center" onclick="return confirm('Are You Sure ? ');" href="<?php echo base_url(); ?>admin-logout">Logout&nbsp;&nbsp;&nbsp;<i class="fa fa-sign-out" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <!-- END TOP-RIGHT TOOLBAR-->
                </div>
            </header>
            <!-- END HEADER-->
