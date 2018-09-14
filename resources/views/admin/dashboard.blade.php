@extends('admin.layouts.layout')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<style>
    .card-title {
        width: 100%;
        /*height: 100px;*/
        /*margin: 20px 525px;*/
        display: inline-block;
        margin-top: 20px;
        margin-left: auto;
        margin-right: auto;
    }
    .bet-time {
        background-color: #2255a4;
        border: none;
        color: white;
        padding: 15px;
        font-size: 15px;
        border-radius: 10px;
    }
    .center-div {
        text-align: center;
    }
    #bet-main {
        width: 100%;
        height: 300px;
    }
    #bet-result {
        width: 100%;
        clear: both;
    }
    .bet-detail-info {
        width: 100%;
        text-align: center;
    }
    .bet-one {
        float: left;
        width: 145px;
        height: 175px;
        text-align: center;
        margin-left: 10px;
        margin-right: 10px;
        margin-bottom: 10px;
    }

    .bet-button {
        width: 150px;
        margin-right: 10px;
        padding-right: 0px;
        padding-left: 0px;
    }

    .bet-title {
        margin-top: 20px;
        height: 50px;
    }

    .header-bet {
        height: 90px;
    }

    .color-green, .color-green:hover, .color-green:focus {
        background-color: #00ff00;
        border-color: #00ff00;
    }

    .color-green:focus {
        box-shadow: 0 0 0 0.2rem rgba(00, 255, 00, 0.5);
    }

    .color-red, .color-red:hover{
        background-color: #da542e;
        border-color: #da542e;
    }

    .color-red:focus {
        box-shadow: 0 0 0 0.2rem rgba(218, 84, 46, 0.5);
    }

    .color-black, .color-black:hover {
        background-color: #000000;
        border-color: #000000;
    }

    .color-black:focus {
        box-shadow: 0 0 0 0.2rem rgba(00, 00, 00, 0.5);
    }

    .circle-button {
        /*background-color: #da542e;
        border: none;
        color: white;
        padding: 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 20px;
        
        cursor: pointer;*/
        margin: 20px 48px;
        width: 50px;
        height: 50px;
        font-size: 18px;
        border-radius: 50%;
    }
    #inner {
        display: table;
        margin: 0 auto;
    }
    .inner-div {
        display: table;
        margin: 0 auto;
    }
    
