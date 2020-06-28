<!-- END PAGE CONTENT-->
<footer class="page-footer">
    <div class="font-13"><?php echo date('Y'); ?> © <b>Betting 07 </b></div>
    <div>Use Google Chrome for Better Response
   </div>
    <div class="to-top"><i class="fa fa-angle-double-up"></i></div>
</footer>
</div>
</div>
<!-- START SEARCH PANEL-->
<form class="search-top-bar" action="http://admincast.com/adminca/preview/admin_1/html/search.html">
    <input class="form-control search-input" type="text" placeholder="Search...">
    <button class="reset input-search-icon"><i class="ti-search"></i></button>
    <button class="reset input-search-close" type="button"><i class="ti-close"></i></button>
</form>
<!-- END SEARCH PANEL-->

<!-- BEGIN PAGA BACKDROPS-->
<div class="sidenav-backdrop backdrop"></div>
<div class="preloader-backdrop">
    <div class="page-preloader">Loading</div>
</div>
<!-- END PAGA BACKDROPS-->
<!-- New question dialog-->
<div class="modal fade" id="session-dialog">
    <div class="modal-dialog" style="width:400px;" role="document">
        <div class="modal-content timeout-modal">
            <div class="modal-body">
                <button class="close" data-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mt-3 mb-4"><i class="ti-lock timeout-icon"></i></div>
                <div class="text-center h4 mb-3">Set Auto Logout</div>
                <p class="text-center mb-4">You are about to be signed out due to inactivity.<br>Select after how many minutes of inactivity you log out of the system.</p>
                <div id="timeout-reset-box" style="display:none;">
                    <div class="form-group text-center">
                        <button class="btn btn-danger btn-fix btn-air" id="timeout-reset">Deactivate</button>
                    </div>
                </div>
                <div id="timeout-activate-box">
                    <form id="timeout-form" action="javascript:;">
                        <div class="form-group pl-3 pr-3 mb-4">
                            <input class="form-control form-control-line" type="text" name="timeout_count" placeholder="Minutes" id="timeout-count">
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-primary btn-fix btn-air" id="timeout-activate">Activate</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End New question dialog-->
<!-- QUICK SIDEBAR-->
<div class="quick-sidebar">
    <ul class="nav nav-tabs tabs-line">
        <li class="nav-item">
            <a class="nav-link active" href="#tab-1" data-toggle="tab"><i class="ti-comment"></i>
                <div>Messages</div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#tab-2" data-toggle="tab"><i class="ti-settings"></i>
                <div>Settings</div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#tab-3" data-toggle="tab"><i class="ti-notepad"></i>
                <div>Logs</div>
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane chat-panel active" id="tab-1">
            <div class="chat-list">
                <div class="scroller">
                    <div class="media-list">
                        <a class="media" href="javascript:;" data-toggle="show-chat">
                            <div class="media-img">
                                <img class="img-circle" src="<?php echo base_url(); ?>assets/admin/img/users/u3.jpg" alt="image" width="40" />
                            </div>
                            <div class="media-body"><small class="float-right text-muted">12:05</small>
                                <div class="media-heading">Frank Cruz</div>
                                <div class="font-13 text-lighter">Lorem Ipsum is simply dummy.</div>
                            </div>
                        </a>
                        <a class="media" href="javascript:;" data-toggle="show-chat">
                            <div class="media-img">
                                <img class="img-circle" src="<?php echo base_url(); ?>assets/admin/img/users/u8.jpg" alt="image" width="40" />
                            </div>
                            <div class="media-body"><small class="float-right text-right text-success"><i class="badge-point badge-success mr-2"></i>12:05<br><span class="badge badge-danger badge-circle">3</span></small>
                                <div class="media-heading">Lynn Weaver</div>
                                <div class="font-13 text-lighter">Lorem Ipsum is simply dummy.</div>
                            </div>
                        </a>
                        <a class="media" href="javascript:;" data-toggle="show-chat">
                            <div class="media-img">
                                <img class="img-circle" src="<?php echo base_url(); ?>assets/admin/img/users/u2.jpg" alt="image" width="40" />
                            </div>
                            <div class="media-body"><small class="float-right text-muted">12:05</small>
                                <div class="media-heading">Becky Brooks</div>
                                <div class="font-13 text-lighter">Lorem Ipsum is simply dummy.</div>
                            </div>
                        </a>
                        <a class="media" href="javascript:;" data-toggle="show-chat">
                            <div class="media-img">
                                <img class="img-circle" src="<?php echo base_url(); ?>assets/admin/img/users/u5.jpg" alt="image" width="40" />
                            </div>
                            <div class="media-body"><small class="float-right text-muted">12:05</small>
                                <div class="media-heading">Bob Gonzalez</div>
                                <div class="font-13 text-lighter">Lorem Ipsum is simply dummy.</div>
                            </div>
                        </a>
                        <a class="media" href="javascript:;" data-toggle="show-chat">
                            <div class="media-img">
                                <img class="img-circle" src="<?php echo base_url(); ?>assets/admin/img/users/u6.jpg" alt="image" width="40" />
                            </div>
                            <div class="media-body"><small class="float-right text-right text-success"><i class="badge-point badge-success mr-2"></i>12:05</small>
                                <div class="media-heading">Connor Perez</div>
                                <div class="font-13 text-lighter">Lorem Ipsum is simply dummy.</div>
                            </div>
                        </a>
                        <a class="media" href="javascript:;" data-toggle="show-chat">
                            <div class="media-img">
                                <img class="img-circle" src="<?php echo base_url(); ?>assets/admin/img/users/u11.jpg" alt="image" width="40" />
                            </div>
                            <div class="media-body"><small class="float-right text-muted">12:05</small>
                                <div class="media-heading">Tyrone Carroll</div>
                                <div class="font-13 text-lighter">Lorem Ipsum is simply dummy.</div>
                            </div>
                        </a>
                        <a class="media" href="javascript:;" data-toggle="show-chat">
                            <div class="media-img">
                                <img class="img-circle" src="<?php echo base_url(); ?>assets/admin/img/users/u9.jpg" alt="image" width="40" />
                            </div>
                            <div class="media-body"><small class="float-right text-right text-success"><i class="badge-point badge-success mr-2"></i>12:05<br><span class="badge badge-danger badge-circle">1</span></small>
                                <div class="media-heading">Tammy Newman</div>
                                <div class="font-13 text-lighter">Lorem Ipsum is simply dummy.</div>
                            </div>
                        </a>
                        <a class="media" href="javascript:;" data-toggle="show-chat">
                            <div class="media-img">
                                <img class="img-circle" src="<?php echo base_url(); ?>assets/admin/img/users/u1.jpg" alt="image" width="40" />
                            </div>
                            <div class="media-body"><small class="float-right text-muted">12:05</small>
                                <div class="media-heading">Jeanne Gonzalez</div>
                                <div class="font-13 text-lighter">Lorem Ipsum is simply dummy.</div>
                            </div>
                        </a>
                        <a class="media" href="javascript:;" data-toggle="show-chat">
                            <div class="media-img">
                                <img class="img-circle" src="<?php echo base_url(); ?>assets/admin/img/users/u10.jpg" alt="image" width="40" />
                            </div>
                            <div class="media-body"><small class="float-right text-muted">12:05</small>
                                <div class="media-heading">Stella Obrien</div>
                                <div class="font-13 text-lighter">Lorem Ipsum is simply dummy.</div>
                            </div>
                        </a>
                        <a class="media" href="javascript:;" data-toggle="show-chat">
                            <div class="media-img">
                                <img class="img-circle" src="<?php echo base_url(); ?>assets/admin/img/users/u7.jpg" alt="image" width="40" />
                            </div>
                            <div class="media-body"><small class="float-right text-muted">12:05</small>
                                <div class="media-heading">Jeanne Smith</div>
                                <div class="font-13 text-lighter">Lorem Ipsum is simply dummy.</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="messenger">
                <div class="messenger-header">
                    <a class="messenger-return" href="javascript:;">
                        <span class="ti-angle-left"></span>
                    </a>
                    <div class="text-center text-white">
                        <h6 class="mb-1 font-16">Lynn Weaver</h6>
                        <div>
                            <span class="badge-point badge-danger mr-2"></span><small>Online</small></div>
                    </div>
                    <div class="dropdown">
                        <a class="messenger-more dropdown-toggle" data-toggle="dropdown">
                            <span class="ti-more-alt"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item">
                                <span class="ti-heart m-r-10"></span>Add to favorite</a>
                            <a class="dropdown-item">
                                <span class="ti-close m-r-10"></span>Clear chat</a>
                        </div>
                    </div>
                </div>
                <div class="messenger-messages">
                    <div class="scroller">
                        <div class="messenger-message">
                            <div class="message-image">
                                <img src="<?php echo base_url(); ?>assets/admin/img/users/u8.jpg" alt="image" />
                            </div>
                            <div class="message-body">Hi Jack. You are comfortable today.</div>
                        </div>
                        <div class="messenger-message messenger-message-answer">
                            <div class="message-body">Hi Lynn. Yes Sure.</div>
                        </div>
                        <div class="messenger-message">
                            <div class="message-image">
                                <img src="<?php echo base_url(); ?>assets/admin/img/users/u8.jpg" alt="image" />
                            </div>
                            <div class="message-body">Hi. What is your main principle in work.</div>
                        </div>
                        <div class="messenger-message messenger-message-answer">
                            <div class="message-body">Our main principle: We work hard to make our client comfortable.</div>
                        </div>
                        <div class="message-time">4.30 PM</div>
                        <div class="messenger-message">
                            <div class="message-image">
                                <img src="<?php echo base_url(); ?>assets/admin/img/users/u8.jpg" alt="image" />
                            </div>
                            <div class="message-body">
                                <p>Here are some beautiful photos.</p>
                                <div class="mb-3">
                                    <img src="<?php echo base_url(); ?>assets/admin/img/blog/culinary-1.jpg" alt="image" />
                                </div>
                                <div>
                                    <img src="<?php echo base_url(); ?>assets/admin/img/blog/01.jpg" alt="image" />
                                </div>
                            </div>
                        </div>
                        <div class="messenger-message messenger-message-answer">
                            <div class="message-body">Thanks, they are beautiful.</div>
                        </div>
                        <div class="messenger-message">
                            <div class="message-image">
                                <img src="<?php echo base_url(); ?>assets/admin/img/users/u8.jpg" alt="image" />
                            </div>
                            <div class="message-body">How many hours are you comfortable.</div>
                        </div>
                        <div class="messenger-message messenger-message-answer">
                            <div class="message-body">In the evening at 6.30 clock.</div>
                        </div>
                    </div>
                </div>
                <div class="messenger-form">
                    <div class="messenger-form-inner">
                        <input class="messenger-input" type="text" placeholder="Type a message">
                        <div class="messenger-actions">
                            <span class="messanger-button messanger-paperclip">
                                <input type="file"><i class="la la-paperclip"></i></span>
                            <a class="messanger-button" href="javascript:;"><i class="fa fa-send-o"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="tab-2">
            <div class="scroller">
                <div class="font-bold mb-4 mt-2">APP SETTINGS</div>
                <div class="settings-item">Show notifications
                    <label class="ui-switch switch-icon">
                        <input type="checkbox">
                        <span></span>
                    </label>
                </div>
                <div class="settings-item">Enable autologout
                    <label class="ui-switch switch-icon">
                        <input type="checkbox" checked>
                        <span></span>
                    </label>
                </div>
                <div class="settings-item">Show recent activity
                    <label class="ui-switch switch-icon">
                        <input type="checkbox">
                        <span></span>
                    </label>
                </div>
                <div class="settings-item">Chat history
                    <label class="ui-switch switch-icon">
                        <input type="checkbox">
                        <span></span>
                    </label>
                </div>
                <div class="settings-item">Users activity
                    <label class="ui-switch switch-icon">
                        <input type="checkbox" checked>
                        <span></span>
                    </label>
                </div>
                <div class="settings-item">Orders history
                    <label class="ui-switch switch-icon">
                        <input type="checkbox">
                        <span></span>
                    </label>
                </div>
                <div class="settings-item">SMS Alerts
                    <label class="ui-switch switch-icon">
                        <input type="checkbox">
                        <span></span>
                    </label>
                </div>
                <div class="font-bold mb-4">SYSTEM SETTINGS</div>
                <div class="settings-item">Error Reporting
                    <label class="ui-switch switch-icon">
                        <input type="checkbox" checked>
                        <span></span>
                    </label>
                </div>
                <div class="settings-item">Server logs
                    <label class="ui-switch switch-icon">
                        <input type="checkbox">
                        <span></span>
                    </label>
                </div>
                <div class="settings-item">Global search
                    <label class="ui-switch switch-icon">
                        <input type="checkbox">
                        <span></span>
                    </label>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="tab-3">
            <div class="log-tabs">
                <a class="active" href="javascript:;" data-type="all" data-toggle="tooltip" data-original-title="All logs"><i class="ti-view-grid"></i></a>
                <a href="javascript:;" data-type="server" data-toggle="tooltip" data-original-title="Server logs"><i class="ti-harddrives"></i></a>
                <a href="javascript:;" data-type="app" data-toggle="tooltip" data-original-title="App logs"><i class="ti-pulse"></i></a>
            </div>
            <div class="logs">
                <div class="scroller">
                    <ul class="logs-list">
                        <li class="log-item" data-type="app"><i class="ti-check log-icon text-success"></i>
                            <div>
                                <a>2 Issue fixed</a><small class="float-right text-muted">Just now</small></div>
                        </li>
                        <li class="log-item" data-type="app"><i class="ti-announcement log-icon"></i>
                            <div>
                                <a>7 new feedback</a>
                                <span class="badge badge-warning badge-pill ml-1">important</span><small class="float-right text-muted">5 mins</small></div>
                        </li>
                        <li class="log-item" data-type="server"><i class="ti-check log-icon text-success"></i>
                            <div>
                                <a>Production server up</a><small class="float-right text-muted">24 mins</small></div>
                        </li>
                        <li class="log-item" data-type="app"><i class="ti-shopping-cart log-icon"></i>
                            <div>
                                <a>12 New orders</a><small class="float-right text-muted">45 mins</small></div>
                        </li>
                        <li class="log-item" data-type="server"><i class="ti-info-alt log-icon text-danger"></i>
                            <div>
                                <a>Server error</a>
                                <span class="badge badge-primary badge-pill ml-1">resolved</span><small class="float-right text-muted">1 hrs</small></div>
                        </li>
                        <li class="log-item" data-type="server"><i class="ti-harddrives log-icon text-danger"></i>
                            <div>
                                <a>Server overloaded 91%</a><small class="float-right text-muted">2 hrs</small></div>
                        </li>
                        <li class="log-item" data-type="app"><i class="ti-user log-icon"></i>
                            <div>
                                <a>18 new users registered</a><small class="float-right text-muted">12.07</small></div>
                        </li>
                        <li class="log-item" data-type="app"><i class="ti-shopping-cart log-icon"></i>
                            <div>
                                <a>5 New orders</a>
                                <span class="badge badge-success badge-pill ml-1">pending</span><small class="float-right text-muted">12.30</small></div>
                        </li>
                        <li class="log-item" data-type="server"><i class="ti-info-alt log-icon text-danger"></i>
                            <div>
                                <a>System error</a><small class="float-right text-muted">13.45</small></div>
                        </li>
                        <li class="log-item" data-type="app"><i class="fa fa-file-excel-o log-icon"></i>
                            <div>
                                <a>The invoice is ready</a><small class="float-right text-muted">16.30</small></div>
                        </li>
                        <li class="log-item" data-type="server"><i class="ti-server log-icon text-danger"></i>
                            <div>
                                <a>Database overloaded 92%</a><small class="float-right text-muted">17.15</small></div>
                        </li>
                        <li class="log-item" data-type="server"><i class="ti-check log-icon text-success"></i>
                            <div>
                                <a>Production server up</a><small class="float-right text-muted">18.05</small></div>
                        </li>
                        <li class="log-item" data-type="app"><i class="ti-user log-icon"></i>
                            <div>
                                <a>12 new users registered</a><small class="float-right text-muted">18.22</small></div>
                        </li>
                        <li class="log-item" data-type="app"><i class="ti-shopping-cart log-icon"></i>
                            <div>
                                <a>8 New orders</a><small class="float-right text-muted">20.00</small></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END QUICK SIDEBAR-->
