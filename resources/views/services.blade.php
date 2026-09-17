<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Услуги</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-services.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
</head>
<body>

    @include('templates.header')

    <div class="breadcrumbs">
        <nav class="breadcrumbs__container">
        <ol class="breadcrumbs__list">
            <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="/">Главная</a></li>
            <li class="breadcrumbs__item"><span class="breadcrumbs__separator">></span></li>
            <li class="breadcrumbs__item"><span class="breadcrumbs__current">Услуги</span></li>
        </ol>
        <h1 class="page__title">Услуги</h1>
        </nav>
    </div>

    <section class="services-grid">
        <div class="services-grid__container container">
            <ul class="services-grid__list">
                <li class="services-grid__item service-card">
                <h3 class="service-card__title">Смета онлайн</h3>
                </li>
                <li class="services-grid__item service-card">
                <h3 class="service-card__title">Сборка мебели</h3>
                </li>
                <li class="services-grid__item service-card">
                <h3 class="service-card__title">Вызов замерщика бесплатно</h3>
                </li>
                <li class="services-grid__item service-card">
                <h3 class="service-card__title">Консультации по строительным нормам</h3>
                </li>
                <li class="services-grid__item service-card">
                <h3 class="service-card__title">Смета онлайн</h3>
                </li>
                <li class="services-grid__item service-card">
                <h3 class="service-card__title">Сборка мебели</h3>
                </li>
                <li class="services-grid__item service-card">
                <h3 class="service-card__title">Смета онлайн</h3>
                </li>
                <li class="services-grid__item service-card">
                <h3 class="service-card__title">Сборка мебели</h3>
                </li>
                <li class="services-grid__item service-card">
                <h3 class="service-card__title">Смета онлайн</h3>
                </li>
                <li class="services-grid__item service-card">
                <h3 class="service-card__title">Сборка мебели</h3>
                </li>
            </ul>
        </div>
    </section>

    @include('templates.footer')

</body>
</html>

