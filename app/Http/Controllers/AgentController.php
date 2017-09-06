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
            $member_transaction->whereDate('member_transactionlog.transactionlog_datetime', '>=', "{$request->get('start_date')}");
            $member_transaction->whereDate('member_transactionlog.transactionlog_datetime', '<=', "{$request->get('end_date')}");


    		$member_transaction = $member_transaction->union($transactionlog);
                                  
               

            


           
            

            return Datatables::of($member_transaction)->make(true);
          }
     
    }

 //    public function exportExcel(Request $request)
	// {
	// 		$user =  Session('user');
			
	// 		$data = Agent::leftjoin('agentcard','transactionlog.agent_card_ref','=','agentcard.agentcard_ref')
	// 					->leftjoin('topup','transactionlog.transactionlog_id','=','topup.transactionlog_id')
	// 					->leftjoin('agent_commission','transactionlog.transactionlog_id','=','agent_commission.transactionlog_id')
	// 					->leftjoin('cnp_payment','transactionlog.transactionlog_id','=','cnp_payment.transactionlog_id')
	// 					->leftjoin('terminal','transactionlog.terminal_ref','=','terminal.terminal_ref')
	// 					->leftjoin('agent','agentcard.agent_id','=','agent.agent_id')
	// 					->leftjoin('activities','transactionlog.activities_ref','=','activities.activities_ref')
	// 					->join('users','users.users_id','=','agent.user_id')
	// 					->orderBy('transactionlog.transactionlog_datetime', 'desc')
	// 					->where("agentcard.factory_cardno", $user->factory_cardno)
	// 					->select([
	// 						"transactionlog.transactionlog_datetime as transaction_date",
	// 						"activities.activities as description",
	// 						"topup.phone_no as mobile_no",
	// 						DB::raw("to_char(transactionlog.pre_agent_card_balance,'99,999,999,999,999,990') as pre_balance"),
	// 						DB::raw("to_char(transactionlog.agent_card_balance,'99,999,999,999,999,990') as post_balance"),
	// 						DB::raw("to_char(transactionlog.amount,'99,999,999,999,999,990') as sale_amount"),
	// 						DB::raw("CONCAT('(',(agent_commission.commission),')') as commission"),
	// 						"transactionlog.transaction_status as status"
	// 						]);

	// 	    if ($request->has('start_date')) {
	// 	        $data->whereDate('transactionlog.transactionlog_datetime', '>=', "{$request->input('start_date')}");
	// 	    }
	// 	    if ($request->has('end_date')) {
	// 	        $data->whereDate('transactionlog.transactionlog_datetime','<=', "{$request->input('end_date')}");
	// 	    }

	// 	    $data = $data->get()->toArray();
				
	// 		Excel::create('Merchant Transaction Report', function($excel) use($data) {

	// 		   $excel->sheet('Sheetname', function($sheet) use($data) {
	// 		       $sheet->fromModel($data);
	// 		   });

	// 		})->export('xls');
	// }

}
