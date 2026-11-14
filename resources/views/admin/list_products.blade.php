@extends('admin.layout')

@section('title', 'Товары')

@section('actions')
    <a href="{{ route('admin.products.create') }}" class="admin__btn admin__btn--primary">
        + Добавить товар
    </a>
@endsection

@section('content')
    <form method="GET" action="{{ route('admin.products.index') }}" class="admin__search">
        <input type="text"
               name="search"
               class="admin-form__input"
               value="{{ $search }}"
               placeholder="Поиск по названию, артикулу или slug">
        <button type="submit" class="admin__btn">Найти</button>

        @if ($search !== '')
            <a href="{{ route('admin.products.index') }}" class="admin__btn admin__btn--muted">Сбросить</a>
        @endif
    </form>

    <div class="admin__table-wrap">
        <table class="admin__table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Фото</th>
                <th>Товар</th>
                <th>Категория</th>
                <th>Цена</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($products as $product)
                @php
                    $imageUrl = $product->images->first()?->image_url;
                    $imageSrc = $imageUrl
                        ? (\Illuminate\Support\Str::startsWith($imageUrl, ['http://', 'https://'])
                            ? $imageUrl
                            : asset($imageUrl))
                        : asset('img/product-card/main-photo.png');
                @endphp

                <tr>
                    <td>{{ $product->product_id }}</td>
                    <td>
                        <img class="admin__thumb"
                             src="{{ $imageSrc }}"
                             alt="{{ $product->name }}">
                    </td>
                    <td>
                        <strong class="admin__product-name">{{ $product->name }}</strong>
                        <span class="admin__muted">Артикул: {{ $product->sku }}</span>
                        <span class="admin__muted admin__slug">Slug: {{ $product->slug }}</span>
                    </td>
                    <td>{{ $product->category?->name ?? '—' }}</td>
                    <td class="admin__price-cell">
                        <strong>{{ number_format((float) $product->price, 0, ',', ' ') }} ₽</strong>
                        @if ($product->old_price)
                            <span class="admin__old-price">
                                {{ number_format((float) $product->old_price, 0, ',', ' ') }} ₽
                            </span>
                        @endif
                    </td>
                    <td>
                        <span class="admin__badge {{ $product->is_active ? 'admin__badge--success' : 'admin__badge--muted' }}">
                            {{ $product->is_active ? 'Активен' : 'Скрыт' }}
                        </span>
                        @if ($product->is_hit)
                            <span class="admin__badge admin__badge--hit">Хит</span>
                        @endif
                    </td>
                    <td>
                        <div class="admin__table-actions">
                            <a href="{{ route('admin.products.edit', $product) }}"
                               class="admin__btn admin__btn--small">
                                Изменить
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.products.destroy', $product) }}"
                                  onsubmit="return confirm('Удалить этот товар?')">
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
                    <td colspan="7" class="admin__empty">Товары не найдены.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $products->links('admin.pagination') }}
@endsection
