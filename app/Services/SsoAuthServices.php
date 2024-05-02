<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Repository\SsoAuthRepository;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;


class SsoAuthServices implements SsoAuthRepository
{
    public function getSsoAuthenticate($provider)
    {
        try {
            Log::info('User logged successfully:', ['provider' => $provider]);
            return Socialite::driver($provider)->redirect();
        } catch (\Exception $e) {
            log::error('Error during process:', ['message' => $e->getMessage()]);
            return abort(500, $e->getMessage());
        }
    }

    public function setSsoAuthenticate($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
            Log::debug('User data from GitHub:', ['$user' => $user]);
         
            $user = User::updateOrCreate([
                "$provider'._id" => $user->id,
            ], [
                "name" => $user->name,
                "email" => $user->email,
                "$provider'._token" => $user->token,
                "$provider'._refresh_token" => $user->refreshToken,
            ]);
         
            Auth::login($user);
            Log::info('User authenticated successfully:', ['user_id' => $user->id]);
         
            return route('dashboard');
        } catch (\Exception $e) {
            Log::error('Error during authentication:', ['message' => $e->getMessage()]);
            return abort(500, $e->getMessage());
        }
    }

}
?>