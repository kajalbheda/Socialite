<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirectToGoogle(){

        //return Socialite::driver('google')->redirect();
return Socialite::driver('google')
    ->scopes(['read:user', 'public_repo'])
    ->redirect();

    }
    public function handleGoogleCallback(){
        try{

            $googleuser = Socialite::driver('google')->user();
            $user=User::where('google_id',$googleuser->id)->first();
            if($user){
                //login
                // Auth::login($findUser);
                // return redirect()->intended('dashboard');
                $user->update([
                'google_token' => $googleuser->token,
                'google_refresh_token' => $googleuser->refreshToken,
            ]);

            }else{
                //register
                // $newuser=User::create([
                //     'name' => $user->name,
                //     'email' => $user->email,
                //     'google_id' => $user->id,
                //     'password'=> encrypt('mypassword')
                // ]);
                // Auth::login($newuser);
                // return redirect()->intended('dashboard'); 

                $user = User::create([
                    'name' => $googleuser->name,
                    'email' => $googleuser->email,
                    'github_id' => $googleuser->id,
                    'github_token' => $googleuser->token,
                    'github_refresh_token' => $googleuser->refreshToken,
                ]);
                
                Auth::login($user);
 
                return redirect('/dashboard');
            }

        }catch(Exception $e){
            dd($e->getMessage());
        }
    }

    public function FacebookRedirect(){
        return Socialite::driver('facebook')->redirect();
    }
    public function FbResponse(){
        try{

            $user = Socialite::driver('facebook')->user();
            $findUser=User::where('fb_id',$user->id)->first();
            if($findUser){
                //login
                Auth::login($findUser);
                return redirect()->intended('/dashboard');
            }else{
                //register
                $newuser=User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'fb_id' => $user->id,
                    'password'=> encrypt('mypassword')
                ]);
                Auth::login($newuser);
                return redirect('/dashboard'); 
            }

        }catch(Exception $e){
            dd($e->getMessage());
        }
    }
}
