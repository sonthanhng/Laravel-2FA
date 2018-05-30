<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Illuminate\Http\Request;
use App\PasswordSecurity;


class PasswordSecurityController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth');
  }
  public function show2faForm(Request $request){
        $user = Auth::user();
        $google2fa_url = "";
        if($user->passwordSecurity()->exists()){
            $google2fa = app('pragmarx.google2fa');
            $google2fa->setAllowInsecureCallToGoogleApis(true);
            $google2fa_url = $google2fa->getQRCodeGoogleUrl(
                '5Balloons 2FA DEMO',
                $user->email,
                $user->passwordSecurity->google2fa_secret
            );
        }
        $data = array(
            'user' => $user,
            'google2fa_url' => $google2fa_url
        );
        return view('auth.2fa')->with('data', $data);
    }
}
