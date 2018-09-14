<?php

namespace App\Http\Controllers\admin;

use App\roundlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Role;

class ResultController extends Controller
{
    //

    public function index(Request $request)
    {
        $user = Auth::user();
        $user_role = Role::where('id', $user->role_id)->first();
        $query = array();
        if ($request->has('searchround') && $request->input('searchround') != '') {
            $round = $request->input('searchround');
            $query['name'] = $round;
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
                $rounds = roundlist::where($query)->whereBetween('created_at', [date($from), date($to)])->get();
            } catch(\Exception $e) {
                $rounds = roundlist::where($query)->get();
            }
        } else {
            $rounds = roundlist::where($query)->get();
        }
        return view('admin.result', ['create_new' => 'false', 'user_role' => $user_role['role'], 'rounds' => $rounds]);
    }
}
