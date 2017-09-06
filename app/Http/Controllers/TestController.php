<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Yajra\Datatables\Facades\Datatables;
use DB;
use Carbon\Carbon;
use Excel;
use App\Test;

class TestController extends Controller
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


    public function index(Request $request)
    { 

         $user = DB::table('users')
                ->join('agent','agent.user_id','=','users.users_id')
                ->join('agentcard','agent.agent_id','=','agentcard.agent_id')
                ->where('agent.agent_id',Auth::user()->agent_id)
                ->first();

        return view('backend.agent.test')->with('user', $user);


    }
    public function transaction(Request $request)
    {
      $user = Session('user');
        if ($request->ajax()) {
          
           
         $transactionlog = DB::table('transactionlog')
              ->leftjoin('agent_commission','agent_commission.transactionlog_id','=','transactionlog.transactionlog_id')
              ->leftjoin('agentcard','agentcard.agentcard_ref','=','transactionlog.agent_card_ref')
              ->where('agentcard.factory_cardno',$user->factory_cardno)
              ->select(
                  
                    "transactionlog.transactionlog_datetime as transaction_date",
                    "transactionlog.activities_ref as description",
                    "transactionlog.mobile as mobile_no",
                    DB::raw('(case when transactionlog.pre_agent_card_balance is null then 0 else transactionlog.pre_agent_card_balance end) AS pre_balance'),
                    DB::raw('(case when transactionlog.agent_card_balance is null then 0 else transactionlog.agent_card_balance end) AS post_balance'),
                    DB::raw('(case when transactionlog.amount is null then 0 else transactionlog.amount end,case when agent_commission.commission is null then 0 else agent_commission.commission end) AS commission')
                  

              );
           
            $transactionlog->whereDate('transactionlog.transactionlog_datetime', '>=', "{$request->get('start_date')}");
            $transactionlog->whereDate('transactionlog.transactionlog_datetime', '<=', "{$request->get('end_date')}");


          $member_transaction = DB::table('member_transactionlog')
                ->leftjoin('agent_commission','agent_commission.member_transactionlog_id','=','member_transactionlog.member_transactionlog_id')
                ->leftjoin('agentcard','agentcard.agentcard_ref','=','member_transactionlog.agent_card_ref')
                ->where('agentcard.factory_cardno',$user->factory_cardno)
                ->select([
                      "member_transactionlog.transactionlog_datetime as transaction_date",
                      "member_transactionlog.activities_ref as description",
                      "member_transactionlog.mobile as mobile_no",
                      DB::raw('(case when member_transactionlog.pre_agent_card_balance is null then 0 else member_transactionlog.pre_agent_card_balance end) AS pre_balance'),
                      DB::raw('(case when member_transactionlog.post_agent_card_balance is null then 0 else member_transactionlog.post_agent_card_balance end) AS post_balance'),
                      DB::raw('(case when member_transactionlog.amount is null then 0 else member_transactionlog.amount end,case when agent_commission.commission is null then 0 else agent_commission.commission end) AS commission')
                  ]);
            $member_transaction->whereDate('member_transactionlog.transactionlog_datetime', '>=', "2017-08-30");
            $member_transaction->whereDate('member_transactionlog.transactionlog_datetime', '<=', "2017-08-31");


    $member_transaction = $member_transaction->union($transactionlog);
                                  
               

            


           
            

            return Datatables::of($member_transaction)->make(true);
          }
     
    }

    

    
    public function exportExcel(Request $request)
  {
      $user =  Session('user');
      
      $transactionlog = DB::table('transactionlog')
              ->leftjoin('agent_commission','agent_commission.transactionlog_id','=','transactionlog.transactionlog_id')
              ->leftjoin('agentcard','agentcard.agentcard_ref','=','transactionlog.agent_card_ref')
              ->where('agentcard.factory_cardno',$user->factory_cardno)
              ->select(
                  
                    "transactionlog.transactionlog_datetime as transaction_date",
                    "transactionlog.activities_ref as description",
                    "transactionlog.mobile as mobile_no",
                    DB::raw('(case when transactionlog.pre_agent_card_balance is null then 0 else transactionlog.pre_agent_card_balance end) AS pre_balance'),
                    DB::raw('(case when transactionlog.agent_card_balance is null then 0 else transactionlog.agent_card_balance end) AS post_balance'),
                    DB::raw('(case when transactionlog.amount is null then 0 else transactionlog.amount end,case when agent_commission.commission is null then 0 else agent_commission.commission end) AS commission')
                  

              );
           
            $transactionlog->whereDate('transactionlog.transactionlog_datetime', '>=', "{$request->get('start_date')}");
            $transactionlog->whereDate('transactionlog.transactionlog_datetime', '<=', "{$request->get('end_date')}");


          $member_transaction = DB::table('member_transactionlog')
                ->leftjoin('agent_commission','agent_commission.member_transactionlog_id','=','member_transactionlog.member_transactionlog_id')
                ->leftjoin('agentcard','agentcard.agentcard_ref','=','member_transactionlog.agent_card_ref')
                ->where('agentcard.factory_cardno',$user->factory_cardno)
                ->select([
                      "member_transactionlog.transactionlog_datetime as transaction_date",
                      "member_transactionlog.activities_ref as description",
                      "member_transactionlog.mobile as mobile_no",
                      DB::raw('(case when member_transactionlog.pre_agent_card_balance is null then 0 else member_transactionlog.pre_agent_card_balance end) AS pre_balance'),
                      DB::raw('(case when member_transactionlog.post_agent_card_balance is null then 0 else member_transactionlog.post_agent_card_balance end) AS post_balance'),
                      DB::raw('(case when member_transactionlog.amount is null then 0 else member_transactionlog.amount end,case when agent_commission.commission is null then 0 else agent_commission.commission end) AS commission')
                  ]);
            $member_transaction->whereDate('member_transactionlog.transactionlog_datetime', '>=', "2017-08-30");
            $member_transaction->whereDate('member_transactionlog.transactionlog_datetime', '<=', "2017-08-31");


 $member_transaction = $member_transaction->union($transactionlog);

        $member_transaction = $member_transaction->get()->toArray();
        
      Excel::create('Merchant Transaction Report', function($excel) use($member_transaction) {

         $excel->sheet('Sheetname', function($sheet) use($member_transaction) {
             $sheet->fromModel($member_transaction);
         });

      })->export('xls');
  }

 

    

}
