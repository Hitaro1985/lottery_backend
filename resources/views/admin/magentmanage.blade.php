@extends('admin.layouts.layout')

@section('content')
<!-- Custom CSS -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/extra-libs/multicheck/multicheck.css') }}">
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<!--<link href="{{ asset('dist/css/font-awesome.min.css') }}" rel="stylesheet">-->
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="card">
            <div class="card-body">
                <h5 class="card-title">Master Agent Management</h5>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Enable</th>
                                <th>Name</th>
                                <th>Email Address</th>
                                <th>Phone Number</th>
                                <th>Role</th>
                                <th>Credit</th>
                                <th>Create Date</th>
                                <th>Update Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < count($all_users); $i++)
                                <tr>
                                    <th>
                                        <label class="customcheckbox">
                                            @if ( $all_users[$i]->role_id == 0)
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
                                    <td id="role{{$all_users[$i]->id}}">{{ $all_users[$i]->role }}</td>
                                    <td id="amount{{$all_users[$i]->id}}">{{ $all_users[$i]->amount }}</td>
                                    <td>{{ $all_users[$i]->created_at }}</td>
                                    <td id="updatetime{{$all_users[$i]->id}}">{{ $all_users[$i]->updated_at }}</td>
                                    <td>
                                        <a class="btn btn-outline-info " onclick="onEdit({{$all_users[$i]->id}})" data-toggle="modal" data-target="#editUser">
                                            <i class="fas fa-edit "></i>
                                        </a>
                                        <a class="btn btn-outline-info " onclick="onSendmoney({{$all_users[$i]->id}})" data-toggle="modal" data-target="#sendMoney">
                                            <i class="fas fa-dollar-sign "></i>
                                        </a>
                                        <a class="btn btn-outline-danger" onclick="onDelete({{$all_users[$i]->id}})">
                                            <i class="fas fa-trash-alt "></i>
                                        </a>
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
                        <h4 class="modal-title">Edit Master Agent</h4>
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
                                <input id="editemail" type="email" class="form-control" placeholder="Password">
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
<script>
    /****************************************
     *       Basic Table                   *
     ****************************************/
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
        
        $("#editid").val(agentID);
        $("#editname").val(prename);
        $("#editemail").val(preemail);
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
                    location.reload();
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
            url: '/admin/magentmange/sendmoney',
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
                    location.reload();
                }
            }
        })
    }

    function onUpdataInfo() {
        preid = $("#editid").val();
        prename = $("#editname").val();
        preemail = $("#editemail").val();
        prepassword = $("#editpassword").val();
        $.ajax({
            /* the route pointing to the post function */
            url: '/admin/magentmanage/update-info',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: { _token: CSRF_TOKEN,
                    id:preid,
                    name:prename,
                    email:preemail,
                    password:prepassword
                },
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                alert(data.status);
                location.reload();
            }
        });
    }
</script>
@endsection