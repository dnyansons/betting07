<!-- START PAGE CONTENT-->
<div class="page-heading">
    <h1 class="page-title">Role Master</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo base_url(); ?>"><i class="la la-home font-20"></i></a>
        </li>
        <li class="breadcrumb-item">Add</li>
        <li class="breadcrumb-item">Role</li>
    </ol>
</div>
<div class="page-content fade-in-up">

    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">Create New Role</div>
            <div class="ibox-tools">
                <a class="ibox-collapse"><i class="ti-angle-down"></i></a>
            </div>
        </div>
        <div class="ibox-body">
            <form class="form-horizontal" id="form-sample-1" method="post" novalidate="novalidate" autocomplete="off">
                <div class="form-group row">
                    <label class="col-sm-2 ">Role Name</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="name">
                         <?php echo form_error("name"); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 ">Role Status</label>
                    <div class="col-sm-10">
                        <select name="status" class="form-control">
                            <option value="">--Select--</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                          <?php echo form_error("status"); ?>
                    </div>
                </div>


                <div class="form-group row">
                    <div class="col-sm-10 ml-sm-auto">
                        <button class="btn btn-primary pull-right" type="submit">Add Role</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $("#form-sample-1").validate({
        rules: {
            name: {
                minlength: 2,
                required: !0
            },
            status: {
                required: !0
            }

        },
        messages: {
            name: "Enter Role Name",
            status: "Select Role Status",
        },
        errorClass: "help-block error",
        highlight: function (e) {
            $(e).closest(".form-group.row").addClass("has-error")
        },
        unhighlight: function (e) {
            $(e).closest(".form-group.row").removeClass("has-error")
        },
    });
</script>