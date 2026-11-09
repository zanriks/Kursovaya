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
                <div class="filters__group">
                    <h3 class="filters__title">Цена, ₽</h3>
                    <div class="filters__price-range">
                        <input class="filters__price-input filters__price-input--min" type="number" placeholder="от 0">
                        <input class="filters__price-input filters__price-input--max" type="number" placeholder="до 95990">
                    </div>
                    <ul class="filters__price-list">
                        <li class="filters__price-item">
                            <label class="filters__price-label">
                                <input class="filters__price-checkbox" type="checkbox">
                                Менее 7000 ₽
                            </label>
                        </li>
                        <li class="filters__price-item">
                            <label class="filters__price-label">
                                <input class="filters__price-checkbox" type="checkbox">
                                7001 - 10 000 ₽
                            </label>
                        </li>
                        <li class="filters__price-item">
                            <label class="filters__price-label">
                                <input class="filters__price-checkbox" type="checkbox">
                                10 001 - 16 000 ₽
                            </label>
                        </li>
                        <li class="filters__price-item">
                            <label class="filters__price-label">
                                <input class="filters__price-checkbox" type="checkbox">
                                16 001 - 20 000 ₽
                            </label>
                        </li>
                        <li class="filters__price-item">
                            <label class="filters__price-label">
                                <input class="filters__price-checkbox" type="checkbox">
                                20 000 ₽ и более
                            </label>
                        </li>
                    </ul>
                </div>

                <div class="filters__group">
                    <h3 class="filters__title">Производители</h3>
                    <ul class="filters__manufacturer-list">
                        <li class="filters__manufacturer-item">
                            <label class="filters__manufacturer-label">
                                <input class="filters__manufacturer-checkbox" type="checkbox">
                                DEKO
                            </label>
                        </li>
                        <li class="filters__manufacturer-item">
                            <label class="filters__manufacturer-label">
                                <input class="filters__manufacturer-checkbox" type="checkbox">
                                Bosch
                            </label>
                        </li>
                        <li class="filters__manufacturer-item">
                            <label class="filters__manufacturer-label">
                                <input class="filters__manufacturer-checkbox" type="checkbox">
                                Makita
                            </label>
                        </li>
                        <li class="filters__manufacturer-item">
                            <label class="filters__manufacturer-label">
                                <input class="filters__manufacturer-checkbox" type="checkbox">
                                Интерскол
                            </label>
                        </li>
                        <li class="filters__manufacturer-item">
                            <label class="filters__manufacturer-label">
                                <input class="filters__manufacturer-checkbox" type="checkbox">
                                Лепсе
                            </label>
                        </li>
                        <li class="filters__manufacturer-item">
                            <label class="filters__manufacturer-label">
                                <input class="filters__manufacturer-checkbox" type="checkbox">
                                Hilti
                            </label>
                        </li>
                        <li class="filters__manufacturer-item">
                            <label class="filters__manufacturer-label">
                                <input class="filters__manufacturer-checkbox" type="checkbox">
                                Фиолент
                            </label>
                        </li>
                    </ul>
                    <button class="filters__show-more">Показать ещё 115</button>
                </div>

                <div class="filters__group">
                    <ul class="filters__extra-list">
                        <li class="filters__extra-item">
                            <label class="filters__extra-label">
                                <input class="filters__extra-checkbox" type="checkbox">
                                Рейтинг 4 и выше
                            </label>
                        </li>
                        <li class="filters__extra-item">
                            <label class="filters__extra-label">
                                <input class="filters__extra-checkbox" type="checkbox">
                                Надёжные модели
                            </label>
                        </li>
                    </ul>
                    <a class="filters__all-link" href="/filters">Все фильтры →</a>
                </div>
            </aside>


            <div class="category-page__products products">
                <button class="filters__toggle" id="filtersToggle" type="button">
                    <span>Выбрать фильтры</span>
                </button>
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
                                <button class="product-card__action product-card__action--add">
                                    В корзину
                                </button>
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

