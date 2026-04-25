<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        $this->configureModels();
        $this->configurePasswordReset();
        $this->configureRoutes();
        $this->configureUrls();
        $this->configureMailRouting();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }

    private function configureModels(): void
    {
        Model::preventLazyLoading(!$this->app->isProduction());
        Model::preventSilentlyDiscardingAttributes(!$this->app->isProduction());
    }

    private function configurePasswordReset(): void
    {
        ResetPassword::toMailUsing(function ($notifiable, $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage())
                ->subject('Reinitialisation de votre mot de passe')
                ->line('Vous recevez cet e-mail car nous avons recu une demande de reinitialisation de mot de passe pour votre compte.')
                ->action('Reinitialiser le mot de passe', $url)
                ->line('Ce lien de reinitialisation expirera dans ' . config('auth.passwords.' . config('auth.defaults.passwords') . '.expire') . ' minutes.')
                ->line('Si vous n\'avez pas demande de reinitialisation, aucune autre action n\'est requise.');
        });
    }

    private function configureRoutes(): void
    {
        Route::resourceVerbs([
            'create' => 'creer',
            'edit' => 'modifier',
        ]);
    }

    private function configureUrls(): void
    {
        URL::forceHttps($this->app->environment(['production', 'develop']));
    }

    private function configureMailRouting(): void
    {
        $alwaysTo = match ($this->app->environment()) {
            'local' => config('mail.to.developer'),
            'develop' => config('mail.to.support'),
            default => null,
        };

        if ($alwaysTo) {
            Mail::alwaysTo($alwaysTo);
        }
    }
}
