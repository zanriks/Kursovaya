<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth', ['activeTab' => 'login']);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'Введите логин или email.',
            'password.required' => 'Введите пароль.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput($request->only('login', 'remember'));
        }

        $data = $validator->validated();
        $field = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'login';

        $authenticated = Auth::attempt([
            $field => $data['login'],
            'password' => $data['password'],
            'is_active' => true,
        ], $request->boolean('remember'));

        if (! $authenticated) {
            return redirect()->route('login')
                ->withErrors(['login' => 'Неверный логин/email или пароль.'])
                ->withInput($request->only('login', 'remember'));
        }

        $request->session()->regenerate();

        return redirect()->intended(route('profile'));
    }

    public function showRegister()
    {
        return view('auth', ['activeTab' => 'register']);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => ['required', 'string', 'min:3', 'max:50', 'regex:/^[A-Za-z0-9_-]+$/', 'unique:users,login'],
            'last_name' => ['nullable', 'string', 'max:100'],
            'first_name' => ['nullable', 'string', 'max:100'],
            'surname' => ['nullable', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'login.required' => 'Введите логин.',
            'login.min' => 'Логин должен содержать минимум 3 символа.',
            'login.max' => 'Логин не должен быть длиннее 50 символов.',
            'login.regex' => 'Логин может содержать только латинские буквы, цифры, дефис и подчёркивание.',
            'login.unique' => 'Такой логин уже занят.',
            'email.required' => 'Введите email.',
            'email.email' => 'Введите корректный email.',
            'email.unique' => 'Этот email уже зарегистрирован.',
            'password.required' => 'Введите пароль.',
            'password.min' => 'Пароль должен содержать минимум 6 символов.',
            'password.confirmed' => 'Пароли не совпадают.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('register')
                ->withErrors($validator)
                ->withInput($request->except(['password', 'password_confirmation']));
        }

        $data = $validator->validated();
        $role = Role::firstOrCreate(['name' => 'customer']);

        $user = User::create([
            'role_id' => $role->role_id,
            'login' => $data['login'],
            'last_name' => $data['last_name'] ?? null,
            'first_name' => $data['first_name'] ?? null,
            'surname' => $data['surname'] ?? null,
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password_hash' => $data['password'],
            'is_active' => true,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('profile');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function profile()
    {
        return view('profile', ['user' => Auth::user()]);
    }
}