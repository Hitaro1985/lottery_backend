@extends('admin.layouts.layout')

@section('content')
<!-- Custom CSS -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/extra-libs/multicheck/multicheck.css') }}">
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
{{--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css"/>--}}
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
                <h5 class="card-title">Bet Management</h5>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="zero_config_info">
                        <thead>
                            <tr>
                                {{--<th>Enable</th>--}}
                                <th>id</th>
                                <th>Name</th>
                                <th>Prize</th>
                                <th>TotalBet</th>
                                <th>TotalPayout</th>
                                <th>Profit</th>
                                <th>Paid Status</th>
                                <th>Create Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{--<th></th>--}}
                            {{--<th></th>--}}
                            {{--<th></th>--}}
                            {{--<th></th>--}}
                            {{--<th></th>--}}
                            {{--<th></th>--}}
                            {{--<th></th>--}}
                            {{--@for ($i = 0; $i < count($rounds); $i++)--}}
                                {{--<tr id="item{{$rounds[$i]->id}}">--}}
                                    {{--<td id="id{{ $rounds[$i]->id }}">{{ $rounds[$i]->id }}</td>--}}
                                    {{--<td id="name{{$rounds[$i]->id}}">{{ $rounds[$i]->name }}</td>--}}
                                    {{--<td id="prize{{$rounds[$i]->id}}">{{ $rounds[$i]->rightNumber }}</td>--}}
                                    {{--<td id="totalbet{{ $rounds[$i]->id }}">{{ $rounds[$i]->totalbet }}</td>--}}
                                    {{--<td id="totalpayout{{ $rounds[$i]->id }}">{{ $rounds[$i]->totalpayout }}</td>--}}
                                    {{--<td id="profit{{ $rounds[$i]->id }}">{{ $rounds[$i]->profit }}</td>--}}
                                    {{--@if($rounds[$i]->paidstatus)--}}
                                        {{--<td id="paidstatus{{ $rounds[$i]->id }}">Paid</td>--}}
                                    {{--@else--}}
                                        {{--<td id="paidstatus{{ $rounds[$i]->id }}">Not Paid</td>--}}
                                    {{--@endif--}}
                                    {{--<td>{{ $rounds[$i]->created_at }}</td>--}}
                                    {{--<td>--}}
                                        {{--@if(!$rounds[$i]->paidstatus)--}}
                                            {{--@if(!$rounds[$i]->rightNumber)--}}
                                            {{--<button class="btn btn-outline-info" onclick="onSetResult({{ $rounds[$i]->id }})" data-toggle="modal" data-target="#setResult">SET RESULT</button>--}}
                                            {{--@else--}}
                                            {{--<button class="btn btn-outline-info" onclick="onPayPrize({{ $rounds[$i]->id }})" data-toggle="modal" data-target="#payPrize">PAY PRIZE</button>--}}
                                            {{--@endif--}}
                                        {{--@endif--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                            {{--@endfor--}}
                        </tbody>
                    </table>
                </div>
                <!-- SendMoneyModal -->
                <div id="setResult" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-primary">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Set Result</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input id="editid" type="hidden" class="form-control">
                                <div class="form-group row">
                                    <label for="editamount" class="col-sm-3 text-right control-label col-form-label">Result : </label>
                                    <div class="col-sm-9">
                                        <input id="editResult" type="text" class="form-control" placeholder="Set Round Result 0-36">
                                    </div>
                                </div>
                            </div>
                            <table style="width: 100%;text-align: center;" border="1">
                                <thead>
                                    <th>Prize</th>
                                    <th>Totalbet</th>
                                    <th>TotalPayout</th>
                                    <th>Profit</th>
                                    <th>Prize</th>
                                    <th>Totalbet</th>
                                    <th>TotalPayout</th>
                                    <th>Profit</th>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>0</td>
                                    <td id="totalbet0"></td>
                                    <td id="totalpayout0"></td>
                                    <td id="profit0"></td>
                                    <td>19</td>
                                    <td id="totalbet19"></td>
                                    <td id="totalpayout19"></td>
                                    <td id="profit19"></td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td id="totalbet1"></td>
                                    <td id="totalpayout1"></td>
                                    <td id="profit1"></td>
                                    <td>20</td>
                                    <td id="totalbet20"></td>
                                    <td id="totalpayout20"></td>
                                    <td id="profit20"></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td id="totalbet2"></td>
                                    <td id="totalpayout2"></td>
                                    <td id="profit2"></td>
                                    <td>21</td>
                                    <td id="totalbet21"></td>
                                    <td id="totalpayout21"></td>
                                    <td id="profit21"></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td id="totalbet3"></td>
                                    <td id="totalpayout3"></td>
                                    <td id="profit3"></td>
                                    <td>22</td>
                                    <td id="totalbet22"></td>
                                    <td id="totalpayout22"></td>
                                    <td id="profit22"></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td id="totalbet4"></td>
                                    <td id="totalpayout4"></td>
                                    <td id="profit4"></td>
                                    <td>23</td>
                                    <td id="totalbet23"></td>
                                    <td id="totalpayout23"></td>
                                    <td id="profit23"></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td id="totalbet5"></td>
                                    <td id="totalpayout5"></td>
                                    <td id="profit5"></td>
                                    <td>24</td>
                                    <td id="totalbet24"></td>
                                    <td id="totalpayout24"></td>
                                    <td id="profit24"></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td id="totalbet6"></td>
                                    <td id="totalpayout6"></td>
                                    <td id="profit6"></td>
                                    <td>25</td>
                                    <td id="totalbet25"></td>
                                    <td id="totalpayout25"></td>
                                    <td id="profit25"></td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td id="totalbet7"></td>
                                    <td id="totalpayout7"></td>
                                    <td id="profit7"></td>
                                    <td>26</td>
                                    <td id="totalbet26"></td>
                                    <td id="totalpayout26"></td>
                                    <td id="profit26"></td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td id="totalbet8"></td>
                                    <td id="totalpayout8"></td>
                                    <td id="profit8"></td>
                                    <td>27</td>
                                    <td id="totalbet27"></td>
                                    <td id="totalpayout27"></td>
                                    <td id="profit27"></td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td id="totalbet9"></td>
                                    <td id="totalpayout9"></td>
                                    <td id="profit9"></td>
                                    <td>28</td>
                                    <td id="totalbet28"></td>
                                    <td id="totalpayout28"></td>
                                    <td id="profit28"></td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td id="totalbet10"></td>
                                    <td id="totalpayout10"></td>
                                    <td id="profit10"></td>
                                    <td>29</td>
                                    <td id="totalbet29"></td>
                                    <td id="totalpayout29"></td>
                                    <td id="profit29"></td>
                                </tr>
                                <tr>
                                    <td>11</td>
                                    <td id="totalbet11"></td>
                                    <td id="totalpayout11"></td>
                                    <td id="profit11"></td>
                                    <td>30</td>
                                    <td id="totalbet30"></td>
                                    <td id="totalpayout30"></td>
                                    <td id="profit30"></td>
                                </tr>
                                <tr>
                                    <td>12</td>
                                    <td id="totalbet12"></td>
                                    <td id="totalpayout12"></td>
                                    <td id="profit12"></td>
                                    <td>31</td>
                                    <td id="totalbet31"></td>
                                    <td id="totalpayout31"></td>
                                    <td id="profit31"></td>
                                </tr>
                                <tr>
                                    <td>13</td>
                                    <td id="totalbet13"></td>
                                    <td id="totalpayout13"></td>
                                    <td id="profit13"></td>
                                    <td>32</td>
                                    <td id="totalbet32"></td>
                                    <td id="totalpayout32"></td>
                                    <td id="profit32"></td>
                                </tr>
                                <tr>
                                    <td>14</td>
                                    <td id="totalbet14"></td>
                                    <td id="totalpayout14"></td>
                                    <td id="profit14"></td>
                                    <td>33</td>
                                    <td id="totalbet33"></td>
                                    <td id="totalpayout33"></td>
                                    <td id="profit33"></td>
                                </tr>
                                <tr>
                                    <td>15</td>
                                    <td id="totalbet15"></td>
                                    <td id="totalpayout15"></td>
                                    <td id="profit15"></td>
                                    <td>34</td>
                                    <td id="totalbet34"></td>
                                    <td id="totalpayout34"></td>
                                    <td id="profit34"></td>
                                </tr>
                                <tr>
                                    <td>16</td>
                                    <td id="totalbet16"></td>
                                    <td id="totalpayout16"></td>
                                    <td id="profit16"></td>
                                    <td>35</td>
                                    <td id="totalbet35"></td>
                                    <td id="totalpayout35"></td>
                                    <td id="profit35"></td>
                                </tr>
                                <tr>
                                    <td>17</td>
                                    <td id="totalbet17"></td>
                                    <td id="totalpayout17"></td>
                                    <td id="profit17"></td>
                                    <td>36</td>
                                    <td id="totalbet36"></td>
                                    <td id="totalpayout36"></td>
                                    <td id="profit36"></td>
                                </tr>
                                <tr>
                                    <td>18</td>
                                    <td id="totalbet18"></td>
                                    <td id="totalpayout18"></td>
                                    <td id="profit18"></td>
                                </tr>
                                </tbody>
                            </table>
                            {{--<div style="width: 45px; margin: auto;">--}}
                                {{--<p id="betexpects" style="text-align: center;"></p>--}}
                            {{--</div>--}}
                            <div class="modal-footer">
                                <button type="button" onclick="onUpdateResult()" class="btn btn-success">Set</button>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Modal -->
                <div id="payPrize" class="modal fade" role="dialog">
                  <div class="modal-dialog modal-primary">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Pay Prize</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <div class="modal-body">
                        <input id="editid" type="hidden" class="form-control">
                        <div class="form-group row">
                            <label for="editname" class="col-sm-3 text-right control-label col-form-label">TotalPayout :</label>
                            <label id="labeltotalpayout" for="editname" class="col-sm-3 text-left control-label col-form-label"></label>
                            <input type="hidden" id="edittotalpayout">
                        </div>
                        <div class="form-group row">
                            <label for="editemail" class="col-sm-3 text-right control-label col-form-label">Profit :</label>
                            <label id="labelprofit" for="editname" class="col-sm-3 text-left control-label col-form-label"></label>
                            <input type="hidden" id="editprofit">
                        </div>
                      </div>
                      <div class="modal-footer">
                            <button type="button" onclick="onUpdatePay()" class="btn btn-success">Pay</button>
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
{{--<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>--}}
{{--<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>--}}
<script>
    /****************************************
     *       Basic Table                   *
     ****************************************/
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    function ajaxData(){
        var obj = {
            _token: CSRF_TOKEN,
        };
        return obj;
    }
    $(document).ready( function() {
        $('#zero_config').DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            pageLength: 10,
            ajax: {
                type: "POST",
                url: '{{route('serverSide')}}',
                "dataType": "json",
                data: {
                    _token: CSRF_TOKEN
                }
            },
            "columns":[
                {"data":"id"},
                {"data":"name"},
                {"data":"rightNumber"},
                {"data":"totalbet"},
                {"data":"totalpayout"},
                {"data":"profit"},
                {"data":"paidstatus"},
                {"data":"created_at"},
                {"data":"action"}
            ]
        });
    });

    function onSetResult(agentID) {
        preID = agentID;
        $.ajax({
            url: '/admin/getbetexpects',
            type: 'POST',
            data: {
                _token: CSRF_TOKEN,
                id: preID
            },
            dataType: 'JSON',
            success: function (data) {
                console.log(data);
                if (data.status == "success") {
                    for (i = 0; i < 37; i ++) {
                        $("#totalbet"+i).text("aa");
                        if ( data.totalbet[i] ) {
                            $("#totalbet" + i).text(data.totalbet[i]);
                        } else {
                            $("#totalbet" + i).text("0");
                        }
                        $("#totalpayout"+i).text("aa");
                        if ( data.totalbet[i] ) {
                            $("#totalpayout" + i).text(data.totalbet[i] * 36);
                        } else {
                            $("#totalpayout" + i).text("0");
                        }
                        if ( data.totalbet[i] ) {
                            $("#profit" + i).text(data.total - data.totalbet[i] * 36);
                        } else {
                            $("#profit" + i).text("0");
                        }
                    }
//                    $("#betexpects").text(data.data);
                } else {
                    alert("ajax request error");
                }
            }
        });
        $("#editid").val(agentID);
    }

    function onPayPrize(agentID) {
        $('#editid').val(agentID);
        pretotalpayout = $('#totalpayout' + agentID).text();
        preprofit = $('#profit' + agentID).text();
        $('#editprofit').val(preprofit);
        $('#labelprofit').text(preprofit);
        $('#edittotalpayout').val(pretotalpayout);
        $('#labeltotalpayout').text(pretotalpayout);
    }

    function onUpdateResult() {
        correct = parseInt($('#editResult').val());
        if(isNaN(correct)) {
            alert("Input is not a number");
        } else if(correct < 0) {
            alert("please input 0-36");
        } else if(correct > 36) {
            alert("please input 0-36");
        } else {
            preid = $("#editid").val();
            $.ajax({
                url: '/admin/betmanage/setresult',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    id:preid,
                    amount:correct
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
            });
        }
    }

    function onUpdatePay() {
        preid = $("#editid").val();
        $.ajax({
            /* the route pointing to the post function */
            url: '/admin/betmanage/pay',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: { _token: CSRF_TOKEN,
                    id:preid
                },
            dataType: 'JSON',
            success: function (data) {
                console.log(data);
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