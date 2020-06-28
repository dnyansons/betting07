<style>
    .padd_lft{padding-left: 13px !important;}
</style>
<div class="page-heading">
    <h1 class="page-title">Market</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo base_url(); ?>"><i class="la la-home font-20"></i></a>
        </li>
        <li class="breadcrumb-item">Market</li>
        <li class="breadcrumb-item">View Market</li>
    </ol>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-body">
            <?php echo $this->session->flashdata('message'); ?>
            <div class="row">
                <div class="col-md-12">
                    <span style="cursor: pointer;font-size: 13px;" class="badge badge-warning badge-pill daterange" data-from="<?php echo date('m/d/Y 00:00:00'); ?>" data-to="<?php echo date('m/d/Y 23:59:00'); ?>" >Today</span>
                    <span style="cursor: pointer;font-size: 13px;" class="badge badge-warning badge-pill daterange" data-from="<?php echo date('m/d/Y 00:00:00', strtotime("+1 days")); ?>" data-to="<?php echo date('m/d/Y 23:59:00', strtotime("+1 days")); ?>" >Tomorrow</span>
                    <span style="cursor: pointer;font-size: 13px;" class="badge badge-warning badge-pill daterange" data-from="<?php echo date('m/d/Y 00:00:00',strtotime("+1 days")); ?>" data-to="<?php echo date('m/d/Y 23:59:00', strtotime("+6 days")); ?>">Next 5 Days</span>
                    <span style="cursor: pointer;font-size: 13px;" class="badge badge-warning badge-pill daterange" data-from="<?php echo date('m/01/Y 00:00:00'); ?>" data-to="<?php echo date('m/t/Y 23:59:00'); ?>">In Month</span>
                </div>
                <br />
                <br />
                <div class="col-md-3">
                    <span class="padd_lft">From</span><br />
                    <div class="form-group" id="date_1">
                        <div class="col-sm-12">
                            <div class="input-group date">
                                <span class="input-group-addon bg-white"><i class="fa fa-calendar"></i></span>
                                <input class="form-control" id="dateFrom" name="datefrom" value="<?php echo date('m/d/Y 00:00:00'); ?>" type="text" placeholder="mm/dd/yyyy" readonly="">
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
                                <input class="form-control" id="dateTo" name="dateto" value="<?php echo date('m/d/Y 23:59:00'); ?>" type="text" placeholder="mm/dd/yyyy" readonly="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <span class="padd_lft">Market Status</span><br />
                    <div class="form-group" id="">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-addon bg-white">@</span>
                                <select class="form-control" id="status" name="status">
                                    <option value=''>--All--</option>
                                    <option value='Active'>Active</option>
                                    <option value='Inactive'>Inactive</option>
                                    <option value='New'>New</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <span>&nbsp;</span><br />
                    <input type="button" class="btn btn-info btn-block" id="btnFilter" value="Filter">
                </div>
            </div>
            <hr>
            <div class="table-responsive row" style="overflow: auto;">

                <table class="table table-bordered table-hover" id="market">
                    <thead class="thead-default thead-lg">
                        <tr>
                            <th>Sr&nbsp;No</th>
                            <th>Sport&nbsp;ID</th>
                            <th>Match&nbsp;ID</th>
                            <th>League&nbsp;Name</th>
                            <th>Team</th>
                            <th>Start&nbsp;Date&nbsp;Time</th>
                            <th>Live&nbsp;Status</th> 
                            <th>Status</th> 
                            <th class="no-sort">Action</th>
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
                        <h4 class="modal-title">Change Match Status</h4>
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
                url: "<?php echo base_url('agent/market/set_market/ajax_market_list') ?>",
                dataType: "json",
                type: "POST",
                data: function (data) {
                    data.datefrom = $('#dateFrom').val();
                    data.dateto = $('#dateTo').val();
                    data.status = $('#status').val();
                    data.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
}
            },
            columns: [
                {data: "sr_no"},
                {data: "sport_id"},
                {data: "match_id"},
                {data: "league_name"},
                {data: "home_name"},
                {data: "match_time"},
                {data: "time_status"},
                {data: "m_status"},
                {data: "action"},
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
        $("#dateFrom").val(datefrom);
        $("#dateTo").val(dateto);
        $('#btnFilter').trigger('click');
        $(".daterange").removeClass('badge-info');
        $(".daterange").addClass('badge-info');
        $(this).addClass('badge-info');
    });

</script>
<script>
    function change_status(m_id)
    {
        if (m_id != '') {

            $.ajax({
                url: '<?php echo base_url(); ?>agent/market/set_market/check_league_status',
                method: 'POST',
                data: {m_id: m_id},
                success: function (data) {
                    console.log(data);

                    $('#change_status_model').modal('show');
                    $('#get_status').html('');
                    $('#get_status').html(data);


                }
            });
        } else {
            $('#get_status').html('');
        }
    }
</script>
