<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use App\Users;
class ProfileController extends Controller
{
  public function __construct() 
  {
    $this->middleware('auth');
  }

  public function getprofile()
  {

    $editdata = DB::table('agentcontract')
                  ->leftjoin('agentcard','agentcard.agentcard_ref','=','agentcontract.agentcard_ref')
                  ->leftjoin('agent','agent.agent_id','=','agentcard.agent_id')
                  ->leftjoin('users','users.users_id','=','agent.user_id')
                  ->leftjoin('terminal','terminal.terminal_ref','=','agentcontract.terminal_ref')
                  ->leftjoin('sim','sim.sim_serial_no','=','terminal.sim_serial_no')
                  ->leftjoin('agent_type','agent_type.agenttype_id','=','agentcard.agenttype_id')
                  ->where('agentcard.factory_cardno','=',Auth::user()->factory_cardno)
                  ->where('agentcontract.status','=','Active')
                  ->select('users.user_name As agent_name',
                        'agent.job_ref As short_name',
                        'users.user_nrc as nrc',
                        'users.township as township',
                        'users.mobileno1 as phone_no',
                        'users.address as address',
                        'agentcard.factory_cardno As AgentCard',
                        'agentcontract.terminal_ref as Terminal',
                        'terminal.app_version as Version',
                        'agentcontract.contract_activatation_date as start_date',
                        'agentcard.balance_amount as balance_amount',
                        'sim.phone_no as sim',
                        'sim.operator as operator',
                        'sim.expire_date as expire_date',
                        'sim.last_check_date as last_check_date',
                        'agent_type.description as description',
                        'sim.last_balance as last_balance','users.location')->first();
               

     // dd($editdata);
    
    if (!$editdata->location) {
      $editdata->location = "0, 0";
    }
    
    $user = DB::table('users')
                ->join('agent','agent.user_id','=','users.users_id')
                ->join('agentcard','agent.agent_id','=','agentcard.agent_id')
                ->where('agent.agent_id',Auth::user()->agent_id)
                ->first();

    return view('backend.profile.list', array(
      'editdata' => $editdata,
      'user' => $user
    ));   
  }

}
