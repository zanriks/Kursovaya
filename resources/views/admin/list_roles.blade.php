@extends('admin.layout')

@section('title', 'Роли')

@section('actions')
    <a href="{{ route('admin.roles.create') }}" class="admin__btn admin__btn--primary">
        + Добавить роль
    </a>
@endsection

@section('content')
    <div class="admin__table-wrap">
        <table class="admin__table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Пользователей</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($roles as $role)
                <tr>
                    <td>{{ $role->role_id }}</td>
                    <td><strong>{{ $role->name }}</strong></td>
                    <td>{{ $role->users_count }}</td>
                    <td>
                        <div class="admin__table-actions">
                            <a href="{{ route('admin.roles.edit', $role) }}"
                               class="admin__btn admin__btn--small">
                                Изменить
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.roles.destroy', $role) }}"
                                  onsubmit="return confirm('Удалить эту роль?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="admin__btn admin__btn--danger admin__btn--small">
                                    Удалить
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="admin__empty">Роли не найдены.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
