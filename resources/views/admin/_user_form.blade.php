@php
    $isEdit = isset($user) && $user->exists;
@endphp

<form method="POST"
      action="{{ $isEdit ? route('admin.users.update', $user) : route('admin.users.store') }}">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="admin-form__grid">
        <label class="admin-form__label">
            Логин
            <input type="text"
                   name="login"
                   class="admin-form__input"
                   value="{{ old('login', $user->login) }}"
                   required>
        </label>

        <label class="admin-form__label">
            Email
            <input type="email"
                   name="email"
                   class="admin-form__input"
                   value="{{ old('email', $user->email) }}"
                   required>
        </label>

        <label class="admin-form__label">
            Роль
            <select name="role_id" class="admin-form__input" required>
                @foreach ($roles as $role)
                    <option value="{{ $role->role_id }}"
                        @selected((string) old('role_id', $user->role_id) === (string) $role->role_id)>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </label>

        <label class="admin-form__label">
            Телефон
            <input type="tel"
                   name="phone"
                   class="admin-form__input"
                   value="{{ old('phone', $user->phone) }}">
        </label>

        <label class="admin-form__label">
            Имя
            <input type="text"
                   name="first_name"
                   class="admin-form__input"
                   value="{{ old('first_name', $user->first_name) }}">
        </label>

        <label class="admin-form__label">
            Фамилия
            <input type="text"
                   name="last_name"
                   class="admin-form__input"
                   value="{{ old('last_name', $user->last_name) }}">
        </label>

        <label class="admin-form__label">
            Отчество
            <input type="text"
                   name="surname"
                   class="admin-form__input"
                   value="{{ old('surname', $user->surname) }}">
        </label>

        <label class="admin-form__label admin-form__label--full">
            Пароль
            <input type="password"
                   name="password"
                   class="admin-form__input"
                   autocomplete="new-password"
                   @if (! $isEdit) required @endif>
            @if ($isEdit)
                <small>Оставьте пустым, если не меняете пароль.</small>
            @endif
        </label>

        <label class="admin-form__label admin-form__label--full">
            Повторите пароль
            <input type="password"
                   name="password_confirmation"
                   class="admin-form__input"
                   autocomplete="new-password"
                   @if (! $isEdit) required @endif>
        </label>

        <label class="admin-form__label admin-form__label--full">
            <input type="checkbox"
                   name="is_active"
                   value="1"
                   @checked(old('is_active', $isEdit ? $user->is_active : true))>
            Активен
        </label>
    </div>

    <div class="admin__actions">
        <button type="submit" class="admin__btn admin__btn--primary">Сохранить</button>
        <a href="{{ route('admin.users.index') }}" class="admin__btn">Отмена</a>
    </div>
</form>
