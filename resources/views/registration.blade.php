<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация — АСТМАСТЕР</title>
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
            <li class="breadcrumbs__item"><span class="breadcrumbs__current">Регистрация</span></li>
        </ol>
        <h1 class="page__title">Регистрация</h1>
    </nav>
</div>

<section class="profile">
    <div class="profile__container container">
        <h2 class="profile-header__username" style="text-align: center; margin-bottom: 24px;">
            Создать аккаунт
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

        <form method="POST" action="{{ route('register.store') }}">
            @csrf

            <div class="form__grid">
                <input type="text" name="login" class="form__field"
                       placeholder="Логин" value="{{ old('login') }}" required autofocus>

                <input type="text" name="first_name" class="form__field"
                       placeholder="Имя" value="{{ old('first_name') }}">

                <input type="text" name="last_name" class="form__field"
                       placeholder="Фамилия" value="{{ old('last_name') }}">

                <input type="text" name="surname" class="form__field"
                       placeholder="Отчество" value="{{ old('surname') }}">

                <input type="email" name="email" class="form__field"
                       placeholder="Email" value="{{ old('email') }}" required>

                <input type="tel" name="phone" class="form__field"
                       placeholder="Телефон" value="{{ old('phone') }}">

                <input type="password" name="password" class="form__field"
                       placeholder="Пароль" required>

                <input type="password" name="password_confirmation" class="form__field"
                       placeholder="Повторите пароль" required>
            </div>

            <div class="profile__actions actions">
                <button type="submit" class="actions__btn">Зарегистрироваться</button>
                <a href="{{ route('login') }}" class="actions__btn"
                   style="text-align: center; text-decoration: none; color: #333;">
                    У меня уже есть аккаунт
                </a>
            </div>
        </form>
    </div>
</section>

@include('templates.footer')
</body>
</html>