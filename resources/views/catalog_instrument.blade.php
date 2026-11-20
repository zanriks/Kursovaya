<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог инструментов</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-cat_inst.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
</head>
<body>

    @include('templates.header')

    <div class="breadcrumbs">
        <nav class="breadcrumbs__container">
            <ol class="breadcrumbs__list">
                <li class="breadcrumbs__item">
                    <a class="breadcrumbs__link" href="/">Главная</a>
                </li>
                <li class="breadcrumbs__item"><span class="breadcrumbs__separator">></span></li>
                <li class="breadcrumbs__item">
                    <a class="breadcrumbs__link" href="/catalog">Каталог</a>
                </li>
                <li class="breadcrumbs__item"><span class="breadcrumbs__separator">></span></li>
                <li class="breadcrumbs__item">
                    <span class="breadcrumbs__current">{{ $category->name }}</span>
                </li>
            </ol>
            <h1 class="page__title">{{ $category->name }}</h1>
        </nav>
    </div>


    <section class="category-page">
        <div class="category-page__container container">
            <aside class="category-page__filters filters">
                <form id="catalog-filters"
                      method="GET"
                      action="{{ route('catalog.show', $category->slug) }}">

                    @if ($errors->any())
                        <div class="filters__error">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="filters__group">
                        <h3 class="filters__title">Цена, ₽</h3>

                        <div class="filters__price-range">
                            <input class="filters__price-input filters__price-input--min"
                                   type="number"
                                   name="price_min"
                                   min="0"
                                   value="{{ old('price_min', request('price_min')) }}"
                                   placeholder="от 0">

                            <input class="filters__price-input filters__price-input--max"
                                   type="number"
                                   name="price_max"
                                   min="0"
                                   value="{{ old('price_max', request('price_max')) }}"
                                   placeholder="до 95990">
                        </div>

                        <ul class="filters__price-list">
                            @foreach ([
                                '0-7000' => 'До 7 000 ₽',
                                '7001-10000' => '7 001 - 10 000 ₽',
                                '10001-16000' => '10 001 - 16 000 ₽',
                                '16001-20000' => '16 001 - 20 000 ₽',
                                '20001-999999999' => 'Более 20 000 ₽',
                            ] as $value => $label)
                                <li class="filters__price-item">
                                    <label class="filters__price-label">
                                        <input class="filters__price-checkbox"
                                               type="radio"
                                               name="price_range"
                                               value="{{ $value }}"
                                            @checked(request('price_range') === $value)>
                                        {{ $label }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    @if ($manufacturers->isNotEmpty())
                        <div class="filters__group">
                            <h3 class="filters__title">Производители</h3>

                            <ul class="filters__manufacturer-list">
                                @foreach ($manufacturers as $manufacturer)
                                    <li class="filters__manufacturer-item">
                                        <label class="filters__manufacturer-label">
                                            <input class="filters__manufacturer-checkbox"
                                                   type="checkbox"
                                                   name="manufacturer[]"
                                                   value="{{ $manufacturer }}"
                                                @checked(in_array($manufacturer, (array) request('manufacturer', []), true))>
                                            {{ $manufacturer }}
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="filters__group">
                        <ul class="filters__extra-list">
                            <li class="filters__extra-item">
                                <label class="filters__extra-label">
                                    <input class="filters__extra-checkbox"
                                           type="checkbox"
                                           name="rating_min"
                                           value="4"
                                        @checked((float) request('rating_min', 0) >= 4)>
                                    Рейтинг 4 и выше
                                </label>
                            </li>

                            <li class="filters__extra-item">
                                <label class="filters__extra-label">
                                    <input class="filters__extra-checkbox"
                                           type="checkbox"
                                           name="is_hit"
                                           value="1"
                                        @checked(request()->boolean('is_hit'))>
                                    Хиты продаж
                                </label>
                            </li>
                        </ul>
                    </div>

                    <button type="submit" class="filters__apply">
                        Применить фильтры
                    </button>

                    <a class="filters__reset"
                       href="{{ route('catalog.show', $category->slug) }}">
                        Сбросить
                    </a>
                </form>
            </aside>


            <div class="category-page__products products">
                <button class="filters__toggle" id="filtersToggle" type="button">
                    <span>Выбрать фильтры</span>
                </button>
                <div class="catalog-sort">
                    <label class="catalog-sort__label" for="sort">Сортировка:</label>

                    <select id="sort"
                            name="sort"
                            form="catalog-filters"
                            class="catalog-sort__select"
                            onchange="document.getElementById('catalog-filters').submit()">
                        <option value="default" @selected(request('sort', 'default') === 'default')>
                            По популярности
                        </option>
                        <option value="price_asc" @selected(request('sort') === 'price_asc')>
                            Сначала дешевле
                        </option>
                        <option value="price_desc" @selected(request('sort') === 'price_desc')>
                            Сначала дороже
                        </option>
                        <option value="rating_desc" @selected(request('sort') === 'rating_desc')>
                            По рейтингу
                        </option>
                        <option value="new" @selected(request('sort') === 'new')>
                            Сначала новые
                        </option>
                        <option value="name_asc" @selected(request('sort') === 'name_asc')>
                            По названию
                        </option>
                    </select>

                    <noscript>
                        <button type="submit" form="catalog-filters" class="catalog-sort__btn">
                            Применить
                        </button>
                    </noscript>
                </div>
                <ul class="products__grid">
                    @forelse ($products as $product)
                        <li class="products__item product-card">
                            <a href="/product/{{ $product->slug }}" style="color: inherit; text-decoration: none;">
                                <img class="product-card__image"
                                    src="{{ asset($product->primaryImage?->image_url ?? 'img/hits-photo/perforator.png') }}"
                                    alt="{{ $product->name }}">
                            </a>

                            @if ($product->old_price && $product->old_price > $product->price)
                                <div class="product-card__badge product-card__badge--discount">
                                    -{{ round((1 - $product->price / $product->old_price) * 100) }}%
                                </div>
                            @endif

                            <div class="product-card__price">
                                <span class="product-card__price-current">
                                    {{ number_format($product->price, 0, ',', ' ') }} ₽
                                </span>
                                @if ($product->old_price)
                                    <span class="product-card__price-old">
                                        {{ number_format($product->old_price, 0, ',', ' ') }} ₽
                                    </span>
                                @endif
                            </div>

                            <a href="/product/{{ $product->slug }}" style="color: inherit; text-decoration: none;">
                                <h3 class="product-card__name">{{ $product->name }}</h3>
                            </a>

                            <div class="product-card__rating">
                                <span class="product-card__stars">
                                    <img src="{{ asset('img/icons/star.svg') }}" alt="">
                                    {{ number_format($product->rating_cache, 2) }}
                                </span>
                                @if ($product->reviews_count > 0)
                                    <span class="product-card__reviews">
                                        {{ $product->reviews_count }} отзывов
                                    </span>
                                @endif
                            </div>

                            <div class="product-card__actions">
                                @include('templates.product-cart-controls', [
                                    'product' => $product,
                                    'cartItems' => $cartItems,
                                    'formClass' => 'product-card__cart-form',
                                    'buttonClass' => 'product-card__action product-card__action--add',
                                ])

                                <button class="product-card__action product-card__action--favorite">
                                    <img src="{{ asset('img/header-icon/heart.svg') }}" alt="Избранное">
                                </button>
                            </div>
                        </li>
                    @empty
                        <li class="products__item product-card">
                            В этой категории пока нет товаров
                        </li>
                    @endforelse
                </ul>
                <button class="show__more-btn">Показать ещё</button>
            </div>
        </div>
    </section>

    @include('templates.footer')
</body>
</html>

