
<!-- START SIDEBAR-->
<nav class="page-sidebar" id="sidebar">
    <div id="sidebar-collapse">
        <ul class="side-menu metismenu">
            <li class="nav-label">
                <a href="<?php echo base_url(); ?>agent/agent_dashboard"><i class="sidebar-item-icon ti-home"></i>
                    <span class="nav-label">Dashboard</span></a>
            </li>
            <li class="heading">FEATURES</li>
            
            
            <li>
                <a href="javascript:;"><i class="sidebar-item-icon ti-package"></i>
                    <span class="nav-label">Market</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="<?php echo base_url(); ?>agent/market/set_market"> Market</a>
                    </li>
                  
                </ul>
            </li>
            <li>
                <a href="javascript:;"><i class="sidebar-item-icon ti-package"></i>
                    <span class="nav-label">Betting</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="<?php echo base_url(); ?>#">All Bets</a>
                    </li>
                   
                </ul>
            </li>
            <li>
                <a href="javascript:;"><i class="sidebar-item-icon ti-user"></i>
                    <span class="nav-label">My Users</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="<?php echo base_url(); ?>agent/users">Users</a>
                    </li>
                   
                </ul>
            </li>
            <li>
                <a href="javascript:;"><i class="sidebar-item-icon ti-wallet"></i>
                    <span class="nav-label">Wallet</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="<?php echo base_url(); ?>agent/wallet">User Wallet</a>
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
                        <a href="#">Match Report</a>
                    </li>
                </ul>
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