@php
    $isEdit = isset($role) && $role->exists;
@endphp

<form method="POST"
      action="{{ $isEdit ? route('admin.roles.update', $role) : route('admin.roles.store') }}">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="admin-form__grid">
        <label class="admin-form__label admin-form__label--full">
            Название роли
            <input type="text"
                   name="name"
                   class="admin-form__input"
                   value="{{ old('name', $role->name) }}"
                   maxlength="50"
                   required>
        </label>
    </div>

    <div class="admin__actions">
        <button type="submit" class="admin__btn admin__btn--primary">Сохранить</button>
        <a href="{{ route('admin.roles.index') }}" class="admin__btn">Отмена</a>
    </div>
</form>
