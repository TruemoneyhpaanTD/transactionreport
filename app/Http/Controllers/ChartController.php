<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class ChartController extends Controller
{
    public function __construct() 
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$mec_10000 = DB::table('mec_10000_topuppin')
						->where('status','=','Store')
						->count();
        
        $mec_5000 = DB::table('mec_5000_topuppin')
        				->where('status','=','Store')
						->count();

		$mec_3000 = DB::table('mec_3000_topuppin')
        				->where('status','=','Store')
						->count();

		$mec_1000 = DB::table('mec_1000_topuppin')
        				->where('status','=','Store')
						->count();

		$ooredoo_20000 = DB::table('ooredoo_20000_topuppin')
						->where('status','=','Store')
						->count();
        
        $ooredoo_10000 = DB::table('ooredoo_10000_topuppin')
        				->where('status','=','Store')
						->count();

		$ooredoo_5000 = DB::table('ooredoo_5000_topuppin')
        				->where('status','=','Store')
						->count();

		$ooredoo_3000 = DB::table('ooredoo_3000_topuppin')
        				->where('status','=','Store')
						->count();

		$ooredoo_1000 = DB::table('ooredoo_1000_topuppin')
        				->where('status','=','Store')
						->count();

		$user = DB::table('users')
                ->join('agent','agent.user_id','=','users.users_id')
                ->join('agentcard','agent.agent_id','=','agentcard.agent_id')
                ->where('agent.agent_id',Auth::user()->agent_id)
                ->first();


		return view('backend.chart.index',[
            'mec_10000' => $mec_10000,
            'mec_5000' => $mec_5000,
            'mec_3000' => $mec_3000,
            'mec_1000' => $mec_1000,

            'ooredoo_20000' => $ooredoo_20000,
            'ooredoo_10000' => $ooredoo_10000,
            'ooredoo_5000' => $ooredoo_5000,
            'ooredoo_3000' => $ooredoo_3000,
            'ooredoo_1000' => $ooredoo_1000,
            'user' => $user
        ]);
	}
}
