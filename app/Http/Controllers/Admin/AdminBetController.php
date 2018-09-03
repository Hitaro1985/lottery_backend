<?php

namespace App\Http\Controllers\admin;

use App\roundlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Role;

class AdminBetController extends Controller
{
    public function index() {
        $user = Auth::user();
        $user_role = Role::where('id', $user->role_id)->first();
        $rounds = roundlist::all();
        return view("admin.betcontroller", ['user_role' => $user_role['role'], 'rounds' => $rounds]);
    }

    public function setresult(Request $request) {
        try {
            $bet = roundlist::where('id', $request->id)->first();
            $bet->rightNumber = $request->amount;
            $bet->save();
            return response()->json(['status' => 'success']);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'errMsg' => $e->getMessage()]);
        }
    }

    public function pay(Request $request) {
        try {
            return response()->json(['status' => 'success']);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'errMsg' => $e->getMessage()]);
        }
    }
}