</style>

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Bet Status</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Bet Management</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="center-div">
                        <label class="bet-time" id="roundname"></label>
                        </div>
                        <div class="center-div">
                        <label class="bet-time">Remaining Time : <span id="remaintime"></span></label>
                        <label class="bet-time">Total Received : <span id="totalreceived"></span></label>
                        </div>
                    </div>
                    <div id="bet-main">
                    @for ($i = 0; $i <= 36; $i++)
                        <div class="bet-one">
                            @if ($i == 0)
                                <button type="button" class="btn btn-danger circle-button color-green">{{ $i }}</button>
                            @else
                                @if ($i == 1 or $i == 3 or $i == 5 or $i == 7 or $i == 9 or $i == 12 or $i == 14 or $i == 16 or $i == 18 or $i == 19 or $i == 21 or $i == 23 or $i == 27
                                 or $i == 30 or $i == 32 or $i == 34 or $i == 36)
                                    <button type="button" class="btn btn-danger circle-button">{{ $i }}</button>
                                @else
                                    <button type="button" class="btn btn-danger circle-button color-black">{{ $i }}</button>
                                @endif
                            @endif
                            <div class="bet-detail-info">
                                <p>
                                    Total Receive : <span id="totalreceives{{ $i }}">{{ $totalreceives['s'.$i] }}</span></br>
                                    Total Payout : <span id="totalpayouts{{ $i }}">{{ $totalpayouts['s'.$i] }}</span>
                                </p>
                            </div>
                                @if($slotstates['s'.$i] == 1)
                                <button id="scbtn{{ $i }}" type="button" class="btn btn-success btn-lg bet-button">STOP BET</button>
                                @else
                                <button id="tcbtn{{ $i }}" type="button" class="btn btn-outline-success btn-lg bet-button">START BET</button>
                                @endif
                        </div>
                    @endfor
                        <div class="bet-one">
                            <div class="header-bet">
                                <button type="button" class="btn btn-info btn-lg bet-button bet-title">1ST 12</button>
                            </div>
                            <div class="bet-detail-info">
                                <p>
                                    Total Receive : <span id="totalreceives1st">{{ $totalreceives['1st'] }}</span></br>
                                    Total Payout : <span id="totalpayouts1st">{{ $totalpayouts['1st'] }}</span>
                                </p>
                            </div>
                            @if($slotstates['1st'] == 1)
                                <button id="scbtn37" type="button" class="btn btn-success btn-lg bet-button">STOP BET</button>
                            @else
                            <button id="tcbtn37" type="button" class="btn btn-outline-success btn-lg bet-button">START BET</button>
                            @endif
                        </div>
                        <div class="bet-one">
                            <div class="header-bet">
                                <button type="button" class="btn btn-info btn-lg bet-button bet-title">2ND 12</button>
                            </div>
                            <div class="bet-detail-info">
                                <p>
                                    Total Receive : <span id="totalreceives2nd">{{ $totalreceives['2nd'] }}</span></br>
                                    Total Payout : <span id="totalpayouts2nd">{{ $totalpayouts['2nd'] }}</span>
                                </p>
                            </div>
                            @if($slotstates['2nd'] == 1)
                                <button id="scbtn38" type="button" class="btn btn-success btn-lg bet-button">STOP BET</button>
                            @else
                                <button id="tcbtn38" type="button" class="btn btn-outline-success btn-lg bet-button">START BET</button>
                            @endif
                        </div>
                        <div class="bet-one">
                            <div class="header-bet">
                                <button type="button" class="btn btn-info btn-lg bet-button bet-title">3RD 12</button>
                            </div>
                            <div class="bet-detail-info">
                                <p>
                                    Total Receive : <span id="totalreceives3rd">{{ $totalreceives['3rd'] }}</span></br>
                                    Total Payout : <span id="totalpayouts3rd">{{ $totalpayouts['3rd'] }}</span>
                                </p>
                            </div>
                            @if($slotstates['3rd'] == 1)
                                <button id="scbtn39" type="button" class="btn btn-success btn-lg bet-button">STOP BET</button>
                            @else
                                <button id="tcbtn39" type="button" class="btn btn-outline-success btn-lg bet-button">START BET</button>
                            @endif
                        </div>
                        <div class="bet-one">
                            <div class="header-bet">
                                <button type="button" class="btn btn-info btn-lg bet-button bet-title">1-18</button>
                            </div>
                            <div class="bet-detail-info">
                                <p>
                                    Total Receive : <span id="totalreceivesf118">{{ $totalreceives['f118'] }}</span></br>
                                    Total Payout : <span id="totalpayoutsf118">{{ $totalpayouts['f118'] }}</span>
                                </p>
                            </div>
                            @if($slotstates['f118'] == 1)
                                <button id="scbtn40" type="button" class="btn btn-success btn-lg bet-button">STOP BET</button>
                            @else
                                <button id="tcbtn40" type="button" class="btn btn-outline-success btn-lg bet-button">START BET</button>
                            @endif
                        </div>
                        <div class="bet-one">
                            <div class="header-bet">
                                <button type="button" class="btn btn-info btn-lg bet-button bet-title">19-36</button>
                            </div>
                            <div class="bet-detail-info">
                                <p>
                                    Total Receive : <span id="totalreceivesf1936">{{ $totalreceives['f1936'] }}</span></br>
                                    Total Payout : <span id="totalpayoutsf1936">{{ $totalpayouts['f1936'] }}</span>
                                </p>
                            </div>
                            @if($slotstates['f1936'] == 1)
                                <button id="scbtn45" type="button" class="btn btn-success btn-lg bet-button">STOP BET</button>
                            @else
                                <button id="tcbtn45" type="button" class="btn btn-outline-success btn-lg bet-button">START BET</button>
                            @endif
                        </div>
                        <div class="bet-one">
                            <div class="header-bet">
                            <button type="button" class="btn btn-info btn-lg bet-button bet-title">RED COLOUR</button>
                            </div>
                            <div class="bet-detail-info">
                                <p>
                                    Total Receive : <span id="totalreceivesred">{{ $totalreceives['red'] }}</span></br>
                                    Total Payout : <span id="totalpayoutsred">{{ $totalpayouts['red'] }}</span>
                                </p>
                            </div>
                            @if($slotstates['red'] == 1)
                                <button id="scbtn43" type="button" class="btn btn-success btn-lg bet-button">STOP BET</button>
                            @else
                                <button id="tcbtn43" type="button" class="btn btn-outline-success btn-lg bet-button">START BET</button>
                            @endif
                        </div>
                        <div class="bet-one">
                            <div class="header-bet">
                                <button type="button" class="btn btn-info btn-lg bet-button bet-title">BLACK COLOUR</button>
                            </div>
                            <div class="bet-detail-info">
                                <p>
                                    Total Receive : <span id="totalreceivesblack">{{ $totalreceives['black'] }}</span></br>
                                    Total Payout : <span id="totalpayoutsblack">{{ $totalpayouts['black'] }}</span>
                                </p>
                            </div>
                            @if($slotstates['black'] == 1)
                                <button id="scbtn42" type="button" class="btn btn-success btn-lg bet-button">STOP BET</button>
                            @else
                                <button id="tcbtn42" type="button" class="btn btn-outline-success btn-lg bet-button">START BET</button>
                            @endif
                        </div>
                        <div class="bet-one">
                            <div class="header-bet">
                                <button type="button" class="btn btn-info btn-lg bet-button bet-title">ODD</button>
                            </div>
                            <div class="bet-detail-info">
                                <p>
                                    Total Receive : <span id="totalreceivesodd">{{ $totalreceives['odd'] }}</span></br>
                                    Total Payout : <span id="totalpayoutsodd">{{ $totalpayouts['odd'] }}</span>
                                </p>
                            </div>
                            @if($slotstates['odd'] == 1)
                                <button id="scbtn44" type="button" class="btn btn-success btn-lg bet-button">STOP BET</button>
                            @else
                                <button id="tcbtn44" type="button" class="btn btn-outline-success btn-lg bet-button">START BET</button>
                            @endif
                        </div>
                        <div class="bet-one">
                            <div class="header-bet">
                                <button type="button" class="btn btn-info btn-lg bet-button bet-title">EVEN</button>
                            </div>
                            <div class="bet-detail-info">
                                <p>
                                    Total Receive : <span id="totalreceiveseven">{{ $totalreceives['even'] }}</span></br>
                                    Total Payout : <span id="totalpayoutseven">{{ $totalpayouts['even'] }}</span>
                                </p>
                            </div>
                            @if($slotstates['even'] == 1)
                                <button id="scbtn41" type="button" class="btn btn-success btn-lg bet-button">STOP BET</button>
                            @else
                                <button id="tcbtn41" type="button" class="btn btn-outline-success btn-lg bet-button">START BET</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- footer -->
