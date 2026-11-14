<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Админ-панель') — АСТМАСТЕР</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
</head>
<body>
@include('templates.header')

<div class="breadcrumbs">
    <nav class="breadcrumbs__container">
        <ol class="breadcrumbs__list">
            <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="/">Главная</a></li>
            <li class="breadcrumbs__item"><span class="breadcrumbs__separator">></span></li>
            <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="{{ route('admin.products.index') }}">Админ-панель</a></li>
            @yield('breadcrumb')
        </ol>
        <h1 class="page__title">Админ-панель</h1>
    </nav>
</div>

<section class="admin">
    <div class="admin__container container">
        <aside class="admin__sidebar">
            <h2 class="admin__sidebar-title">Управление</h2>
            <nav class="admin__nav">
                <a class="admin__nav-link {{ request()->routeIs('admin.products.*') ? 'is-active' : '' }}"
                   href="{{ route('admin.products.index') }}">
                    Товары
                </a>
                <a class="admin__nav-link" href="/catalog" target="_blank" rel="noopener">
                    Открыть каталог
                </a>
                <a class="admin__nav-link" href="/">На главную</a>
            </nav>
        </aside>

        <div class="admin__content">
            <div class="admin__header">
                <h1 class="admin__title">@yield('title', 'Админ-панель')</h1>
                <div class="admin__actions">@yield('actions')</div>
            </div>

            @if (session('success'))
                <div class="admin__alert admin__alert--success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="admin__alert admin__alert--error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</section>

@include('templates.footer')

@stack('scripts')
</body>
</html>
