<style>
    label{padding-left: 12px  !important;}
</style>
<div class="page-heading">
    <h1 class="page-title">Update User</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo base_url(); ?>"><i class="la la-home font-20"></i></a>
        </li>
        <li class="breadcrumb-item">Update</li>
        <li class="breadcrumb-item">User</li>
    </ol>
</div>
<div class="page-content fade-in-up">

    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">Update User</div>
            <div class="ibox-tools">
                <a class="ibox-collapse"><i class="ti-angle-down"></i></a>
            </div>
        </div>
        <div class="ibox-body">
            <form class="form-horizontal" id="form-sample-1" method="post" novalidate="novalidate">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label">Username</label>
                            <div class="col-sm-12">
                                <input class="form-control" type="text" name="username" value="<?php echo $users->username; ?>" readonly="">
                                <?php echo form_error("username"); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">First Name</label>
                            <div class="col-sm-12">
                                <input class="form-control" type="text" name="first_name" value="<?php echo $users->first_name; ?>">
                                <?php echo form_error("first_name"); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Mobile</label>
                            <div class="col-sm-12">
                                <input class="form-control" type="text" name="mobile" value="<?php echo $users->mobile; ?>">
                                <?php echo form_error("mobile"); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Country</label>
                            <div class="col-sm-12">
                                <select name="country" class="form-control select2_demo_1" onchange="get_state(this.value);">

                                    <?php
                                    foreach ($country as $co) {
                                        if ($co->id) {
                                            if ($co->id == $users->country) {
                                                $selected = 'selected="selected"';
                                            } else {
                                                $selected = '';
                                            }
                                            echo '<option value="' . $co->id . ' ' . $selected . '">' . $co->name . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <?php echo form_error("country"); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Address 1</label>
                            <div class="col-sm-12">
                                <input class="form-control" type="text" name="addr1" value="<?php echo $users->addr1; ?>">
                                <?php echo form_error("addr1"); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">User Role</label>
                            <div class="col-sm-12">
                                <select name="role" id="role" class="form-control" onchange="enable_commission(this.value)">

                                    <?php
                                    foreach ($role as $ro) {
                                        if ($ro->role_id == $users->role) {
                                            $selected = 'selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        if ($ro->role_id != 1) {
                                            echo '<option value="' . $ro->role_id . '" ' . $selected . '>' . $ro->name . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <?php echo form_error("role"); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label">Email</label>
                            <div class="col-sm-12">
                                <input class="form-control" type="text" name="email" value="<?php echo $users->email; ?>">
                                <?php echo form_error("email"); ?>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-form-label">Last Name</label>
                            <div class="col-sm-12">
                                <input class="form-control" type="text" name="last_name" value="<?php echo $users->last_name; ?>">
                                <?php echo form_error("last_name"); ?>
                            </div>
                        </div>
                        <div class="form-group" id="date_1">
                            <label class="col-form-label">Date of Birth</label>
                            <div class="col-sm-12">
                                <div class="input-group date">
                                    <span class="input-group-addon bg-white"><i class="fa fa-calendar"></i></span>
                                    <input class="form-control" name="dob" id="" type="text" placeholder="mm/dd/yyyy" value="<?php echo date('m/d/Y', strtotime($users->dob)); ?>">
                                </div>
                                <?php echo form_error("dob"); ?>
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <label class="col-form-label">State</label>
                            <div class="col-sm-12">
                                <select name="state" id="state" class="form-control select2_demo_1">

                                    <?php
                                    foreach ($states as $st) {
                                        if ($st->id) {
                                            if ($st->id == $users->state) {
                                                $selected = 'selected="selected"';
                                            } else {
                                                $selected = '';
                                            }
                                            echo '<option value="' . $st->id . ' ' . $selected . '">' . $st->name . '</option>';
                                        }
                                    }
                                    ?>             
                                </select>
                                <?php echo form_error("state"); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Address 2</label>
                            <div class="col-sm-12">
                                <input class="form-control" type="text" name="addr2" value="<?php echo $users->addr2; ?>">
                                <?php echo form_error("addr2"); ?>
                            </div>
                        </div>
                        <div class="form-group" id="comm" style="display:none;">
                            <label class="col-form-label">Commission (if Agent)</label>
                            <div class="col-sm-12">
                                <select name="commission" class="form-control select2_demo_1" style="width:100%">
                                    <?php
                                    $i = 0;

                                    while ($i <= 100) {
                                        if ($i == $users->commission) {
                                            $selected = 'selected';
                                            echo '<option value="' . $i . '" ' . $selected . '>' . $users->commission . ' %</option>';
                                        } else {

                                            echo '<option value="' . $i . '">' . $i . ' %</option>';
                                        }
                                        $i++;
                                    }
                                    ?>
                                </select>
                                <?php echo form_error("commission"); ?>
                            </div>
                        </div>
                        <div class="form-group" id="under_user" style="display:none;">
                            <label class="col-form-label">User Under</label>
                            <div class="col-sm-12">
                                <select name="created_by" class="form-control select2_demo_1" style="width:100%">
                                    <option value="">--Select--</option>
                                    <?php
                                    foreach ($admin_agent as $ad) {
                                        if ($ad->user_id == $users->created_by) {
                                            $selected = 'selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                        echo '<option value="' . $ad->user_id . '" ' . $selected . '>' . $ad->first_name . ' ' . $ad->last_name . ' ( ' . $ad->name . ' )</option>';
                                    }
                                    ?>
                                </select>
                                <?php echo form_error("created_by"); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">User Status</label>
                            <div class="col-sm-12">
                                <select name="status" class="form-control">
                                    <option value="Active" <?php
                                    if ($users->status == 'Active') {
                                        echo 'selected';
                                    }
                                    ?>>Active</option>
                                    <option value="Inactive" <?php
                                    if ($users->status == 'Inactive') {
                                        echo 'selected';
                                    }
                                    ?>>Inactive</option>
                                    <option value="Block" <?php
                                    if ($users->status == 'Block') {
                                        echo 'selected';
                                    }
                                    ?>>Block</option>
                                </select>
                                <?php echo form_error("status"); ?>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-group row">
                    <div class="col-sm-12 ml-sm-auto">
                        <button class="btn btn-primary pull-right" type="submit">Update User</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var role = $('#role').val();
        if (role == 2) {
            $('#comm').show();
        }
        if (role == 3) {
            $('#under_user').show();
        }
    });

    function get_state(id)
    {
        if (id != '') {
            $.ajax({
                url: '<?php echo base_url(); ?>users/get_state',
                method: 'POST',
                data: {country_id: id},
                success: function (data) {
                    console.log(data);
                    if (data != false)
                    {
                        var dt = JSON.parse(data);
                        var opt = "<option value=''>--Select--</option>";
                        $.each(dt, function (indx, obj) {
                            opt += "<option value=" + obj.id + ">" + obj.name + "</option>";
                        });
                        $('#state').html(opt);
                    }
                }
            });
        } else {

        }
    }

    function enable_commission(id)
    {

        //Commision Show Hide
        if (id == 2)
        {
            $("#comm").show();

        } else {
            $("#comm").hide();
        }


        //check In Under 
        if (id == 3)
        {
            $("#under_user").show();

        } else {
            $("#under_user").hide();
        }
    }
</script>
<script>
    $("#form-sample-1").validate({
        rules: {
            username: {
                minlength: 2,
                required: !0
            },
            first_name: {
                minlength: 2,
                required: !0
            },
            last_name: {
                minlength: 2,
                required: !0
            },
            email: {
                email: true,
                required: !0
            },
            mobile: {
                minlength: 8,
                maxlength: 15,
                required: !0,
                number: !0
            },
            country: {
                required: !0
            },
            state: {
                required: !0
            },
            city: {
                required: !0
            },
            role: {
                required: !0
            },
            status: {
                required: !0
            }

        },
        messages: {
            username: "Enter Username",
            first_name: "Enter First Name",
            last_name: "Enter Last Name",
            email: "Enter Valid Email",
            mobile: "Enter Valid Mobile Number",
            country: "Select Country",
            state: "Select State",
            status: "Select User Status",
            role: "Select Role",
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