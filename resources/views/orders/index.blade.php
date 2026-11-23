<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои заказы — АСТМАСТЕР</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-orders.css') }}">
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
                <a class="breadcrumbs__link" href="{{ route('profile') }}">Личный кабинет</a>
            </li>
            <li class="breadcrumbs__item"><span class="breadcrumbs__separator">></span></li>
            <li class="breadcrumbs__item">
                <span class="breadcrumbs__current">Мои заказы</span>
            </li>
        </ol>
        <h1 class="page__title">Мои заказы</h1>
    </nav>
</div>

<section class="orders">
    <div class="container">
        <div class="orders__card">
            <h2 class="orders__title">История заказов</h2>

            @forelse ($orders as $order)
                <article class="order-card">
                    <div class="order-card__head">
                        <div>
                            <h3 class="order-card__number">Заказ № {{ $order->order_id }}</h3>
                            <p class="order-card__date">
                                от {{ $order->created_at?->format('d.m.Y H:i') }}
                            </p>
                        </div>

                        <span class="order-status order-status--{{ $order->status }}">
                            {{ $order->status }}
                        </span>
                    </div>

                    <div class="order-card__body">
                        <div class="order-card__meta">
                            <span>Позиций: {{ $order->items->count() }}</span>
                            <span>Получатель: {{ $order->customer_name }}</span>
                        </div>

                        <div class="order-card__total">
                            <strong>{{ number_format($order->total_amount, 2, ',', ' ') }} ₽</strong>
                        </div>
                    </div>

                    <div class="order-card__actions">
                        <a href="{{ route('orders.show', $order) }}" class="orders__btn">
                            Подробнее
                        </a>
                    </div>
                </article>
            @empty
                <div class="orders__empty">
                    <h3>У вас пока нет заказов</h3>
                    <p>Добавьте товары в корзину и оформите первый заказ.</p>
                    <a href="{{ route('catalog') }}" class="orders__btn">Перейти в каталог</a>
                </div>
            @endforelse

            <p class="orders__links">
                <a href="{{ route('profile') }}">Вернуться в профиль</a>
            </p>
        </div>
    </div>
</section>

@include('templates.footer')
</body>
</html>
