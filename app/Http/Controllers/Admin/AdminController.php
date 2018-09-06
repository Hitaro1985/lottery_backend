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
        $slots = slotstate::get()->first();
        $slotstates = array();
        $totalreceives = array();
        $totalpayouts = array();
        for ($i = 0; $i < 37; $i ++) {
            $pieces = explode("|", $slots['s'.$i]);
            $slotstates['s'.$i] = $pieces[0];
            $totalreceives['s'.$i] = $pieces[1];
            $totalpayouts['s'.$i] =  36 * $pieces[1];
        }
        $pieces = explode("|", $slots['1st']);
        $slotstates['1st'] = $pieces[0];
        $totalreceives['1st'] = $pieces[1];
        $totalpayouts['1st'] = 3 * $pieces[1];
        $pieces = explode("|", $slots['2nd']);
        $slotstates['2nd'] = $pieces[0];
        $totalreceives['2nd'] = $pieces[1];
        $totalpayouts['2nd'] = 3 * $pieces[1];
        $pieces = explode("|", $slots['3rd']);
        $slotstates['3rd'] = $pieces[0];
        $totalreceives['3rd'] = $pieces[1];
        $totalpayouts['3rd'] = 3 * $pieces[1];
        $pieces = explode("|", $slots['red']);
        $slotstates['red'] = $pieces[0];
        $totalreceives['red'] = $pieces[1];
        $totalpayouts['red'] = 2 * $pieces[1];
        $pieces = explode("|", $slots['black']);
        $slotstates['black'] = $pieces[0];
        $totalreceives['black'] = $pieces[1];
        $totalpayouts['black'] = 2 * $pieces[1];
        $pieces = explode("|", $slots['odd']);
        $slotstates['odd'] = $pieces[0];
        $totalreceives['odd'] = $pieces[1];
        $totalpayouts['odd'] = 2 * $pieces[1];
        $pieces = explode("|", $slots['even']);
        $slotstates['even'] = $pieces[0];
        $totalreceives['even'] = $pieces[1];
        $totalpayouts['even'] = 2 * $pieces[1];
        $pieces = explode("|", $slots['f118']);
        $slotstates['f118'] = $pieces[0];
        $totalreceives['f118'] = $pieces[1];
        $totalpayouts['f118'] = 2 * $pieces[1];
        $pieces = explode("|", $slots['f1936']);
        $slotstates['f1936'] = $pieces[0];
        $totalreceives['f1936'] = $pieces[1];
        $totalpayouts['f1936'] = 2 * $pieces[1];

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
        return view('admin.dashboard', ['user_role' => $user_role['role'], 'slotstates'=>$slotstates, 'totalreceives' => $totalreceives, 'totalpayouts' => $totalpayouts]);
    }
}
