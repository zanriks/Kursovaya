<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search'));

        $users = User::query()
            ->with('role')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('login', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                });
            })
            ->orderBy('user_id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.list_users', compact('users', 'search'));
    }

    public function create()
    {
        return view('admin.create_user', [
            'user' => new User(),
            'roles' => Role::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateUser($request);

        User::create([
            'role_id' => $data['role_id'],
            'login' => $data['login'],
            'last_name' => $data['last_name'] ?? null,
            'first_name' => $data['first_name'] ?? null,
            'surname' => $data['surname'] ?? null,
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            // Каст 'hashed' сам захеширует пароль.
            'password_hash' => $data['password'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Пользователь «' . $data['login'] . '» создан.');
    }

    public function edit(User $user)
    {
        return view('admin.edit_user', [
            'user' => $user,
            'roles' => Role::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $this->validateUser($request, $user);

        $payload = [
            'role_id' => $data['role_id'],
            'login' => $data['login'],
            'last_name' => $data['last_name'] ?? null,
            'first_name' => $data['first_name'] ?? null,
            'surname' => $data['surname'] ?? null,
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ];

        if (! empty($data['password'])) {
            $payload['password_hash'] = $data['password'];
        }

        // Себя админ не должен разжаловать или выключить.
        if ((int) $user->user_id === (int) Auth::id()) {
            $payload['role_id'] = $user->role_id;
            $payload['is_active'] = true;
        }

        $user->update($payload);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Пользователь «' . $user->login . '» обновлён.');
    }

    public function destroy(User $user)
    {
        if ((int) $user->user_id === (int) Auth::id()) {
            return back()->withErrors(['delete' => 'Нельзя удалить самого себя.']);
        }

        if ($user->isAdmin() && $this->adminCount() <= 1) {
            return back()->withErrors([
                'delete' => 'Нельзя удалить последнего администратора.',
            ]);
        }

        $login = $user->login;
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Пользователь «' . $login . '» удалён.');
    }

    private function validateUser(Request $request, ?User $user = null): array
    {
        $loginRule = Rule::unique('users', 'login');
        $emailRule = Rule::unique('users', 'email');

        if ($user) {
            $loginRule->ignore($user->user_id, 'user_id');
            $emailRule->ignore($user->user_id, 'user_id');
        }

        return $request->validate([
            'role_id' => ['required', 'integer', 'exists:roles,role_id'],

            'login' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'regex:/^[A-Za-z0-9_-]+$/',
                $loginRule,
            ],

            'last_name' => ['nullable', 'string', 'max:100'],
            'first_name' => ['nullable', 'string', 'max:100'],
            'surname' => ['nullable', 'string', 'max:100'],

            'email' => [
                'required',
                'email',
                'max:255',
                $emailRule,
            ],

            'phone' => ['nullable', 'string', 'max:20'],

            'password' => [
                $user ? 'nullable' : 'required',
                'string',
                'min:6',
                'confirmed',
            ],

            'is_active' => ['nullable', 'boolean'],
        ], [
            'role_id.required' => 'Выберите роль.',
            'role_id.exists' => 'Такая роль не найдена.',

            'login.required' => 'Введите логин.',
            'login.min' => 'Логин слишком короткий.',
            'login.max' => 'Логин слишком длинный.',
            'login.regex' => 'Логин: только латиница, цифры, дефис и подчёркивание.',
            'login.unique' => 'Такой логин уже есть.',

            'email.required' => 'Введите email.',
            'email.email' => 'Email не похож на email.',
            'email.unique' => 'Такой email уже есть.',

            'password.required' => 'Введите пароль.',
            'password.min' => 'Пароль минимум 6 символов.',
            'password.confirmed' => 'Пароли не совпадают.',
        ]);
    }

    private function adminCount(): int
    {
        return User::query()
            ->whereHas('role', function ($query) {
                $query->where('name', 'admin');
            })
            ->count();
    }
}
