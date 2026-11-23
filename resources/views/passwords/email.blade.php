<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Восстановление пароля — АСТМАСТЕР</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-auth.css') }}">
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
                <span class="breadcrumbs__current">Восстановление пароля</span>
            </li>
        </ol>
        <h1 class="page__title">Восстановление пароля</h1>
    </nav>
</div>

<section class="auth">
    <div class="auth__container">
        <div class="auth__card">
            <h2 class="auth__title">Восстановить пароль</h2>

            <p class="auth__hint">
                Введите email, указанный при регистрации. Мы отправим ссылку для сброса пароля.
            </p>

            @if (session('status'))
                <div class="auth__status">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="auth__errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="auth__grid">
                    <label class="auth__label auth__label--full">
                        Email
                        <input type="email"
                               name="email"
                               class="auth__input"
                               value="{{ old('email') }}"
                               autocomplete="email"
                               required
                               autofocus>
                    </label>
                </div>

                <button type="submit" class="auth__submit">Отправить ссылку</button>

                <p class="auth__switch">
                    <a href="{{ route('login') }}">Вернуться к входу</a>
                </p>
            </form>
        </div>
    </div>
</section>

@include('templates.footer')
</body>
</html>
