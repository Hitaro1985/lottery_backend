@extends('admin.layouts.layout')

@section('content')
<!-- Custom CSS -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/extra-libs/multicheck/multicheck.css') }}">
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" >
<!--<link href="{{ asset('dist/css/font-awesome.min.css') }}" rel="stylesheet">-->
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
                <h5 class="card-title">Agent Management</h5>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Enable</th>
                                <th>UserName</th>
                                <th>Email Address</th>
                                <th>Phone Number</th>
                                <th>Credit</th>
                                <th>Create Date</th>
                                <th>Update Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <div style="margin:20px;">
                            <form id="searchDetail" action="" method="get">
                                Search -
                                Date : <input type="text" id="searchdate" name="datefilter" autocomplete="off" value="{{ app('request')->input('datefilter') }}" style="width:200px; text-align:center;" placeholder="Date Range" />
                                <input type="button" value="Search" class="button" onclick="onSearchDetail();">
                                <input type="button" value="All" class="button" onclick="onSearchAll();">
                            </form>
                        </div>
                        <tbody>
                            @for ($i = 0; $i < count($all_users); $i++)
                                <tr id="item{{$all_users[$i]->id}}">
                                    <th>
                                        <label class="customcheckbox">
                                            @if ( $all_users[$i]->enabled == false)
                                                <input id="agent{{$all_users[$i]->id}}" type="checkbox" class="listCheckbox" onclick="onAccept({{$all_users[$i]->id}})" />
                                                <span class="checkmark"></span>
                                            @else
                                                <input id="agent{{$all_users[$i]->id}}" type="checkbox" class="listCheckbox" onclick="onAccept({{$all_users[$i]->id}})" checked="checked" />
                                                <span class="checkmark"></span>
                                            @endif
                                        </label>
                                    </th>
                                    <td id="name{{$all_users[$i]->id}}">{{ $all_users[$i]->name }}</td>
                                    <td id="email{{$all_users[$i]->id}}">{{ $all_users[$i]->email }}</td>
                                    <td id="phoneno{{ $all_users[$i]->id }}">{{ $all_users[$i]->phoneno }}</td>
                                    <td id="credit{{ $all_users[$i]->id }}">
                                        @if($user_role == "Admin")<a href="/admin/trans-admin">{{ $all_users[$i]->amount }}</a>
                                        @else<a href="/admin/trans">{{ $all_users[$i]->amount }}</a>
                                        @endif
                                    </td>
                                    <td>{{ $all_users[$i]->created_at }}</td>
                                    <td id="updatetime{{$all_users[$i]->id}}">{{ $all_users[$i]->updated_at }}</td>
                                    <td>
                                        <a class="btn btn-outline-info " onclick="onEdit({{$all_users[$i]->id}})" data-toggle="modal" data-target="#editUser">
                                            <i class="fas fa-edit "></i>
                                        </a>
                                        <a class="btn btn-outline-info " onclick="onSendmoney({{$all_users[$i]->id}})" data-toggle="modal" data-target="#sendMoney">
                                            <i class="fas fa-dollar-sign "></i>
                                        </a>
                                        {{--<a class="btn btn-outline-danger" onclick="onDelete({{$all_users[$i]->id}})">--}}
                                            {{--<i class="fas fa-trash-alt "></i>--}}
                                        {{--</a>--}}
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
                <!-- SendMoneyModal -->
                <div id="sendMoney" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-primary">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Send Money</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input id="editid" type="hidden" class="form-control">
                                <div class="form-group row">
                                    <label for="editamount" class="col-sm-3 text-right control-label col-form-label">Amount : </label>
                                    <div class="col-sm-9">
                                        <input id="editamount" type="text" class="form-control" placeholder="Credit Card Amount">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" onclick="onUpdateSend()" class="btn btn-success">Send</button>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Modal -->
                <div id="editUser" class="modal fade" role="dialog">
                  <div class="modal-dialog modal-primary">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Edit Agent</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <div class="modal-body">
                        <input id="editid" type="hidden" class="form-control">
                        <div class="form-group row">
                            <label for="editname" class="col-sm-3 text-right control-label col-form-label">Name : </label>
                            <div class="col-sm-9">
                                <input id="editname" type="text" class="form-control" placeholder="Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="editemail" class="col-sm-3 text-right control-label col-form-label">Email : </label>
                            <div class="col-sm-9">
                                <input id="editemail" type="email" class="form-control" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="editpassword" class="col-sm-3 text-right control-label col-form-label">Password : </label>
                            <div class="col-sm-9">
                                <input id="editpassword" type="password" class="form-control" placeholder="Password">
                            </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                            <button type="button" onclick="onUpdataInfo()" class="btn btn-success">Edit</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Create Modal -->
                <div id="createNew" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-primary">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Create Agent</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group row">
                                    <label for="editname" class="col-sm-3 text-right control-label col-form-label">UserName : </label>
                                    <div class="col-sm-9">
                                        <input id="createname" type="text" class="form-control" placeholder="UserName">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="editemail" class="col-sm-3 text-right control-label col-form-label">Email : </label>
                                    <div class="col-sm-9">
                                        <input id="createemail" type="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="editpassword" class="col-sm-3 text-right control-label col-form-label">Password : </label>
                                    <div class="col-sm-9">
                                        <input id="createpassword" type="password" class="form-control" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="editphoneno" class="col-sm-3 text-right control-label col-form-label">Phone : </label>
                                    <div class="col-sm-9">
                                        <input id="createphoneno" type="text" class="form-control" placeholder="Phone">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="editcredit" class="col-sm-3 text-right control-label col-form-label">Credit : </label>
                                    <div class="col-sm-9">
                                        <input id="createcredit" type="text" class="form-control" placeholder="Credit" value="0">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" onclick="onCreate()" class="btn btn-success">Create</button>
                            </div>
                        </div>

                    </div>
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
            url: '/admin/agentmanage/accept',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {_token: CSRF_TOKEN, id:agentID},
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                utime = data.updated_at;
                $("#updatetime" + agentID).text(utime.date.split(".")[0]);
            }
        });
    }
    function onEdit(agentID) {
        prename = $("#name" + agentID).text();
        preemail = $("#email" + agentID).text();
        precredit = $('#credit' + agentID).text();
        
        $("#editid").val(agentID);
        $("#editname").val(prename);
        $("#editemail").val(preemail);
        $('#editcredit').val(precredit);
    }
    function onDelete(agentID) {
        $.ajax({
            /* the route pointing to the post function */
            url: '/admin/agentmanage/delete',
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
                    location.href = "/admin/agentmanage";
                }
            }
        });
    }

    function onSendmoney(agentID) {
        $("#editid").val(agentID);
    }

    function onUpdateSend() {
        preid = $("#editid").val();
        preamount = $('#editamount').val();
        $.ajax({
            url: '/admin/agentmange/sendmoney',
            type: 'POST',
            data: {
                _token: CSRF_TOKEN,
                id:preid,
                amount:preamount
            },
            dataType: 'JSON',
            success: function (data) {
                if (data.status == "failed") {
                    alert(data.status + " : " + data.errMsg);
                } else {
                    alert(data.status);
                    location.href = "/admin/agentmanage";
                }
            }
        })
    }

    function onUpdataInfo() {
        preid = $("#editid").val();
        prename = $("#editname").val();
        preemail = $("#editemail").val();
        prepassword = $("#editpassword").val();
        precredit = $('#editcredit').val();
        $.ajax({
            /* the route pointing to the post function */
            url: '/admin/agentmanage/update-info',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: { _token: CSRF_TOKEN,
                    id:preid,
                    name:prename,
                    email:preemail,
                    password:prepassword,
                    credit:precredit
                },
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                alert(data.status);
                location.href = "/admin/agentmanage";
            }
        });
    }

    function onCreate() {
        prename = $("#createname").val();
        preemail = $("#createemail").val();
        prepassword = $("#createpassword").val();
        prephoneno = $("#createphoneno").val();
        precredit = $("#createcredit").val();
        $.ajax({
            /* the route pointing to the post function */
            url: '/admin/agentmanage/create-new',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {
                _token: CSRF_TOKEN,
                name: prename,
                email: preemail,
                password: prepassword,
                phoneno: prephoneno,
                credit: precredit
            },
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                if ( data.status == "failed" ) {
                    alert(data.msg);
                } else {
                    alert(data.status);
                    location.reload();
                }
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