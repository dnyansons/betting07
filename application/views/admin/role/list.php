<div class="page-heading">
    <h1 class="page-title">Role Master</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo base_url(); ?>"><i class="la la-home font-20"></i></a>
        </li>
        <li class="breadcrumb-item">Role</li>
        <li class="breadcrumb-item">Admin</li>
    </ol>
    <a href="<?php echo base_url(); ?>role/add" class="on-up btn btn-gradient-blue btn-icon-only btn-circle btn-lg btn-air pull-right"><i class="ti-plus"></i></a>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-body">
            <div class="flexbox mb-4">
                <div class="flexbox">
                    <label class="mb-0 mr-2">Type:</label>
                    <select class="selectpicker show-tick form-control" id="type-filter" title="Please select" data-style="btn-solid" data-width="150px">
                        <option value="">All</option>
                        <option>Active</option>
                        <option>Inactive</option>
                    </select>
                </div>
                <div class="input-group-icon input-group-icon-left mr-3">
                    <span class="input-icon input-icon-right font-16"><i class="ti-search"></i></span>
                    <input class="form-control form-control-rounded form-control-solid" id="key-search" type="text" placeholder="Search ...">
                </div>
            </div>
            <?php echo $this->session->flashdata('message'); ?>
            <div class="table-responsive row">

                <table class="table table-bordered table-hover" id="datatable">
                    <thead class="thead-default thead-lg">
                        <tr>
                            <th>Sr No</th>
                            <th>Role ID</th>
                            <th>Role Name</th>
                            <th>Role Status</th>
                            <th>Date</th>
                            <th class="no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $i = 1;
                        foreach ($role as $ro) {
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $ro->role_id; ?></td>
                                <td><?php echo $ro->name; ?></td>
                                <td><?php echo $ro->status; ?></td>
                                <td><?php echo date('d-m-Y H:i:s', strtotime($ro->created_at)); ?></th>
                                <td>
                                    <!--<button class="btn btn-danger btn-sm font-16 role-delete"><i class="ti-trash"></i></button>-->
                                    <a class="text-muted font-16" onclick="return confirm('Are You Sure ?')" href="<?php echo base_url(); ?>role/delete/<?php echo $ro->role_id ?>"><i class="ti-trash"></i></a>
                                    &nbsp;&nbsp;&nbsp;<a class="text-muted font-16" href="<?php echo base_url(); ?>role/edit/<?php echo $ro->role_id ?>"><i class="ti-pencil-alt"></i></a>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>

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
      $(document).ready(function () {

        $('#datatable').DataTable({
            pageLength: 10,
            fixedHeader: true,
            responsive: true,
            "sDom": 'rtip',
            columnDefs: [{
                    targets: 'no-sort',
                    orderable: false
                }]
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