<!-- ============================================================== -->
<footer class="footer text-center">
</footer>
<!-- ============================================================== -->
<!-- End footer -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset('assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="{{ asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
<script src="{{ asset('assets/extra-libs/sparkline/sparkline.js') }}"></script>
<!--Wave Effects -->
<script src="{{ asset('dist/js/waves.js') }}"></script>
<!--Menu sidebar -->
<script src="{{ asset('dist/js/sidebarmenu.js') }}"></script>
<!--Custom JavaScript -->
<script src="{{ asset('dist/js/custom.min.js') }}"></script>
<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $('#btn-endbet').click(function() {
        $correct = parseInt($('#correct-number').val());
        if(isNaN($correct)) {
            alert("Input is not a number");
        } else if($correct < 0) {
            alert("please input 0-36");
        } else if($correct > 36) {
            alert("please input 0-36");
        } else {
            alert("Correct Number is " + $correct);
        }
    });
    @for($i=0;$i<=45;$i++)
        $('#scbtn{{ $i }}').click(function() {
            $.ajax({
                /* the route pointing to the post function */
                url: '/admin/betmanagement/stopnumberbet',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: { _token: CSRF_TOKEN,
                    number:{{$i}}
                },
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    if (data.status == "success") {
                        location.href = "/admin";
                    }
                }
            });
        });
        $('#tcbtn{{ $i }}').click(function() {
            $.ajax({
                /* the route pointing to the post function */
                url: '/admin/betmanagement/startnumberbet',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: { _token: CSRF_TOKEN,
                    number:{{$i}}
                },
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    if (data.status == "success") {
                        location.href = "/admin";
                    }
                }
            });
        });
    @endfor
    sendRequest();

    function sendRequest() {
        $.post({
            url:"/admin/betstatus",
            data: { _token: CSRF_TOKEN
            },
            dataType: 'JSON',
            success:
                function(data) {
                    console.log(data);
                    $('#roundname').text(data.data.roundname);
                    $('#totalreceived').text(data.data.totalbet);
                    $('#remaintime').text(data.data.remaintime);
                    for( i = 0; i < 37; i ++) {
                        $('#totalreceives'+i).text(data.data.totalreceives['s'+i]);
                        $('#totalpayouts'+i).text(data.data.totalpayouts['s'+i]);
                    }
                    $('#totalreceives1st').text(data.data.totalreceives['1st']);
                    $('#totalpayouts1st').text(data.data.totalpayouts['1st']);
                    $('#totalreceives2nd').text(data.data.totalreceives['2nd']);
                    $('#totalpayouts2nd').text(data.data.totalpayouts['2nd']);
                    $('#totalreceives3rd').text(data.data.totalreceives['3rd']);
                    $('#totalpayouts3rd').text(data.data.totalpayouts['3rd']);
                    $('#totalreceivesf118').text(data.data.totalreceives['f118']);
                    $('#totalpayoutsf118').text(data.data.totalpayouts['f118']);
                    $('#totalreceivesf1936').text(data.data.totalreceives['f1936']);
                    $('#totalpayoutsf1936').text(data.data.totalpayouts['f1936']);
                    $('#totalreceivesred').text(data.data.totalreceives['red']);
                    $('#totalpayoutsred').text(data.data.totalpayouts['red']);
                    $('#totalreceivesblack').text(data.data.totalreceives['black']);
                    $('#totalpayoutsblack').text(data.data.totalpayouts['black']);
                    $('#totalreceivesodd').text(data.data.totalreceives['odd']);
                    $('#totalpayoutsodd').text(data.data.totalpayouts['odd']);
                    $('#totalreceiveseven').text(data.data.totalreceives['even']);
                    $('#totalpayoutseven').text(data.data.totalpayouts['even']);
                }
        });
    }

    setInterval(sendRequest, 1000);
</script>
@endsection