<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $estimate->name }} — АСТМАСТЕР</title>
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
                <a class="breadcrumbs__link" href="{{ route('estimates.index') }}">Мои сметы</a>
            </li>
            <li class="breadcrumbs__item"><span class="breadcrumbs__separator">></span></li>
            <li class="breadcrumbs__item">
                <span class="breadcrumbs__current">{{ $estimate->name }}</span>
            </li>
        </ol>
        <h1 class="page__title">{{ $estimate->name }}</h1>
    </nav>
</div>

<section class="estimate">
    <div class="container">
        <div class="estimate__card">
            <p class="estimate__hint">
                Дата создания: {{ $estimate->created_at?->format('d.m.Y H:i') }}
            </p>

            <table class="estimate__table estimate__table--result">
                <thead>
                <tr>
                    <th>Работа / материал</th>
                    <th>Кол-во</th>
                    <th>Ед.</th>
                    <th>Цена за ед.</th>
                    <th>Сумма</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($estimate->items as $item)
                    <tr>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->unit ?: '—' }}</td>
                        <td>{{ number_format($item->unit_price, 2, ',', ' ') }} ₽</td>
                        <td>{{ number_format($item->line_total, 2, ',', ' ') }} ₽</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <p class="estimate__total">
                Итого: {{ number_format($estimate->total_amount, 2, ',', ' ') }} ₽
            </p>

            <p class="estimate__links">
                <a href="{{ route('estimates.index') }}">Ко всем сметам</a>
            </p>
        </div>
    </div>
</section>

@include('templates.footer')
</body>
</html>