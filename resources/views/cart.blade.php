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
            <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="/">Главная</a></li>
            <li class="breadcrumbs__item"><span class="breadcrumbs__separator">></span></li>
            <li class="breadcrumbs__item"><span class="breadcrumbs__current">Корзина</span></li>
        </ol>
        <h1 class="page__title">Корзина</h1>
        </nav>
    </div>

    <section class="cart">
        <div class="cart__container container">
            <div class="cart__empty empty-state">
                <h3 class="empty-state__title">Пока пусто</h3>
                <p class="empty-state__desc">Воспользуйтесь каталогом или поиском</p>
                <a class="empty-state__btn" href="/catalog">Перейти в каталог ></a>
            </div>
        </div>
    </section>

@include('templates.footer')
</body>
</html>

