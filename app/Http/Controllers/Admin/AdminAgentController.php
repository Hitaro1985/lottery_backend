<?php

namespace App\Http\Controllers\Admin;
use App\betlist;
use App\Http\Controllers\Controller;
use App\round;
use App\roundlist;
use App\slotstate;
use App\transaction;
use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Role;
use App\Admin;
use App\User;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateInterval;

class AdminAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $user_role = Role::where('id', $user->role_id)->first();
        $query = array();
        if ($user->role_id != 1) {
            $query['created_by'] = $user->name;
        }
        if ( $request->has('name') && $request->input('name') != '' ) {
            $query['created_by'] = $request->input('name');
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
                if ( $request->has('name') && $request->input('name') != '' ) {
                    $all_users = Admin::leftJoin('roles', function ($join) {
                        $join->on('admins.role_id', '=', 'roles.id');
                    })->where('admins.role_id', '!=', 1)->where('admins.role_id', '!=', 2)->where($query)->whereBetween('created_at', [date($from), date($to)])->get([
                        'admins.*',
                        'roles.role'
                    ]);
                } else {
                    $all_users = Admin::leftJoin('roles', function ($join) {
                        $join->on('admins.role_id', '=', 'roles.id');
                    })->where('admins.role_id', '=', 3)->where($query)->whereBetween('created_at', [date($from), date($to)])->get([
                        'admins.*',
                        'roles.role'
                    ]);
                }
            } catch(\Exception $e) {
                if ( $request->has('name') && $request->input('name') != '' ) {
                    $all_users = Admin::leftJoin('roles', function ($join) {
                        $join->on('admins.role_id', '=', 'roles.id');
                    })->where($query)->where('admins.role_id', '!=', 1)->where('admins.role_id', '!=', 2)->get([
                        'admins.*',
                        'roles.role'
                    ]);
                } else {
                    $all_users = Admin::leftJoin('roles', function ($join) {
                        $join->on('admins.role_id', '=', 'roles.id');
                    })->where($query)->where('admins.role_id', '=', 3)->get([
                        'admins.*',
                        'roles.role'
                    ]);
                }
            }
        } else {
            if ( $request->has('name') && $request->input('name') != '' ) {
                $all_users = Admin::leftJoin('roles', function ($join) {
                    $join->on('admins.role_id', '=', 'roles.id');
                })->where($query)->where('admins.role_id', '!=', 1)->where('admins.role_id', '!=', 2)->get([
                    'admins.*',
                    'roles.role'
                ]);
            } else {
                $all_users = Admin::leftJoin('roles', function ($join) {
                    $join->on('admins.role_id', '=', 'roles.id');
                })->where($query)->where('admins.role_id', '=', 3)->get([
                    'admins.*',
                    'roles.role'
                ]);
            }
        }
        return view('admin.magentmanage', ['create_new' => 'true', 'user_role' => $user_role['role'], 'user_name' => $user->name, 'all_users' => $all_users]);
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

    public function getbetexpects(Request $request)
    {
        $round = roundlist::where('id', $request->id)->get()->first();
        $start = $round->created_at;
        $end = $round->created_at->modify('+30 minutes');
        $betlists = betlist::where('round', $round->name)->whereBetween('created_at', [$start, $end])->get();
        $k = array();
        $total = 0;
        foreach ($betlists as $betlist) {
            $betstate = $betlist['betNumber'];
            $betNumbers = $this->getbetinfo($betstate);
            $total = $total + $betlist->total;
            for ($i = 0; $i < count($betNumbers); $i++) {
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
                    if (!array_key_exists((string)$betNumbers[$i][0], $k)) {
                        $k[(string)$betNumbers[$i][0]] = $betNumbers[$i][1];
                    } else {
                        $k[(string)$betNumbers[$i][0]] = $k[(string)$betNumbers[$i][0]] + $betNumbers[$i][1];
                    }
                } else {
                    if ($betNumbers[$i][0] == "1st") {
                        $infs = [1,2,3,4,5,6,7,8,9,10,11,12];
                        $tnum = 12;
                    }
                    if ($betNumbers[$i][0] == "2nd") {
                        $infs = [13,14,15,16,17,18,19,20,21,22,23,24];
                        $tnum = 12;
                    }
                    if ($betNumbers[$i][0] == "3rd") {
                        $infs = [25,26,27,28,29,30,31,32,33,34,35,36];
                        $tnum = 12;
                    }
                    if ($betNumbers[$i][0] == "RED") {
                        $infs = [1,3,5,7,9,12,14,16,18,19,21,23,25,27,30,32,34,36];
                        $tnum = 18;
                    }
                    if ($betNumbers[$i][0] == "BLACK") {
                        $infs = [2,4,6,8,10,11,13,15,17,20,22,24,26,28,29,31,33,35];
                        $tnum = 18;
                    }
                    if ($betNumbers[$i][0] == "ODD") {
                        $infs = [1,3,5,7,9,11,13,15,17,19,21,23,25,27,29,31,33,35];
                        $tnum = 18;
                    }
                    if ($betNumbers[$i][0] == "EVEN") {
                        $infs = [2,4,6,8,10,12,14,16,18,20,22,24,26,28,30,32,34,36];
                        $tnum = 18;
                    }
                    if ($betNumbers[$i][0] == "1-18") {
                        $infs = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18];
                        $tnum = 18;
                    }
                    if ($betNumbers[$i][0] == "19-36") {
                        $infs = [19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36];
                        $tnum = 18;
                    }
                    foreach ($infs as $inf) {
                        if (!array_key_exists((string)$inf, $k)) {
                            $k[(string)$inf] = $betNumbers[$i][1];
                            //$k[(string)$inf] = number_format($betNumbers[$i][1] / $tnum, 2, '.', '');
                        } else {
                            $k[(string)$inf] = $k[(string)$inf] + $betNumbers[$i][1];
                            //$k[(string)$inf] = number_format($k[(string)$inf] + $betNumbers[$i][1] / $tnum, 2, '.', '');
                        }
                    }
                }
            }
        }
        $result = "";
        for ($i = 0; $i < 37; $i ++) {
            if (!array_key_exists((string)$i, $k)) {
                $result = $result . $i . "->0  ";
            } else {
                $result = $result . $i . "->" . $k[(string)$i] . "  ";
            }
        }
        return response()->json(['status' => 'success', 'totalbet' => $k, 'total' => $total], 200);
    }

    public function sagentmanage(Request $request)
    {
        $user = Auth::user();
        $user_role = Role::where('id', $user->role_id)->first();
        $query = array();
        if ($user->role_id != 1) {
            $query['created_by'] = $user->name;
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
                $all_users = Admin::leftJoin('roles', function($join) {
                    $join->on('admins.role_id', '=', 'roles.id');
                })->where($query)->where('admins.role_id', '=', 2)->whereBetween('created_at', [date($from), date($to)])->get([
                    'admins.*',
                    'roles.role'
                ]);
            } catch(\Exception $e) {
                $all_users = Admin::leftJoin('roles', function($join) {
                    $join->on('admins.role_id', '=', 'roles.id');
                })->where($query)->where('admins.role_id', '=', 2)->get([
                    'admins.*',
                    'roles.role'
                ]);
            }
        } else {
            $all_users = Admin::leftJoin('roles', function($join) {
                $join->on('admins.role_id', '=', 'roles.id');
            })->where($query)->where('admins.role_id', '=', 2)->get([
                'admins.*',
                'roles.role'
            ]);
        }
        return view('admin.sagentmanage', ['create_new' => 'true', 'user_role' => $user_role['role'], 'user_name' => $user->name, 'all_users' => $all_users]);
    }

    public function senior_create_new(Request $request)
    {
        try{
            $checkif = Admin::where('name', $request->name)->get();
            if (count($checkif) > 0) {
                return response()->json(['status' => 'failed', 'msg' => 'Username Exists']);
            }
            $nuser = Auth::user();
            $user = new Admin();
            //$user = Admin::where('id', $request->id)->first();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $currentuser = Auth::user();
            if ($currentuser->role_id == 2 ) {
                if ($currentuser->amount < $request->credit) {
                    return response()->json(['status' => 'failed', 'msg' => 'Not enough credit']);
                }
                $currentuser->amount = $currentuser->amount - $request->credit;
                $currentuser->save();
            }
            $user->amount = $request->credit;
            if ($request->credit > 0) {
                $newtrans = new transaction();
                $newtrans->fromname = $currentuser->name;
                $newtrans->toname = $user->name;
                $newtrans->amount = $request->credit;
                $newtrans->status = "Create and send";
                $newtrans->save();
            }
            $user->phoneno = $request->phoneno;
            if ( $request->role == "sagent") {
                $user->role_id = 2;
            } else if ( $request->role == "magent" ) {
                $user->role_id = 3;
            } else {
                $user->role_id = 4;
            }
            $user->created_by = $nuser->name;
            $user->save();
            return response()->json(["status" => 'success']);
        } catch (\Exception $e) {
            return response()->json(["status" => "failed", "msg" => $e->getMessage()]);
        }
    }

    public function agentmanage(Request $request)
    {
        $user = Auth::user();
        $user_role = Role::where('id', $user->role_id)->first();
        $query = array();
        if ($user->role_id != 1) {
            $query['created_by'] = $user->name;
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
                $all_users = Admin::leftJoin('roles', function($join) {
                    $join->on('admins.role_id', '=', 'roles.id');
                })->where($query)->where('admins.role_id', '=', 4)->whereBetween('created_at', [date($from), date($to)])->get([
                    'admins.*',
                    'roles.role'
                ]);
            } catch(\Exception $e) {
                $all_users = Admin::leftJoin('roles', function($join) {
                    $join->on('admins.role_id', '=', 'roles.id');
                })->where($query)->where('admins.role_id', '=', 4)->get([
                    'admins.*',
                    'roles.role'
                ]);
            }
        } else {
            $all_users = Admin::leftJoin('roles', function($join) {
                $join->on('admins.role_id', '=', 'roles.id');
            })->where($query)->where('admins.role_id', '=', 4)->get([
                'admins.*',
                'roles.role'
            ]);
        }
        return view('admin.agentmanage', ['create_new' => 'true', 'user_role' => $user_role['role'], 'user_name' => $user->name, 'all_users' => $all_users]);
    }

    public function view_credit()
    {
        $user = Auth::user();
        $user_role = Role::where('id', $user->role_id)->first();

        $current_user = User::where('id', $user->id)->first();
        return view('admin.credit', ['create_new' => 'false', 'user_role' => $user_role['role'], 'current_user'=>$user]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function master_accept(Request $request)
    {
        $user = Admin::where('id', $request->id)->first();
//        if ($user->role_id == 0) {
//            $user->role_id = 2;
//        }
//        else {
//            $user->role_id = 0;
//        }
        if ($user->enabled == true) {
            $user->enabled = false;
        } else {
            $user->enabled = true;
        }
        $response = array(
            'role_id' => $user->role_id,
            'updated_at' => $user->updated_at,
        );
        $user->save();
        return response()->json($response);
    }

    public function sendmoney(Request $request)
    {
        try {
            $trans = new transaction;
            $admin = Auth::user();
            if ($admin->amount < $request->amount && $admin->role_id != 1) {
                return response()->json(['status' => 'failed', 'errMsg' => 'Not Enough Money']);
            }
            if ($admin->role_id != 1) {
                $admin->amount = $admin->amount - $request->amount;
            }
            $admin->save();
            $trans->fromname = $admin->name;
            $user = Admin::where('id', $request->id)->first();
            $user->amount = $user->amount + $request->amount;
            $user->save();
            $trans->toname = $user->name;
            $trans->amount = $request->amount;
            $trans->status = "paid";
            $trans->save();
            return response()->json(['status' => 'success']);
        } catch (Exception $e){
            return response()->json(['status'=> 'failed', 'errMsg'=>$e->getMessage()], 200);
        }
    }

    public function accept(Request $request)
    {
        try {
            $user = Admin::where('id', $request->id)->first();
            if ($user->enabled == false) {
                $user->enabled = true;
            } else {
                $user->enabled = false;
            }
            $response = array(
                'updated_at' => $user->updated_at,
            );
            $user->save();
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function master_update_info(Request $request)
    {
        try {
            $user = Admin::where('id', $request->id)->first();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            //$user->amount = $request->amount;
            $user->save();
            return response()->json(["status" => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed', 'msg' => $e->getMessage()]);
        }
    }

    public function master_create_new(Request $request)
    {
        try{
            $checkif = Admin::where('name', $request->name)->get();
            if (count($checkif) > 0) {
                return response()->json(['status' => 'failed', 'msg' => 'Username Exists']);
            }
            $nuser = Auth::user();
            $user = new Admin();
            //$user = Admin::where('id', $request->id)->first();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $currentuser = Auth::user();
            if ($currentuser->role_id == 2) {
                if ($currentuser->amount < $request->credit) {
                    return response()->json(['status' => 'failed', 'msg' => 'Not enough credit']);
                }
                $currentuser->amount = $currentuser->amount - $request->credit;
                $currentuser->save();
            }
            $user->amount = $request->credit;
            if ($request->credit > 0) {
                $newtrans = new transaction();
                $newtrans->fromname = $currentuser->name;
                $newtrans->toname = $user->name;
                $newtrans->amount = $request->credit;
                $newtrans->status = "Create and send";
                $newtrans->save();
            }
            $user->phoneno = $request->phoneno;
            if ( $request->role == "magent") {
                $user->role_id = 3;
            } else {
                $user->role_id = 4;
            }
            $user->created_by = $nuser->name;
            $user->save();
            return response()->json(["status" => 'success']);
        } catch (\Exception $e) {
            return response()->json(["status" => "failed", "msg" => $e->getMessage()]);
        }
    }

    public function create_new(Request $request)
    {
        try{
            $user = new Admin();
            $nuser = Auth::user();
            //$user = Admin::where('id', $request->id)->first();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $currentuser = Auth::user();
            if ($currentuser->role_id == 2) {
                if ($currentuser->amount < $request->credit) {
                    return response()->json(['status' => 'failed', 'msg' => 'Not enough credit']);
                }
                $currentuser->amount = $currentuser->amount - $request->credit;
                $currentuser->save();
            }
            $user->amount = $request->credit;
            if ($request->credit > 0) {
                $newtrans = new transaction();
                $newtrans->fromname = $currentuser->name;
                $newtrans->toname = $user->name;
                $newtrans->amount = $request->credit;
                $newtrans->status = "Create and send";
                $newtrans->save();
            }
            $user->phoneno = $request->phoneno;
            if ( $request->role ==  "agent" ) {
                $user->role_id = 4;
            }
            $user->created_by = $nuser->name;
            $user->save();
            return response()->json(["status" => 'success']);
        } catch (\Exception $e) {
            return response()->json(["status" => "failed", "msg" => $e->getMessage()]);
        }
    }

    public function update_info(Request $request)
    {
        $user = Admin::where('id', $request->id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        //$user->amount = $request->credit;
        $user->save();
        return response()->json(["status" => 'success']);
    }

    public function master_delete(Request $request)
    {
        $user = Admin::where('id', $request->id)->first();
        $user->delete();
        return response()->json(["status" => 'success']);
    }
    public function delete(Request $request)
    {
        $user = Admin::where('id', $request->id)->first();
        $user->delete();
        return response()->json(["status" => 'success']);
    }

    public function startnumberbet(Request $request)
    {
        $nowslot = slotstate::get()->first();
        if ( $request->number < 37 ) {
            $changecol = 's' . $request->number;
        } else {
            switch ( $request->number ) {
                case 37:
                    $changecol = '1st';
                    break;
                case 38:
                    $changecol = '2nd';
                    break;
                case 39:
                    $changecol = '3rd';
                    break;
                case 40:
                    $changecol = 'f118';
                    break;
                case 41:
                    $changecol = 'even';
                    break;
                case 42:
                    $changecol = 'black';
                    break;
                case 43:
                    $changecol = 'red';
                    break;
                case 44:
                    $changecol = 'odd';
                    break;
                case 45:
                    $changecol = 'f1936';
                    break;
            }
        }
        $val = $nowslot->value($changecol);
        $val[0] = '1';
//        $nowslot->value('s'.$changecol) = $val;
//        $nowslot.save();
        DB::table('slotstates')
            ->where('id','>', 0)
            ->update(array($changecol => $val));
//        DB::table('slotstates')
//            ->where('id', 1)
//            ->update(array('s'.$request->number => true));
        return response()->json(["status" => 'success']);
    }

    public function stopnumberbet(Request $request)
    {
        $nowslot = slotstate::get()->first();
        if ( $request->number < 37 ) {
            $changecol = 's' . $request->number;
        } else {
            switch ( $request->number ) {
                case 37:
                    $changecol = '1st';
                    break;
                case 38:
                    $changecol = '2nd';
                    break;
                case 39:
                    $changecol = '3rd';
                    break;
                case 40:
                    $changecol = 'f118';
                    break;
                case 41:
                    $changecol = 'even';
                    break;
                case 42:
                    $changecol = 'black';
                    break;
                case 43:
                    $changecol = 'red';
                    break;
                case 44:
                    $changecol = 'odd';
                    break;
                case 45:
                    $changecol = 'f1936';
                    break;
            }
        }
        $val = $nowslot->value($changecol);
        $val[0] = '0';
//        $nowslot->value('s'.$changecol) = $val;
//        $nowslot.save();
        DB::table('slotstates')
            ->where('id','>', 0)
            ->update(array($changecol => $val));
        return response()->json(["status" => 'success']);
    }

    public function betstatus()
    {
        try{
            $nowbet = round::get()->first();
            $round = $nowbet->created_at;
            $rname = $round->format('d-m-Y') . " ---- " . $nowbet->roundname . " ---- " . $round->format('H:i:s');
            $date1 = new DateTime("now");
            $round->add(new DateInterval('PT30M'));
            $diff = date_diff($date1, $round);
            if ( $diff->i == 1) {
                $remaintime = $diff->i . "minute " . $diff->s . "seconds";
            } else if ( $diff->i == 0) {
                $remaintime = $diff->s . "seconds";
            } else {
                $remaintime = $diff->i . "minutes " . $diff->s . "seconds";
            }
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
            return response()->json(["status" => 'success', 'data' => ['roundname' => $rname, 'totalbet' => $nowbet->totalbet, 'remaintime' => $remaintime, 'totalreceives' => $totalreceives, 'totalpayouts' => $totalpayouts]]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Request Error', 'data'=> $e, 'response_code' => 0], 200);
        }
    }

    public function trans_admin(Request $request)
    {
        $user = Auth::user();
        $user_role = Role::where('id', $user->role_id)->first();
        $searchName = $user->name;
        if ($request->has('name') && $request->input('name') != '') {
            $searchName = $request->input('name');
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
                if ($request->has('name') && $request->input('name') != '') {
                    $trans = transaction::whereBetween('created_at', [date($from), date($to)])->where(function ($query) use ($searchName) {
                        $query->where('fromname', '=', $searchName)
                            ->orWhere('toname', '=', $searchName);
                    })->get();
                } else {
                    $trans = transaction::whereBetween('created_at', [date($from), date($to)])->get();
                }
            } catch(\Exception $e) {
                $trans = transaction::all();
            }
        } else {
            if ($request->has('name') && $request->input('name') != '') {
                $trans = transaction::where(function ($query) use ($searchName) {
                    $query->where('fromname', '=', $searchName)
                        ->orWhere('toname', '=', $searchName);
                })->get();
            } else {
                $trans = transaction::all();
            }
        }
        $receive = 0;
        foreach ($trans as $tran) {
            if ($tran['fromname'] == $searchName) {
                $receive = $receive + $tran->amount;
            }
        }
        $current = $user->amount;
        if ($request->has('name') && $request->input('name') != '') {
            $curuser = Admin::where('name', $request->input('name'))->get()->first();
            $current = $curuser->amount;
        }
        return view('admin.transhistory', ['create_new' => 'false', 'user_role' => $user_role['role'], 'trans' => $trans, 'receive' => $receive, 'current' => $current]);
    }

    public function trans(Request $request)
    {
        $user = Auth::user();
        $user_role = Role::where('id', $user->role_id)->first();
        $searchName = $user->name;
        if ($request->has('name') && $request->input('name') != '') {
            $searchName = $request->input('name');
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
                if ($request->has('name') && $request->input('name') != '') {
                    $trans = transaction::whereBetween('created_at', [date($from), date($to)])->where(function ($query) use ($searchName) {
                        $query->where('fromname', '=', $searchName)
                            ->orWhere('toname', '=', $searchName);
                    })->where(function ($query) use ($user) {
                        $query->where('fromname', '=', $user->name)
                            ->orWhere('toname', '=', $user->name);
                    })->get();
                } else {
                    $trans = transaction::whereBetween('created_at', [date($from), date($to)])->where(function ($query) use ($user) {
                        $query->where('fromname', '=', $user->name)
                            ->orWhere('toname', '=', $user->name);
                    })->get();
                }
            } catch(\Exception $e) {
                $trans = transaction::where(function ($query) use ($user) {
                    $query->where('fromname', '=', $user->name)
                        ->orWhere('toname', '=', $user->name);
                })->get();
            }
        } else {
            if ($request->has('name') && $request->input('name') != '') {
                $trans = transaction::where(function ($query) use ($user) {
                    $query->where('fromname', '=', $user->name)
                        ->orWhere('toname', '=', $user->name);
                })->where(function ($query) use ($searchName) {
                    $query->where('fromname', '=', $searchName)
                        ->orWhere('toname', '=', $searchName);
                })->get();
            } else {
                $trans = transaction::where(function ($query) use ($user) {
                    $query->where('fromname', '=', $user->name)
                        ->orWhere('toname', '=', $user->name);
                })->get();
            }
        }
        $receive = 0;
        foreach ($trans as $tran) {
            if ($tran['fromname'] == $searchName) {
                $receive = $receive + $tran->amount;
            }
        }
        $current = $user->amount;
        if ($request->has('name') && $request->input('name') != '') {
            $curuser = Admin::where('name', $request->input('name'))->get()->first();
            $current = $curuser->amount;
        }
        return view('admin.transhistory', ['create_new' => 'false', 'user_role' => $user_role['role'], 'trans' => $trans, 'receive' => $receive, 'current' => $current]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
