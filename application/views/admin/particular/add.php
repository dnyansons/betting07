<!-- START PAGE CONTENT-->
<div class="page-heading">
    <h1 class="page-title">Particular Master</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo base_url(); ?>"><i class="la la-home font-20"></i></a>
        </li>
        <li class="breadcrumb-item">Admin</li>
        <li class="breadcrumb-item">Add Particular</li>
    </ol>
</div>
<div class="page-content fade-in-up">

    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">Create New Particular</div>
            <div class="ibox-tools">
                <a class="ibox-collapse"><i class="ti-angle-down"></i></a>
            </div>
        </div>
        <div class="ibox-body">
            <form class="form-horizontal" id="form-sample-1" method="post" novalidate="novalidate" autocomplete="off">
                <div class="form-group row">
                    <label class="col-sm-2 ">Particular Name</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="particular_name">
                         <?php echo form_error("particular_name"); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 ">Particular Status</label>
                    <div class="col-sm-10">
                        <select name="particular_status" class="form-control">
                            <option value="">--Select--</option>
                            <option value="Active">Active</option>
                            <option value="InActive">Inactive</option>
                        </select>
                          <?php echo form_error("particular_status"); ?>
                    </div>
                </div>


                <div class="form-group row">
                    <div class="col-sm-10 ml-sm-auto">
                        <button class="btn btn-primary pull-right" type="submit">Add Particular</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $("#form-sample-1").validate({
        rules: {
            particular_name: {
                minlength: 2,
                required: !0
            },
            particular_status: {
                required: !0
            }

        },
        messages: {
            particular_name: "Enter Particular Name",
            particular_status: "Select Particular Status",
        },
       // errorClass: "help-block error",
        highlight: function (e) {
            $(e).closest(".form-group.row").addClass("has-error");
        },
        unhighlight: function (e) {
            $(e).closest(".form-group.row").removeClass("has-error");
            
        },
    });
</script>