<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Введите email.',
            'email.email' => 'Введите корректный email.',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with(
                'status',
                'Ссылка для восстановления пароля отправлена на ваш email.'
            );
        }

        $message = match ($status) {
            Password::INVALID_USER => 'Пользователь с таким email не найден.',
            Password::THROTTLED => 'Слишком много запросов. Подождите немного и попробуйте снова.',
            default => 'Не удалось отправить ссылку. Попробуйте позже.',
        };

        return back()
            ->withErrors(['email' => $message])
            ->withInput($request->only('email'));
    }

    public function showResetForm(Request $request, string $token)
    {
        return view('passwords.reset', [
            'token' => $token,
            'email' => $request->input('email'),
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'token.required' => 'Отсутствует токен восстановления.',

            'email.required' => 'Введите email.',
            'email.email' => 'Введите корректный email.',

            'password.required' => 'Введите новый пароль.',
            'password.min' => 'Пароль должен содержать минимум 6 символов.',
            'password.confirmed' => 'Пароли не совпадают.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, string $password) {
                // У User стоит каст 'password_hash' => 'hashed',
                // поэтому пароль будет захеширован автоматически.
                $user->forceFill([
                    'password_hash' => $password,
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()
                ->route('login')
                ->with('status', 'Пароль успешно изменён. Теперь войдите с новым паролем.');
        }

        $field = $status === Password::INVALID_TOKEN ? 'token' : 'email';

        $message = match ($status) {
            Password::INVALID_TOKEN => 'Ссылка для сброса пароля недействительна или устарела.',
            Password::INVALID_USER => 'Пользователь с таким email не найден.',
            default => 'Не удалось изменить пароль. Запросите новую ссылку.',
        };

        return back()
            ->withErrors([$field => $message])
            ->withInput($request->only('email'));
    }
}
