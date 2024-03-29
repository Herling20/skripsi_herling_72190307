<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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

    public function login(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'kodeUser' => 'required',
            'password' => 'required'
        ]);
        // dd($request);

        // if(Auth::attempt(['kodeUser' => $input["kodeUser"], 'password' => $input["password"]]))
        if(Auth::dosen(['nidn' => $input["kodeUser"], 'password' => $input["password"]]) || Auth::mahasiswa(['nim' => $input["kodeUser"], 'password' => $input["password"]]))
        {
            if(Auth::dosen()->role == 'admin')
            {
                return redirect()->route('home.admin');
            }
            else if(Auth::dosen()->role == 'dosen')
            {
                return redirect()->route('dashboard.dosen');
            }
            else if(Auth::mahasiswa()->role == 'mahasiswa')
            {
                return redirect()->route('home.mhs');
            }
        }
        else
        {
            return redirect()->route("login")->with("error", 'Incorrect email or password');
        }
    }
}
