<style>
    .padd_lft{padding-left: 13px !important;}
</style>
<div class="page-heading">
    <h1 class="page-title">All Notification</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo base_url(); ?>"><i class="la la-home font-20"></i></a>
        </li>
        <li class="breadcrumb-item">Agent</li>
        <li class="breadcrumb-item">Notification</li>
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
                <div class="col-md-3">
                    <span class="padd_lft">Status</span><br />
                    <div class="form-group" id="">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <select class="form-control" id="status" name="status">
                                    <option value=''>--All--</option>
                                    <option value='Read'>Read</option>
                                    <option value='Unread'>Unread</option>
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

                <table class="table table-bordered table-hover" id="notification">
                    <thead class="thead-default thead-lg">
                        <tr>
                            <th>Sr.No</th>
                            <th>UserName</th>
                            <th>Title</th>
                            <th>Message</th>
                            <th>Created At</th>
                            <th>Status</th>
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
        var dtTable = $('#notification').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
//            dom: 'Bfrtip',

            ajax: {
                url: "<?php echo base_url('agent/notification/ajax_notification_list') ?>",
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
                {data: "username"},
                {data: "title"},
                {data: "message"},
                {data: "created_at"},
                {data: "status"}
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