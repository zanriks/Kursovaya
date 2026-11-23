<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказ оформлен — АСТМАСТЕР</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-checkout.css') }}">
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
                <span class="breadcrumbs__current">Заказ оформлен</span>
            </li>
        </ol>
        <h1 class="page__title">Заказ оформлен</h1>
    </nav>
</div>

<section class="checkout">
    <div class="container">
        <div class="checkout__card checkout__card--success">
            <h2 class="checkout__title">Спасибо за заказ!</h2>

            <p class="checkout__success-text">
                Ваш заказ № {{ $order->order_id }} принят.
                Мы свяжемся с вами по указанному email.
            </p>

            <div class="checkout__success-sum">
                Сумма заказа:
                <strong>{{ number_format($order->total_amount, 2, ',', ' ') }} ₽</strong>
            </div>

            <h3 class="checkout__subtitle">Состав заказа</h3>

            @foreach ($order->items as $item)
                <div class="checkout__item">
                    <span>{{ $item->product_name_snapshot }}</span>
                    <span>{{ $item->quantity }} × {{ number_format($item->unit_price, 2, ',', ' ') }} ₽</span>
                    <strong>{{ number_format($item->line_total ?? ($item->quantity * $item->unit_price), 2, ',', ' ') }} ₽</strong>
                </div>
            @endforeach

            <p class="checkout__links">
                <a href="{{ route('catalog') }}">Перейти в каталог</a>
            </p>
        </div>
    </div>
</section>

@include('templates.footer')
</body>
</html>