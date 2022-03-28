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
                $ng_user_access = new \Models\ng_user_access();
    
                $ng_user_access->users_id = $user->id;
                $ng_user_access->access_date = date('Y-m-d H:i:s');
                $ng_user_access->platform = $agent->platform();
                $ng_user_access->browser = $agent->browser();
                $ng_user_access->device = $agent->device();
                $ng_user_access->ip_address = \Request::ip();
                $ng_user_access->save();

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
