<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Yajra\Datatables\Facades\Datatables;
use DB;

class CustomerController extends Controller
{
    public function index(Request $request)
    {

    	if ($request->ajax()) {

			// $start = '2015-08-21';
			// $end = '2015-08-21';

			$start = $request->get('start');
			$end = $request->get('end');

    		$customers = DB::table('transactionlog')
							->leftjoin('agentcard','transactionlog.agent_card_ref','=','agentcard.agentcard_ref')
							->leftjoin('topup','transactionlog.transactionlog_id','=','topup.transactionlog_id')
							->leftjoin('agent_commission','transactionlog.transactionlog_id','=','agent_commission.transactionlog_id')
							->leftjoin('cnp_payment','transactionlog.transactionlog_id','=','cnp_payment.transactionlog_id')
							->leftjoin('terminal','transactionlog.terminal_ref','=','terminal.terminal_ref')
							->leftjoin('agent','agentcard.agent_id','=','agent.agent_id')
							->join('users','users.users_id','=','agent.user_id')
							// ->where("agentcard.factory_cardno",'$agentCard')
              				->orderBy('transactionlog.transactionlog_datetime')
							->select([
								"transactionlog.trx",
								"transactionlog.transactionlog_datetime",
								DB::raw("(CASE WHEN transactionlog.activities_ref = 'CnP_Bill_Payment_C1' THEN cnp_payment.merchant_code ELSE transactionlog.activities_ref END) AS SaleActivities"),
								"topup.phone_no as TopupMobile",
								DB::raw("to_char(transactionlog.pre_agent_card_balance,'99,999,999,999,999,990') as PreBalance"),
								DB::raw("to_char(transactionlog.agent_card_balance,'99,999,999,999,999,990') as PostBalance"),
								DB::raw("to_char(transactionlog.amount,'99,999,999,999,999,990') as SaleAmount"),
								DB::raw("CONCAT('(',(agent_commission.commission),')') as agentcommission"),
								"transactionlog.transaction_status as Status",
								"agentcard.factory_cardno as AgentCard",
								"transactionlog.terminal_ref as Terminal",
								"terminal.app_version as Version",
								DB::raw("Case when cnp_payment.merchant_code = 'MPT Bill' then 'MPT Bill' when cnp_payment.merchant_code = 'YESC' then 'YESC Bill' when cnp_payment.merchant_code = 'YCDC' then 'YCDC Bill' end")
								]);

    		return Datatables::of($customers)
			    ->filter(function ($query) use ($request,$start,$end) {
                if ($request->get('start') != "") {
                	$query->whereDate('transactionlog.transactionlog_datetime','>=', $start);
                }
                if ($request->get('end') != "") {
                    $query->whereDate('transactionlog.transactionlog_datetime','<=', $end);
                }
          	})
    		->make(true);

        }
    	return view('backend.customer.list');

    }
}
