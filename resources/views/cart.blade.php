<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-cart.css') }}">
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
            <li class="breadcrumbs__item">
                <span class="breadcrumbs__separator">></span>
            </li>
            <li class="breadcrumbs__item">
                <span class="breadcrumbs__current">Корзина</span>
            </li>
        </ol>
        <h1 class="page__title">Корзина</h1>
    </nav>
</div>

<section class="cart">
    <div class="cart__container container">
        @if ($items->isEmpty())
            <div class="cart__empty empty-state">
                <h3 class="empty-state__title">Пока пусто</h3>
                <p class="empty-state__desc">
                    Воспользуйтесь каталогом или поиском
                </p>
                <a class="empty-state__btn" href="{{ route('catalog') }}">
                    Перейти в каталог >
                </a>
            </div>
        @else
            <div class="cart__list">
                @foreach ($items as $item)
                    <article class="cart-item">
                        <a class="cart-item__image-link"
                           href="{{ route('product.show', $item->product->slug) }}">
                            @if ($item->product->primaryImage)
                                <img class="cart-item__image"
                                     src="{{ asset($item->product->primaryImage->image_url) }}"
                                     alt="{{ $item->product->name }}">
                            @else
                                <img class="cart-item__image"
                                     src="{{ asset('img/product-card/main-photo.png') }}"
                                     alt="{{ $item->product->name }}">
                            @endif
                        </a>

                        <div class="cart-item__info">
                            <a class="cart-item__name"
                               href="{{ route('product.show', $item->product->slug) }}">
                                {{ $item->product->name }}
                            </a>
                            <p class="cart-item__sku">
                                Артикул: {{ $item->product->sku }}
                            </p>
                        </div>

                        <div class="cart-item__quantity">
                            {{ $item->quantity }} шт.
                        </div>

                        <div class="cart-item__price">
                            {{ number_format((float) $item->price_at_add, 0, ',', ' ') }} ₽
                        </div>

                        <div class="cart-item__sum">
                            {{ number_format((float) $item->price_at_add * $item->quantity, 0, ',', ' ') }} ₽
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="cart__summary">
                <span class="cart__summary-label">Итого:</span>
                <span class="cart__summary-value">
                    {{ number_format($total, 0, ',', ' ') }} ₽
                </span>
            </div>
        @endif
    </div>
</section>

@include('templates.footer')
</body>
</html>
