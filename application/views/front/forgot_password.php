<!DOCTYPE html>
<html>
<head>
	<title></title>
	    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	 <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/bootstrap.css"> 
	
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/core.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/components.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/common.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/icons/fontawesome/styles.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/chartist.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/ionicons.min.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500&display=swap" rel="stylesheet">
<style>
	<style>

    .btnCss{
        padding : 15px 0px 0px 0px;
        border-radius : 2px;
    }

    .btnCss .btn{
        font-size: 1em;
        color: #fff;
        background:linear-gradient(40deg,#445268,#263238);			
        outline: none;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        border-bottom: 2px solid #0d002b;
        font-weight: 500;
    }


    .d-flex {
        display: flex !important;
    }

    .card
    {
        box-shadow: 0 3px 20px 0px rgba(0, 0, 0, 0.1);
        margin:6rem auto;
    }

.h1, h1 {
    font-size: 2.1rem;
}
    body{
        background: url('') !important;
        background-repeat:no-repeat !important;
        background-size:100% !important;
        background-position:center center !important;
        background-color: #f7f7f7 !important;
    }

</style>


		</style>
<body>
	    <nav class="navbar navbar-expand-lg">
    

        <a class="navbar-brand logo" href="#">
            <!--<img src="" alt="betting07">-->
			<h3 class="logo1">Betting07</h3>
        </a>
    <div class="" id="navb">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)">Sports</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)">In Play</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="javascript:void(0)">Account</a>
            </li>
        </ul>
        
    </div>

    </nav>
<div class="container-fluid">
    <div class="row full-height-vh m-0 d-flex  align-middle align-items-center justify-content-center">
        <div class="col-lg-5 col-sm-12">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body fg-image">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 bg-white px-4 py-5">
                                <form action="" class="form-group">
                                    <div id="messege"></div>
                                    <div class="">
                                        <h1>Change Your Password </h1>
                                        <p id="lable_name"></p>
                                    </div>
                                    <div class="form-group mx-4" id="email_div">
                                        <input type="text" name="username" id="username" class="form-control" placeholder="User Name" required="">
                                        
                                    </div>
                                     <div class="form-group mx-4" id="email_div">
                                        <input type="email" name="username" id="username" class="form-control" placeholder="User Email" required="">
                                        
                                    </div>
                                      <div class="form-group mx-4" id="email_div">
                                        <input type="text" name="username" id="username" class="form-control" placeholder="User DOB" required="">
                                        
                                    </div>

                                    <div id="show_div" class="mx-4 my-3" style="display: none;">
                                        <input type="text" name="otp" class="ui-input form-control" placeholder="Enter Your OTP" value="" id="otp" required="">
                                    </div>
                                    <div class="btnCss mx-5">
                                        <input type="button" value="Continue" class="btn btn-danger " id="btnGetOtp">
                                        <input type="button" value=" Submit " class="btn btn-danger " id="submit_button"  style="display: none;">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


	<script>

    $(document).on("click", "div.alert .close", function () {
        $("div.alert").hide();
    });

    $(document).ready(function () {

        $('#show_div').hide();
        $('#email_div').show();
        $('#submit_button').hide();
        var func_call = 0;
        $("#btnGetOtp").click(function () {
            func_call++;

            var username = $("#username").val();
            if (username != "") {
                $.ajax({
                    type: "POST",
                    url: "https://www.atzcart.com/affiliate/login/ajaxSendOtp",
                    data: {username: username},
                    success: function (resp) {
                        var data = JSON.parse(resp);
                        $('#email_error').text("");
                        if (data.status == 0) {
                            $("#messege").html("<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Error!</strong> Invalid Email.</div>");
                            
                        } else if (data.status == 1) {

                            if (func_call == 1)
                            {
                                $("#messege").html("<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Success!</strong> OTP sent successfully! </div>");
                            } else {
                                $("#messege").html('<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> OTP resent successfully! </div>');
                            }


                            $("#info_text").text("Enter Otp");
                            $('#show_div').show();
                            $('#email_div').hide();
                            $("#btnGetOtp").prop('value', 'Resend OTP');
                            $("#lable_name").text('Please Enter OTP :');
                            $('#submit_button').show();

                        } else if (data.status == 2) {
                            $("#messege").html('<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> This Email / mobile number is not registered.</div>');
                        }
                    },
                });
            } else {
                $('#email_error').text("Enter email or mobile number");
            }
        });
    });

    function submit_form()
    {
        var username = $("#username").val();
        var otp = $("#otp").val();
        if(otp != '')
        {
            $('#otp').css("");
            $.ajax({
                type: "POST",
                url: "https://www.atzcart.com/affiliate/login/forgotPassword",
                data: {username: username, otp: otp},
                success: function (resp) {
                    var data = JSON.parse(resp);
                    if (data.status == 0) {
                        $("#messege").html('<div class="alert alert-danger alert-dismissible">' +
                                '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                                '<strong>Error!</strong> Invalid otp.' +
                                '</div>');
                    } else {
                        window.location.href = "https://www.atzcart.com/affiliate/login/resetPassword";
                    }
                },
            });
        }else{
             $('#otp').css("border","1px solid red");
        }
    }
     </script>
</body>
</html>
