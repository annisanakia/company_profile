<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Fortify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Contracts\LogoutResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password');
        });

        Fortify::resetPasswordView(function ($request) {
        });

        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::authenticateUsing(function (Request $request) {
            $user = \App\Models\User::where('username', $request->username)
                ->where('status',1)
                ->whereNull('deleted_at')
                ->first();

            if ($user && Hash::check($request->password, $user->password)) {
                $agent = new \Jenssegers\Agent\Agent();

                $access_date = date('Y-m-d H:i:s');
                $user_access = \Models\user_access::where('users_id',$user->id)
                    ->where('access_date',$access_date)
                    ->where('platform',$agent->platform())
                    ->where('browser',$agent->browser())
                    ->where('device',$agent->device())
                    ->where('ip_address',\Request::ip())
                    ->first();
                
                if(!$user_access){
                    $user_access = new \Models\user_access();
                }
    
                $user_access->users_id = $user->id;
                $user_access->name = $user->name;
                $user_access->username = $user->username;
                $user_access->access_date = $access_date;
                $user_access->platform = $agent->platform();
                $user_access->browser = $agent->browser();
                $user_access->device = $agent->device();
                $user_access->ip_address = \Request::ip();
                $user_access->save();

                $request->session()->put('alert', 1);
                return $user;
            } elseif (!$user) {
                throw ValidationException::withMessages([
                    'user_valid' => 'Data pengguna tidak ditemukan'
                ]);
            } elseif (!Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'user_valid' => 'Password tidak benar, silahkan ulangi menggunakan password yang benar'
                ]);
            } else {
                throw ValidationException::withMessages([
                    'user_valid' => 'Mohon maaf, akun anda telah dinonaktifkan sehingga tidak dapat mengakses portal kembali.'
                ]);
            }
        });

        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
            public function toResponse($request)
            {
                return redirect('/admin');
            }
        });
    }
}
