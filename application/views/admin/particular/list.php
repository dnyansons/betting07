<div class="page-heading">
    <h1 class="page-title">Particular Master</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo base_url(); ?>"><i class="la la-home font-20"></i></a>
        </li>
        <li class="breadcrumb-item">Admin</li>
        <li class="breadcrumb-item">Particular List</li>
    </ol>
    <a href="<?php echo base_url(); ?>particular/add" class="on-up btn btn-gradient-blue btn-icon-only btn-circle btn-lg btn-air pull-right"><i class="ti-plus"></i></a>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-body">
            
            <?php echo $this->session->flashdata('message'); ?>
            <div class="table-responsive row">

                <table class="table table-bordered table-hover" id="datatable">
                    <thead class="thead-default thead-lg">
                        <tr>
                            <th>Sr No</th>
                            <th>Particular</th>
                            <th>Particular Status</th>
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
</div>
<script>
    // Confirm
    $('.role-delete').click(function () {
        alertify.confirm("Are You Sure ? ", function () {
            return true;
        }, function () {
            return false;
        });
    });
</script>
<script>
    $(function () {

        $('#datatable').DataTable({
            pageLength: 10,
            fixedHeader: true,
            responsive: true,
            processing: true,
            serverSide: true,
            searching: true,

            ajax: {
                url: "<?php echo base_url('particular/ajax_list'); ?>",
                dataType: "json",
                type: "POST",
                data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}
            },
            columns: [
                {data: "per_id"},
                {data: "per_name"},
                {data: "status"},
                {data: "created_at"},
                {data: "action"},
             
            ],
            "aaSorting": [[ 0, "desc" ]],
            "lengthMenu": [[10, 50, 100, 500], [10, 50, 100, 500]]
               
        });

        var table = $('#datatable').DataTable();
        $('#key-search').on('keyup', function () {
            table.search(this.value).draw();
        });
        $('#type-filter').on('change', function () {
            table.column(3).search($(this).val()).draw();
        });
    });
</script>
