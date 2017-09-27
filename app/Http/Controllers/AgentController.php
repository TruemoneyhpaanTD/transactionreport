<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use DB;
use Auth;
use App\Agent;
use Excel;

class AgentController extends Controller
{
	public function __construct() 
	{
		$this->middleware('auth');
	}

    public function index()
    {

    	  $user = DB::table('users')
                ->join('agent','agent.user_id','=','users.users_id')
                ->join('agentcard','agent.agent_id','=','agentcard.agent_id')
                ->where('agent.agent_id',Auth::user()->agent_id)
                ->first();

        return view('backend.agent.index')->with('user', $user);

    }

    public function transaction(Request $request)
    {
      	$user = Session('user');
        if ($request->ajax()) {
          
           
         $transactionlog = DB::table('transactionlog')
              ->leftjoin('agent_commission','agent_commission.transactionlog_id','=','transactionlog.transactionlog_id')
              ->leftjoin('agentcard','agentcard.agentcard_ref','=','transactionlog.agent_card_ref')
              ->leftjoin('activities','activities.activities_ref','=','transactionlog.activities_ref')
              ->where('agentcard.factory_cardno',$user->factory_cardno)
              ->select([
                  
                    "transactionlog.transactionlog_datetime as transaction_date",
                    "activities.activities as description",
                    "transactionlog.mobile as mobile_no",
                    "transactionlog.fee_charges as fee",
                    DB::raw('(case when transactionlog.pre_agent_card_balance is null then 0 else transactionlog.pre_agent_card_balance end) AS pre_balance'),
                    DB::raw('(case when transactionlog.agent_card_balance is null then 0 else transactionlog.agent_card_balance end) AS post_balance'),
                    DB::raw('(case when transactionlog.amount is null then 0 else transactionlog.amount end) AS amount'),
                    DB::raw('(case when agent_commission.commission is null then 0 else agent_commission.commission end) AS commission'),

              ]);
           
            $transactionlog->whereDate('transactionlog.transactionlog_datetime', '>=', "{$request->get('start_date')}");
            $transactionlog->whereDate('transactionlog.transactionlog_datetime', '<=', "{$request->get('end_date')}");

            $result = DB::table('transactionlog')
            			->join(DB::raw("(select agent_commission.transactionlog_id,agent_commission.commission,agent_commission.agent_commission_id,agent_commission.date,agent_commission.remark,agent_commission.activities_ref,agent_commission.agentcard_ref,agent_commission.member_transactionlog_id from agent_commission left join transactionlog on agent_commission.transactionlog_id=transactionlog.transactionlog_id
            				where transactionlog.transaction_status='SUCCESSFUL') as acom"),function($join){
            				$join->on('acom.transactionlog_id','=','transactionlog.transactionlog_id');})
            			->join('agentcard',function($join){
            				$join->on('agentcard.agentcard_ref','=','transactionlog.master_agent_card_ref');					 
            			})
                  ->join('activities','activities.activities_ref','=','transactionlog.activities_ref')
            			->where('agentcard.factory_cardno',$user->factory_cardno)
            			->select([
            							"transactionlog.transactionlog_datetime as transaction_date",
                          "activities.activities as description",
            							"transactionlog.mobile as mobile_no",
            							"transactionlog.fee_charges as fee",
                          DB::raw('(case when transactionlog.pre_master_agent_card_balance is null then 0 else transactionlog.pre_master_agent_card_balance end) As pre_balance'),
            							DB::raw('(case when transactionlog.master_agent_card_balance is null then 0 else transactionlog.master_agent_card_balance end) AS post_balance'),
            							DB::raw('(case when transactionlog.amount is null then 0 else transactionlog.amount end) AS amount'),
                          DB::raw('(case when acom.commission is null then 0 else acom.commission end) AS commission'),
            							]);

        			$result->whereDate('transactionlog.transactionlog_datetime','>=',"{$request->get('start_date')}");
        			$result->whereDate('transactionlog.transactionlog_datetime','<=',"{$request->get('end_date')}");
  		
  		    $member_transaction = DB::table('member_transactionlog')
                ->leftjoin('agent_commission','agent_commission.member_transactionlog_id','=','member_transactionlog.member_transactionlog_id')
                ->leftjoin('agentcard','agentcard.agentcard_ref','=','member_transactionlog.agent_card_ref')
                ->leftjoin('activities','activities.activities_ref','=','member_transactionlog.activities_ref')
                ->where('agentcard.factory_cardno',$user->factory_cardno)
                ->select([
                      "member_transactionlog.transactionlog_datetime as transaction_date",
                      "member_transactionlog.activities_ref as description",
                      "member_transactionlog.mobile as mobile_no",
                      "member_transactionlog.fee_charges as fee",
                      DB::raw('(case when member_transactionlog.pre_agent_card_balance is null then 0 else member_transactionlog.pre_agent_card_balance end) AS pre_balance'),
                      DB::raw('(case when member_transactionlog.post_agent_card_balance is null then 0 else member_transactionlog.post_agent_card_balance end) AS post_balance'),
                      DB::raw('(case when member_transactionlog.amount is null then 0 else member_transactionlog.amount end) As amount'),
                      DB::raw('(case when agent_commission.commission is null then 0 else agent_commission.commission end) AS commission'),
                  ]);
            $member_transaction->whereDate('member_transactionlog.transactionlog_datetime', '>=', "{$request->get('start_date')}");
            $member_transaction->whereDate('member_transactionlog.transactionlog_datetime', '<=', "{$request->get('end_date')}");


    		$member_transaction = $member_transaction->union($result)->union($transactionlog);


 
           
            

            return Datatables::of($member_transaction)->make(true);
          }
     
    }

        public function exportExcel(Request $request)

        {

            
            $user = Session('user');
            
            $transactionlog = Agent::leftjoin('transactionlog','transactionlog.agent_card_ref','=','agentcard.agentcard_ref')
                      ->leftjoin('agent_commission','agent_commission.transactionlog_id','=','transactionlog.transactionlog_id')
                      ->leftjoin('activities','activities.activities_ref','=','transactionlog.activities_ref')
                      ->where('agentcard.factory_cardno',$user->factory_cardno)
                      ->select([
                    "transactionlog.transactionlog_datetime as transaction_date",
                    "activities.activities as description",
                    "transactionlog.mobile as mobile_no",
                    
                    DB::raw('(case when transactionlog.pre_agent_card_balance is null then 0 else transactionlog.pre_agent_card_balance end) AS pre_balance'),
                    DB::raw('(case when transactionlog.agent_card_balance is null then 0 else transactionlog.agent_card_balance end) AS post_balance'),
                    DB::raw('(case when transactionlog.amount is null then 0 else transactionlog.amount end) AS amount'),
                    DB::raw('(case when agent_commission.commission is null then 0 else agent_commission.commission end) AS commission'),
                   "transactionlog.fee_charges as fee",

              ]);

            $transactionlog->whereDate('transactionlog.transactionlog_datetime', '>=', "{$request->get('start')}");
            $transactionlog->whereDate('transactionlog.transactionlog_datetime', '<=', "{$request->get('end')}");
           
             // $result = DB::table('transactionlog')
             //            ->join(DB::raw("(select agent_commission.transactionlog_id,agent_commission.commission,agent_commission.agent_commission_id,agent_commission.date,agent_commission.remark,agent_commission.activities_ref,agent_commission.agentcard_ref,agent_commission.member_transactionlog_id from agent_commission left join transactionlog on agent_commission.transactionlog_id=transactionlog.transactionlog_id
             //                where transactionlog.transaction_status='SUCCESSFUL') as acom"),function($join){
             //                $join->on('acom.transactionlog_id','=','transactionlog.transactionlog_id');})
             //            ->join('agentcard',function($join){
             //                $join->on('agentcard.agentcard_ref','=','transactionlog.master_agent_card_ref');                     
             //            })
             //            ->where('agentcard.factory_cardno',$user->factory_cardno)
             //            ->select([
             //                            "transactionlog.transactionlog_datetime as transaction_date",
             //                            "transactionlog.activities_ref as description",
             //                            "transactionlog.mobile as mobile_no",
             //                            DB::raw('(case when transactionlog.pre_master_agent_card_balance is null then 0 else transactionlog.pre_master_agent_card_balance end) As pre_balance'),
             //                            DB::raw('(case when transactionlog.master_agent_card_balance is null then 0 else transactionlog.master_agent_card_balance end) AS post_balance'),
             //                            DB::raw('(case when transactionlog.amount is null then 0 else transactionlog.amount end,case when acom.commission is null then 0 else acom.commission end ) AS commission'),
             //                            ]);

             //        $result->whereDate('transactionlog.transactionlog_datetime','>=',"{$request->get('start_date')}");
             //        $result->whereDate('transactionlog.transactionlog_datetime','<=',"{$request->get('end_date')}");




            $result = Agent::join('transactionlog','agentcard.agentcard_ref','=','transactionlog.master_agent_card_ref')
                         ->join(DB::raw("(select agent_commission.transactionlog_id,agent_commission.commission,agent_commission.agent_commission_id,agent_commission.date,agent_commission.remark,agent_commission.activities_ref,agent_commission.agentcard_ref,agent_commission.member_transactionlog_id from agent_commission left join transactionlog on agent_commission.transactionlog_id=transactionlog.transactionlog_id
                            where transactionlog.transaction_status='SUCCESSFUL') as acom"),function($join){
                            $join->on('acom.transactionlog_id','=','transactionlog.transactionlog_id');})                    
                        ->leftjoin('activities','activities.activities_ref','=','transactionlog.activities_ref')           
                        ->whereDate('transactionlog.transactionlog_datetime','>=',"{$request->get('start')}")
                        ->whereDate('transactionlog.transactionlog_datetime','<=',"{$request->get('end')}")
                        ->where('agentcard.factory_cardno',$user->factory_cardno)
                        ->select([
                          "transactionlog.transactionlog_datetime as transaction_date",
                          "activities.activities as description",
                          "transactionlog.mobile as mobile_no",
                         
                          DB::raw('(case when transactionlog.pre_master_agent_card_balance is null then 0 else transactionlog.pre_master_agent_card_balance end) As pre_balance'),
                          DB::raw('(case when transactionlog.master_agent_card_balance is null then 0 else transactionlog.master_agent_card_balance end) AS post_balance'),
                          DB::raw('(case when transactionlog.amount is null then 0 else transactionlog.amount end) AS amount'),
                          DB::raw('(case when acom.commission is null then 0 else acom.commission end) AS commission'),
                           "transactionlog.fee_charges as fee",
                          ]);

                        
        
        
      
        $member_transaction = Agent::leftjoin('member_transactionlog','member_transactionlog.agent_card_ref','=','agentcard.agentcard_ref')
                ->leftjoin('agent_commission','agent_commission.member_transactionlog_id','=','member_transactionlog.member_transactionlog_id')
                ->leftjoin('activities','activities.activities_ref','=','member_transactionlog.activities_ref')
                ->where('agentcard.factory_cardno',$user->factory_cardno)
                ->select([
                      "member_transactionlog.transactionlog_datetime as transaction_date",
                      "member_transactionlog.activities_ref as description",
                      "member_transactionlog.mobile as mobile_no",
                      
                      DB::raw('(case when member_transactionlog.pre_agent_card_balance is null then 0 else member_transactionlog.pre_agent_card_balance end) AS pre_balance'),
                      DB::raw('(case when member_transactionlog.post_agent_card_balance is null then 0 else member_transactionlog.post_agent_card_balance end) AS post_balance'),
                      DB::raw('(case when member_transactionlog.amount is null then 0 else member_transactionlog.amount end) As amount'),
                      DB::raw('(case when agent_commission.commission is null then 0 else agent_commission.commission end) AS commission'),
                  "member_transactionlog.fee_charges as fee",
                  ]);
            
            $member_transaction->whereDate('member_transactionlog.transactionlog_datetime', '>=', "{$request->get('start')}");
            $member_transaction->whereDate('member_transactionlog.transactionlog_datetime', '<=', "{$request->get('end')}");
            
            $member_transaction = $member_transaction->union($transactionlog)->union($result);
            
            $member_transaction = $member_transaction->union($result)->union($transactionlog)->get()->toArray();

                
            Excel::create('Merchant Transaction Report', function($excel) use($member_transaction) {

               $excel->sheet('Sheetname', function($sheet) use($member_transaction) {
                   $sheet->fromModel($member_transaction);
               });

            })->export('xls');

        }
 

}
