<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\roundlist;
use App\Role;
use App\betlist;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function getbetinfo($betinfo)
    {
        $bets = explode("%", $betinfo);
        $betNumbers = array();
        $red = ["1","3","5","7","9","12","14","16","18","19","21","23","25","27","30","32","34","36","RED"];
        for ($i = 0; $i < count($bets); $i ++)
        {
            $res = explode('&', $bets[$i]);
            if ($res[0] == "0") {
                $res[2] = "color-green";
            } else if ( in_array($res[0], $red)) {
                $res[2] = "color-red";
            } else {
                $res[2] = "color-black";
            }
            array_push($betNumbers, $res);
        }
        return $betNumbers;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $user_role = Role::where('id', $user->role_id)->first();
        $query = array();
        if ($request->has('searchagent') && $request->input('searchagent') != '') {
            $name = $request->input('searchagent');
            $query['name'] = $name;
        }
        if ($request->has('searchround') && $request->input('searchround') != '') {
            $round = $request->input('searchround');
            $query['round'] = $round;
        }
        if ($request->has('datefilter') && $request->input('datefilter') != '') {
            try {
                $daterange = $request->input('datefilter');
                $daterange = str_replace(' ', '', $daterange);
                $dates = explode('-', $daterange);
                $t1 = explode('/', $dates[0]);
                $from = $t1[2] . '-' . $t1[0] . '-' . $t1[1];
                $t2 = explode('/', $dates[1]);
                $to = $t2[2] . '-' . $t2[0] . '-' . $t2[1];
                $bets = betlist::where($query)->whereBetween('created_at', [date($from), date($to)])->get();
            } catch(\Exception $e) {
                $bets = betlist::where($query)->get();
            }
        } else {
            $bets = betlist::where($query)->get();
        }
        $betNumbers = array();
        for ($i = 0; $i < count($bets); $i ++)
        {
            array_push($betNumbers,$this->getbetinfo($bets[$i]->betNumber));
        }
        return view('admin.reportagent', ['create_new' => 'false', 'user_role' => $user_role['role'], 'bets' => $bets, 'betinfos' => $betNumbers]);
    }

    public function report_agent(Request $request)
    {
        $user = Auth::user();
        $user_role = Role::where('id', $user->role_id)->first();
        $query = array();
        $query['name'] = $user->name;
        if ($request->has('searchround') && $request->input('searchround') != '') {
            $round = $request->input('searchround');
            $query['round'] = $round;
        }
        if ($request->has('datefilter') && $request->input('datefilter') != '') {
            try {
                $daterange = $request->input('datefilter');
                $daterange = str_replace(' ', '', $daterange);
                $dates = explode('-', $daterange);
                $t1 = explode('/', $dates[0]);
                $from = $t1[2] . '-' . $t1[0] . '-' . $t1[1];
                $t2 = explode('/', $dates[1]);
                $to = $t2[2] . '-' . $t2[0] . '-' . $t2[1];
                $bets = betlist::where($query)->whereBetween('created_at', [date($from), date($to)])->get();
            } catch(\Exception $e) {
                $bets = betlist::where($query)->get();
            }
        } else {
            $bets = betlist::where($query)->get();
        }
        $betNumbers = array();
        for ($i = 0; $i < count($bets); $i ++)
        {
            array_push($betNumbers,$this->getbetinfo($bets[$i]->betNumber));
        }
        return view('admin.reportagent', ['create_new' => 'false', 'user_role' => $user_role['role'], 'bets' => $bets, 'betinfos' => $betNumbers]);
    }
}
