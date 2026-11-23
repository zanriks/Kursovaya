@extends('admin.layout')

@section('title', 'Товары')

@section('actions')
    <a href="{{ route('admin.products.create') }}" class="admin__btn admin__btn--primary">
        + Добавить товар
    </a>
@endsection

@section('content')
    @php
        $hasFilters = collect([
            'search',
            'category_id',
            'manufacturer',
            'is_active',
            'is_hit',
            'price_min',
            'price_max',
            'sort',
        ])->contains(fn ($key) => request()->filled($key));
    @endphp

    <form method="GET" action="{{ route('admin.products.index') }}" class="admin__filters">
        <div class="admin__filters-row">
            <input type="text"
                   name="search"
                   class="admin-form__input admin__filters-search"
                   value="{{ $search }}"
                   placeholder="Поиск по названию, артикулу или slug">

            <select name="category_id" class="admin-form__input">
                <option value="">Все категории</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->category_id }}"
                        @selected((string) request('category_id') === (string) $category->category_id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <select name="manufacturer" class="admin-form__input">
                <option value="">Все производители</option>
                @foreach ($manufacturers as $manufacturer)
                    <option value="{{ $manufacturer }}"
                        @selected(request('manufacturer') === $manufacturer)>
                        {{ $manufacturer }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="admin__filters-row">
            <input type="number"
                   name="price_min"
                   class="admin-form__input"
                   value="{{ request('price_min') }}"
                   min="0"
                   step="0.01"
                   placeholder="Цена от">

            <input type="number"
                   name="price_max"
                   class="admin-form__input"
                   value="{{ request('price_max') }}"
                   min="0"
                   step="0.01"
                   placeholder="Цена до">

            <select name="is_active" class="admin-form__input">
                <option value="">Все статусы</option>
                <option value="1" @selected(request('is_active') === '1')>Активен</option>
                <option value="0" @selected(request('is_active') === '0')>Скрыт</option>
            </select>

            <select name="is_hit" class="admin-form__input">
                <option value="">Все товары</option>
                <option value="1" @selected(request('is_hit') === '1')>Только хиты</option>
                <option value="0" @selected(request('is_hit') === '0')>Не хиты</option>
            </select>

            <select name="sort" class="admin-form__input">
                <option value="default" @selected(request('sort', 'default') === 'default')>Сначала новые</option>
                <option value="name_asc" @selected(request('sort') === 'name_asc')>Название А–Я</option>
                <option value="price_asc" @selected(request('sort') === 'price_asc')>Цена по возрастанию</option>
                <option value="price_desc" @selected(request('sort') === 'price_desc')>Цена по убыванию</option>
                <option value="rating_desc" @selected(request('sort') === 'rating_desc')>Рейтинг</option>
                <option value="new" @selected(request('sort') === 'new')>Новинки</option>
            </select>

            <button type="submit" class="admin__btn">Применить</button>

            @if ($hasFilters)
                <a href="{{ route('admin.products.index') }}" class="admin__btn admin__btn--muted">Сбросить</a>
            @endif
        </div>
    </form>

    <p class="admin__results">Найдено товаров: {{ $products->total() }}</p>

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
                        @if ($product->manufacturer)
                            <span class="admin__muted">Производитель: {{ $product->manufacturer }}</span>
                        @endif
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
