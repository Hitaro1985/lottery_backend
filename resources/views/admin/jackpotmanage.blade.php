@extends('admin.layouts.layout')

@section('content')
<!-- Custom CSS -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/extra-libs/multicheck/multicheck.css') }}">
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" >
<!--<link href="{{ asset('dist/css/font-awesome.min.css') }}" rel="stylesheet">-->
<meta name="csrf-token" content="{{ csrf_token() }}" />
<style type="text/css">
    .tg  {border-collapse:collapse;border-spacing:0;margin: auto;margin-top: 70px;}
    .tg td{font-family:Arial, sans-serif;font-size:14px;padding:9px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
    .tg th{font-family:Arial, sans-serif;font-size:20px;font-weight:normal;padding:9px 20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
    .tg .tg-0lax{text-align:left;vertical-align:top}
    .release-btn {
        background: linear-gradient(rgba(255,105,30,1) 0%, rgba(230,95,28,1) 100%);
        padding: 8px 18px;
        font-size: 14px;
        color: white;border: 1px solid rgba(0,0,0,0.21);
        border-bottom: 4px solid rgba(0,0,0,0.21);
        border-radius: 4px;
        text-shadow: 0 1px 0 rgba(0,0,0,0.15);
        cursor: pointer;
    }
    .release-btn:active {
        background: #E8601B;
    }
</style>
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <table class="tg">
        <tr>
            <th class="tg-0lax">Smaller Jackpot Credit</th>
            <th class="tg-0lax"><span id="smalljackcredit"></span></th>
        </tr>
    </table>
    <div style="margin: auto; width: 75px; margin-top: 25px;">
        <button class="release-btn" onclick="onReleaseSmall()" data-toggle="modal" data-target="#smalljackrelease">RELEASE</button>
    </div>

    <div id="smalljackrelease" class="modal fade" role="dialog">
        <div class="modal-dialog modal-primary">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Release Samll JACKPOT</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="selectUser" class="col-sm-3 text-right control-label col-form-label">UserName : </label>
                        <div class="col-sm-9">
                            <select style="width: 100%; height: 100%;" id="userOptionssmall">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="releaseSmall()" class="btn btn-success">Release</button>
                </div>
            </div>
        </div>
    </div>


    <table class="tg">
        <tr>
            <th class="tg-0lax">Major Jackpot Credit</th>
            <th class="tg-0lax"><span id="majorjackcredit"></span></th>
        </tr>
    </table>
    <div style="margin: auto; width: 75px; margin-top: 25px;">
        <button class="release-btn" onclick="onReleaseMajor()" data-toggle="modal" data-target="#majorjackrelease">RELEASE</button>
    </div>

    <div id="majorjackrelease" class="modal fade" role="dialog">
        <div class="modal-dialog modal-primary">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Release Major JACKPOT</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="selectUser" class="col-sm-3 text-right control-label col-form-label">UserName : </label>
                        <div class="col-sm-9">
                            <select style="width: 100%; height: 100%;" id="userOptionsMajor">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="releaseMajor()" class="btn btn-success">Release</button>
                </div>
            </div>
        </div>
    </div>
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
<!-- this page js -->
<script src="{{ asset('assets/extra-libs/multicheck/datatable-checkbox-init.js') }}"></script>
<script src="{{ asset('assets/extra-libs/multicheck/jquery.multicheck.js') }}"></script>
<script src="{{ asset('assets/extra-libs/DataTables/datatables.min.js') }}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    function onReleaseSmall() {
        $.ajax({
            /* the route pointing to the post function */
            url: '/admin/jackpot/getAgents',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {_token: CSRF_TOKEN},
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                data['admins'].forEach(function(ele) {
                    userSelect = document.getElementById('userOptionssmall');
                    userSelect.options[userSelect.options.length] = new Option(ele, ele);
                });
            }
        });
    }
    function onReleaseMajor() {
        $.ajax({
            /* the route pointing to the post function */
            url: '/admin/jackpot/getAgents',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {_token: CSRF_TOKEN},
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                data['admins'].forEach(function(ele) {
                    userSelect = document.getElementById('userOptionsMajor');
                    userSelect.options[userSelect.options.length] = new Option(ele, ele);
                });
            }
        });
    }

    sendRequest();

    function sendRequest() {
        $.post({
            url:"/admin/jackpot/getJack",
            data: { _token: CSRF_TOKEN
            },
            dataType: 'JSON',
            success:
                function(data) {
                    $('#smalljackcredit').text(data.jack);
                    $('#majorjackcredit').text(data.mjack);
                }
        });
    }
    setInterval(sendRequest, 1000);

    function releaseSmall() {
        prename = $('#userOptionssmall').val();
        $.post({
            url:"/admin/jackpot/release",
            data: {
                _token: CSRF_TOKEN,
                name: prename
            },
            dataType: 'JSON',
            success:
                function(data) {
                    if (data.status == "failed") {
                        alert(data.status + " : " + data.errMsg);
                    } else {
                        alert(data.status);
                        location.reload();
                    }
                }
        });
    }

    function releaseMajor() {
        prename = $('#userOptionsMajor').val();
        $.post({
            url:"/admin/jackpot/releaseMajor",
            data: {
                _token: CSRF_TOKEN,
                name: prename
            },
            dataType: 'JSON',
            success:
                function(data) {
                    if (data.status == "failed") {
                        alert(data.status + " : " + data.errMsg);
                    } else {
                        alert(data.status);
                        location.reload();
                    }
                }
        });
    }
</script>
@endsection