<?php

namespace App\Http\Controllers\Auth\AuthController;

use Illuminate\Http\Request;

class AuthController extends Controller
{
	 public function __construct()
        {
            $this->middleware('guest', [ 'except' => 'logout' ]); // Default router name is "logout" should be same router 

        }

        public function getLogout()
{
   $this->auth->logout();
   Session::flush();
   return redirect('/');
}
}
