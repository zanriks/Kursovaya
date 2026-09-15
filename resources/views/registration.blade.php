<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
</head>
<body>
    <header class="header">
        <div class="header__container container">
            <a class="header__logo logo" href="/">
                <span class="logo__text">АСТМАСТЕР</span>
            </a>

            <nav class="header__nav nav">
                <ul class="nav__list">
                    <li class="nav__item"><a class="nav__link" href="/">Главная</a></li>
                    <li class="nav__item"><a class="nav__link" href="/catalog">Каталог</a></li>
                    <li class="nav__item"><a class="nav__link" href="/about">О нас</a></li>
                    <li class="nav__item"><a class="nav__link" href="/contacts">Контакты</a></li>
                    <li class="nav__item"><a class="nav__link" href="/services">Услуги</a></li>
                </ul>
            </nav>

            <div class="header__search search">
                <input class="search__input" type="text" placeholder="Поиск...">
            </div>

            <input type="checkbox" id="burger-toggle" class="burger-toggle" aria-hidden="true">

            <label for="burger-toggle" class="burger-menu">
                <span class="burger-menu__line"></span>
                <span class="burger-menu__line"></span>
                <span class="burger-menu__line"></span>
            </label>

            <div class="mobile-menu">
                <nav class="mobile-nav">
                    <ul class="mobile-menu__list">
                        <li><a class="mobile-menu__link" href="/">Главная</a></li>
                        <li><a class="mobile-menu__link" href="/catalog/instrument">Каталог</a></li>
                        <li><a class="mobile-menu__link" href="/about">О нас</a></li>
                        <li><a class="mobile-menu__link" href="/contacts">Контакты</a></li>
                        <li><a class="mobile-menu__link" href="/services">Услуги</a></li>
                        <li><a class="mobile-menu__link" href="/favorites">Избранное</a></li>
                        <li><a class="mobile-menu__link" href="/profile">Профиль</a></li>
                        <li><a class="mobile-menu__link" href="/cart">Корзина</a></li>
                    </ul>
                </nav>
            </div>

            <div class="mobile-menu__overlay"></div>

            <div class="header__actions actions">
                <a href="/favorites" class="actions__icon actions__icon--heart">
                    <img src="{{ asset('img/header-icon/heart.svg') }}" alt="Избранное">
                </a>
                <a href="/profile" class="actions__icon actions__icon--user">
                    <img src="{{ asset('img/header-icon/profile.svg') }}" alt="Профиль">
                </a>
                <a href="/cart" class="actions__icon actions__icon--cart">
                    <img src="{{ asset('img/header-icon/cart.svg') }}" alt="Корзина">
                </a>
            </div>
        </div>
    </header>


</body>
</html>

