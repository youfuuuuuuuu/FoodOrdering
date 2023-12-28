<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Provides\RoutesServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to riderect users after login.
     * 
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     * 
     * @return void
    */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $request){
        $input = $request->all();
        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required'
        ]);
    
        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password']))){
            Log::info('User is_admin value: ' . auth()->user()->is_admin);
    
            if(auth()->user()->is_admin == 1){
                return redirect()->route('admin.home');
            } else {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('login')->with('error', 'Input proper email or password.');
        }
    }
}