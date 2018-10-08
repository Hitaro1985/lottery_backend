<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\jackhistory;
use App\jackpot;
use App\majorjackpot;
use App\Role;
use App\transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DateTime;
use Illuminate\Support\Facades\Input;

class JackpotController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        $user_role = Role::where('id', $user->role_id)->first();
        return view('admin.jackpotmanage', ['create_new' => 'false', 'user_role' => $user_role['role'], 'user_name' => $user->name]);
    }

    public function getAgents()
    {
        $admins = Admin::where('role_id', '!=', 1)->pluck('name');
        return response()->json(['admins' => $admins], 200);
    }

    public function getJack()
    {
        $jack = jackpot::get()->last();
        $mjack = majorjackpot::get()->last();
        return response()->json(['jack' => $jack->credit, 'mjack' => $mjack->credit], 200);
    }

    public function release(Request $request)
    {
        try {
            $jack = jackpot::get()->last();
            $amount = floor($jack->credit);
            //-----new jack history save-----
            $newjhis = new jackhistory();
            $newjhis->credit = $amount;
            $newjhis->agent = $request->name;
            $date = date("Y-m-d H:i:s");
            $newjhis->assign_time = $date;
            $newjhis->jacks = "small jack";
            $newjhis->save();

            $jack->credit = $jack->credit - $amount;
            $jack->save();
            $user = Admin::where('name', $request->name)->get()->first();
            $user->amount = $user->amount + $amount;
            $user->save();
            $newtrans = new transaction();
            $newtrans->fromname = "Tony";
            $newtrans->toname = $user->name;
            $newtrans->amount = $amount;
            $newtrans->status = "small jackpot gift";
            $newtrans->save();
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed', 'msg' => $e->getMessage()], 200);
        }
    }

    public function releaseMajor(Request $request)
    {
        try {
            $mjack = majorjackpot::get()->last();
            $amount = floor($mjack->credit);
            //-----new jack history save-----
            $newjhis = new jackhistory();
            $newjhis->credit = $amount;
            $newjhis->agent = $request->name;
            $date = date("Y-m-d H:i:s");
            $newjhis->assign_time = $date;
            $newjhis->jacks = "major jack";
            $newjhis->save();

            $mjack->credit = 2000 + ($mjack->credit - $amount);
            $mjack->save();
            $user = Admin::where('name', $request->name)->get()->first();
            $user->amount = $user->amount + $amount;
            $user->save();
            $newtrans = new transaction();
            $newtrans->fromname = "Tony";
            $newtrans->toname = $user->name;
            $newtrans->amount = $amount;
            $newtrans->status = "major jackpot gift";
            $newtrans->save();
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed', 'msg' => $e->getMessage()], 200);
        }
    }
}
