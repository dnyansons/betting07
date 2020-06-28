<!-- START PAGE CONTENT-->
<div class="page-heading">
    <h1 class="page-title">Match Event</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo base_url(); ?>"><i class="la la-home font-20"></i></a>
        </li>
        <li class="breadcrumb-item">Admin</li>
        <li class="breadcrumb-item">Event</li>
    </ol>
</div>
<div class="page-content fade-in-up">

    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">Create New Event</div>
            <div class="ibox-tools">
                <a class="ibox-collapse"><i class="ti-angle-down"></i></a>
            </div>
        </div>
        <div class="ibox-body">
            <form class="form-horizontal" id="form-sample-1" method="post" novalidate="novalidate" autocomplete="off">
                <div class="form-group row">
                    <label class="col-sm-2 ">Event ID</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="match_event_id">
                         <?php echo form_error("match_event_id"); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 ">Event Name</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="match_event_name">
                         <?php echo form_error("match_event_name"); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 ">Status</label>
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
                        <button class="btn btn-primary pull-right" type="submit">Add Event</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $("#form-sample-1").validate({
        rules: {
            match_event_id: {
                minlength: 4,
                maxlength:8,
                required: !0,
                number: !0
            },
            match_event_name: {
                required: !0
            },
            status: {
                required: !0
            }

        },
        messages: {
            match_event_id: "Enter Event ID",
            match_event_name: "Enter Event Name",
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