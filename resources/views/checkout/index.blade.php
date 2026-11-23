<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оформление заказа — АСТМАСТЕР</title>
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
                <a class="breadcrumbs__link" href="{{ route('cart.index') }}">Корзина</a>
            </li>
            <li class="breadcrumbs__item"><span class="breadcrumbs__separator">></span></li>
            <li class="breadcrumbs__item">
                <span class="breadcrumbs__current">Оформление заказа</span>
            </li>
        </ol>
        <h1 class="page__title">Оформление заказа</h1>
    </nav>
</div>

<section class="checkout">
    <div class="container">
        <div class="checkout__card">
            @if ($errors->any())
                <div class="checkout__errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="checkout__grid">
                <div class="checkout__form-wrap">
                    <h2 class="checkout__title">Данные получателя</h2>

                    <form method="POST" action="{{ route('checkout.store') }}">
                        @csrf

                        <label class="checkout__field">
                            Имя получателя
                            <input type="text"
                                   name="customer_name"
                                   class="checkout__input"
                                   value="{{ old('customer_name', $defaultName) }}"
                                   required>
                        </label>

                        <label class="checkout__field">
                            Email
                            <input type="email"
                                   name="email"
                                   class="checkout__input"
                                   value="{{ old('email', $user->email) }}"
                                   required>
                        </label>

                        <label class="checkout__field">
                            Адрес доставки
                            <textarea name="delivery_address"
                                      class="checkout__input checkout__textarea"
                                      rows="3"
                                      required>{{ old('delivery_address') }}</textarea>
                        </label>

                        <label class="checkout__field">
                            Комментарий
                            <textarea name="comment"
                                      class="checkout__input checkout__textarea"
                                      rows="3">{{ old('comment') }}</textarea>
                        </label>

                        <button type="submit" class="checkout__btn">
                            Подтвердить заказ
                        </button>
                    </form>
                </div>

                <aside class="checkout__summary">
                    <h2 class="checkout__title">Ваш заказ</h2>

                    @foreach ($items as $item)
                        <div class="checkout__item">
                            <span>{{ $item->product?->name ?? 'Товар удалён' }}</span>
                            <span>{{ $item->quantity }} × {{ number_format($item->price_at_add, 0, ',', ' ') }} ₽</span>
                            <strong>
                                {{ number_format($item->price_at_add * $item->quantity, 0, ',', ' ') }} ₽
                            </strong>
                        </div>
                    @endforeach

                    <div class="checkout__total">
                        <span>Итого:</span>
                        <strong>{{ number_format($total, 0, ',', ' ') }} ₽</strong>
                    </div>

                    <a href="{{ route('cart.index') }}" class="checkout__back">
                        Вернуться в корзину
                    </a>
                </aside>
            </div>
        </div>
    </div>
</section>

@include('templates.footer')
</body>
</html>