<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminRoleController extends Controller
{
    private const SYSTEM_ROLES = ['admin', 'manager', 'customer'];

    public function index()
    {
        $roles = Role::query()
            ->withCount('users')
            ->orderBy('role_id')
            ->get();

        return view('admin.list_roles', compact('roles'));
    }

    public function create()
    {
        return view('admin.create_role', [
            'role' => new Role(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('roles', 'name'),
            ],
        ], [
            'name.required' => 'Введите название роли.',
            'name.max' => 'Название роли слишком длинное.',
            'name.unique' => 'Такая роль уже есть.',
        ]);

        Role::create($data);

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Роль «' . $data['name'] . '» создана.');
    }

    public function edit(Role $role)
    {
        return view('admin.edit_role', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        if (in_array($role->name, self::SYSTEM_ROLES, true)) {
            return back()->withErrors([
                'name' => 'Системную роль переименовывать нельзя.',
            ]);
        }

        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('roles', 'name')->ignore($role->role_id, 'role_id'),
            ],
        ], [
            'name.required' => 'Введите название роли.',
            'name.max' => 'Название роли слишком длинное.',
            'name.unique' => 'Такая роль уже есть.',
        ]);

        $role->update($data);

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Роль обновлена.');
    }

    public function destroy(Role $role)
    {
        if (in_array($role->name, self::SYSTEM_ROLES, true)) {
            return back()->withErrors([
                'delete' => 'Системную роль удалять нельзя.',
            ]);
        }

        if ($role->users()->exists()) {
            return back()->withErrors([
                'delete' => 'Нельзя удалить роль, потому что у неё есть пользователи.',
            ]);
        }

        $name = $role->name;
        $role->delete();

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Роль «' . $name . '» удалена.');
    }
}
