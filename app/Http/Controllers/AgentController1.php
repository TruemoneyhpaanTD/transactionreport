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

    public function index(Request $request)
    {
    	$user = Session('user');
    	
    	if ($request->ajax()) {

			$agents = DB::table('transactionlog')
						->leftjoin('agentcard','transactionlog.agent_card_ref','=','agentcard.agentcard_ref')
						->leftjoin('topup','transactionlog.transactionlog_id','=','topup.transactionlog_id')
						->leftjoin('agent_commission','transactionlog.transactionlog_id','=','agent_commission.transactionlog_id')
						->leftjoin('cnp_payment','transactionlog.transactionlog_id','=','cnp_payment.transactionlog_id')
						->leftjoin('terminal','transactionlog.terminal_ref','=','terminal.terminal_ref')
						->leftjoin('agent','agentcard.agent_id','=','agent.agent_id')
						->leftjoin('activities','transactionlog.activities_ref','=','activities.activities_ref')
						->join('users','users.users_id','=','agent.user_id')
						->orderBy('transactionlog.transactionlog_datetime', 'desc')
						->where("agentcard.factory_cardno", $user->factory_cardno)
						->select([
							"transactionlog.transactionlog_datetime as transaction_date",
							"activities.activities as description",
							"topup.phone_no as mobile_no",
							DB::raw("to_char(transactionlog.pre_agent_card_balance,'99,999,999,999,999,990') as pre_balance"),
							DB::raw("to_char(transactionlog.agent_card_balance,'99,999,999,999,999,990') as post_balance"),
							DB::raw("to_char(transactionlog.amount,'99,999,999,999,999,990') as sale_amount"),
							DB::raw("CONCAT('(',(agent_commission.commission),')') as commission"),
							"transactionlog.transaction_status as status"
							]);
    		return Datatables::of($agents)
			       ->filter(function ($query) use ($request) {
	                if ($request->has('start_date')) {
	                    $query->whereDate('transactionlog.transactionlog_datetime', '>=', "{$request->get('start_date')}");
	                }
	                if ($request->has('end_date')) {
	                    $query->whereDate('transactionlog.transactionlog_datetime','<=', "{$request->get('end_date')}");
	                }

	          	})
			       
    		->make(true);

        }
    	return view('backend.agent.index', array(
		      
		      'user' => $user
		    ));  

    }

    public function exportExcel(Request $request)
	{
			$user =  Session('user');
			
			$data = Agent::leftjoin('agentcard','transactionlog.agent_card_ref','=','agentcard.agentcard_ref')
						->leftjoin('topup','transactionlog.transactionlog_id','=','topup.transactionlog_id')
						->leftjoin('agent_commission','transactionlog.transactionlog_id','=','agent_commission.transactionlog_id')
						->leftjoin('cnp_payment','transactionlog.transactionlog_id','=','cnp_payment.transactionlog_id')
						->leftjoin('terminal','transactionlog.terminal_ref','=','terminal.terminal_ref')
						->leftjoin('agent','agentcard.agent_id','=','agent.agent_id')
						->leftjoin('activities','transactionlog.activities_ref','=','activities.activities_ref')
						->join('users','users.users_id','=','agent.user_id')
						->orderBy('transactionlog.transactionlog_datetime', 'desc')
						->where("agentcard.factory_cardno", $user->factory_cardno)
						->select([
							"transactionlog.transactionlog_datetime as transaction_date",
							"activities.activities as description",
							"topup.phone_no as mobile_no",
							DB::raw("to_char(transactionlog.pre_agent_card_balance,'99,999,999,999,999,990') as pre_balance"),
							DB::raw("to_char(transactionlog.agent_card_balance,'99,999,999,999,999,990') as post_balance"),
							DB::raw("to_char(transactionlog.amount,'99,999,999,999,999,990') as sale_amount"),
							DB::raw("CONCAT('(',(agent_commission.commission),')') as commission"),
							"transactionlog.transaction_status as status"
							]);

		    if ($request->has('start_date')) {
		        $data->whereDate('transactionlog.transactionlog_datetime', '>=', "{$request->input('start_date')}");
		    }
		    if ($request->has('end_date')) {
		        $data->whereDate('transactionlog.transactionlog_datetime','<=', "{$request->input('end_date')}");
		    }

		    $data = $data->get()->toArray();
				
			Excel::create('Merchant Transaction Report', function($excel) use($data) {

			   $excel->sheet('Sheetname', function($sheet) use($data) {
			       $sheet->fromModel($data);
			   });

			})->export('xls');
	}

}
