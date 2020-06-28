<style>
    .padd_lft{padding-left: 13px !important;}
</style>
<div class="page-heading">
    <h1 class="page-title">User Bets :- <span style="color: green;"><?php echo $fancy_market_info->fancy_market_name; ?></span></h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo base_url(); ?>"><i class="la la-home font-20"></i></a>
        </li>
        <li class="breadcrumb-item">Market</li>
        <li class="breadcrumb-item">User Bets</li>
    </ol>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-body">
            <?php echo $this->session->flashdata('message'); ?>
            <div class="row">
                <input type="hidden" id="fancy_market_id" value="<?php echo $fancy_id; ?>">
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
                    <span class="padd_lft">Bet Status</span><br />
                    <div class="form-group" id="">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-addon bg-white">@</span>
                                <select class="form-control" id="status" name="status">
                                    <option value=''>--All--</option>
                                    <option value='Pending'>Pending</option>
                                    <option value='Declared'>Declared</option>
                                    <option value='Win'>Win</option>
                                    <option value='Loss'>Loss</option>
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
                            <th>Username</th>
                            <th>Mobile</th>
                            <th>Fancy&nbsp;Name</th>
                            <th>Odds</th>
                            <th>Stake</th>
                            <th>Win&nbsp;Amount</th> 
                            <th>Bet&nbsp;Status</th> 
                            <th>Result</th> 
                            <th>Created</th> 
                            <th>Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot align="right">
                        <tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr>
                    </tfoot>
                </table>
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
                url: "<?php echo base_url('market/set_market/user_market_bets_ajax_list'); ?>",
                dataType: "json",
                type: "POST",
                data: function (data) {
                    data.datefrom = $('#dateFrom').val();
                    data.dateto = $('#dateTo').val();
                    data.status = $('#status').val();
                    data.fancy_id = $('#fancy_market_id').val();
                    data.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
                }
            },
            columns: [
                {data: "sr_no"},
                {data: "username"},
                {data: "mobile"},
                {data: "fancy_name"},
                {data: "odd"},
                {data: "stake"},
                {data: "win_amount"},
                {data: "bet_status"},
                {data: "win_status"},
                {data: "created_at"},
                {data: "updated_at"},
            ],
            footerCallback: function (row, data, start, end, display) {
                var api = this.api(), data;

                // converting to interger to find total
                var intVal = function (i) {
                    return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                };

                // computing column Total of the complete result 


                var friTotal = api
                        .column(6)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                var stakeTotal = api
                        .column(5)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                var oddTotal = api
                        .column(4)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);


                // Update footer by showing the total with the reference of the column index 
                $(api.column(3).footer()).html('Total');
                $(api.column(4).footer()).html(oddTotal.toFixed(2));
                $(api.column(5).footer()).html(stakeTotal.toFixed(2));
                $(api.column(6).footer()).html(friTotal.toFixed(2));
            },
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

