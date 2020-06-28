<!-- START PAGE CONTENT-->
<div class="page-content fade-in-up">
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card mb-3">
                <a href="<?php echo base_url('users') ?>">
                    <div class="card-body flexbox-b">
                        <div class="easypie mr-3" data-percent="80" data-bar-color="#18C5A9" data-size="80" data-line-width="8">
                            <span class="easypie-data text-success" style="font-size:32px;"><i class="la la-users"></i></span>
                        </div>
                        <div>
                            <h3 class="font-strong text-success"><?php echo $tot_uses; ?></h3>
                            <div class="text-muted">All USERS</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card mb-3">
                <a href="<?php echo base_url('report/user_report') ?>">
                    <div class="card-body flexbox-b">
                        <div class="easypie mr-3" data-percent="80" data-bar-color="#5c6bc0" data-size="80" data-line-width="8">
                            <span class="easypie-data font-26 text-primary"><i class="ti-user"></i></span>
                        </div>
                        <?php if (!empty($currd_user)) { ?>
                            <div>
                                <h3 class="font-strong text-primary"><?php echo count($currd_user) ?></h3>
                                <div class="text-muted">TODAY'S JOIN</div>
                            </div>
                        <?php } else { ?>

                            <div>
                                <h3 class="font-strong text-primary">00</h3>
                                <div class="text-muted">TODAY'S JOIN</div>
                            </div>

                        <?php } ?>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card mb-3">
                <a href="<?php echo base_url('market/set_market') ?>">
                    <div class="card-body flexbox-b">
                        <div class="easypie mr-3" data-percent="80" data-bar-color="#ff4081" data-size="80" data-line-width="8">
                            <span class="easypie-data text-pink" style="font-size:32px;"><i class="ti-basketball"></i></span>
                        </div>
                        <?php if (!empty($tot_match)) { ?>
                            <div>
                                <h3 class="font-strong text-pink"><?php echo $tot_match; ?></h3>
                                <div class="text-muted">TODAY`S MATCH</div>
                            </div>
                        <?php } else { ?>
                            <div>
                                <h3 class="font-strong text-pink">00</h3>
                                <div class="text-muted">TODAY`S MATCH</div>
                            </div>
                        <?php } ?>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card mb-3">
                <a href="<?php echo base_url('wallet') ?>">
                    <div class="card-body flexbox-b">
                        <div class="easypie mr-3" data-percent="80" data-bar-color="#3498db" data-size="80" data-line-width="8">
                            <span class="easypie-data text-blue" style="font-size:32px;"><i class="ti-wallet"></i></span>
                        </div>
                        <?php if (!empty($wallet_bal->total_bal)) { ?>
                            <div>
                                <h3 class="font-strong text-blue"><?php echo $wallet_bal->total_bal; ?></h3>
                                <div class="text-muted">WALLET AMOUNT</div>
                            </div>
                        <?php } else { ?>
                            <div>
                                <h3 class="font-strong text-blue">0.00</h3>
                                <div class="text-muted">WALLET AMOUNT</div>
                            </div>
                        <?php } ?>
                    </div>
                </a>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="row">
                <div class="col-lg-6">
                    <div class="ibox ibox-fullheight">
                        <div class="ibox-head">
                            <div class="ibox-title">TODAY'S ACTIVITIES</div>
                            <div class="ibox-tools">
                                <a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-tasks"></i></a>
                            </div>
                        </div>
                        <div class="ibox-body" style="height: 340px;overflow: auto;">
                            <ul class="list-group list-group-divider list-group-full">
                                <li class="list-group-item flexbox" style="padding: 1.2rem 0;">
                                    <a class="media-img" href="<?php echo base_url('betting') ?>">
                                        <span class="media-heading"><i class="fa fa-tasks"></i>&nbsp;&nbsp;Total Betting</span>

                                    </a>
                                    <span class="badge badge-success badge-pill"><?php echo $today_bets; ?></span>
                                </li>

                                <li class="list-group-item flexbox" style="padding: 1.2rem 0;">

                                    <a class="media-img" href="javascript:;">
                                        <span class="media-heading"><i class="fa fa-money" aria-hidden="true"></i>&nbsp;&nbsp;Total Deposit </span>

                                    </a>
                                    <span class="badge badge-success badge-pill">0</span>
                                </li>
                                <li class="list-group-item flexbox" style="padding: 1.2rem 0;">

                                    <a class="media-img" href="javascript:;">
                                        <span class="media-heading"><i class="fa fa-money" aria-hidden="true"></i>&nbsp;Total Profit / Loss </span>

                                    </a>
                                    <span class="badge badge-success badge-pill">0</span>
                                </li>

                                <li class="list-group-item flexbox" style="padding: 1.2rem 0;">

                                    <a class="media-img" href="javascript:;">
                                        <span class="media-heading"><i class="fa fa-users" aria-hidden="true"></i>&nbsp;Total Agent </span>

                                    </a>
                                    <span class="badge badge-success badge-pill"><?php echo $today_agent; ?></span>
                                </li>
                                <li class="list-group-item flexbox" style="padding: 1.2rem 0;">

                                    <a class="media-img" href="javascript:;">
                                        <span class="media-heading"><i class="fa fa-money" aria-hidden="true"></i>&nbsp;Total Transfer </span>

                                    </a>
                                    <span class="badge badge-success badge-pill">0</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ibox ibox-fullheight">
                        <div class="ibox-head">
                            <div class="ibox-title">TODAY'S MATCH BETS </div>
                            <div class="ibox-tools">
                                <a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-tasks"></i></a>
                            </div>
                        </div>
                        <div class="ibox-body" style="height: 340px;overflow: auto;">
                            <ul class="list-group list-group-divider list-group-full">
                                <?php
                                if (!empty($tot_bets)) {
                                    foreach ($tot_bets as $value) {
                                        ?>
                                        <li class="list-group-item flexbox">
                                            <span class="media-heading"><i class="fa fa-tasks"></i>&nbsp;<?php echo $value['match_name']; ?></span>
                                            <span class="badge badge-success badge-pill"><?php echo $value['tot_bets']; ?></span>
                                        </li>

                                    <?php }
                                } else { ?>

                                    <li class="list-group-item flexbox">
                                        <span class="media-heading"><i class="fa fa-tasks"></i>&nbsp;There is no bets today</span>
                                        <span class="badge badge-success badge-pill">0</span>
                                    </li>

                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-4">
            <div class="ibox ibox-fullheight">
                <div class="ibox-head">
                    <div class="ibox-title">NEW USERS</div>
                    <div class="ibox-tools">
                        <a class="dropdown-toggle" data-toggle="dropdown"><i class="ti-user"></i></a>

                    </div>
                </div>
                <div class="ibox-body" style="height: 340px;overflow: auto;">
                    <ul class="media-list media-list-divider mr-2 scroller" >

                        <?php
                        if (!empty($currd_user)) {
                            foreach ($currd_user as $key => $value) {
                                ?>  

                                <li class="media align-items-center">
                                    <a class="media-img" href="javascript:;">
                                        <i class="ti-user" style='font-size:20px'></i>
                                    </a>
                                    <div class="media-body d-flex align-items-center">
                                        <div class="flex-1">
                                            <div class="media-heading">Name: <?php echo $value->username ?></div>Role: <small class="text-muted"><?php echo $value->rol_name ?></small></div>
                                        <button class="btn btn-sm btn-outline-secondary btn-rounded"><?php echo $value->curr_balance ?></button>
                                    </div>
                                </li>

                            <?php }
                        } else { ?>  

                            <li class="media align-items-center">
                                <a class="media-img" href="javascript:;">
                                    <i class="ti-user" style='font-size:25px'></i>
                                </a>
                                <div class="media-body d-flex align-items-center">
                                    <div class="flex-1">
                                        <div class="media-heading">Name: No User</div>Role: <small class="text-muted">Empty</small></div>
                                    <button class="btn btn-sm btn-outline-secondary btn-rounded">0.00</button>
                                </div>
                            </li>

<?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="ibox ibox-fullheight">
        <div class="ibox-head">
            <div class="ibox-title">VISITORS ANALYTICS</div>
            <div class="ibox-tools">
                <a class="dropdown-toggle" data-toggle="dropdown"><i class="ti-more-alt"></i></a>

            </div>
        </div>
        <div class="ibox-body">
            <div id="world-map" style="height: 400px;"></div>
        </div>
    </div>
</div>
