@extends('admin.layouts.layout')

@section('content')
<!-- Custom CSS -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/extra-libs/multicheck/multicheck.css') }}">
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<!--<link href="{{ asset('dist/css/font-awesome.min.css') }}" rel="stylesheet">-->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" >
<meta name="csrf-token" content="{{ csrf_token() }}" />
<style>
    .button {
        margin-left: 20px;
        position:relative;
        padding:6px 15px;
        left:-8px;
        border:2px solid #207cca;
        background-color:#207cca;
        color:#fafafa;
    }
    .button:hover  {
        background-color:#fafafa;
        color:#207cca;
    }
</style>
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="card">
            <div class="card-body">
                <h5 class="card-title">Transaction History</h5>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <div style="margin:20px;">
                            <form id="searchDetail" action="" method="get">
                                Search -
                                Date : <input type="text" id="searchdate" name="datefilter" autocomplete="off" value="{{ app('request')->input('datefilter') }}" style="width:200px; text-align:center;" placeholder="Date Range" />
                                <input type="button" value="Search" class="button" onclick="onSearchDetail();">
                                <input type="button" value="All" class="button" onclick="onSearchAll();">
                                @if( app('request')->input('name'))
                                    Total credit added  &nbsp;<div style="    display: inline-block;
                                                border-color: red;
                                                border-width: 3px;
                                                border-style: solid;
                                                width: 100px;
                                                height: 39px;
                                                line-height: 39px;
                                                text-align: center;
                                                vertical-align: middle;
                                                background-color: #DE4747;
                                                color: white;
                                                font-size: 21px;
                                                font-weight: bold;">{{ $receive }}</div>
                                    &nbsp;&nbsp; Current credit &nbsp;<div style="display: inline-block;
                                                border-color: green;
                                                border-width: 3px;
                                                border-style: solid;
                                                width: 100px;
                                                height: 39px;
                                                line-height: 39px;
                                                text-align: center;
                                                vertical-align: middle;
                                                background-color: #43CB29;
                                                color: white;
                                                font-size: 21px;
                                                font-weight: bold;">{{ $current }}</div>
                                    <input type="hidden" name="name" value="{{app('request')->input('name')}}">
                                @endif
                            </form>
                        </div>
                        <tbody>
                        @for ($i = 0; $i < count($trans); $i++)
                            <tr id="item{{$trans[$i]->id}}">
                                <td id="id{{ $trans[$i]->id }}">{{ $trans[$i]->id }}</td>
                                <td id="name{{$trans[$i]->id}}">{{ $trans[$i]->fromname }}</td>
                                <td id="prize{{$trans[$i]->id}}">{{ $trans[$i]->toname }}</td>
                                <td id="totalbet{{ $trans[$i]->id }}">{{ $trans[$i]->amount}}</td>
                                <td id="totalpayout{{ $trans[$i]->id }}">{{ $trans[$i]->status }}</td>
                                <td id="profit{{ $trans[$i]->id }}">{{ $trans[$i]->created_at }}</td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>
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
    /****************************************
     *       Basic Table                   *
     ****************************************/
    $(function() {

        $('input[name="datefilter"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

    });
    $('#zero_config').DataTable();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    function onAccept(agentID) {
        $.ajax({
            /* the route pointing to the post function */
            url: '/admin/magentmanage/accept',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {_token: CSRF_TOKEN, id:agentID},
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                utime = data.updated_at;
                $("#updatetime" + agentID).text(utime.date.split(".")[0]);
                if (data.role_id == 0) {
                    $("#role" + agentID).text('');
                }
                else {
                    $("#role" + agentID).text('Master Agent');
                }
            }
        });
    }
    function onEdit(agentID) {
        prename = $("#name" + agentID).text();
        preemail = $("#email" + agentID).text();
        preamount = $("#amount" + agentID).text();
        
        $("#editid").val(agentID);
        $("#editname").val(prename);
        $("#editemail").val(preemail);
        $("#editamount").val(preamount);
    }
    function onDelete(agentID) {
        $.ajax({
            /* the route pointing to the post function */
            url: '/admin/magentmanage/delete',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: { _token: CSRF_TOKEN,
                    id:agentID
                },
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                alert(data.status);
                if (data.status == "success") {
                    location.href = "/admin/magentmanage";
                }
            }
        });
    }
    function onUpdataInfo() {
        preid = $("#editid").val();
        prename = $("#editname").val();
        preemail = $("#editemail").val();
        prepassword = $("#editpassword").val();
        preamount = $("#editamount").val();
        $.ajax({
            /* the route pointing to the post function */
            url: '/admin/magentmanage/update-info',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: { _token: CSRF_TOKEN,
                    id:preid,
                    name:prename,
                    email:preemail,
                    password:prepassword,
                    amount:preamount
                },
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                alert(data.status);
            }
        });
    }
    function onSearchDetail() {
        $('#searchDetail').submit();
    }
    function onSearchAll() {
        window.location = window.location.href.split("?")[0];
    }
</script>
@endsection