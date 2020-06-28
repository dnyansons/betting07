
<!-- START SIDEBAR-->
<nav class="page-sidebar" id="sidebar">
    <div id="sidebar-collapse">
        <ul class="side-menu metismenu">
            <li class="nav-label">
                <a href="<?php echo base_url(); ?>dashboard"><i class="sidebar-item-icon ti-home"></i>
                    <span class="nav-label">Dashboard</span></a>
            </li>
            <li class="heading">FEATURES</li>
            
            <li>
                <a href="javascript:;"><i class="sidebar-item-icon ti-package"></i>
                    <span class="nav-label">Master</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="<?php echo base_url(); ?>role">Role Master</a>
                    </li>
                    <li>
                        <a href="#">Currency Master</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>particular">Particular Master</a>
                    </li>
                   <li>
                        <a href="<?php echo base_url(); ?>sports">Sports Master</a>
                    </li>
                   <li>
                        <a href="<?php echo base_url(); ?>match_event">Match Event</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;"><i class="sidebar-item-icon ti-package"></i>
                    <span class="nav-label">Market Setting</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="<?php echo base_url(); ?>market/set_market">Set Market</a>
                    </li>
<!--                    <li>
                        <a href="#">Declare Market Result</a>
                    </li>-->
                </ul>
            </li>
            <li>
                <a href="javascript:;"><i class="sidebar-item-icon ti-package"></i>
                    <span class="nav-label">Betting</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="<?php echo base_url(); ?>betting/">All Bets</a>
                    </li>
                   
                </ul>
            </li>
            <li>
                <a href="javascript:;"><i class="sidebar-item-icon ti-user"></i>
                    <span class="nav-label">All Users</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="<?php echo base_url(); ?>users">All Users</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>users/block_user">Block Users</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;"><i class="sidebar-item-icon ti-wallet"></i>
                    <span class="nav-label">Wallet</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="<?php echo base_url(); ?>wallet">User Wallet</a>
                    </li>
                   
                </ul>
            </li>
            <li>
                <a href="javascript:;"><i class="sidebar-item-icon ti-file"></i>
                    <span class="nav-label">Reports</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="<?php echo base_url(); ?>report/user_report">User Report</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>report/match_report">Match Report</a>
                    </li>
                </ul>
            </li>
            <li class="heading">PERMISSION</li>
             <li class="nav-label">
                <a href="#"><i class="sidebar-item-icon ti-layout-tab-window"></i>
                    <span class="nav-label">User Permission</span></a>
            </li>
           
        </ul>
        <div class="sidebar-footer">
            <a href="javascript:;"><i class="ti-announcement"></i></a>
            <a href="#"><i class="ti-calendar"></i></a>
            <a href="#"><i class="ti-comments"></i></a>
            <a onclick="return confirm('Are You Sure ? ');" href="<?php echo base_url(); ?>admin-logout"><i class="ti-power-off"></i></a>
        </div>
    </div>
</nav>
<!-- END SIDEBAR-->
<div class="content-wrapper">