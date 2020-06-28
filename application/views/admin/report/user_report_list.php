<style>
    .padd_lft{padding-left: 13px !important;}
</style>
<div class="page-heading">
    <h1 class="page-title">User Report</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo base_url(); ?>"><i class="la la-home font-20"></i></a>
        </li>
        <li class="breadcrumb-item">Report</li>
        <li class="breadcrumb-item">User Report</li>
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
                    <span style="cursor: pointer;font-size: 13px;" class="badge badge-warning badge-pill daterange" data-from="<?php echo date('m/d/Y',strtotime("-1 days")); ?>" data-to="<?php echo date('m/d/Y', strtotime("-6 days")); ?>">Last 5 Days</span>
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
                                <input class="form-control" id="dateFrom" name="datefrom" value="<?php echo date('m/d/Y'); ?>" type="text" placeholder="mm/dd/yyyy" readonly="">
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
                                <input class="form-control" id="dateTo" name="dateto" value="<?php echo date('m/d/Y'); ?>" type="text" placeholder="mm/dd/yyyy" readonly="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <span class="padd_lft">User Status</span><br />
                    <div class="form-group" id="">
                        <div class="col-sm-12">
                            <div class="input-group">
                                
                                <select class="form-control" id="status" name="status">
                                    <option value=''>--All--</option>
                                    <option value='Active'>Active</option>
                                    <option value='Inactive'>Inactive</option>
                                    <option value='Block'>Block</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <span class="padd_lft">Role</span><br />
                    <div class="form-group" id="">
                        <div class="col-sm-12">
                            <div class="input-group">
                               
                                <select class="form-control" id="role" name="role">
                                    <option value=''>--All--</option>
                                    <option value='2'>Agent</option>
                                    <option value='3'>Users</option>
                                    <option value='4'>Operator</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <span>&nbsp;</span><br />
                    <input type="button" class="btn btn-info btn-block" id="btnFilter" value="Filter">
                </div>
            </div>
            <hr>
            <div class="table-responsive row" style="overflow: auto;">

                <table class="table table-bordered table-hover" id="market">
                    <thead class="thead-default thead-lg">
                        <tr>
                            <th>User&nbsp;ID</th>
                            <th>UserName</th>
                            <th>Full&nbsp;Name</th>
                            <th>Role</th>
                            <th>Under</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Join Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="change_status_model" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form class="form-horizontal" action="<?php echo base_url(); ?>market/set_market/update_league_status" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Change League Status</h4>
                    </div>
                    <div class="modal-body">
                        <p id="get_status">Loading...</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" onclick="return confirm('Are You Sure ? ');">Change</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var dtTable = $('#market').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
//            dom: 'Bfrtip',

            ajax: {
                url: "<?php echo base_url('report/user_report/ajax_user_report_list') ?>",
                dataType: "json",
                type: "POST",
                data: function (data) {
                    data.datefrom = $('#dateFrom').val();
                    data.dateto = $('#dateTo').val();
                    data.status = $('#status').val();
                    data.role = $('#role').val();
                    data.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
}
            },
            columns: [
                {data: "user_id"},
                {data: "username"},
                {data: "first_name"},
                {data: "role"},
                {data: "under"},
                {data: "mobile"},
                {data: "email"},
                {data: "status"},
                {data: "created_at"},
                
            ],
            "lengthMenu": [[10, 25, 100], [10, 25, 100]]
        });

        $(document).on('click', '#btnFilter', function () {
            //dtTable.destroy();
            dtTable.clear().draw();
        });

        $(document).on('click', '#export', function () {
            $('#form_submit').submit();
        });

    });

    $('.daterange').click(function () {
        var datefrom = $(this).attr('data-from');
        var dateto = $(this).attr('data-to');
        var role = $(this).attr('role');
        $("#role").val(role);
        $("#dateFrom").val(datefrom);
        $("#dateTo").val(dateto);
        $('#btnFilter').trigger('click');
        $(".daterange").removeClass('badge-info');
        $(".daterange").addClass('badge-info');
        $(this).addClass('badge-info');
    });

</script>