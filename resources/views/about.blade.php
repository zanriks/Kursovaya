<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>О нас</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-about.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
</head>
<body>
@include('templates.header')

    <div class="breadcrumbs">
        <nav class="breadcrumbs__container">
        <ol class="breadcrumbs__list">
            <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="/">Главная</a></li>
            <li class="breadcrumbs__item"><span class="breadcrumbs__separator">></span></li>
            <li class="breadcrumbs__item"><span class="breadcrumbs__current">О нас</span></li>
        </ol>
        <h1 class="page__title">О нас</h1>
        </nav>
    </div>

    <section class="intro">
        <div class="intro__container">
            <div class="intro__image">
                <img src="{{ asset('img/img-about/grupovaya_photographiya 1.png') }}" alt="Наша команда" class="intro__img" />
            </div>
            <p class="intro__text">
                Наш строительный магазин — это более чем 5 лет уверенной работы на рынке. За эти годы мы стали надежным партнером для тысяч профессионалов и домашних мастеров, которые доверяют нам самое ценное — свой дом.
            </p>
        </div>
    </section>

    <section class="team">
        <div class="team__container">
            <h2 class="team__title">Наша команда</h2>
            <div class="team__members">
                <div class="member">
                    <img src="{{ asset('img/img-about/upravlyauhiy.png') }}" alt="Управляющий" class="member__photo">
                    <p class="member__role">Управляющий</p>
                </div>
                <div class="member">
                    <img src="{{ asset('img/img-about/specialist.png') }}" alt="Специалист по подбору материалов" class="member__photo">
                    <p class="member__role">Специалист по подбору материалов</p>
                </div>
                <div class="member">
                    <img src="{{ asset('img/img-about/logist.png') }}" alt="Логист" class="member__photo">
                    <p class="member__role">Логист</p>
                </div>
                <div class="member">
                    <img src="{{ asset('img/img-about/driver.png') }}" alt="Водитель" class="member__photo">
                    <p class="member__role">Водитель</p>
                </div>
            </div>
        </div>
    </section>

    <section class="products">
        <div class="products__container">
            <h2 class="products__title">В магазинах АСТМАСТЕР вы найдёте:</h2>
            <div class="products__list">
                <p class="products__item">Строительные материалы: цемент, кирпичи, блоки, древесина и многое другое.</p>
                <p class="products__item">Отделочные материалы: обои, плитка, краски, напольные покрытия.</p>
                <p class="products__item">Сантехника: оборудование для ванных комнат, кухни и водоснабжения.</p>
                <p class="products__item">Инструменты: профессиональные и бытовые инструменты для ремонта и строительства.</p>
                <p class="products__item">Дача и сад: семена, рассада, саженцы плодовых и декоративных культур, грунты, техника для сада и огорода, садовый инвентарь</p>
            </div>
        </div>
    </section>

    <section class="company">
        <div class="company__container">
            <h2 class="company__title">Реквизиты компании:</h2>
            <div class="company__info">
                <p class="company__line">Общество с ограниченной ответственностью «Строительный магазин «АСТМАСТЕР»</p>
                <p class="company__line">ИНН: 7392543549</p>
                <p class="company__line">КПП: 997350001</p>
                <p class="company__line">ОГРН: 1067841986742</p>
                <p class="company__line">Юридический адрес: 650000, г. Кемерово, Красноармейская улица, 136</p>
                <p class="company__line">Р/с: 40702843255570424182</p>
                <p class="company__line">Северо-Западный банк ПАО «СБЕРБАНК»</p>
            </div>
        </div>
    </section>

@include('templates.footer')
</body>
</html>
