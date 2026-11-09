<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход — АСТМАСТЕР</title>
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
            <li class="breadcrumbs__item"><span class="breadcrumbs__current">Вход</span></li>
        </ol>
        <h1 class="page__title">Вход</h1>
    </nav>
</div>

<section class="profile">
    <div class="profile__container container">
        <h2 class="profile-header__username" style="text-align: center; margin-bottom: 24px;">
            Войдите в личный кабинет
        </h2>

        @if ($errors->any())
            <div style="background: #fde8e8; color: #9b1c1c; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px;">
                <ul style="margin: 0; padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <div class="form__grid">
                <input type="text" name="login" class="form__field"
                       placeholder="Email или логин" value="{{ old('login') }}" required autofocus>
                <input type="password" name="password" class="form__field"
                       placeholder="Пароль" required>
            </div>

            <label style="display: flex; align-items: center; gap: 8px; margin-bottom: 20px;">
                <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                Запомнить меня
            </label>

            <div class="profile__actions actions">
                <button type="submit" class="actions__btn">Войти</button>
                <a href="{{ route('register') }}" class="actions__btn"
                   style="text-align: center; text-decoration: none; color: #333;">
                    Регистрация
                </a>
            </div>
        </form>
    </div>
</section>

@include('templates.footer')
</body>
</html>