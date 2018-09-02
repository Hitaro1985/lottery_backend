<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\slotstate;
use App\transaction;
use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Role;
use App\Admin;
use App\User;
use Illuminate\Support\Facades\DB;

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
        if ($user->role_id == 0) {
            $user->role_id = 2;
        }
        else {
            $user->role_id = 0;
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
            if ($admin->amount < $request->amount) {
                return response()->json(['status' => 'failed', 'errMsg' => 'Not Enough Money']);
            }
            $admin->amount = $admin->amount - $request->amount;
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
        $user = User::where('id', $request->id)->first();
        if ($user->accept == 0) {
            $user->accept = 1;
        }
        else {
            $user->accept = 0;
        }
        $response = array(
            'updated_at' => $user->updated_at,
        );
        $user->save();
        return response()->json($response);
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
        DB::table('slotstates')
            ->where('id', 1)
            ->update(array('s'.$request->number => true));
        return response()->json(["status" => 'success']);
    }

    public function stopnumberbet(Request $request)
    {
        //slotstate::get()->first()->update(['s0' => false]);
        DB::table('slotstates')
            ->where('id', 1)
            ->update(array('s'.$request->number => false));
//        $slotstate = slotstate::get()->first();
//        $slotstate->s0 = false;
//        $slotstate->save();
        return response()->json(["status" => 'success']);
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
