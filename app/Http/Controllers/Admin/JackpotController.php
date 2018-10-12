<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\betlist;
use App\jackhistory;
use App\jackpot;
use App\majorjackpot;
use App\Role;
use App\round;
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

    public function getReceipts(Request $request)
    {
        $admins = Admin::where('role_id', '!=', 1)->pluck('name');
        $receipts = betlist::where('name', $request->name)->pluck('receipts');
        return response()->json(['receipts' => $receipts], 200);
    }

    public function getJack()
    {
        $jack = jackpot::get()->last();
        $mjack = majorjackpot::get()->last();
        return response()->json(['jack' => $jack->credit, 'mjack' => $mjack->credit], 200);
    }

    public function release(Request $request)
    {
//        if ($request->receipt == null) {
//            return response()->json(['status' => 'failed', 'request22222' => $request->receipt], 200);
//        } else {
//            return response()->json(['status' => 'failed', 'request11111' => $request->receipt], 200);
//        }
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

            $nround = round::get()->first();

            $user = Admin::where('name', $request->name)->get()->first();

            $lastbet = betlist::where('name', $user->name)->orderBy('receipts', 'desc')->get()->first();
            $roundInt = intval(str_replace("Round", "", $nround->roundname));
            $lastjack = jackhistory::where('agent', $user->name)->orderBy('receipts', 'desc')->get()->first();
            if (!$lastbet && !$lastjack) {
                $newjhis->receipts = 100000000;
                $newjhis->receiptNumber = 1;
            } else {
                if ( !$lastbet ) {
                    if ($request->receipt == null) {
                        $newjhis->receipts = $lastjack->receipts + 1;
                    } else {
                        $newjhis->receipts = $request->receipt;
                    }
                    $newjhis->receiptNumber = $lastjack->receiptNumber + 1;
                } else if (!$lastjack ) {
                    if ($request->receipt == null) {
                        $newjhis->receipts = $lastbet->receipts + 1;
                    } else {
                        $newjhis->receipts = $request->receipt;
                    }
                    $newjhis->receiptNumber = $lastbet->receiptNumber + 1;
                } else {
                    if ( $lastbet->receipts > $lastjack->receipts ) {
                        if ($request->receipt == null) {
                            $newjhis->receipts = $lastbet->receipts + 1;
                        } else {
                            $newjhis->receipts = $request->receipt;
                        }
                        $newjhis->receiptNumber = $lastbet->receiptNumber + 1;
                    } else {
                        if ($request->receipt == null) {
                            $newjhis->receipts = $lastjack->receipts + 1;
                        } else {
                            $newjhis->receipts = $request->receipt;
                        }
                        $newjhis->receiptNumber = $lastjack->receiptNumber + 1;
                    }
                }
            }

            $newjhis->round = $roundInt;
            $newjhis->save();

            $jack->credit = $jack->credit - $amount;
            $jack->save();
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

            $nround = round::get()->first();

            $user = Admin::where('name', $request->name)->get()->first();


            $lastbet = betlist::where('name', $user->name)->orderBy('receipts', 'desc')->get()->first();
            $roundInt = intval(str_replace("Round", "", $nround->roundname));
            $lastjack = jackhistory::where('agent', $user->name)->orderBy('receipts', 'desc')->get()->first();
            if (!$lastbet && !$lastjack) {
                $newjhis->receipts = 100000000;
                $newjhis->receiptNumber = 1;
            } else {
                if ( !$lastbet ) {
                    if ($request->receipt == null) {
                        $newjhis->receipts = $lastjack->receipts + 1;
                    } else {
                        $newjhis->receipts = $request->receipt;
                    }
                    $newjhis->receiptNumber = $lastjack->receiptNumber + 1;
                } else if (!$lastjack ) {
                    if ($request->receipt == null) {
                        $newjhis->receipts = $lastbet->receipts + 1;
                    } else {
                        $newjhis->receipts = $request->receipt;
                    }
                    $newjhis->receiptNumber = $lastbet->receiptNumber + 1;
                } else {
                    if ( $lastbet->receipts > $lastjack->receipts ) {
                        if ($request->receipt == null) {
                            $newjhis->receipts = $lastbet->receipts + 1;
                        } else {
                            $newjhis->receipts = $request->receipt;
                        }
                        $newjhis->receiptNumber = $lastbet->receiptNumber + 1;
                    } else {
                        if ($request->receipt == null) {
                            $newjhis->receipts = $lastjack->receipts + 1;
                        } else {
                            $newjhis->receipts = $request->receipt;
                        }
                        $newjhis->receiptNumber = $lastjack->receiptNumber + 1;
                    }
                }
            }

            $newjhis->round = $roundInt;
            $newjhis->save();

            $mjack->credit = 2000 + ($mjack->credit - $amount);
            $mjack->save();
            $user->amount = $user->amount + $amount;
            $user->save();
            $newtrans = new transaction();
            $newtrans->fromname = "Tony";
            $newtrans->toname = $user->name;
            $newtrans->amount = $amount;
            $newtrans->status = "major jackpot gift";
            $newtrans->save();
            return response()->json(['status' => 'success', 'lastjack'=>$lastjack, 'lastbet'=>$lastbet], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed', 'msg' => $e->getMessage()], 200);
        }
    }
}
