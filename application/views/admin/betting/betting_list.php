<style>
    .padd_lft{
        padding-left: 13px;
    }
</style>
<div class="page-heading">
    <h1 class="page-title">Betting List</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo base_url(); ?>"><i class="la la-home font-20"></i></a>
        </li>
        <li class="breadcrumb-item">Admin</li>
        <li class="breadcrumb-item">Betting List</li>
    </ol>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-body">
            
            <?php echo $this->session->flashdata('message'); ?>
            
            <div class="row">
                <div class="col-md-12">
                    <span style="cursor: pointer;font-size: 13px;" class="badge badge-warning badge-pill daterange" data-from="<?php echo date('m/d/Y'); ?>" data-to="<?php echo date('m/d/Y'); ?>" >Today</span>
                    <span style="cursor: pointer;font-size: 13px;" class="badge badge-warning badge-pill daterange" data-from="<?php echo date('m/d/Y', strtotime("-1 days")); ?>" data-to="<?php echo date('m/d/Y', strtotime("-1 days")); ?>" >Yesterday</span>
                    <span style="cursor: pointer;font-size: 13px;" class="badge badge-warning badge-pill daterange" data-to="<?php echo date('m/d/Y'); ?>" data-from="<?php echo date('m/d/Y', strtotime("-7 days")); ?>">Last Week</span>
                    <span style="cursor: pointer;font-size: 13px;" class="badge badge-warning badge-pill daterange" data-from="<?php echo date('m/01/Y'); ?>" data-to="<?php echo date('m/t/Y'); ?>">In Month</span>
                </div>
                <br />
                <br />
                <div class="col-md-3">
                    <span class="padd_lft">From</span><br />
                    <div class="form-group" id="date_1">
                        <div class="col-sm-12">
                            <div class="input-group date">
                                <span class="input-group-addon bg-white"><i class="fa fa-calendar"></i></span>
                                <input class="form-control" id="dateFrom" name="datefrom" value="<?php echo date('m/d/Y'); ?>" value="" type="text" placeholder="mm/dd/yyyy" readonly="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <span class="padd_lft">To</span><br />
                    <div class="form-group" id="date_1">
                        <div class="col-sm-12">
                            <div class="input-group date">
                                <span class="input-group-addon bg-white"><i class="fa fa-calendar"></i></span>
                                <input class="form-control" id="dateTo" name="dateto" value="<?php echo date('m/d/Y'); ?>" value="" type="text" placeholder="mm/dd/yyyy" readonly="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <span class="padd_lft">Betting Status</span><br />
                    <div class="form-group" id="">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <!--<span class="input-group-addon bg-white">@</span>-->
                                <select class="form-control" id="bet_status" name="bet_status">
                                    <option value=''>--All--</option>
                                    <option value='pending'>Pending</option>
                                    <option value='declared'>Declared</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <span class="padd_lft">Win Status</span><br />
                    <div class="form-group" id="">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <!--<span class="input-group-addon bg-white">@</span>-->
                                <select class="form-control" id="win_status" name="win_status">
                                    <option value=''>--All--</option>
                                    <option value='win'>Win</option>
                                    <option value='loss'>Loss</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-2">
                    <span>&nbsp;</span><br />
                    <input type="button" class="btn btn-info btn-block" id="btnFilter" value="Filter">
                </div>
                <div class="col-md-3">
                    <span class="padd_lft">Match ID</span><br />
                    <div class="form-group" id="">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-addon bg-white">@</span>
                               <input type="text" class="form-control" id="match_id" name="match_id">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <span class="padd_lft">User ID</span><br />
                    <div class="form-group" id="">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-addon bg-white">@</span>
                               <input type="text" class="form-control" id="user_id" name="user_id">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            
            <div style="overflow-x:auto;" class="table-responsive row">

                <table class="table table-bordered table-hover" id="bettingList">
                    <thead class="thead-default thead-lg">
                        <tr>
                            <th>Sr.No</th>
                            <th>User&nbsp;ID</th>
                            <th>UserName</th>
                            <th>Mobile</th>
                            <th>Sports</th>
                            <th>Match</th>
                            <th>League</th>
                            <th>Event</th>
                            <th>Bet&nbsp;On</th>
                            <th>Odds</th>
                            <th>Stake</th>
                            <th>Bet&nbsp;Status</th>
                            <th>Win&nbsp;Status</th>
                            <th>Created</th>
                            <th>Updated</th>
                        <!--  <th class="no-sort">Action</th>-->
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
     $(document).ready(function () {

       var dtTable = $('#bettingList').DataTable({
            "sScrollX": '100%',
            pageLength: 10,
            processing: true,
            serverSide: true,
            searching: true,
           
            ajax: {
                url: "<?php echo base_url('Betting/ajax_list'); ?>",
                dataType: "json",
                type: "POST",
                data: function(data){
                    
                    data.datefrom = $('#dateFrom').val();
                    data.dateto = $('#dateTo').val();
                    data.bet_status = $('#bet_status').val();
                    data.win_status = $('#win_status').val();
                    data.match_id = $('#match_id').val();
                    data.user_id = $('#user_id').val();
                    data.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
                }
                
            },
            columns: [
                {data: "bet_id"},
                {data: "user_id"},
                {data: "username"},
                {data: "mobile"},
                {data: "sport_on"},
                {data: "event_id"},
                {data: "league_id"},
                {data: "beton"},
                {data: "odd"},
                {data: "stake"},
                {data: "expose"},
                {data: "bet_status"},
                {data: "win_status"},
                {data: "created_at"},
                {data: "updated_at"},
             
            ],
            "lengthMenu": [[10, 50, 100, 500], [10, 50, 100, 500]]
               
        });
        
         $(document).on('click', '#btnFilter', function () {
            //dtTable.destroy();
            dtTable.clear().draw();
        });
        
    });
    
      $('.daterange').click(function () {
        var datefrom = $(this).attr('data-from');
        var dateto = $(this).attr('data-to');
        var match_id = $(this).attr('match_id');
        var user_id = $(this).attr('user_id');
        $("#dateFrom").val(datefrom);
        $("#dateTo").val(dateto);
        $("#match_id").val(match_id);
        $("#user_id").val(user_id);
      
        $('#btnFilter').trigger('click');
        $(".daterange").removeClass('badge-info');
        $(".daterange").addClass('badge-info');
        $(this).addClass('badge-info');
    });
    
</script>
