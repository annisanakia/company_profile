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
            // $domain = request()->getHost();
            // $apps = \Models\app::where('domain_local', $domain)->OrWhere('domain_production', $domain)->first();

            // if ($apps->client->id = 400) {
            //     return view('auth.reset-password-new', ['request' => $request]);
            // } else {
            //     return view('auth.reset-password', ['request' => $request]);
            // }
        });

        Fortify::loginView(function () {
            // $domain = request()->getHost();

            // $apps = \Models\app::where('domain_local', $domain)->OrWhere('domain_production', $domain)->first();

            // if ($apps) {
            //     $client = $apps->client;
            // } else {
            //     $client = \Models\client::where('url_bo', $domain)
            //         ->first();
            // }

            // if ($domain == "demo.pintro.id") {
            //     return view('demo.login_demo');
            // } else {
            //     if ($client) {
            //         $with['login_logo'] = $client->web_template_login_logo;
            //         $with['favicon'] = $client->logo_favicon;
            //         $with['background'] = $client->background_color;
            //         $with['logo_size'] = $client->logo_size;
            //         $with['client'] = $client;
            //         return view('auth.' . $client->web_template_login, $with);
            //     } else {
            //         $with['login_logo'] = asset('images/logoalazharyogya.png');
            //         $with['favicon'] = NULL;
            //         $with['client'] = NULL;
            //         return view('auth.login_pintro', $with);
            //     }
            // }

            // return view('auth.login');
        });

        Fortify::authenticateUsing(function (Request $request) {
            $domain = request()->getHost();

            $apps = \Models\app::where('domain_local', $domain)->OrWhere('domain_production', $domain)->first();

            if ($apps) {
                $client = $apps->client;
            } else {
                $client = \Models\client::where('url_bo', $domain)
                    ->first();
            }

            if ($client) {
                $user = \App\Models\User::where('username', $request->username)
                    ->where('client_id', $client->id)
                    ->whereNull('deleted_at')
                    ->whereHas('user_group', function ($builder) {
                        $builder->whereHas('groups', function ($builder) {
                            $builder->whereNotIn('code', ['APPL', 'appl', 'crstu']);
                        });
                    });

                if ($request->has('ng_department_id')) {
                    $user->where('ng_department_id', $request->ng_department_id);
                }

                $user = $user->first();

                $valid_user = true;
                if ($user) {
                    /**
                     * Cek is Employee
                     */
                    $employee = \Models\ng_employee::where('users_id', $user->id)->first();

                    if ($employee) {
                        $valid_user = $employee->status == 1;
                    }

                    /**
                     * Cek is Student
                     *
                     */
                    $student = \Models\ng_student::where('users_id', $user->id)->first();
                    if ($student) {
                        $valid_user = $student->status == 1;
                    }
                }

                if ($apps) {
                    \Session::put('client_detail', $client);
                    \Session::put('client_id', $apps->client_id);
                    \Session::put('app_id', $apps->id);
                    \Session::put('login_logo', $apps->client->web_template_login_logo);
                    \Session::put('web_template_login_logo', $apps->client->web_template_login_logo);
                    \Session::put('web_template_login_bg', $apps->client->web_template_login_bg);
                    \Session::put('fee', $apps->client->fee);
                    \Session::put('url_verification', $apps->tiny_url_verification);
                }

                if ($user && Hash::check($request->password, $user->password) && $valid_user) {
                    $agent = new \Jenssegers\Agent\Agent();
                    $ng_user_activity = new \Models\ng_user_access();

                    $ng_user_activity->users_id = $user->id;
                    $ng_user_activity->name = $user->name;
                    $ng_user_activity->username = $user->username;
                    $ng_user_activity->access_date = date('Y-m-d H:i:s');
                    $ng_user_activity->platform = $agent->platform();
                    $ng_user_activity->browser = $agent->browser();
                    $ng_user_activity->device = $agent->device();
                    $ng_user_activity->ip_address = \Request::ip();
                    $ng_user_activity->client_id = $user->client_id;
                    $ng_user_activity->save();
                    $request->session()->put('alert', 1);
                    return $user;
                } elseif (!$user) {
                    throw ValidationException::withMessages([
                        'user_valid' => say('Data pengguna tidak ditemukan')
                    ]);
                } elseif (!Hash::check($request->password, $user->password)) {
                    throw ValidationException::withMessages([
                        'user_valid' => say('Password tidak benar, silahkan ulangi menggunakan password yang benar')
                    ]);
                } else {
                    throw ValidationException::withMessages([
                        'user_valid' => say('Mohon maaf, akun anda telah dinonaktifkan sehingga tidak dapat mengakses portal kembali.')
                    ]);
                }
            }
        });
    }
}
