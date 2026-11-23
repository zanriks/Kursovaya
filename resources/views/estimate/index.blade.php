<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Калькулятор сметы — АСТМАСТЕР</title>
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
                <span class="breadcrumbs__current">Калькулятор сметы</span>
            </li>
        </ol>
        <h1 class="page__title">Калькулятор сметы</h1>
    </nav>
</div>

<section class="estimate">
    <div class="container">
        <div class="estimate__card">
            <h2 class="estimate__title">Рассчитать смету</h2>

            <p class="estimate__hint">
                Заполните позиции. Пустые строки будут проигнорированы.
                Сумма рассчитывается как количество × цена за единицу.
            </p>

            @if ($errors->any())
                <div class="estimate__errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('estimate.calculate') }}">
                @csrf

                <label class="estimate__field estimate__field--full">
                    Название сметы
                    <input type="text"
                           name="name"
                           class="estimate__input"
                           value="{{ old('name') }}"
                           placeholder="Например: Ремонт кухни">
                </label>

                <table class="estimate__table">
                    <thead>
                    <tr>
                        <th>Работа / материал</th>
                        <th>Кол-во</th>
                        <th>Ед.</th>
                        <th>Цена за ед.</th>
                    </tr>
                    </thead>
                    <tbody>
                    @for ($i = 0; $i < 5; $i++)
                        <tr>
                            <td>
                                <input type="text"
                                       name="items[{{ $i }}][description]"
                                       class="estimate__input"
                                       value="{{ old('items.' . $i . '.description') }}"
                                       placeholder="Например: Грунтование стен">
                            </td>
                            <td>
                                <input type="number"
                                       name="items[{{ $i }}][quantity]"
                                       class="estimate__input"
                                       value="{{ old('items.' . $i . '.quantity') }}"
                                       min="0"
                                       step="1"
                                       placeholder="0">
                            </td>
                            <td>
                                <input type="text"
                                       name="items[{{ $i }}][unit]"
                                       class="estimate__input"
                                       value="{{ old('items.' . $i . '.unit') }}"
                                       placeholder="м², шт, м">
                            </td>
                            <td>
                                <input type="number"
                                       name="items[{{ $i }}][unit_price]"
                                       class="estimate__input"
                                       value="{{ old('items.' . $i . '.unit_price') }}"
                                       min="0"
                                       step="0.01"
                                       placeholder="0.00">
                            </td>
                        </tr>
                    @endfor
                    </tbody>
                </table>

                <button type="submit" class="estimate__btn">Рассчитать смету</button>
            </form>

            @auth
                <p class="estimate__links">
                    <a href="{{ route('estimates.index') }}">Мои сохранённые сметы</a>
                </p>
            @endauth
        </div>
    </div>
</section>

@include('templates.footer')
</body>
</html>