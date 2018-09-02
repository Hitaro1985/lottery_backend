<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\slotstate;
use Illuminate\Http\Request;
use Auth;
use App\Role;
class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $user_role = Role::where('id', $user->role_id)->first();
        //$bets = array();
        $slotstates = slotstate::get()->first();
        //return $bet;
//        for( $i = 0; $i <= 36; $i ++) {
//            if( $i % 3 == 0){
//                $bets[$i]['exist'] = '1';
//                $bets[$i]['Total Receive'] = '3.00';
//                $bets[$i]['Total Payout'] = '240.00';
//            }
//            else if( $i % 16 == 0) {
//                $bets[$i]['exist'] = '0';
//            }
//            else {
//                $bets[$i]['exist'] = '-1';
//            }
//        }
        if ($user_role['role'] == 'Master Agent') {
            return redirect('/admin/agentmanage');
        }
        if ($user_role['role'] == 'Agent') {
            return redirect('/admin/report');
        }
        return view('admin.dashboard', ['user_role' => $user_role['role'], 'slotstates'=>$slotstates]);
    }
}
