<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\jackpot;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

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
        return response()->json(['jack' => $jack->credit], 200);
    }

    public function release(Request $request)
    {
        try {
            $jack = jackpot::get()->last();
            $amount = $jack->credit;
            $newjack = new jackpot();
            $newjack->save();
            $jack->credit = $amount;
            $jack->agent = $request->name;
            $jack->save();
            $user = Admin::where('name', $request->name)->get()->first();
            $user->amount = $user->amount + $amount;
            $user->save();
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed', 'msg' => $e->getMessage()], 200);
        }
    }
}
