<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход и регистрация — АСТМАСТЕР</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
</head>
<body>
@include('templates.header')

@php
    $activeTab = $activeTab ?? 'login';
@endphp

<div class="breadcrumbs">
    <nav class="breadcrumbs__container">
        <ol class="breadcrumbs__list">
            <li class="breadcrumbs__item">
                <a class="breadcrumbs__link" href="/">Главная</a>
            </li>
            <li class="breadcrumbs__item"><span class="breadcrumbs__separator">></span></li>
            <li class="breadcrumbs__item">
                <span class="breadcrumbs__current">Вход и регистрация</span>
            </li>
        </ol>
        <h1 class="page__title">Личный кабинет</h1>
    </nav>
</div>

<section class="auth">
    <div class="auth__container">
        <div class="auth__card">
            <div class="auth__tabs" role="tablist">
                <button type="button"
                        class="auth__tab {{ $activeTab === 'login' ? 'is-active' : '' }}"
                        data-tab="login">
                    Вход
                </button>
                <button type="button"
                        class="auth__tab {{ $activeTab === 'register' ? 'is-active' : '' }}"
                        data-tab="register">
                    Регистрация
                </button>
            </div>

            @if ($errors->any())
                <div class="auth__errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="auth__panel {{ $activeTab === 'login' ? 'is-active' : '' }}"
                 data-panel="login">
                <h2 class="auth__title">Вход в личный кабинет</h2>

                <form method="POST" action="{{ route('login.store') }}">
                    @csrf

                    <div class="auth__grid">
                        <label class="auth__label auth__label--full">
                            Email или логин
                            <input type="text" name="login" class="auth__input"
                                   value="{{ old('login') }}" required autofocus>
                        </label>

                        <label class="auth__label auth__label--full">
                            Пароль
                            <input type="password" name="password" class="auth__input" required>
                        </label>
                    </div>

                    <label class="auth__checkbox">
                        <input type="checkbox" name="remember" value="1"
                               {{ old('remember') ? 'checked' : '' }}>
                        Запомнить меня
                    </label>

                    <button type="submit" class="auth__submit">Войти</button>

                    <p class="auth__switch">
                        Нет аккаунта?
                        <button type="button" data-tab="register">Зарегистрироваться</button>
                    </p>
                </form>
            </div>

            <div class="auth__panel {{ $activeTab === 'register' ? 'is-active' : '' }}"
                 data-panel="register">
                <h2 class="auth__title">Создать аккаунт</h2>

                <form method="POST" action="{{ route('register.store') }}">
                    @csrf

                    <div class="auth__grid">
                        <label class="auth__label auth__label--full">
                            Логин
                            <input type="text" name="login" class="auth__input"
                                   value="{{ old('login') }}" required>
                        </label>

                        <label class="auth__label">
                            Имя
                            <input type="text" name="first_name" class="auth__input"
                                   value="{{ old('first_name') }}">
                        </label>

                        <label class="auth__label">
                            Фамилия
                            <input type="text" name="last_name" class="auth__input"
                                   value="{{ old('last_name') }}">
                        </label>

                        <label class="auth__label">
                            Отчество
                            <input type="text" name="surname" class="auth__input"
                                   value="{{ old('surname') }}">
                        </label>

                        <label class="auth__label">
                            Телефон
                            <input type="tel" name="phone" class="auth__input"
                                   value="{{ old('phone') }}">
                        </label>

                        <label class="auth__label auth__label--full">
                            Email
                            <input type="email" name="email" class="auth__input"
                                   value="{{ old('email') }}" required>
                        </label>

                        <label class="auth__label">
                            Пароль
                            <input type="password" name="password" class="auth__input" required>
                        </label>

                        <label class="auth__label">
                            Повторите пароль
                            <input type="password" name="password_confirmation"
                                   class="auth__input" required>
                        </label>
                    </div>

                    <button type="submit" class="auth__submit">Зарегистрироваться</button>

                    <p class="auth__switch">
                        Уже есть аккаунт?
                        <button type="button" data-tab="login">Войти</button>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    document.querySelectorAll('[data-tab]').forEach(function (button) {
        button.addEventListener('click', function () {
            const tab = button.dataset.tab;

            document.querySelectorAll('.auth__tab').forEach(function (tabButton) {
                tabButton.classList.toggle('is-active', tabButton.dataset.tab === tab);
            });

            document.querySelectorAll('[data-panel]').forEach(function (panel) {
                panel.classList.toggle('is-active', panel.dataset.panel === tab);
            });
        });
    });
</script>

@include('templates.footer')
</body>
</html>