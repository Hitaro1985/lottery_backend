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
        for ($i = 0; $i < count($bets); $i ++)
        {
            $res = explode('&', $bets[$i]);
            array_push($betNumbers, $res);
        }
        return $betNumbers;
    }

    public function index()
    {
        $user = Auth::user();
        $user_role = Role::where('id', $user->role_id)->first();
        $rounds = roundlist::all();
        return view('admin.report', ['user_role' => $user_role['role'], 'rounds' => $rounds]);
    }

    public function report_agent()
    {
        $user = Auth::user();
        $user_role = Role::where('id', $user->role_id)->first();
        $bets = betlist::where('name', $user->name)->get();
        $betNumbers = array();
        for ($i = 0; $i < count($bets); $i ++)
        {
            array_push($betNumbers,$this->getbetinfo($bets[$i]->betNumber));
        }
        return view('admin.reportagent', ['user_role' => $user_role['role'], 'bets' => $bets, 'betinfos' => $betNumbers]);
    }
}
