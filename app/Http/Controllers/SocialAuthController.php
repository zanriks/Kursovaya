<?php

namespace App\Http\Controllers;

use App\Models\ExternalAuthAccount;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    private const PROVIDERS = [
        'yandex',
        'vkontakte',
        'google',
    ];

    public function redirect(string $provider)
    {
        abort_unless(in_array($provider, self::PROVIDERS, true), 404);

        return Socialite::driver($provider)->redirect();
    }

    public function callback(Request $request, string $provider)
    {
        abort_unless(in_array($provider, self::PROVIDERS, true), 404);

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Throwable $exception) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'social' => 'Не удалось войти через ' . $provider . '. Попробуйте ещё раз.',
                ]);
        }

        $email = $socialUser->getEmail();
        $providerId = (string) $socialUser->getId();

        if (! $email || $providerId === '') {
            return redirect()
                ->route('login')
                ->withErrors([
                    'social' => 'Сторонний сервис не вернул необходимые данные. Убедитесь, что приложению разрешён доступ к email.',
                ]);
        }

        $user = DB::transaction(function () use ($socialUser, $provider, $email, $providerId) {
            // 1. Уже привязанный аккаунт
            $account = ExternalAuthAccount::query()
                ->where('provider', $provider)
                ->where('provider_user_id', $providerId)
                ->first();

            if ($account) {
                return $account->user;
            }

            // 2. Пользователь с таким email уже существует — просто привязываем
            $user = User::query()
                ->where('email', $email)
                ->first();

            // 3. Нового пользователя создаём сами
            if (! $user) {
                $role = Role::firstOrCreate(['name' => 'customer']);

                $user = User::create([
                    'role_id' => $role->role_id,
                    'login' => $this->makeLogin($socialUser, $provider, $email),
                    'first_name' => $this->firstName($socialUser->getName()),
                    'last_name' => null,
                    'email' => $email,
                    // У пользователя нет локального пароля,
                    // но поле password_hash обязательное.
                    'password_hash' => Str::password(32),
                    'is_active' => true,
                ]);
            }

            ExternalAuthAccount::create([
                'user_id' => $user->user_id,
                'provider' => $provider,
                'provider_user_id' => $providerId,
            ]);

            return $user;
        });

        if (! $user->is_active) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'social' => 'Этот аккаунт деактивирован.',
                ]);
        }

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->intended(route('profile'));
    }

    private function makeLogin($socialUser, string $provider, string $email): string
    {
        $source = $socialUser->getNickname() ?: explode('@', $email)[0];
        $source = $source ?: $provider . '_user';

        $base = strtolower(Str::slug($source));
        $base = preg_replace('/[^a-z0-9_-]/', '', $base);
        $base = Str::limit($base ?: $provider . '_user', 40, '');

        $login = $base;
        $counter = 2;

        while (User::query()->where('login', $login)->exists()) {
            $login = $base . '_' . $counter++;
        }

        return $login;
    }

    private function firstName(?string $name): ?string
    {
        if (! $name) {
            return null;
        }

        $parts = preg_split('/\s+/', trim($name));

        return Str::limit($parts[0] ?? '', 100, '') ?: null;
    }
}
