<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Administracion\Usuario;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['only' => 'login']);
    }

    public function login()
    {
        /*$user = User::factory()->create();

        dd($user);*/

        $credentials = $this->validate( request(), [
            'email' => 'email|required|string',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($credentials))
        {
            return redirect()->route('home');
        }

        return back()
            ->withErrors(['email' => trans('auth.failed')])
            ->withInput(request(['email']));

    }

    public function logout()
    {
        Auth::logout();

        return redirect('login');
    }
}
