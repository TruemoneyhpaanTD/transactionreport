<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use Yajra\Datatables\Facades\Datatables;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = DB::table('users')
                    ->join('agent','agent.user_id','=','users.users_id')
                    ->join('agentcard','agent.agent_id','=','agentcard.agent_id')
                    ->where('agent.agent_id',Auth::user()->agent_id)
                    ->first();
        return view('backend.dashboard.home',compact('user'));
    }

    public function transaction(Request $request)
    {
        

        if ($request->ajax()) {

        $all_transaction = DB::table('transactionlog')->join('agentcard', 'transactionlog.agent_card_ref','=','agentcard.agentcard_ref')
            ->select(['transactionlog.transactionlog_datetime as Date', 'transactionlog.transactionlog_id as TransactionID', 'agentcard.factory_cardno as AgentCardNo', 'transactionlog.transaction_status as Status', 'transactionlog.activities_ref as Details']);
            return Datatables::of($all_transaction)->make(true);
            }
     
    }

    public function dashboard_trans()
    {
        // $all_transcount = DB::table('transactionlog')->join('agentcard', 'transactionlog.agent_card_ref','=','agentcard.agentcard_ref')
        //                 ->count();

        //                 select count(*) from transactionlog

        $all_transcount = DB::table('transactionlog')->count();
        

        $pending_trans = DB::table('transactionlog')
                ->where('transaction_status', 'like', '%SUCCESS%')
                ->where('transaction_status', 'like', '%FAIL%')
                ->count();


        $success_trans = DB::table('transactionlog')
                        ->where('transaction_status', 'like', '%SUCCESS%')
                        ->count();

        $fail_trans = DB::table('transactionlog')
                        ->where('transaction_status', 'like', '%FAIL%')
                        ->count();

      return response()->json([
            'all_transcount' => $all_transcount,
            'success_trans' => $success_trans,
            'pending_trans' => $pending_trans,      
            'fail_trans' => $fail_trans
        ]);
    }

   

}
