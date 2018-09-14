<?php

namespace App\Http\Controllers\admin;

use App\Admin;
use App\betlist;
use App\payoutlist;
use App\roundlist;
use App\transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Role;
use Yajra\Datatables\Datatables;

class AdminBetController extends Controller
{
    public function index() {
        $user = Auth::user();
        $user_role = Role::where('id', $user->role_id)->first();
        //$rounds = roundlist::all();
        //return view("admin.betcontroller", ['create_new' => 'false', 'user_role' => $user_role['role'], 'rounds' => $rounds]);
        return view("admin.betcontroller", ['create_new' => 'false', 'user_role' => $user_role['role']]);
    }

    public function serverSide(Request $request) {
//        $rounds = roundlist::select('id', 'name', 'rightNumber', 'totalbet', 'totalpayout', 'profit', 'paidstatus', 'created_at');
//        return Datatables::of($rounds)->make(true);
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'rightNumber',
            3 => 'totalbet',
            4 => 'totalpayout',
            5 => 'profit',
            6 => 'paidstatus',
            7 => 'created_at',
            8 => 'action',
        );

        $totalData = roundlist::count();
        $limit = $request->input('length');
        $start = $request->input('start');
//        $order = $columns[$request->input('order.0.column')];
//        $dir = $request->input('order.0.dir');

        $posts = roundlist::offset($start)
            ->limit($limit)
            ->get();
//            ->orderBy($order,$dir)

        $data = array();
        if($posts) {
            foreach ($posts as $r) {
                $nestedData['id'] = $r->id;
                $nestedData['name'] = $r->name;
                $nestedData['rightNumber'] = $r->rightNumber;
                $nestedData['totalbet'] = $r->totalbet;
                $nestedData['totalpayout'] = $r->totalpayout;
                $nestedData['profit'] = $r->profit;
                $nestedData['paidstatus'] = $r->paidstatus;
                $nestedData['created_at'] = date('d-m-Y H:i:s', strtotime($r->created_at));
                $nestedData['action'] = '
                    <button class="btn btn-outline-info" data-toggle="modal" data-target="#setResult">SET RESULT</button>
                ';
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"          => intval($request->input('draw')),
            "recordsTotal"  => intval($totalData),
            "data"          => $data
        );

        echo json_encode($json_data);
    }

    public function getbetinfo($betinfo)
    {
        $bets = explode("%", $betinfo);
        $betNumbers = array();
        for ($i = 0; $i < count($bets); $i ++)
        {
            $res = explode('&', $bets[$i]);
            array_push($betNumbers, $res);
        }
        return $betNumbers;
    }

    public function setresult(Request $request) {
        try {
            $bet = roundlist::where('id', $request->id)->first();
            $bet->rightNumber = $request->amount;
            $roundtotal = 0;
            $betlists = betlist::where('round', $bet->name)->get();
            foreach ($betlists as $betlist) {
                $betstate = $betlist['betNumber'];
                $betNumbers = $this->getbetinfo($betstate);
                $res = "lose";
                $totalpayout = 0;
                for ($i = 0; $i < count($betNumbers); $i ++) {
                    if ($betNumbers[$i][0] != "1st"
                        && $betNumbers[$i][0] != "2nd"
                        && $betNumbers[$i][0] != "3rd"
                        && $betNumbers[$i][0] != "RED"
                        && $betNumbers[$i][0] != "BLACK"
                        && $betNumbers[$i][0] != "ODD"
                        && $betNumbers[$i][0] != "EVEN"
                        && $betNumbers[$i][0] != "1-18"
                        && $betNumbers[$i][0] != "19-36"
                    ) {
                        if (strpos((string)$betNumbers[$i][0], (string)$request->amount) !== false) {
                            $totalpayout = $totalpayout + 36 * $betNumbers[$i][1];
                            $res = "winner";
                        }
                    } else {
                        if ($betNumbers[$i][0] == "1st") {
                            if ($request->amount > 0 && $request->amount < 13) {
                                $totalpayout = $totalpayout + 3 * $betNumbers[$i][1];
                                $res = "winner";
                            }
                        }
                        if ($betNumbers[$i][0] == "2nd") {
                            if ($request->amount > 12 && $request->amount < 25) {
                                $totalpayout = $totalpayout + 3 * $betNumbers[$i][1];
                                $res = "winner";
                            }
                        }
                        if ($betNumbers[$i][0] == "3rd") {
                            if ($request->amount > 24 && $request->amount < 37) {
                                $totalpayout = $totalpayout + 3 * $betNumbers[$i][1];
                                $res = "winner";
                            }
                        }
                        if ($betNumbers[$i][0] == "RED") {
                            if (in_array($request->amount, [1, 3, 5, 7, 9, 12, 14, 16, 18, 19, 21, 23, 25, 27, 30, 35, 34, 36])) {
                                $totalpayout = $totalpayout + 2 * $betNumbers[$i][1];
                                $res = "winner";
                            }
                        }
                        if ($betNumbers[$i][0] == "BLACK") {
                            if (in_array($request->amount, [2, 4, 6, 8, 10, 11, 13, 15, 17, 20, 22, 24, 26, 28, 29, 31, 33, 35])) {
                                $totalpayout = $totalpayout + 2 * $betNumbers[$i][1];
                                $res = "winner";
                            }
                        }
                        if ($betNumbers[$i][0] == "ODD") {
                            if ($request->amount % 2 == 1 ) {
                                $totalpayout = $totalpayout + 2 * $betNumbers[$i][1];
                                $res = "winner";
                            }
                        }
                        if ($betNumbers[$i][0] == "EVEN") {
                            if ($request->amount % 2 == 0 ) {
                                $totalpayout = $totalpayout + 2 * $betNumbers[$i][1];
                                $res = "winner";
                            }
                        }
                        if ($betNumbers[$i][0] == "1-18") {
                            if ($request->amount > 0 && $request->amount < 19) {
                                $totalpayout = $totalpayout + 2 * $betNumbers[$i][1];
                                $res = "winner";
                            }
                        }
                        if ($betNumbers[$i][0] == "19-36") {
                            if ($request->amount > 18 && $request->amount < 37) {
                                $totalpayout = $totalpayout + 2 * $betNumbers[$i][1];
                                $res = "winner";
                            }
                        }
                    }
                }
                $betlist->wls = $res;
                $betlist->totalpayout = $totalpayout;
                $roundtotal = $roundtotal + $totalpayout;
                $betlist->save();
            }
            $bet->totalpayout = $roundtotal;
            $bet->profit = $bet->totalbet - $roundtotal;
            $bet->save();
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed', 'errMsg' => $e->getMessage()]);
        }
    }

    public function pay(Request $request) {
        try {
            $round = roundlist::where('id', $request->id)->get()->first();
            $betlists = betlist::where('round', $round->name)->get();
            $au = Admin::where('name', 'Tony')->get()->first();
            foreach ($betlists as $betlist) {
                $us = Admin::where('name', $betlist->name)->get()->first();
                $us->amount = $us->amount + $betlist->totalpayout;
                $au->amount = $au->amount - $betlist->totalpayout;
                $us->save();
                $au->save();
                $payout = new payoutlist();
                $payout->adminname = $au->name;
                $payout->agentname = $us->name;
                $payout->payout = $betlist->totalpayout;
                $payout->save();
                $trans = new transaction();
                $trans->fromname = $au->name;
                $trans->toname = $us->name;
                $trans->amount = $betlist->totalpayout;
                $trans->status = "round paid";
                $trans->save();
            }
            $round->paidstatus = true;
            $round->save();
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed', 'errMsg' => $e->getMessage()]);
        }
    }
}
