<div class="page-heading">
    <h1 class="page-title">Wallet</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo base_url(); ?>"><i class="la la-home font-20"></i></a>
        </li>
        <li class="breadcrumb-item">Agent</li>
        <li class="breadcrumb-item">Users Wallet</li>
    </ol>
</div>
<br/>
<!--<div class=" page-heading">
    <span id="userRole"><i class="fa fa-user"></i></span>
</div>-->

<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-body">
            <div id="message"></div>
            <?php echo $this->session->flashdata('message'); ?>
            <div class="table-responsive row" style="overflow: auto;">

                <table class="table table-bordered table-hover" id="wallet_table">
                    <thead class="thead-default thead-lg">
                        <tr>
                            <th>Sr.No</th>
                            <th>User&nbsp;ID</th>
                            <th>UserName</th>
                            <th>Full&nbsp;Name</th>
                             <th>Mobile</th> 
                            <th>Current Balance</th>
                            <th>Total Credit</th>
                            <th>Total Debit</th>
                            <th>Updated At</th>
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

<!-- The Modal -->
 <!-- Modal -->
  <div class="modal fade" id="wallet_model" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
          <h4 class="modal-title">Credit / Debit Amount</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
          
        <div class="modal-body">
            <form role="form" action="" id="wallet-data" method="post">
         <input type="hidden" name="user_id" id="user_id" class="form-control" value=""/>
          <div class="page-content fade-in-up">

                  <div class="form-group row">
                    <label class="col-sm-2 "> Amount:</label>
                        <div class="col-sm-10">
                            <input class="form-control numberInput TextBoxCls" type="number" name="curr_amount" min="1" max="9999999" id="curr_amount" placeholder="0.00" >
                            <?php echo form_error("curr_amount"); ?>
                        </div>
                  </div>
                
               <div class="form-group row">
                    <label class="col-sm-2 ">Type:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="amount_type" id="amount_type" >
                                <option value="">Select</option>
                            <?php $option=['credit','debit'];
                            foreach ($option as $value) {
                                echo '<option value='.$value.'>'.ucfirst($value).'</option>';
                            }
                            ?>
                            </select>
                            <?php echo form_error("amount_type"); ?>
                        </div>
                  </div>
                
                   <div class="form-group row">
                    <label class="col-sm-2">Particular:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="per_type" id="per_type">
                                <option value="">Select</option>
                            <?php 
                            foreach ($perticular as $key=>$value) {
                                echo '<option value='.$value->per_id.'>'.ucfirst($value->per_name).'</option>';
                            }
                            ?>
                            </select>
                            <?php echo form_error("per_type"); ?>
                        </div>
                  </div>
              
              
               </div>
                
      
               
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" id="saveWalletData" class="btn btn-info saveWalletData" >Submit</button>
          
        </div>
           </form>
              </div>
      </div>
      
    </div>
  </div>
 
<script>
    $(document).ready(function () {
        $('#wallet_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            //dom: 'Bfrtip',
            ajax: {
                url: "<?php echo base_url('agent/wallet/ajax_list'); ?>",
                dataType: "json",
                type: "POST",
                data: function(data){
                    data.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>";
                }
            },
                 
            columns: [
                {data: "wallet_id"},
                {data: "user_id"},
                {data: "username"},
                {data: "first_name"},
                {data: "mobile"},
                {data: "curr_balance"},
                {data: "tot_credit"},
                {data: "tot_debit"},
                {data: "created_at"},
                {data: "action"}
            ],
           "aaSorting": [[ 0, "desc" ]],
            "lengthMenu": [[10, 50, 100, 500], [10, 50, 100, 500]]
          
        });
    
    /*
    * @Author Ishwar
    * Open model onclick and return userid
    */
    // open model
      $('#wallet_model').modal('hide');
        $(document).on('click','.wallet_data',function(e){
            e.preventDefault();
            $('#wallet_model').modal('toggle');
            $("#wallet_model").modal({
                backdrop: 'static',
                keyboard: false
            });
           $('#user_id').val($(this).attr('user-id'));
           
        });
    
       /*
        * @Author Ishwar
        * save wallet particular data
        * return response
        */
     $("#wallet-data").validate({
        rules: {
            curr_amount: {
                minlength: 2,
                required: !0
            },
            amount_type: {
                required: !0
            },
            per_type: {
                required: !0
            },
        },
   
        messages: {
            curr_amount: "Please Enter Amount",
            amount_type: "Select Amount Type",
            per_type: "Select Perticular Type",
        },
        submitHandler: function(form) {
              var dataString= $("#wallet-data").serialize();
            
                $.ajax({
                   url: '<?php echo base_url(); ?>agent/wallet/store_wallet_particular',
                   method: 'POST',
                   dataType:"JSON",
                   data: dataString,
                   success: function (data) {
                       $('#wallet_model').modal('toggle');
                       //$("#wallet_model")[0].reset();
                       //window.location.href='<?php echo base_url(); ?>admin/wallet';
                       if(data.status===1 && data.message==='success')    
                       {   
                            var msg = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close"></a><strong>Success : </strong>Wallet Amount Added Successfully. </div>';
                            $("#message").html(msg);
                            $("#message").fadeTo(3000, 500).slideUp(500, function(){
                                window.location.href='<?php echo base_url(); ?>wallet'
                            $("#message").alert('close');
                          });
                       }
                       else if(data.status===0 )
                       {
                           var msg = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close"></a><strong>Error : </strong>Something went wrong. </div>';
                           $("#message").html(msg);
                           $("#message").fadeTo(3000, 500).slideUp(500, function(){
                               window.location.href='<?php echo base_url(); ?>/wallet'
                           $("#message").alert('close');
                          });
                       }
                       else
                       {
                           var msg = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close"></a><strong>Error : </strong>Invalid Amount. </div>';
                           $("#message").html(msg);
                           $("#message").fadeTo(3000, 500).slideUp(500, function(){
                               window.location.href='<?php echo base_url(); ?>wallet'
                           $("#message").alert('close');
                          });
                       }
                   },
                   error:function(data)
                   {
                       console.log("some error occured"+data);
                   },
               });
            
        },
        errorClass: "help-block error",
        highlight: function (e) {
            $(e).closest(".form-group.row").addClass("has-error")
        },
        unhighlight: function (e) {
            $(e).closest(".form-group.row").removeClass("has-error")
        },
    });

        /*
        * @Author Ishwar
        * cleart form while close model
        */
        
    $('#wallet_model').on('hidden.bs.modal', function(e) {
         $(this).find('#wallet-data')[0].reset();
            $(".error").remove();
     });

    });

</script>