<!-- CORE PLUGINS-->

<!--<script src="<?php //echo base_url(); ?>assets/admin/vendors/popper.js/dist/umd/popper.min.js"></script>
<script src="<?php //echo base_url(); ?>assets/admin/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php //echo base_url(); ?>assets/admin/vendors/metisMenu/dist/metisMenu.min.js"></script>
<script src="<?php //echo base_url(); ?>assets/admin/vendors/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php //echo base_url(); ?>assets/admin/vendors/jquery-idletimer/dist/idle-timer.min.js"></script>
<script src="<?php //echo base_url(); ?>assets/admin/vendors/toastr/toastr.min.js"></script>
<script src="<?php //echo base_url(); ?>assets/admin/vendors/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php //echo base_url(); ?>assets/admin/vendors/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
 PAGE LEVEL PLUGINS
<script src="<?php //echo base_url(); ?>assets/admin/vendors/chart.js/dist/Chart.min.js"></script>
<script src="<?php// echo base_url(); ?>assets/admin/vendors/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
<script src="<?php //echo base_url(); ?>assets/admin/vendors/jvectormap/jquery-jvectormap-2.0.3.min.js"></script>
<script src="<?php //echo base_url(); ?>assets/admin/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
 CORE SCRIPTS
<script src="<?php //echo base_url(); ?>assets/admin/vendors/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="<?php //echo base_url(); ?>assets/admin/js/app.min.js"></script>
 PAGE LEVEL SCRIPTS
