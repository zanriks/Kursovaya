<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Избранное</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-favorite.css') }}">
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
        <h1 class="page__title">Избранное</h1>
        </nav>
    </div>

    <section class="favorites">
        <div class="favorites__container container">
            <div class="favorites__empty empty-state">
                <h3 class="empty-state__title">Ваш список пуст</h3>
                <p class="empty-state__desc">Воспользуйтесь каталогом или поиском</p>
                <a class="empty-state__btn" href="/catalog">Перейти в каталог ></a>
            </div>
        </div>
    </section>

    @include('templates.footer')
</body>
</html>

