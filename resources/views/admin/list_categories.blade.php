@extends('admin.layout')

@section('title', 'Категории')

@section('actions')
    <a href="{{ route('admin.categories.create') }}" class="admin__btn admin__btn--primary">
        + Добавить категорию
    </a>
@endsection

@section('content')
    <form method="GET" action="{{ route('admin.categories.index') }}" class="admin__search">
        <input type="text"
               name="search"
               class="admin-form__input"
               value="{{ $search }}"
               placeholder="Поиск по названию или slug">
        <button type="submit" class="admin__btn">Найти</button>

        @if ($search !== '')
            <a href="{{ route('admin.categories.index') }}" class="admin__btn admin__btn--muted">Сбросить</a>
        @endif
    </form>

    <div class="admin__table-wrap">
        <table class="admin__table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Категория</th>
                <th>Родительская</th>
                <th>Сортировка</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->category_id }}</td>
                    <td>
                        <strong class="admin__product-name">{{ $category->name }}</strong>
                        <span class="admin__muted admin__slug">Slug: {{ $category->slug }}</span>
                    </td>
                    <td>{{ $category->parent?->name ?? '—' }}</td>
                    <td>{{ $category->sort_order }}</td>
                    <td>
                        <span class="admin__badge {{ $category->is_active ? 'admin__badge--success' : 'admin__badge--muted' }}">
                            {{ $category->is_active ? 'Активна' : 'Скрыта' }}
                        </span>
                    </td>
                    <td>
                        <div class="admin__table-actions">
                            <a href="{{ route('admin.categories.edit', $category) }}"
                               class="admin__btn admin__btn--small">
                                Изменить
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.categories.destroy', $category) }}"
                                  onsubmit="return confirm('Удалить эту категорию?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin__btn admin__btn--danger admin__btn--small">
                                    Удалить
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="admin__empty">Категории не найдены.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $categories->links('admin.pagination') }}
@endsection
