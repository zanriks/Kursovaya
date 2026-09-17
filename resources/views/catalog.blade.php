<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-catalog.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
</head>
<body>
@include('templates.header')

    <div class="breadcrumbs">
        <nav class="breadcrumbs__container">
        <ol class="breadcrumbs__list">
            <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="/">Главная</a></li>
            <li class="breadcrumbs__item"><span class="breadcrumbs__separator">></span></li>
            <li class="breadcrumbs__item"><span class="breadcrumbs__current">Каталог</span></li>
        </ol>
        <h1 class="page__title">Каталог</h1>
        </nav>
    </div>

    <section class="categories">
        <div class="categories__container container">
            <ul class="categories__list">
                <li class="categories__item category">
                    <a href="/catalog/instrument">
                    <img class="category__image" src="{{ asset('img/categories_main/instrumenti_main.png') }}" alt="Инструменты">
                    <p class="category__name">Инструменты</p>
                    </a>
                </li>
                <li class="categories__item category">
                    <a href="/catalog/instrument">
                    <img class="category__image" src="{{ asset('img/catalog_photos/vodosnabzhenie.png') }}" alt="Водоснабжение">
                    <p class="category__name">Водоснабжение</p>
                    </a>
                </li>
                <li class="categories__item category">
                    <a href="/catalog/instrument">
                    <img class="category__image" src="{{ asset('img/categories_main/plitka_main.webp') }}" alt="Плитка">
                    <p class="category__name">Плитка</p>
                    </a>
                </li>
                <li class="categories__item category">
                    <a href="/catalog/instrument">
                    <img class="category__image" src="{{ asset('img/catalog_photos/napolnie_pokritiya.png') }}" alt="Напольные покрытия">
                    <p class="category__name">Напольные покрытия</p>
                    </a>
                </li>
                <li class="categories__item category">
                    <a href="/catalog/instrument">
                    <img class="category__image" src="{{ asset('img/catalog_photos/kraski.png') }}" alt="Краски">
                    <p class="category__name">Краски</p>
                    </a>
                </li>

                <li class="categories__item category">
                    <a href="/catalog/instrument">
                    <img class="category__image" src="{{ asset('img/catalog_photos/smesi.png') }}" alt="Стройматериалы">
                    <p class="category__name">Стройматериалы</p>
                    </a>
                </li>
                <li class="categories__item category">
                    <a href="/catalog/instrument">
                    <img class="category__image" src="{{ asset('img/categories_main/molotok.png') }}" alt="Ручной инструмент">
                    <p class="category__name">Ручной инструмент</p>
                    </a>
                </li>
                <li class="categories__item category">
                    <a href="/catalog/instrument">
                    <img class="category__image" src="{{ asset('img/catalog_photos/electrika.png') }}" alt="Электрика">
                    </a>
                    <p class="category__name">Электрика</p>
                </li>
                <li class="categories__item category">
                    <a href="/catalog/instrument">
                    <img class="category__image" src="{{ asset('img/catalog_photos/santehnika.png') }}" alt="Сантехника">
                    <p class="category__name">Сантехника</p>
                    </a>
                </li>
                <li class="categories__item category">
                    <a href="/catalog/instrument">
                    <img class="category__image" src="{{ asset('img/catalog_photos/osveshenie.png') }}" alt="Освещение">
                    <p class="category__name">Освещение</p>
                    </a>
                </li>

                <li class="categories__item category">
                    <a href="/catalog/instrument">
                    <img class="category__image" src="{{ asset('img/catalog_photos/otopitelnoe_oborudovanie.png') }}" alt="Отопительное оборудование" style="width: 100%; height: 100%;">
                    <p class="category__name">Отопительное оборудование</p>
                    </a>
                </li>
                <li class="categories__item category">
                    <a href="/catalog/instrument">
                    <img class="category__image" src="{{ asset('img/categories_main/gvozdi_main.png') }}" alt="Крепеж и фурнитура">
                    <p class="category__name">Крепеж и фурнитура</p>
                    </a>
                </li>
                <li class="categories__item category">
                    <a href="/catalog/instrument">
                    <img class="category__image" src="{{ asset('img/categories_main/generator.png') }}" alt="Силовая техника">
                    <p class="category__name">Силовая техника</p>
                    </a>
                </li>
                <li class="categories__item category">
                    <a href="/catalog/instrument">
                    <img class="category__image" src="{{ asset('img/catalog_photos/door.png') }}" alt="Двери">
                    <p class="category__name">Двери</p>
                    </a>
                </li>
                <li class="categories__item category">
                    <a href="/catalog/instrument">
                    <img class="category__image" src="{{ asset('img/catalog_photos/klimat_i_ventilyacia.png') }}" alt="Климат и вентиляция">
                    <p class="category__name">Климат и вентиляция</p>
                    </a>
                </li>
            </ul>
        </div>
    </section>

@include('templates.footer')
</body>
</html>

