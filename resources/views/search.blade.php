<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Поиск — АСТМАСТЕР</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-cat_inst.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-search.css') }}">
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
                <span class="breadcrumbs__current">Поиск</span>
            </li>
        </ol>
        <h1 class="page__title">Результаты поиска</h1>
    </nav>
</div>

<section class="category-page">
    <div class="category-page__container container">
        <div class="category-page__products products">
            <div class="search-results__summary">
                По запросу <strong>«{{ $query }}»</strong> найдено товаров:
                <strong>{{ $products->total() }}</strong>
            </div>

            @if ($products->isEmpty())
                <div class="search-results__empty">
                    <p>По запросу «{{ $query }}» ничего не найдено.</p>
                    <p>
                        Попробуйте изменить запрос или
                        <a href="/catalog">перейти в каталог</a>.
                    </p>
                </div>
            @else
                <ul class="products__grid">
                    @foreach ($products as $product)
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

                                @include('templates.favorite-button', [
                                    'product' => $product,
                                    'favoriteIds' => $favoriteIds,
                                    'buttonClass' => 'product-card__action product-card__action--favorite',
                                ])
                            </div>
                        </li>
                    @endforeach
                </ul>

                @if ($products->hasPages())
                    <nav class="search-pagination" aria-label="Навигация по результатам поиска">
                        @if ($products->onFirstPage())
                            <span class="search-pagination__link search-pagination__link--disabled">Назад</span>
                        @else
                            <a class="search-pagination__link"
                               href="{{ $products->previousPageUrl() }}"
                               rel="prev">Назад</a>
                        @endif

                        <span class="search-pagination__info">
                            Страница {{ $products->currentPage() }} из {{ $products->lastPage() }}
                        </span>

                        @if ($products->hasMorePages())
                            <a class="search-pagination__link"
                               href="{{ $products->nextPageUrl() }}"
                               rel="next">Вперёд</a>
                        @else
                            <span class="search-pagination__link search-pagination__link--disabled">Вперёд</span>
                        @endif
                    </nav>
                @endif
            @endif
        </div>
    </div>
</section>

@include('templates.footer')
</body>
</html>
