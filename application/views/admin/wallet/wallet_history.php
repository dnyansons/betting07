<div class="page-heading">
    <h1 class="page-title">Wallet History</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo base_url(); ?>admin"><i class="la la-home font-20"></i></a>
        </li>
        <li class="breadcrumb-item">Admin</li>
        <li class="breadcrumb-item">Wallet History</li>
    </ol>
</div>
<br/>
<div id="message"></div>
<div class="page-content fade-in-up toggleDiv">
    <div class="ibox">
        <div class="ibox-body">
            <?php echo $this->session->flashdata('message'); ?>
            <h4>User : <?php echo $user_detail->username; ?> </h4>
            <hr>
            <div class="table-responsive row" style="overflow: auto;">

                <table class="table table-striped table-bordered nowrap" id="wallethistory_table">
                    <thead class="thead-default thead-lg">
                        <tr>
                            <th>Sr.No</th>
                            <th>Amt Type</th>
                            <th>Pre Amount</th>
                            <th>Curr Amount</th>
                            <th>Trans Amount</th>
                            <th>Amt Description</th>
                            <!--<th>Trans Status</th>-->
                            <th>Updated At</th>
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
       var user_id='<?php echo $user_id; ?>';
        $('#wallethistory_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            //dom: 'Bfrtip',
            ajax: {
                url: "<?php echo base_url('wallet/ajax_wallet_historylist'); ?>",
                dataType: "json",
                type: "POST",
                data: {user_id:user_id,'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
            },
            columns: [
                {data: "hist_id"},
                {data: "amount_type"},
                {data: "pre_amount"},
                {data: "current_amount"},
                {data: "trans_amount"},
                {data: "amt_description"},
                {data: "created_at"}
            ],
            "aaSorting": [[ 0, "desc" ]],
            "lengthMenu": [[10, 50, 100, 500], [10, 50, 100, 500]]
        });
    
            
    });

</script>
