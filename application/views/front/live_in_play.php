<style>
  .card-body{
  padding:0px;
  }
  .nav-tabs .nav-link {
  border: 0px;
  border-top-left-radius: unset;
  border-top-right-radius: unset;
  }
  .nav-tabs .nav-item {
  margin-bottom: 0px;
  }
  .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active{
  border:0px;
  color: #000;
  }
  .nav-tabs .nav-link:focus, .nav-tabs .nav-link:hover{
  border: 0px;
  }
  .nav-tabs{
  background-color:#585858;
  }
  .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
  background-color:#585858;
  }
  .nav-link {
  color:#fff;
  }
  a:hover {
  color: #fff;
  }
  .nav-iten:after{
  display: block;
  content: "";
  position: absolute;
  width: 100%;
  height: 2px;
  background-color: #4acfa5;
  bottom: 5px;
  }
</style>
<div class="content-wrapper">
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-9 col-sm-9 col-xs-12">
          <div id="carousel1_indicator" class="carousel slide">
            <div class="carousel-inner">
              <div class="carousel-item  hm-white-slight active">
                <a href="">
                <img class="d-block lazy banner-img" height="" alt="First slide" src="<?php echo base_url(); ?>assets/front/images/banner2.jpg" style="display: none;"> </a>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="container mt-4">
              <div class="title">Tianjin Gold Lions vs Zhejiang Golden Bulls</div>
              <div class="row ptb-10">
                <div class="col-md-12 pd0">
                  <div class="panel panel-primary">
                    <ul class="nav nav-tabs responsive " role="tablist">
                      <li class="nav-item ">
                        <a class="nav-link active" data-toggle="tab" href="#tabAll" role="tab">All</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#Quarter" role="tab">Quarter</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#half" role="tab">Half</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#team" role="tab">Team</a>
                      </li>
                    </ul>
                    <div class="panel-body">
                      <div class="tab-content">
                        <div class="tab-pane active" id="tabAll">
                          <div id="accordion">
                            <div class="" >
                              <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                  <button class="btn btn-link match_btn" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                  Game Line
                                  </button>
                                  <span id="click_advance1">
                                  <i class="fa fa-angle-right" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"></i></span>
                                </h5>
                              </div>
                              <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body match_view">
                                  <div class="li-InPlayLeague ">
                                    <div class="li-InPlayLeague_MarketGroup ">
                                      <div class="li-InPlayEvent li-InPlayEvent-open ">
                                        <div class="row">
                                          <div class="col-md-4 col-sm-4 col-xs-12" id="show_betslip">
                                            <div class="gll-Participant li-InPlayParticipant ">
                                              <span class="gll-Participant_Name" style="">PS TIRA Women</span>
                                              <span class="gll-Participant_Odds">6.00</span>
                                            </div>
                                          </div>
                                          <div class="col-md-4 col-sm-4 col-xs-12 match_hover_bgcolor">
                                            <div class="gll-Participant li-InPlayParticipant ">
                                              <span class="gll-Participant_Name" style="">PS TIRA Women</span>
                                              <span class="gll-Participant_Odds">6.00</span>
                                            </div>
                                          </div>
                                          <div class="col-md-4 col-sm-4 col-xs-12 match_hover_bgcolor">
                                            <div class="gll-Participant li-InPlayParticipant ">
                                              <span class="gll-Participant_Name" style="">PS TIRA Women</span>
                                              <span class="gll-Participant_Odds">6.00</span>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="card" style="margin-bottom:0px;">
                              <div class="card-header" id="headingTwo">
                                <h5 class="mb-0">
                                  <button class="btn btn-link match_btn" data-toggle="collapse" data-target="#matchTwo" aria-expanded="true" aria-controls="matchTwo">
                                  Point Spread 3-Way
                                  </button>
                                  <span id="click_advance2">
                                  <i class="fa fa-angle-right" data-toggle="collapse" data-target="#matchTwo" aria-expanded="true" aria-controls="matchTwo"></i></span>
                                </h5>
                              </div>
                              <div id="matchTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                                <div class="card-body match_view">
                                  <div class="li-InPlayLeague ">
                                    <div class="li-InPlayLeague_MarketGroup ">
                                      <div class="li-InPlayEvent li-InPlayEvent-open ">
                                        <div class="row">
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="gll-Participant li-InPlayParticipant ">
                                              <span class="gll-Participant_Name" style="">PS TIRA Women</span>
                                              <span class="gll-Participant_Odds">6.00</span>
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="gll-Participant li-InPlayParticipant ">
                                              <span class="gll-Participant_Name" style="">PS TIRA Women</span>
                                              <span class="gll-Participant_Odds">6.00</span>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="card" style="width:100%;">
                              <div class="card-header" id="headingThree">
                                <h5 class="mb-0">
                                  <button class="btn btn-link match_btn" data-toggle="collapse" data-target="#matchThree" aria-expanded="true" aria-controls="matchThree">
                                  3rd Quarter Lines
                                  </button>
                                  <span id="click_advance3">
                                  <i class="fa fa-angle-right" data-toggle="collapse" data-target="#matchThree" aria-expanded="true" aria-controls="matchThree"></i></span>
                                </h5>
                              </div>
                              <div id="matchThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordion">
                                <div class="card-body match_view">
                                  <div class="li-InPlayLeague ">
                                    <div class="li-InPlayLeague_MarketGroup ">
                                      <div class="li-InPlayEvent li-InPlayEvent-open ">
                                        <div class="row">
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="gll-Participant li-InPlayParticipant ">
                                              <span class="gll-Participant_Name" style="">PS TIRA Women</span>
                                              <span class="gll-Participant_Odds">6.00</span>
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="gll-Participant li-InPlayParticipant ">
                                              <span class="gll-Participant_Name" style="">PS TIRA Women</span>
                                              <span class="gll-Participant_Odds">6.00</span>
                                            </div>
                                          </div>
                                        </div>
                                        <hr class="m-0">
                                        <div class="row">
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="gll-Participant li-InPlayParticipant ">
                                              <span class="gll-Participant_Name" style="">PS TIRA Women</span>
                                              <span class="gll-Participant_Odds">6.00</span>
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="gll-Participant li-InPlayParticipant ">
                                              <span class="gll-Participant_Name" style="">PS TIRA Women</span>
                                              <span class="gll-Participant_Odds">6.00</span>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane" id="Quarter">
                          <div id="accordion">
                            <div class="card-header" id="headingOne">
                              <h5 class="mb-0">
                                <button class="btn btn-link match_btn" data-toggle="collapse" data-target="#collapsetabOne" aria-expanded="true" aria-controls="collapsetabOne">
                                Game Line
                                </button>
                                <span id="click_advance1">
                                <i class="fa fa-angle-right" data-toggle="collapse" data-target="#collapsetabOne" aria-expanded="true" aria-controls="collapsetabOne"></i></span>
                              </h5>
                            </div>
                            <div id="collapsetabOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                              <div class="card-body match_view">
                                <div class="li-InPlayLeague ">
                                  <div class="li-InPlayLeague_MarketGroup ">
                                    <div class="li-InPlayEvent li-InPlayEvent-open ">
                                      <div class="row">
                                        <div class="col-md-4 col-sm-4 col-xs-12" id="show_betslip">
                                          <div class="gll-Participant li-InPlayParticipant ">
                                            <span class="gll-Participant_Name" style="">PS TIRA Women</span>
                                            <span class="gll-Participant_Odds">6.00</span>
                                          </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12 match_hover_bgcolor">
                                          <div class="gll-Participant li-InPlayParticipant ">
                                            <span class="gll-Participant_Name" style="">PS TIRA Women</span>
                                            <span class="gll-Participant_Odds">6.00</span>
                                          </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12 match_hover_bgcolor">
                                          <div class="gll-Participant li-InPlayParticipant ">
                                            <span class="gll-Participant_Name" style="">PS TIRA Women</span>
                                            <span class="gll-Participant_Odds">6.00</span>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="card" style="margin-bottom:0px;">
                              <div class="card-header" id="headingtabTwo">
                                <h5 class="mb-0">
                                  <button class="btn btn-link match_btn" data-toggle="collapse" data-target="#heading_tab" aria-expanded="true" aria-controls="heading_tab">
                                  Point Spread 3-Way
                                  </button>
                                  <span id="click_advance2">
                                  <i class="fa fa-angle-right" data-toggle="collapse" data-target="#heading_tab" aria-expanded="true" aria-controls="heading_tab"></i></span>
                                </h5>
                              </div>
                              <div id="heading_tab" class="collapse show" aria-labelledby="headingtabTwo" data-parent="#accordion">
                                <div class="card-body match_view">
                                  <div class="li-InPlayLeague ">
                                    <div class="li-InPlayLeague_MarketGroup ">
                                      <div class="li-InPlayEvent li-InPlayEvent-open ">
                                        <div class="row">
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="gll-Participant li-InPlayParticipant ">
                                              <span class="gll-Participant_Name" style="">PS TIRA Women</span>
                                              <span class="gll-Participant_Odds">6.00</span>
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="gll-Participant li-InPlayParticipant ">
                                              <span class="gll-Participant_Name" style="">PS TIRA Women</span>
                                              <span class="gll-Participant_Odds">6.00</span>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="card" style="width:100%;">
                              <div class="card-header" id="headingtabThree">
                                <h5 class="mb-0">
                                  <button class="btn btn-link match_btn" data-toggle="collapse" data-target="#matchtab_Three" aria-expanded="true" aria-controls="matchtab_Three">
                                  3rd Quarter Lines
                                  </button>
                                  <span id="click_advance3">
                                  <i class="fa fa-angle-right" data-toggle="collapse" data-target="#matchtab_Three" aria-expanded="true" aria-controls="matchtab_Three"></i></span>
                                </h5>
                              </div>
                              <div id="matchtab_Three" class="collapse show" aria-labelledby="headingtabThree" data-parent="#accordion">
                                <div class="card-body match_view">
                                  <div class="li-InPlayLeague ">
                                    <div class="li-InPlayLeague_MarketGroup ">
                                      <div class="li-InPlayEvent li-InPlayEvent-open ">
                                        <div class="row">
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="gll-Participant li-InPlayParticipant ">
                                              <span class="gll-Participant_Name" style="">PS TIRA Women</span>
                                              <span class="gll-Participant_Odds">6.00</span>
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="gll-Participant li-InPlayParticipant ">
                                              <span class="gll-Participant_Name" style="">PS TIRA Women</span>
                                              <span class="gll-Participant_Odds">6.00</span>
                                            </div>
                                          </div>
                                        </div>
                                        <hr class="m-0">
                                        <div class="row">
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="gll-Participant li-InPlayParticipant ">
                                              <span class="gll-Participant_Name" style="">PS TIRA Women</span>
                                              <span class="gll-Participant_Odds">6.00</span>
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="gll-Participant li-InPlayParticipant ">
                                              <span class="gll-Participant_Name" style="">PS TIRA Women</span>
                                              <span class="gll-Participant_Odds">6.00</span>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane" id="half">
                          <div id="accordion">
                            <div class="" style="margin-bottom:0px;">
                              <div class="card-header" id="Half">
                                <h5 class="mb-0">
                                  <button class="btn btn-link match_btn" data-toggle="collapse" data-target="#half_section" aria-expanded="true" aria-controls="half_section">
                                  Cricket
                                  </button>
                                  <span id="click_advance3"><i class="fa fa-angle-right" data-toggle="collapse" data-target="#half_section" aria-expanded="true" aria-controls="half_section"></i></span>
                                </h5>
                              </div>
                              <div id="half_section" class="collapse show" aria-labelledby="Half" data-parent="#accordion">
                                <div class="card-body match_view">
                                  <div class="li-InPlayLeague ">
                                    <div class="li-InPlayLeague_MarketGroup ">
                                      <div class="li-InPlayEvent li-InPlayEvent-open ">
                                        <div class="row">
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="gll-Participant li-InPlayParticipant ">
                                              <span class="gll-Participant_Name" style="">PS TIRA Women</span>
                                              <span class="gll-Participant_Odds">6.00</span>
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="gll-Participant li-InPlayParticipant ">
                                              <span class="gll-Participant_Name" style="">PS TIRA Women</span>
                                              <span class="gll-Participant_Odds">6.00</span>
                                            </div>
                                          </div>
                                        </div>
                                        <hr class="m-0">
                                        <div class="row">
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="gll-Participant li-InPlayParticipant ">
                                              <span class="gll-Participant_Name" style="">PS TIRA Women</span>
                                              <span class="gll-Participant_Odds">6.00</span>
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="gll-Participant li-InPlayParticipant ">
                                              <span class="gll-Participant_Name" style="">PS TIRA Women</span>
                                              <span class="gll-Participant_Odds">6.00</span>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane" id="team">
                          <div id="accordion">
                            <div class="" style="margin-bottom:0px;">
                              <div class="card-header" id="Team">
                                <h5 class="mb-0">
                                  <button class="btn btn-link match_btn" data-toggle="collapse" data-target="#team_section" aria-expanded="true" aria-controls="team_section">
                                  Cricket
                                  </button>
                                  <span id="click_advance3"><i class="fa fa-angle-right" data-toggle="collapse" data-target="#team_section" aria-expanded="true" aria-controls="team_section"></i></span>
                                </h5>
                              </div>
                              <div id="team_section" class="collapse show" aria-labelledby="Team" data-parent="#accordion">
                                <div class="card-body match_view">
                                  <div class="li-InPlayLeague ">
                                    <div class="li-InPlayLeague_MarketGroup ">
                                      <div class="li-InPlayEvent li-InPlayEvent-open ">
                                        <div class="row">
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="gll-Participant li-InPlayParticipant ">
                                              <span class="gll-Participant_Name" style="">PS TIRA Women</span>
                                              <span class="gll-Participant_Odds">6.00</span>
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="gll-Participant li-InPlayParticipant ">
                                              <span class="gll-Participant_Name" style="">PS TIRA Women</span>
                                              <span class="gll-Participant_Odds">6.00</span>
                                            </div>
                                          </div>
                                        </div>
                                        <hr class="m-0">
                                        <div class="row">
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="gll-Participant li-InPlayParticipant ">
                                              <span class="gll-Participant_Name" style="">PS TIRA Women</span>
                                              <span class="gll-Participant_Odds">6.00</span>
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="gll-Participant li-InPlayParticipant ">
                                              <span class="gll-Participant_Name" style="">PS TIRA Women</span>
                                              <span class="gll-Participant_Odds">6.00</span>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12 bet-border">
          <div class="heading betslip_heading">
            <h4 class="text-center">Betslip</h4>
          </div>
          <div class="betslip_section">
            <div id="betslipContainer" class="mobile">
              <div id="bsDiv" class="betslipWrapper overlay" style="display: none;">
                <ul class="betSlip full-text bs-MultipleToggle-hide bs-NoMultiples">
                  <li class="bs-Header">
                    <div class="bs-ChangeSlipTypeContainer">
                      <div class="bs-BetSlipType qb-BetSlipType" >
                        <div id="betSlipTypeSelection" class="bs-BetSlipType_Selection">
                          <div id="betSlipTypeSelectionText" class="bs-BetSlipType_SelectionText">Standard </div>
                        </div>
                      </div>
                    </div>
                    <div class="bs-Header_RemoveAll" id="remove_betslip">
                      <a  class="bs-Header_RemoveAllLink">Remove</a> 
                    </div>
                  </li>
                  <li class="single-section bs-StandardBet">
                    <ul>
                      <li  class="bs-Item bs-SingleItem  oddsChange">
                        <div class="bs-SelectionRow">
                          <div class="bs-RemoveColumn">
                            <span> <i class="fa fa-angle-right"></i></span>
                          </div>
                          <div class="bs-Selection">
                            <div class="bs-Selection_Desc">Mlada Boleslav II </div>
                            <div class="bs-Selection_Details">Fulltime Result</div>
                            <div class="bs-Selection_Details">Mlada Boleslav II v Bohemians 1905 B</div>
                          </div>
                        </div>
                        <div class="stake bs-StakeData ">
                          <div class="bs-StakeAndToReturnContainer">
                            <div class="bs-Stake">
                              <input  class="stk bs-Stake_TextBox" value="" placeholder="Stake">
                            </div>
                            <div class="bs-StakeToReturn">
                              <div class="bs-StakeToReturn_Text">To Return</div>
                              <span class="bs-StakeToReturn_Value ">0.00</span> 
                            </div>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </li>
                  <li class="bs-Alert">
                    <div class="bs-Alert_Msg">The line, odds or availability of your selections has changed.</div>
                  </li>
                  <li class="bs-Footer placebet">
                    <a class="acceptChanges bs-BtnWrapper">
                      <div class="bs-BtnAccept" id="place_bet"> Place Bet</div>
                    </a>
                  </li>
                </ul>
              </div>
              <div class="bw-BetslipLogin " id="login_view" style="display: none;">
                <div class="bw-BetslipLogin_Close " id="remove_login"><i class="fa fa-times 2x"></i></div>
                <div class="bw-BetslipLogin_Blurb ">
                  <div class="bw-BetslipLogin_Message ">Please log in to place a bet</div>
                </div>
                <div class="bw-BetslipLogin_Input ">
                  <input type="text" class="bw-BetslipLogin_InputText bw-BetslipLogin_Password ">
                  <input type="password" class="bw-BetslipLogin_InputText bw-BetslipLogin_InputTextActive ">
                  <button class="bw-BetslipLogin_LoginBtn ">Log In</button>
                </div>
                <div class="bw-BetslipLogin_Help ">
                  <div class="bw-BetslipLogin_NewCustomer ">New Customer?</div>
                  <div class="bw-BetslipLogin_JoinNow ">Join</div>
                </div>
              </div>
            </div>
          </div>
          <hr>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>