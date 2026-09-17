<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контакты</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-contacts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
</head>
<body>

    @include('templates.header')

    <div class="breadcrumbs">
        <nav class="breadcrumbs__container">
        <ol class="breadcrumbs__list">
            <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="/">Главная</a></li>
            <li class="breadcrumbs__item"><span class="breadcrumbs__separator">></span></li>
            <li class="breadcrumbs__item"><span class="breadcrumbs__current">Контакты</span></li>
        </ol>
        <h1 class="page__title">Контакты</h1>
        </nav>
    </div>

    <section class="contacts">
        <div class="contacts__container container">
            <div class="contacts__info info-block">
                <h2 class="info-block__title">Всегда рады вас видеть</h2>

                <div class="info-block__item">
                    <h3 class="info-block__label">Адрес</h3>
                    <p class="info-block__value">Город Томск Ул. колёсная 4</p>
                </div>

                <div class="info-block__item">
                    <h3 class="info-block__label">Телефон</h3>
                    <p class="info-block__value">+7 (900) 888 - 88 - 88</p>
                </div>

                <div class="info-block__item">
                    <h3 class="info-block__label">Email</h3>
                    <p class="info-block__value">info@shurik.ru</p>
                </div>

                <div class="info-block__item">
                    <h3 class="info-block__label">Часы работы</h3>
                    <p class="info-block__value">Пн-Сб 9:00 - 19:00</p>
                    <p class="info-block__value">Вс выходной</p>
                </div>

                <div class="info-block__item">
                    <h3 class="info-block__label">Реквизиты компании</h3>
                    <p class="info-block__value">ИНН 893333222342123</p>
                </div>
            </div>

            <div class="contacts__map map">
                <div class="map-wrapper">
                    <img src="{{ asset('img/contacts_map.avif') }}" alt="Карта Томска">
                </div>
            </div>
        </div>
    </section>

    @include('templates.footer')
</body>
</html>

