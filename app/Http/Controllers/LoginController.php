<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\User;
use Illuminate\Support\Facades\Validato


class LoginController extends Controller
{
	protected $redirectTo = '/agent';
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }


    public function showLogin()
    {
    	return view('login.login');
    }


     public function authenticate(Request $request)
 	{
	     $this->validate($request, [  
	     	  'factory_cardno' => 'required',    
	     	  'pinno' => 'required',    
	          // 'g-recaptcha-response' => 'required|captcha',
	      ]);
	   
	    $user = User::where('factory_cardno', '=',  $request->input('factory_cardno'))->first();

	     if(!$user){
	     	// return "Agent Not Found";
	     	Session::flash('message', "Your ID and Password are not found!");
	     	// Session::flash('alert-class', 'alert-danger'); 
	     	return redirect('login');
	     }

	     if(!($user->pinno == strtoupper(md5($request->input('pinno'))))){
	     	// return "User mismatch";
	     	// Session::flash('alert-class', 'alert-danger'); 
	     	Session::flash('message', "Your ID and Password are not match!");
	     	 return redirect('login');

	     }
	      Auth::login($user);

	       $user = DB::table('users')
                ->join('agent','agent.user_id','=','users.users_id')
                ->join('agentcard','agent.agent_id','=','agentcard.agent_id')
                ->where('agent.agent_id',Auth::user()->agent_id)
                ->first();

          session(['user' => $user]);
	      return redirect('/agent');
 	}



	public function logout() {

		 Auth::logout();
		 return redirect('login');
 	}

}

