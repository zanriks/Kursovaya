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
                <div class="profile-avatar">
                    <img class="profile-avatar__preview"
                         src="{{ $user->avatar ? asset($user->avatar) : asset('img/avatar.jpg') }}"
                         alt="Аватар пользователя">
                </div>
                <div class="profile-header__info">
                    <h2 class="profile-header__username">
                        {{ trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: $user->login }}
                    </h2>
                    <p class="profile-header__reg-date">
                        Дата регистрации: {{ $user->created_at?->format('d.m.Y') }}
                    </p>
                </div>
            </div>

            @if (session('status'))
                <div class="profile__success">
                    {{ session('status') }}
                </div>
            @endif

            <div class="form__grid">
                @if ($errors->any())
                    <div class="profile__errors">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="profile__form">
                    @csrf
                    @method('PUT')

                    <div class="form__grid">
                        <label class="profile__field">
                            <span class="profile__label">Имя</span>
                            <input type="text"
                                   name="first_name"
                                   class="form__field"
                                   value="{{ old('first_name', $user->first_name) }}"
                                   autocomplete="given-name">
                        </label>

                        <label class="profile__field">
                            <span class="profile__label">Фамилия</span>
                            <input type="text"
                                   name="last_name"
                                   class="form__field"
                                   value="{{ old('last_name', $user->last_name) }}"
                                   autocomplete="family-name">
                        </label>

                        <label class="profile__field">
                            <span class="profile__label">Отчество</span>
                            <input type="text"
                                   name="surname"
                                   class="form__field"
                                   value="{{ old('surname', $user->surname) }}">
                        </label>

                        <label class="profile__field">
                            <span class="profile__label">Телефон</span>
                            <input type="tel"
                                   name="phone"
                                   class="form__field"
                                   value="{{ old('phone', $user->phone) }}"
                                   autocomplete="tel">
                        </label>

                        <label class="profile__field">
                            <span class="profile__label">Email</span>
                            <input type="email"
                                   name="email"
                                   class="form__field"
                                   value="{{ old('email', $user->email) }}"
                                   autocomplete="email">
                        </label>

                        <label class="profile__field">
                            <span class="profile__label">Логин</span>
                            <input type="text"
                                   name="login"
                                   class="form__field"
                                   value="{{ old('login', $user->login) }}"
                                   autocomplete="username">
                        </label>
                    </div>

                    <div class="profile-avatar">
                        <h2 class="profile__section-title">Смена аватара</h2>
                        <label class="profile-avatar__upload">
                            Выбрать фото
                            <input type="file"
                                   name="avatar"
                                   accept="image/jpeg,image/png,image/webp">
                        </label>

                        @if ($user->avatar)
                            <label class="profile-avatar__remove">
                                <input type="checkbox"
                                       name="remove_avatar"
                                       value="1"
                                    @checked(old('remove_avatar'))>
                                Удалить текущий аватар
                            </label>
                        @endif

                        <p class="profile__hint">
                            JPG, PNG или WebP. Максимум 2 МБ.
                        </p>
                    </div>

                    <h2 class="profile__section-title">Смена пароля</h2>
                    <p class="profile__hint">
                        Заполняйте эти поля, только если хотите изменить пароль.
                    </p>

                    <div class="form__grid">
                        <label class="profile__field">
                            <span class="profile__label">Текущий пароль</span>
                            <input type="password"
                                   name="current_password"
                                   class="form__field"
                                   autocomplete="current-password">
                        </label>

                        <label class="profile__field">
                            <span class="profile__label">Новый пароль</span>
                            <input type="password"
                                   name="password"
                                   class="form__field"
                                   autocomplete="new-password">
                        </label>

                        <label class="profile__field">
                            <span class="profile__label">Повторите новый пароль</span>
                            <input type="password"
                                   name="password_confirmation"
                                   class="form__field"
                                   autocomplete="new-password">
                        </label>
                    </div>

                    <div class="profile__actions actions">
                        <button type="submit" class="actions__btn actions__btn--save">
                            Сохранить изменения
                        </button>
                    </div>
                </form>
            </div>
            <div class="profile__actions actions">
                <a href="{{ route('orders.index') }}" class="actions__btn">
                    Мои заказы
                </a>

                @if (auth()->user()->isStaff())
                    <a href="{{ route('admin.products.index') }}" class="actions__btn actions__btn--admin">
                        {{ auth()->user()->isAdmin() ? 'Админ-панель' : 'Кабинет менеджера' }}
                    </a>
                @endif

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

