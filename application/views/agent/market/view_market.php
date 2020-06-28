<style>
    .padd_lft{padding-left: 13px !important;}
</style>
<div class="page-heading">
    <h1 class="page-title">View Market</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo base_url(); ?>"><i class="la la-home font-20"></i></a>
        </li>
        <li class="breadcrumb-item">Market</li>
        <li class="breadcrumb-item">View Market</li>
    </ol>
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-body">
            <?php echo $this->session->flashdata('message'); ?>
            <div class="table-responsive row" style="overflow: auto;">
                <table class="table table-bordered">
                    <tr>
                        <th>League Name</th>
                        <td colspan="2"><?php echo $market->league_name.'--( '.$market->match_id.' )'; ?>
                            <input type="hidden" id="match_id" name="match_id" value="<?php echo $market->match_id; ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>Team :</th>
                        <td><?php echo $market->home_name; ?></td>
                        <td><?php echo $market->away_name; ?></td>
                    </tr>
                    <tr>
                        <?php
                        if ($market->time_status == 0) {
                            $time_status = ' <span class="badge badge-danger badge-pill">Not Started</span>';
                        }
                        if ($market->time_status == 1) {
                            $time_status = ' <span class="badge badge-success badge-pill">Running</span>';
                        }

                        if ($market->time_status == 3) {
                            $time_status = ' <span class="badge badge-primary badge-pill">Match End</span>';
                        }
                        ?>
                        <th>Live Status</th>
                        <td><?php echo $market->m_status; ?></td>
                        <td><?php echo '<b>Match:</b> ' . $time_status; ?></td>
                    </tr>
                </table>

            </div>
        </div>
    </div>

    <div class="ibox">
        <div class="ibox-body">
            <?php echo $this->session->flashdata('message'); ?>
            <div class="table-responsive row" style="overflow: auto;">
                <table class="table table-bordered" id="datatable">
                    <thead
                        <tr class="alert alert-primary">
                            <th>Sr.No.</th>
                            <th>Market</th>
                            <th>Total Bets</th>
                            <th>Status</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody id="market_data">
                        <?php
                        $i = 1;
                        $sum = 0;
                        if (!empty($mk_view)) {
                            foreach ($mk_view as $m_data) {
                                echo'<tr>';
                                echo'<td>' . $i . '</td>';
                                echo'<td>' . $m_data["market_name"] . '</td>';
                                echo'<td>' . $m_data["tot_bets"] . '</td>';
                                echo'<td>' . $m_data["result"] . '</td>';
                                echo'<td><a href="' . base_url() . 'market/set_market/user_market_bets/' . $m_data["fancy_id"] . '" class="badge badge-success badge-pill">View Bets</a></td>';
                                echo'</tr>';

                                $sum = $sum + $m_data["tot_bets"];
                                $i++;
                            }
                        }
                        ?>
                        <tr>
                            <th></th>
                            <th>Total Bets</th>
                            <th><?php echo $sum; ?></th>
                            <th colspan="2"></th>
                        </tr>
                    </tbody>

                </table>


            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="change_status_model" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form class="form-horizontal" action="<?php echo base_url(); ?>market/set_market/update_league_status" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Change League Status</h4>
                    </div>
                    <div class="modal-body">
                        <p id="get_status">Loading...</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" onclick="return confirm('Are You Sure ? ');">Change</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        window.setInterval(function () {
            var match_id = $('#match_id').val();
            $.ajax({
                url: '<?php echo base_url(); ?>market/set_market/get_market_view',
                method: 'POST',
                beforeSend: function () {
                    // $('#loading').show();
                },
                data: {match_id: match_id},
                success: function (data) {
                    //$('#loading').hide();
                    //console.log(data);

                    if (data != false)
                    {
                        var dt = JSON.parse(data);
                        var opt = "";
                        var i = 1;
                        var sum = 0;
                        $.each(dt, function (indx, obj) {
                            opt += "<tr>";
                            opt += "<td>" + i + "</td>";
                            opt += "<td>" + obj.market_name + "</td>";
                            opt += "<td>" + obj.tot_bets + "</td>";
                            opt += "<td>" + obj.result + "</td>";
                            opt += "<td><a href='<?php echo base_url(); ?>market/set_market/user_market_bets/" + obj.fancy_id + "' class='badge badge-success badge-pill'>View Bets</a></td>";
                            opt += "</tr>";
                            sum = Number(sum) + Number(obj.tot_bets);
                            i++;
                        });
                        opt += "<tr><th></th><th>Total Bets</th><th>" + sum + "</th><th colspan='2'></th></tr>";
                        $('#market_data').html(opt);
                    }


                }
            });
        }, 4000);
        
        
        ///demo//
//          window.setInterval(function () {
//            var match_id = $('#match_id').val();
//            $.ajax({
//                url: '<?php echo base_url(); ?>cron/match_odds',
//                method: 'POST',
//                beforeSend: function () {
//                    // $('#loading').show();
//                },
//                data: {match_id: match_id},
//                success: function (data) {
//                   console.log('run');
//                }
//            });
//        }, 3000);
        
        
    });

</script>
<script>
    function change_status(m_id)
    {
        if (m_id != '') {

            $.ajax({
                url: '<?php echo base_url(); ?>market/set_market/check_league_status',
                method: 'POST',
                data: {m_id: m_id},
                success: function (data) {
                    console.log(data);

                    $('#change_status_model').modal('show');
                    $('#get_status').html('');
                    $('#get_status').html(data);
                }
            });
        } else {
            $('#get_status').html('');
        }
    }
</script>
