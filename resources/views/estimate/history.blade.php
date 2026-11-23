<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои сметы — АСТМАСТЕР</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-estimate.css') }}">
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
                <span class="breadcrumbs__current">Мои сметы</span>
            </li>
        </ol>
        <h1 class="page__title">Мои сметы</h1>
    </nav>
</div>

<section class="estimate">
    <div class="container">
        <div class="estimate__card">
            <h2 class="estimate__title">Сохранённые сметы</h2>

            @forelse ($estimates as $estimate)
                <a class="estimate__item" href="{{ route('estimates.show', $estimate) }}">
                    <strong>{{ $estimate->name }}</strong>
                    <span>{{ $estimate->created_at?->format('d.m.Y H:i') }}</span>
                    <span>{{ number_format($estimate->total_amount, 2, ',', ' ') }} ₽</span>
                </a>
            @empty
                <p class="estimate__hint">У вас пока нет сохранённых смет.</p>
            @endforelse

            <p class="estimate__links">
                <a href="{{ route('estimate.index') }}">Создать новую смету</a>
            </p>
        </div>
    </div>
</section>

@include('templates.footer')
</body>
</html>