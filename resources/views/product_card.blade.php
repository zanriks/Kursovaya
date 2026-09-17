<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Карточка товара</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-product-card.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
</head>
<body>
@include('templates.header')

    <div class="breadcrumbs">
        <nav class="breadcrumbs__container">
        <ol class="breadcrumbs__list">
            <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="/">Каталог</a></li>
            <li class="breadcrumbs__item"><span class="breadcrumbs__separator">></span></li>
            <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="/">Подкатегория</a></li>
            <li class="breadcrumbs__item"><span class="breadcrumbs__separator">></span></li>
            <li class="breadcrumbs__item"><span class="breadcrumbs__current">Сварочный полуавтомат IRMIG 200 SYN LED с горелкой 250A</span></li>
        </ol>
        </nav>
    </div>

    <section class="product__page">
        <div class="product__page-container container">
            <div class="product__page-gallery gallery">
                <ul class="gallery__thumbs">
                    <li class="gallery__thumb-item">
                        <img class="gallery__thumb-image" src="{{ asset('img/product-card/vid-sboku.jpg') }}" alt="Основное изображение сварочного полуавтомата">
                    </li>
                    <li class="gallery__thumb-item">
                        <img class="gallery__thumb-image" src="{{ asset('img/product-card/vid-Speredi.jpg') }}" alt="Вид спереди">
                    </li>
                    <li class="gallery__thumb-item">
                        <img class="gallery__thumb-image" src="{{ asset('img/product-card/vid-szadi.jpg') }}" alt="Задняя панель">
                    </li>
                    <li class="gallery__thumb-item">
                        <img class="gallery__thumb-image" src="{{ asset('img/product-card/complekt-s-maskoy.jpg') }}" alt="В комплекте с маской">
                    </li>
                    <li class="gallery__thumb-item">
                        <img class="gallery__thumb-image" src="{{ asset('img/product-card/panel-upravleniya.jpg') }}" alt="Панель управления">
                    </li>
                </ul>
                <div class="gallery__main">
                    <img class="gallery__main-image" src="{{ asset('img/product-card/main-photo.png') }}" alt="Сварочный полуавтомат IRMIG 200 SYN LED">
                </div>

                <div class="product-page__info info-block">
                    <div class="info-block__rating rating">
                        <span class="rating__stars"><img src="{{ asset('img/icons/star.svg') }}" alt=""><img src="{{ asset('img/icons/star.svg') }}" alt=""><img src="{{ asset('img/icons/star.svg') }}" alt=""><img src="{{ asset('img/icons/star.svg') }}" alt=""><img src="{{ asset('img/icons/star.svg') }}" alt=""></span>
                        <span class="rating__count">13 отзывов</span>
                    </div>

                    <span class="info-block__title">Сварочный полуавтомат IRMIG 200 SYN LED с горелкой 250A</span>
                    <p class="info-block__sku">Артикул: 533574540</p>

                    <div class="info-block__price">
                        <div class="price">
                            <h2 class="price__current">32 540 ₽</h2>
                            <span class="price__installment">От 3021 ₽ / мес.</span>
                        </div>
                        <button class="info-block__favorite favorite-btn"><img src="{{ asset('img/icons/heart.svg') }}" alt="Избранное"></button>
                    </div>

                    <div class="info-block__delivery delivery">
                        <h3 class="delivery__title">Доставим на дом</h3>
                        <div class="delivery__option">
                            <span class="delivery__icon"><img src="" alt=""></span>
                            <span class="delivery__text">Курьером - с 12 декабря</span>
                        </div>
                        <div class="delivery__option">
                            <span class="delivery__icon"><img src="" alt=""></span>
                            <span class="delivery__text">На пункт выдачи - с 11 декабря</span>
                        </div>
                    </div>

                    <button class="info-block__add-to-cart add-to-cart-btn">Добавить в корзину</button>
                </div>
            </div>
        </div>

        <div class="product-page__moreinfo">
            <div class="product-page__description description">
                <div class="description__content">
                    <p class="description__paragraph">
                        Сварочный полуавтомат Fubag IRMIG 200 SYN LED – высокопроизводительный сварочный аппарат с ярким LED-дисплеем. Выбор методов сварки MMA, MIG/MAG, TIG Lift. Имеет 11 встроенных синергетических программ. Оснащен ярким, хорошо читаемым LED дисплеем с индикацией сварочного тока, напряжения и коррекции напряжения. Аппарат работает в самом распространенном диапазоне сварочного тока 15-200 А с проволокой диаметром от 0,6 до 1,0 мм, катушкой весом 5 кг и диаметром 200 мм. Передняя панель оснащена регуляторами силы тока и скорости подачи проволоки, что позволяет быстро и просто выбирать режимы и оптимальные параметры сварки.
                    </p>
                    <p class="description__paragraph">
                        Сварочный полуавтомат IRMIG 200 SYN LED оснащен евроразъемом (EURO) для быстрого и безопасного подключения сварочной горелки.
                    </p>
                    <p class="description__paragraph">
                        Продолжительность включения (ПВ) составляет 15% при 40С. Эти данные приведены в соответствии с европейским стандартом EN60974-1 при внешней температуре 40С. Часто на рынке используется значение ПВ при температуре окружающей среды 20С: чем ниже температура, тем выше ПВ.
                    </p>
                    <p class="description__paragraph">
                        Сварочный полуавтомат обладает легкой сменой полярности для работы с самозащитной проволокой. Эффективная система охлаждения, а также встроенная функция термозащиты с индикацией перегрева гарантируют долговечность и надежность использования аппарата в условиях интенсивной эксплуатации. Быстрое подключение сварочных кабелей и евроразъем для подключения горелки гарантируют удобство использования. Все технические характеристики наглядно и подробно указаны на корпусе аппарата.
                    </p>
                </div>
            </div>

            <div class="specs">
                <h1 class="specs__title">Характеристики</h1>

                <h2 class="specs__section-title">Заводские настройки</h2>
                <div class="specs__row">
                    <span class="specs__label">Гарантия продавца</span>
                    <span class="specs__line"></span>
                    <span class="specs__value">24 мес.</span>
                </div>
                <div class="specs__row">
                    <span class="specs__label">Срок эксплуатации</span>
                    <span class="specs__line"></span>
                    <span class="specs__value">24 мес.</span>
                </div>
                <div class="specs__row">
                    <span class="specs__label">Страна производитель</span>
                    <span class="specs__line"></span>
                    <span class="specs__value">Китай</span>
                </div>

                <h2 class="specs__section-title">Общие параметры</h2>
                <div class="specs__row">
                    <span class="specs__label">Тип</span>
                    <span class="specs__line"></span>
                    <span class="specs__value">Полуавтомат</span>
                </div>
                <div class="specs__row">
                    <span class="specs__label">Модель</span>
                    <span class="specs__line"></span>
                    <span class="specs__value">IRMIG 200 SYN LED</span>
                </div>

                <h2 class="specs__section-title">Технические характеристики</h2>
                <div class="specs__row">
                    <span class="specs__label">Тип сварочного аппарата</span>
                    <span class="specs__line"></span>
                    <span class="specs__value">Инверторный</span>
                </div>
                <div class="specs__row">
                    <span class="specs__label">Тип сварки</span>
                    <span class="specs__line"></span>
                    <span class="specs__value">Комби (MIG/MAG/MMA/TIG)</span>
                </div>
                <div class="specs__row">
                    <span class="specs__label">Макс. диаметр электрода</span>
                    <span class="specs__line"></span>
                    <span class="specs__value">5 мм</span>
                </div>
                <div class="specs__row">
                    <span class="specs__label">Макс. диаметр проволоки</span>
                    <span class="specs__line"></span>
                    <span class="specs__value">1 мм</span>
                </div>
                <div class="specs__row">
                    <span class="specs__label">Максимальный сварочный ток (А)</span>
                    <span class="specs__line"></span>
                    <span class="specs__value">180 А</span>
                </div>
                <div class="specs__row">
                    <span class="specs__label">Охлаждение горелки</span>
                    <span class="specs__line"></span>
                    <span class="specs__value">Воздушное</span>
                </div>
            </div>

            <button class="specifications__expand-btn">Развернуть все</button>
        </div>

        <div class="reviews__container container">
            <div class="reviews__header">
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <h2 class="reviews__title">Отзывы 13</h2>
                    <div class="reviews__gallery-wrapper">
                        <img src="https://via.placeholder.com/50" alt="Фото отзыва" class="review__image">
                        <img src="https://via.placeholder.com/50" alt="Фото отзыва" class="review__image">
                        <img src="https://via.placeholder.com/50" alt="Фото отзыва" class="review__image">
                        <img src="https://via.placeholder.com/50" alt="Фото отзыва" class="review__image">
                        <img src="https://via.placeholder.com/50" alt="Фото отзыва" class="review__image">
                        <div class="reviews__total">Всего 7</div>
                    </div>
                </div>
                <button class="review__add-btn">Добавить отзыв</button>
            </div>

            <div class="review__popular">
            <h3 class="popular__review-title">Самый популярный отзыв</h3>

            <div class="reviewer__info">
                <img src="https://via.placeholder.com/50" alt="Аватар" class="reviewer__avatar">
                <span class="reviewer__name">Алексей Самоваров</span>
            </div>

            <div class="rating__box">
                <span>Общая:</span>
                <span class="rating__stars-review"><img src="{{ asset('img/icons/star.svg') }}" alt=""><img src="{{ asset('img/icons/star.svg') }}" alt=""><img src="{{ asset('img/icons/star.svg') }}" alt=""><img src="{{ asset('img/icons/star.svg') }}" alt=""><img src="{{ asset('img/icons/star.svg') }}" alt=""></span>
            </div>

            <p class="usage__period">Срок использования: Менее месяца</p>

            <h4 class="pros__title">Достоинства</h4>
            <p class="pros__text">Такого хорошего сварочного аппарата у меня ещё не было, без опыта варю как сварщик 5 разряда, маска которая идёт в комплекте очень хороша.</p>

            <h4 class="cons__title">Недостатки</h4>
            <p class="cons__text">Вес более 10 кг</p>
            </div>

            <button class="show-more__btn">Показать ещё</button>
        </div>
    </section>

    @include('templates.footer')
</body>
</html>

