@extends('admin.layout')

@section('title', 'Пользователи')

@section('actions')
    <a href="{{ route('admin.users.create') }}" class="admin__btn admin__btn--primary">
        + Добавить пользователя
    </a>
@endsection

@section('content')
    <form method="GET" action="{{ route('admin.users.index') }}" class="admin__search">
        <input type="text"
               name="search"
               class="admin-form__input"
               value="{{ $search }}"
               placeholder="Поиск по логину, email или имени">
        <button type="submit" class="admin__btn">Найти</button>

        @if ($search !== '')
            <a href="{{ route('admin.users.index') }}" class="admin__btn admin__btn--muted">Сбросить</a>
        @endif
    </form>

    <div class="admin__table-wrap">
        <table class="admin__table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Логин</th>
                <th>Имя</th>
                <th>Email</th>
                <th>Роль</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->user_id }}</td>
                    <td><strong>{{ $user->login }}</strong></td>
                    <td>
                        {{ trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: '—' }}
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role?->name ?? '—' }}</td>
                    <td>
                        <span class="admin__badge {{ $user->is_active ? 'admin__badge--success' : 'admin__badge--muted' }}">
                            {{ $user->is_active ? 'Активен' : 'Выключен' }}
                        </span>
                    </td>
                    <td>
                        <div class="admin__table-actions">
                            <a href="{{ route('admin.users.edit', $user) }}"
                               class="admin__btn admin__btn--small">
                                Изменить
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.users.destroy', $user) }}"
                                  onsubmit="return confirm('Удалить этого пользователя?')">
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
                    <td colspan="7" class="admin__empty">Пользователи не найдены.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $users->links('admin.pagination') }}
@endsection
