<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function handleProviderCallback($provider)
    {
        try {
//            dd($provider);
            $user = Socialite::driver($provider)->user();
            $finduser = User::where('email', $user->email)->first();

            if($finduser){
                Auth::login($finduser, true);
                return redirect()->route('employee.dashboard');
            }else{
                $newUser = User::create([
                    'schedule_id' => 2,
                    'role_id' => 2,
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'social_id'=> $user->id,
                    'status'=> 'Active',
                    'password' => encrypt('12345678')
                ]);

                Auth::login($newUser, true);

                return redirect()->route('employee.dashboard');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }

    }
}
