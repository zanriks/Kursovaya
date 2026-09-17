<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
</head>
<body>

    @include('templates.header')

    <div class="breadcrumbs">
        <nav class="breadcrumbs__container">
        <ol class="breadcrumbs__list">
            <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="/">Главная</a></li>
            <li class="breadcrumbs__item"><span class="breadcrumbs__separator">></span></li>
            <li class="breadcrumbs__item"><span class="breadcrumbs__current">Личный кабинет</span></li>
        </ol>
        <h1 class="page__title">Личный кабинет</h1>
        </nav>
    </div>

    <section class="profile">
        <div class="profile__container container">
            <div class="profile__header profile-header">
                <img class="profile-header__avatar" src="{{ asset('img/avatar.jpg') }}" alt="Аватар пользователя">
                <div class="profile-header__info">
                    <h2 class="profile-header__username">Артемий-31b153e</h2>
                    <p class="profile-header__reg-date">Дата регистрации: 16.10.2024</p>
                </div>
            </div>

        <div class="form__grid">
            <input type="text" class="form__field" placeholder="Имя">
            <input type="text" class="form__field" placeholder="Фамилия">
            <input type="tel" class="form__field" placeholder="Номер телефона">
            <input type="email" class="form__field" placeholder="Электронная почта">
            <input type="text" class="form__field" placeholder="Никнейм">
        </div>

            <div class="profile__actions actions">
                <button class="actions__btn actions__btn--logout">Выйти</button>
                <a class="actions__link actions__link--delete" href="/delete-profile">Удалить профиль</a>
            </div>
        </div>
    </section>

    @include('templates.footer')
</body>
</html>

