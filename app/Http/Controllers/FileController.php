<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function getCaptchaForm(){
        return view('files.captchaform');
     }
    
    public function postCaptchaForm(Request $request){
         $this->validate($request, [
		          'trueemployee_id' => 'required',
		          'password'=>'required',
		          'g-recaptcha-response' => 'required',
          ]);
     }
}
