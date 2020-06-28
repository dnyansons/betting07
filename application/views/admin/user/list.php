<div class="page-heading">
    <h1 class="page-title">Users</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo base_url(); ?>"><i class="la la-home font-20"></i></a>
        </li>
        <li class="breadcrumb-item">Admin</li>
        <li class="breadcrumb-item">All Users</li>
    </ol>
    <a href="<?php echo base_url(); ?>users/add" class="on-up btn btn-gradient-blue btn-icon-only btn-circle btn-lg btn-air pull-right"><i class="ti-plus"></i></a>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-body">
            <?php echo $this->session->flashdata('message'); ?>
            <div class="table-responsive row" style="overflow: auto;">

                <table class="table table-bordered table-hover" id="datatable">
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
                            <th>Date</th>
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
    <div id="chanhe_status_model" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form class="form-horizontal" action="<?php echo base_url(); ?>users/update_user_status" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Change User Status</h4>
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
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            //dom: 'Bfrtip',
            ajax: {
                url: "<?php echo base_url('users/ajax_list'); ?>",
                dataType: "json",
                type: "POST",
                data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}
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
                {data: "action"}
            ],
            "aaSorting": [[ 0, "desc" ]],
            "lengthMenu": [[10, 50, 100, 500], [10, 50, 100, 500]]
        });

    });

</script>
<script>
    function change_status(user_id)
    {
        if (user_id != '') {

            $.ajax({
                url: '<?php echo base_url(); ?>users/check_user_status',
                method: 'POST',
                data: {user_id: user_id},
                success: function (data) {
                    console.log(data);

                    $('#chanhe_status_model').modal('show');
                    $('#get_status').html('');
                    $('#get_status').html(data);


                }
            });
        } else {
            $('#get_status').html('');
        }
    }
</script>
