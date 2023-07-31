<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use App\Utilities\LogActivity;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Actions\EnsureLoginIsNotThrottled;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;

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

        Fortify::loginView(fn() => view('admin.auth.login'));

        Fortify::authenticateThrough(function (Request $request) {
            LogActivity::addToLog('Login Attempt-' . 'Email: ' . $request->email);
            $user = User::where('email', $request->email)
            // ->orWhere('mobile',$request->email)
            // ->where('status',true)
            // ->whereIn('type',['admin', 'superadmin', 'staff'])
                ->first();
            return array_filter([
                config('fortify.limiters.login') ? null : EnsureLoginIsNotThrottled::class,
                (@$user->two_factor_secret) ? RedirectIfTwoFactorAuthenticatable::class : '',
                AttemptToAuthenticate::class,
                PrepareAuthenticatedSession::class,
            ]);
        });

        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)
            // ->orWhere('mobile',$request->email)
            // ->where('status',true)
            // ->whereIn('type',['admin', 'superadmin', 'staff'])
                ->first();
            if ($user && Hash::check($request->password, $user->password)) {
                if ($user->two_factor_secret) {
                    LogActivity::addToLog('युजर लगइन भएको: ' . $request->email, $user->id);
                } else {
                    LogActivity::addToLog('युजर लगइन भएको: ' . $request->email, $user->id);
                }
                $request->session()->flash('success', "You are Logged in successfully");

                // dd($appsetting->website_content_item);

                return $user;
            }
        });

        // dd($user);

        Fortify::confirmPasswordView(function () {
            $user = null;
            if (Auth::check()) {
                $user = User::where('id', Auth::user()->id)->with(['has_profile'])->first();
            }
            return view('admin.auth.password-confirm', compact('user'));
        });
        Fortify::requestPasswordResetLinkView(fn() => view('admin.auth.forgot-password'));
        Fortify::resetPasswordView(fn($request) => view('admin.auth.reset-password', ['request' => $request]));
        Fortify::verifyEmailView(fn() => view('admin.auth.verify-email'));
        Fortify::twoFactorChallengeView(fn() => view('admin.auth.two-factor-challenge'));
    }
}
