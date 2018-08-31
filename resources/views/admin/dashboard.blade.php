@extends('admin.layouts.layout')

@section('content')
<style>
    .card-title {
        width: 400px;
        height: 50px;
        /*margin: 20px 525px;*/
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
        float: left;
        cursor: pointer;
        border-radius: 10px;
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
        height: 130px;
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
            <h4 class="page-title">Bet Management</h4>
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
                        <label class="bet-time">28 - 08 - 2018 ----- ROUND 1 ----- 09 : 10 : 20</label>
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
                                    Total Receive : {{ $bets['r'.$i] }}</br>
                                    Total Payout : {{ $bets['p'.$i] }}
                                </p>
                            </div>
                            {{--<button type="button" class="btn btn-success btn-lg bet-button">STOP BET</button>--}}
                        </div>
                    @endfor
                    </div>

                    <div id="bet-result">
                        <div id="inner">
                            {{--<button type="button" class="btn btn-info btn-lg bet-button">1ST 12</button>--}}
                            {{--<button type="button" class="btn btn-info btn-lg bet-button">2ND 12</button>--}}
                            {{--<button type="button" class="btn btn-info btn-lg bet-button">3RD 12</button>--}}
                            <button type="button" class="btn btn-info btn-lg bet-button">RED COLOUR</button>
                            <button type="button" class="btn btn-info btn-lg bet-button">BLACK COLOUR</button>
                            <button type="button" class="btn btn-info btn-lg bet-button">ODD</button>
                            <button type="button" class="btn btn-info btn-lg bet-button">EVEN</button>
                        </div>
                    </div>
                    <div style="margin-top: 10px;">
                        <div class="inner-div">
                            <input type="text" placeholder="Input Correct Number" id="correct-number" name="correct-number" style="margin-right: 10px; height: 100%;"/>
                            <button type="button" class="btn btn-success btn-lg bet-button" id="btn-endbet">END BET</button>
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
</script>
@endsection