<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\round;
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
    public function index()
    {
        $user = Auth::user();
        $user_role = Role::where('id', $user->role_id)->first();
        $all_users = Admin::leftJoin('roles', function($join) {
            $join->on('admins.role_id', '=', 'roles.id');
        })->where('admins.role_id', '=', 2)->get([
            'admins.*',
            'roles.role'
        ]);
        return view('admin.magentmanage', ['user_role' => $user_role['role'], 'user_name' => $user->name, 'all_users' => $all_users]);
    }

    public function agentmanage()
    {
        $user = Auth::user();
        $user_role = Role::where('id', $user->role_id)->first();
        $all_users = Admin::leftJoin('roles', function($join) {
            $join->on('admins.role_id', '=', 'roles.id');
        })->where('admins.role_id', '=', 3)->get([
            'admins.*',
            'roles.role'
        ]);
        return view('admin.agentmanage', ['user_role' => $user_role['role'], 'user_name' => $user->name, 'all_users' => $all_users]);
    }

    public function view_credit()
    {
        $user = Auth::user();
        $user_role = Role::where('id', $user->role_id)->first();

        $current_user = User::where('id', $user->id)->first();
        return view('admin.credit', ['user_role' => $user_role['role'], 'current_user'=>$user]);
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
        $user = Admin::where('id', $request->id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->amount = $request->amount;
        $user->save();
        return response()->json(["status" => 'success']);
    }

    public function master_create_new(Request $request)
    {
        try{
            $user = new Admin();
            //$user = Admin::where('id', $request->id)->first();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->amount = 0;
            $user->phoneno = $request->phoneno;
            $user->role_id = 2;
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
            //$user = Admin::where('id', $request->id)->first();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->amount = 0;
            $user->phoneno = $request->phoneno;
            $user->role_id = 3;
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
        $user->amount = $request->credit;
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

    public function trans_admin()
    {
        $user = Auth::user();
        $user_role = Role::where('id', $user->role_id)->first();
        $trans = transaction::all();
        return view('admin.transhistory', ['user_role' => $user_role['role'], 'trans' => $trans]);
    }

    public function trans()
    {
        $user = Auth::user();
        $user_role = Role::where('id', $user->role_id)->first();
        $trans = transaction::where(function ($query) use ($user) {
            $query->where('fromname', '=', $user->name)
                ->orWhere('toname', '=', $user->name);
        })->get();
        return view('admin.transhistory', ['user_role' => $user_role['role'], 'trans' => $trans]);
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
