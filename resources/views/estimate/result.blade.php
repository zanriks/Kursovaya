<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результат расчёта — АСТМАСТЕР</title>
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
                <a class="breadcrumbs__link" href="{{ route('estimate.index') }}">Калькулятор сметы</a>
            </li>
            <li class="breadcrumbs__item"><span class="breadcrumbs__separator">></span></li>
            <li class="breadcrumbs__item">
                <span class="breadcrumbs__current">Результат</span>
            </li>
        </ol>
        <h1 class="page__title">Результат расчёта</h1>
    </nav>
</div>

<section class="estimate">
    <div class="container">
        <div class="estimate__card">
            <h2 class="estimate__title">{{ $name }}</h2>

            @if ($saved)
                <div class="estimate__status">
                    Смета сохранена в вашем личном кабинете.
                </div>
            @else
                <div class="estimate__hint">
                    Чтобы сохранить смету, <a href="{{ route('login') }}">войдите в аккаунт</a>.
                </div>
            @endif

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
                @foreach ($rows as $row)
                    <tr>
                        <td>{{ $row['description'] }}</td>
                        <td>{{ $row['quantity'] }}</td>
                        <td>{{ $row['unit'] !== '' ? $row['unit'] : '—' }}</td>
                        <td>{{ number_format($row['unit_price'], 2, ',', ' ') }} ₽</td>
                        <td>{{ number_format($row['line_total'], 2, ',', ' ') }} ₽</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <p class="estimate__total">
                Итого: {{ number_format($total, 2, ',', ' ') }} ₽
            </p>

            <div class="estimate__actions">
                <a href="{{ route('estimate.index') }}" class="estimate__btn">Пересчитать</a>

                @if ($saved)
                    <a href="{{ route('estimates.show', $saved) }}" class="estimate__btn estimate__btn--muted">
                        Открыть сохранённую смету
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>

@include('templates.footer')
</body>
</html>