<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UsersController;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use App\Models\Ankets;

class AuthenticatedSessionController extends Controller
{

//protected $username = 'login';

/*protected function guard()
{
    return Auth::guard('guard-name');
}*/

 /*public function username()
  {
      return 'login';
  }*/

/*
 public function getAuthPassword()
{
    return $this->name;
}*/

    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $ankets = new Ankets();
        return view('auth.login', ['ankets' => $ankets->getAllAnkets()]);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

       // dd($request);

        $request->session()->regenerate();

		session(['setAuditorium' => 0]);

        UsersController::setOnLine();

        return redirect()->route('call');
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        UsersController::setOffLine();
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
