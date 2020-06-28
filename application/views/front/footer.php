<footer class="footer">
    <div class="container bottom_border">
        <div class="row">
          
            <div class=" col-sm-4 col-md  col-6 col">
                <h5 class="headin5_amrc col_white_amrc pt2">Quick links</h5>
                <!--headin5_amrc-->
                <ul class="footer_ul_amrc">
                    <li><a href="http://webenlance.com">Image Rectoucing</a></li>
                    <li><a href="http://webenlance.com">Clipping Path</a></li>
                    <li><a href="http://webenlance.com">Hollow Man Montage</a></li>
                    <li><a href="http://webenlance.com">Ebay & Amazon</a></li>
                    <li><a href="http://webenlance.com">Hair Masking/Clipping</a></li>
                    <li><a href="http://webenlance.com">Image Cropping</a></li>
                </ul>
                <!--footer_ul_amrc ends here-->
            </div>
            <div class=" col-sm-4 col-md  col-6 col">
                <h5 class="headin5_amrc col_white_amrc pt2">Quick links</h5>
                <!--headin5_amrc-->
                <ul class="footer_ul_amrc">
                    <li><a href="http://webenlance.com">Remove Background</a></li>
                    <li><a href="http://webenlance.com">Shadows & Mirror Reflection</a></li>
                    <li><a href="http://webenlance.com">Logo Design</a></li>
                    <li><a href="http://webenlance.com">Vectorization</a></li>
                    <li><a href="http://webenlance.com">Hair Masking/Clipping</a></li>
                    <li><a href="http://webenlance.com">Image Cropping</a></li>
                </ul>
                <!--footer_ul_amrc ends here-->
            </div>
			    <div class=" col-sm-4 col-md  col-6 col">
                <h5 class="headin5_amrc col_white_amrc pt2">Quick links</h5>
                <!--headin5_amrc-->
                <ul class="footer_ul_amrc">
                    <li><a href="http://webenlance.com">Remove Background</a></li>
                    <li><a href="http://webenlance.com">Shadows & Mirror Reflection</a></li>
                    <li><a href="http://webenlance.com">Logo Design</a></li>
                    <li><a href="http://webenlance.com">Vectorization</a></li>
                    <li><a href="http://webenlance.com">Hair Masking/Clipping</a></li>
                    <li><a href="http://webenlance.com">Image Cropping</a></li>
                </ul>
                <!--footer_ul_amrc ends here-->
            </div>
			  <div class=" col-sm-4 col-md col-sm-4  col-12 col">
                <h5 class="headin5_amrc col_white_amrc pt2">Find us</h5>
                <!--headin5_amrc-->
                <p class="mb10">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                <p><i class="fa fa-location-arrow"></i> 9878/25 sec 9 rohini 35 </p>
                <p><i class="fa fa-phone"></i>  +91-9999878398  </p>
                <p><i class="fa fa fa-envelope"></i> info@example.com  </p>
            </div>
         
        </div>
    </div>
    <div class="container">
        <!--foote_bottom_ul_amrc ends here-->
        <p class="text-center all-right">© All Rights Reserved 2019.</p>
        <!--social_footer_ul ends here-->
    </div>
</footer>


	<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/tether.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/chartist.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/app.min.js"></script>


<script>

$('#click_advance1').click(function() {
    $("i", this).toggleClass("fa fa-angle-right fa fa-angle-down");
});
$('#click_advance2').click(function() {
    $("i", this).toggleClass("fa fa-angle-right fa fa-angle-down");
});
$('#click_advance3').click(function() {
    $("i", this).toggleClass("fa fa-angle-right fa fa-angle-down");
});


//

</script>

<script type="text/javascript">
$(document).ready(function () {
    $("#show_betslip").click(function () {
        $("#bsDiv").show();

    });

    $("#remove_betslip").click(function () {
        $("#bsDiv").hide();
        
    });

    // $("#place_bet").click(function () {
    //     $("#login_view").show();
        
    // });

    // $("#remove_login").click(function () {
    //     $("#login_view").hide();
        
    // });

    $('#place_bet').on('click', function () {
    $('#login_view').show();
    $(this).hide();
})

$('#remove_login').on('click', function () {
    $('#login_view').hide();
    $('#place_bet').show();
})
});
</script>

</body>
</html>
