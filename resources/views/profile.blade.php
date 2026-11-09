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
                    <h2 class="profile-header__username">
                        {{ trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: $user->login }}
                    </h2>
                    <p class="profile-header__reg-date">
                        Дата регистрации: {{ $user->created_at?->format('d.m.Y') }}
                    </p>
                </div>
            </div>

            <div class="form__grid">
                <input type="text" class="form__field" value="{{ $user->first_name }}" placeholder="Имя" readonly>
                <input type="text" class="form__field" value="{{ $user->last_name }}" placeholder="Фамилия" readonly>
                <input type="tel" class="form__field" value="{{ $user->phone }}" placeholder="Номер телефона" readonly>
                <input type="email" class="form__field" value="{{ $user->email }}" placeholder="Электронная почта" readonly>
                <input type="text" class="form__field" value="{{ $user->login }}" placeholder="Логин" readonly>
            </div>

            <div class="profile__actions actions">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="actions__btn actions__btn--logout">Выйти</button>
                </form>
            </div>
        </div>
    </section>

    @include('templates.footer')
</body>
</html>

