<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказ № {{ $order->order_id }} — АСТМАСТЕР</title>
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
                <a class="breadcrumbs__link" href="{{ route('orders.index') }}">Мои заказы</a>
            </li>
            <li class="breadcrumbs__item"><span class="breadcrumbs__separator">></span></li>
            <li class="breadcrumbs__item">
                <span class="breadcrumbs__current">Заказ № {{ $order->order_id }}</span>
            </li>
        </ol>
        <h1 class="page__title">Заказ № {{ $order->order_id }}</h1>
    </nav>
</div>

<section class="orders">
    <div class="container">
        <div class="orders__card">
            <div class="order-detail__head">
                <div>
                    <h2 class="orders__title">Заказ № {{ $order->order_id }}</h2>
                    <p class="order-card__date">
                        от {{ $order->created_at?->format('d.m.Y H:i') }}
                    </p>
                </div>

                <span class="order-status order-status--{{ $order->status }}">
                    {{ $order->status }}
                </span>
            </div>

            <div class="order-detail__info">
                <div>
                    <span class="order-detail__label">Получатель</span>
                    <strong>{{ $order->customer_name }}</strong>
                </div>
                <div>
                    <span class="order-detail__label">Email</span>
                    <strong>{{ $order->email }}</strong>
                </div>
                <div>
                    <span class="order-detail__label">Адрес доставки</span>
                    <strong>{{ $order->delivery_address }}</strong>
                </div>
                @if ($order->comment)
                    <div>
                        <span class="order-detail__label">Комментарий</span>
                        <strong>{{ $order->comment }}</strong>
                    </div>
                @endif
            </div>

            <h3 class="order-detail__subtitle">Состав заказа</h3>

            <table class="order-detail__table">
                <thead>
                <tr>
                    <th>Товар</th>
                    <th>Кол-во</th>
                    <th>Цена за ед.</th>
                    <th>Сумма</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name_snapshot }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->unit_price, 2, ',', ' ') }} ₽</td>
                        <td>
                            {{ number_format($item->quantity * $item->unit_price, 2, ',', ' ') }} ₽
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="order-detail__total">
                <span>Итого:</span>
                <strong>{{ number_format($order->total_amount, 2, ',', ' ') }} ₽</strong>
            </div>

            <p class="orders__links">
                <a href="{{ route('orders.index') }}">Ко всем заказам</a>
            </p>
        </div>
    </div>
</section>

@include('templates.footer')
</body>
</html>
