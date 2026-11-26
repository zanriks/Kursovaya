<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Избранное</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-favorite.css') }}">
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
                <span class="breadcrumbs__current">Избранное</span>
            </li>
        </ol>
        <h1 class="page__title">Избранное</h1>
    </nav>
</div>

<section class="favorites">
    <div class="favorites__container container">
        @if (session('favorite_success'))
            <div class="favorites__message">
                {{ session('favorite_success') }}
            </div>
        @endif

        @if ($products->isNotEmpty())
            <ul class="products__grid">
                @foreach ($products as $product)
                    <li class="product-card">
                    <a href="{{ route('product.show', $product->slug) }}" class="product-card__link">
                        <img class="product-card__image"
                             src="{{ asset($product->primaryImage?->image_url ?? 'img/product-card/main-photo.png') }}"
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

                    <a href="{{ route('product.show', $product->slug) }}" class="product-card__link">
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
        @else
            <div class="favorites__empty empty-state">
                <h3 class="empty-state__title">Ваш список пуст</h3>
                <p class="empty-state__desc">Воспользуйтесь каталогом или поиском</p>
                <a class="empty-state__btn" href="{{ route('catalog') }}">Перейти в каталог ></a>
            </div>
        @endif
    </div>
</section>

@include('templates.footer')
</body>
</html>
