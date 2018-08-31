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
                <h5 class="card-title">Report</h5>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>RoundName</th>
                                <th>RightNumber</th>
                                <th>1ST 12</th>
                                <th>2ND 12</th>
                                <th>3RD 12</th>
                                <th>1 - 18</th>
                                <th>18 - 36</th>
                                <th>BLACK COLOUR</th>
                                <th>RED COLOUR</th>
                                <th>ODD</th>
                                <th>EVEN</th>
                                <th>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                        @for ($i = 0; $i < count($reports); $i++)
                            <tr id="item{{$reports[$i]->id}}">
                                <td>{{ $reports[$i]->created_at }}</td>
                                <td id="name{{$reports[$i]->id}}">{{ $reports[$i]->roundname }}#{{ $reports[$i]->roundnumber }}</td>
                                <td id="rightnumber{{$reports[$i]->id}}">{{ $reports[$i]->rightNumber }}</td>
                                <td id="first{{$reports[$i]->id}}">MYR{{ $reports[$i]->first }}</td>
                                <td id="second{{$reports[$i]->id}}">MYR{{ $reports[$i]->second }}</td>
                                <td id="third{{$reports[$i]->id}}">MYR{{ $reports[$i]->third }}</td>
                                <td id="firsttoeighteen{{$reports[$i]->id}}">MYR{{ $reports[$i]->firsttoeighteen }}</td>
                                <td id="eighteentothirtysix{{$reports[$i]->id}}">MYR{{ $reports[$i]->eighteentothirtysix }}</td>
                                <td id="blackcolor{{$reports[$i]->id}}">MYR{{ $reports[$i]->blackcolor }}</td>
                                <td id="redcolor{{$reports[$i]->id}}">MYR{{ $reports[$i]->redcolor }}</td>
                                <td id="odd{{$reports[$i]->id}}">MYR{{ $reports[$i]->odd }}</td>
                                <td id="even{{$reports[$i]->id}}">MYR{{ $reports[$i]->even }}</td>
                                <td id="totalmoney{{$reports[$i]->id}}">MYR{{ $reports[$i]->totalmoney }}</td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>
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
                        <div class="form-group row">
                            <label for="editamount" class="col-sm-3 text-right control-label col-form-label">Amount : </label>
                            <div class="col-sm-9">
                                <input id="editamount" type="text" class="form-control" placeholder="Credit Card Amount">
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
    All Rights Reserved by Matrix-admin. Designed and Developed by <a href="https://wrappixel.com">WrapPixel</a>.
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
</script>
@endsection