<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EpinController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	$user =  Session('user');

    	    	if ($request->ajax()) {

    		$epin = DB::table('users');
							
							->select([
								"address",
								"province",
								]);
		

    		return Datatables::of($epin)
			    ->filter(function ($query) use ($request) {
	                if ($request->has('fromdate')) {
	                    $query->whereDate('users.dateofbirth', '>=', "{$request->get('start_date')}");
	                }
	                if ($request->has('todate')) {
	                    $query->whereDate('users.dateofbirth','<=', "{$request->get('end_date')}");
	                }
	          	})
    		->make(true);

    	

        }

    	return view('backend.callcenter.epin.index', array( 
		      'user' => $user
		    ));  
    }
}