<script src="<?php //echo base_url(); ?>assets/admin/vendors/alertifyjs/dist/js/alertify.js"></script>
<script src="<?php //echo base_url(); ?>assets/admin/js/scripts/dashboard_visitors.js"></script>
<script src="<?php //echo base_url(); ?>assets/admin/js/scripts/alertify-demo.js"></script>
<script src="<?php //echo base_url(); ?>assets/admin/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php //echo base_url(); ?>assets/admin/vendors/smalot-bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php //echo base_url(); ?>assets/admin/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php //echo base_url(); ?>assets/admin/vendors/clockpicker/dist/bootstrap-clockpicker.min.js"></script>
<script src="<?php //echo base_url(); ?>assets/admin/vendors/jquery-minicolors/jquery.minicolors.min.js"></script>
<script src="<?php //echo base_url(); ?>assets/admin/vendors/multiselect/js/jquery.multi-select.js"></script>
<script src="<?php //echo base_url(); ?>assets/admin/js/app.min.js"></script>
<script src="<?php //echo base_url(); ?>assets/admin/js/scripts/form-plugins.js"></script>-->

<!--dfdfd-->
   
 <!-- CORE PLUGINS-->
   
  <!-- PAGE LEVEL PLUGINS-->
     <script src="<?php echo base_url(); ?>assets/admin/vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/vendors/metisMenu/dist/metisMenu.min.js"></script>
    
    <script src="<?php echo base_url(); ?>assets/admin/vendors/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/vendors/jquery-idletimer/dist/idle-timer.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/vendors/toastr/toastr.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/vendors/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/vendors/chart.js/dist/Chart.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/vendors/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/vendors/jvectormap/jquery-jvectormap-2.0.3.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
   
    <!-- PAGE LEVEL PLUGINS-->
    <script src="<?php echo base_url(); ?>assets/admin/vendors/select2/dist/js/select2.full.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/vendors/jquery-knob/dist/jquery.knob.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/vendors/ion.rangeSlider/js/ion.rangeSlider.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/vendors/moment/min/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/vendors/smalot-bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/vendors/clockpicker/dist/bootstrap-clockpicker.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/vendors/jquery-minicolors/jquery.minicolors.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/vendors/multiselect/js/jquery.multi-select.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/vendors/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/vendors/bootstrap-maxlength/src/bootstrap-maxlength.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/vendors/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
    <!-- CORE SCRIPTS-->
    <script src="<?php echo base_url(); ?>assets/admin/js/app.min.js"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script src="<?php echo base_url(); ?>assets/admin/js/scripts/form-plugins.js"></script>
    
    <!-- PAGE LEVEL SCRIPTS-->
    <script src="<?php echo base_url(); ?>assets/admin/js/scripts/dashboard_visitors.js"></script>
    <script>
      
