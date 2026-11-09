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
                @foreach ($categories as $category)
                    <li class="categories__item category">
                        <a href="/catalog/{{ $category->slug }}">
                            <img class="category__image"
                                src="{{ asset($category->image_url ?? 'img/categories_main/instrumenti_main.png') }}"
                                alt="{{ $category->name }}">
                            <p class="category__name">{{ $category->name }}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

@include('templates.footer')
</body>
</html>

