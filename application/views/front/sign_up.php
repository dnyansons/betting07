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
		.card-header{
			padding: 0.75rem 1.25rem;
			background-color: 
		}
		.card-body{
			padding: 20px;
		}
		.card {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0,0,0,.125);
    border-radius: .25rem;
}

	</style>
</head>
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
 <div class="container mb-5">
    <div class="row">
        <div class="col-9 m-auto">
            <form action="" method="POST" name="affiliateSignup" id="affiliateSignup" novalidate="novalidate">
                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="h5 ">Personal Information</h6>
                    </div>
                    <div class="card-body ">
                        <div class="row ">
                            <div class="col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Title</label>
                                    <select type="text" class="form-control" name="fullname" maxlength="50">

                                    	<option>Mr</option>
                                    	<option>Mrs</option>
                                    	<option>Ms</option>
                                    	<option>Miss</option>
                                     </select>
                                </div>
                            </div>
                              <div class="col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">First Name </label>
                                    <input type="text" class="form-control" name="firstname" maxlength="50" placeholder="Full Name" value="">
                                </div>
                            </div>
                            <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Last Name </label>
                                    <input type="text" class="form-control" name="lastname" placeholder="Last Name" value=""  maxlength="50">
                                </div>
                            </div>
                            <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Date Of Birth</label>
                                    <input type="text" class="form-control" placeholder="Date of birth" name="mobilenumber" maxlength="15" value="">
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="h5">Contact Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email Address </label>
                                    <input type="email" class="form-control" placeholder="Email" name="sitename" value="">
                                </div>
                            </div>
                            <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Contact Number</label>
                                    <input type="text" class="form-control" placeholder="contact number" name="siteurl" value="">
                                </div>
                            </div>

                        </div>

                       <hr class="m-3 p-0">
                        <div class="row">

                            <div class="col-lg-offset-0 col-lg-12 col-xs-12 col-sm-12">
                            	<label>Choose How You Review Your Offers</label>
                                <form>
                                <div class="row pdt-10">

                                <span class="col-md-3">Notifications</span>
                                <div class="col-md-7">
						        <div class="custom-control custom-radio custom-control-inline radio1">
						            <input type="radio" class="custom-control-input" name="customRadio" id="customRadio1">
						            <label class="custom-control-label" for="customRadio1">Yes</label>
						        </div>
						        <div class="custom-control custom-radio custom-control-inline radio1">
						            <input type="radio" class="custom-control-input" name="customRadio" id="customRadio2" checked>
						            <label class="custom-control-label" for="customRadio2">No</label>
						        </div>
						    </div>
						    </div>
						    <div class="row pdt-10">
						         <span class="col-md-3">Text Message</span>
						         <div class="col-md-7">
						        <div class="custom-control custom-radio custom-control-inline radio1">
						            <input type="radio" class="custom-control-input" name="customRadio" id="customRadio3">
						            <label class="custom-control-label" for="customRadio3">Yes</label>
						        </div>
						        <div class="custom-control custom-radio custom-control-inline radio1">
						            <input type="radio" class="custom-control-input" name="customRadio" id="customRadio4" checked>
						            <label class="custom-control-label" for="customRadio4">No</label>
						        </div>
						    </div>
						    </div>
						    <div class="row pdt-10">
						        <span class="col-md-3">Email</span>
						        <div class="col-md-7">
						        <div class="custom-control custom-radio custom-control-inline radio1">
						            <input type="radio" class="custom-control-input" name="customRadio" id="customRadio5">
						            <label class="custom-control-label" for="customRadio5">Yes</label>
						        </div>
						        <div class="custom-control custom-radio custom-control-inline radio1">
						            <input type="radio" class="custom-control-input" name="customRadio" id="customRadio6" checked>
						            <label class="custom-control-label" for="customRadio6">No</label>
						        </div>
						    </div>
						    </div>
						    <div class="row pdt-10">
						          <span class="col-md-3">Message In Betting07</span>
						          <div class="col-md-7">
						        <div class="custom-control custom-radio custom-control-inline radio1">
						            <input type="radio" class="custom-control-input" name="customRadio" id="customRadio7">
						            <label class="custom-control-label" for="customRadio7">Yes</label>
						        </div>
						        <div class="custom-control custom-radio custom-control-inline radio1">
						            <input type="radio" class="custom-control-input" name="customRadio" id="customRadio8" checked>
						            <label class="custom-control-label" for="customRadio8">No</label>
						        </div>
						    </div>
						    </div>
						    </form>
							 
                            </div>
                            
                        </div> 
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="h5">Address</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Address Line 1</label>
                                    <input type="text" class="form-control" placeholder="" name="benfryname" value="">
                                </div>
                            </div>
                            <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Address Line 2 </label>
                                    <input type="text" class="form-control" placeholder="" name="accno" value="">
                                </div>
                            </div>
                          
                            <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Town / City </label>
                                    <select class="form-control">
                                    	<option>Pune</option>
                                     </select>
                                </div>
                            </div>
                              <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">State / Region </label>
                                    <select class="form-control">
                                    	<option>Maharashtra</option>
                                     </select>
                                </div>
                            </div>
                               <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Country Of Residence </label>
                                    <select class="form-control">
                                    	<option>India</option>
                                     </select>
                                </div>
                            </div>
                            <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Postcode</label>
                                    <input type="text" class="form-control" placeholder="pincode" name="pincode" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="h5">Create Login</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">User Name</label>
                                    <input type="text" class="form-control" placeholder="" name="user name" value="">
                                </div>
                            </div>
                            <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Password </label>
                                    <input type="password" class="form-control" placeholder="" name="password" value="">
                                </div>
                            </div>
                            <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Confirm Password</label>
                                    <input type="password" class="form-control" placeholder="" name="confirm password" value="">
                                </div>
                            </div>
                          
                        </div>
                    </div>
                </div>
                  <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="h5">Preferences</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Time Zone</label>
                                    <select class="form-control">
                                    	<option>GMT-8</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Odds Display </label>
                                      <select class="form-control">
                                    	<option>Decimal</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-offset-0 col-lg-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Bonus Code</label>
                                    <input type="password" class="form-control" placeholder="" name="confirm password" value="">
                                </div>
                            </div>
                          
                        </div>
                    </div>
                </div>
           	<div class="row mt-4">
			    <div class="col-lg-offset-0 col-lg-12 col-xs-12">
			        <div class="custom-control custom-checkbox">
					    <input type="checkbox" class="custom-control-input" id="customCheck" name="example1">
					    <label class="custom-control-label" for="customCheck">I agree with Terms and conditions</label>
					  </div>
			    </div>
  
			</div>
                <hr class="my-4">
                <div class="pull-right">
                    <button type="button" class="btn btn-primary " id="submit_button"> Join Betting07</button>
                </div>
            </form>

        </div>
    </div>
</div>
    </div>

</body>

</html>