//          $("input").on("keypress",function(e){
//             
//             var k = e.keyCode;
//            return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8   || (k >= 48 && k <= 57));
//          });
            

         
        </script>
        
        <?php  $user_data = $this->session->all_userdata(); ?>
<!-- The Modal -->
 <!-- Modal -->
  <div class="modal fade" id="profile_model" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
          <h4 class="modal-title">User Info.</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
          
        <div class="modal-body">
         
         <input type="hidden" name="user_id" id="user_id" class="form-control" value=""/>
          <div class="page-content fade-in-up">
              
               <table class="table tablew ">   
                   <?php if(!empty($user_deatil)){ ?>
                        <tbody>
                            <tr>                         
                                    <th><strong>Name :</strong></th>
                                    <td> <strong><?php echo $user_deatil[0]->first_name.' '.$user_deatil[0]->last_name ?></strong></td>
                            </tr>
                                <tr> 
                                 <th><strong>Email :</strong></th>
                                 <td><strong><?php echo $user_deatil[0]->email ?></strong></td>

                                </tr>
							
                            <tr>
                                     <th><strong>Mobile :</strong></th>							
                                     <td class=""><strong><span class=""><?php echo $user_deatil[0]->mobile ?></span><strong></td>
                             </tr>
                             
                               <tr>
                                     <th><strong>Last Login :</strong></th>							
                                     <td class=""><strong><span class=""><?php echo $user_deatil[0]->last_login_activity ?></span></strong></td>
                             </tr>
                        </tbody>
                        
                   <?php } ?>
                      </table>

               </div>
               
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          
        </div>
          
              </div>
      </div>
      
    </div>
  </div>
</body>
</html>