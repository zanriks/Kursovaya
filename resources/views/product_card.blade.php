<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} — АСТМАСТЕР</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-product-card.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
</head>
<body>
@include('templates.header')

@php
    $mainImage = $product->images->firstWhere('is_primary', true) ?? $product->images->first();
@endphp

<div class="breadcrumbs">
    <nav class="breadcrumbs__container">
        <ol class="breadcrumbs__list">
            <li class="breadcrumbs__item">
                <a class="breadcrumbs__link" href="/">Главная</a>
            </li>
            <li class="breadcrumbs__item"><span class="breadcrumbs__separator">></span></li>
            <li class="breadcrumbs__item">
                <a class="breadcrumbs__link" href="/catalog">Каталог</a>
            </li>
            <li class="breadcrumbs__item"><span class="breadcrumbs__separator">></span></li>
            <li class="breadcrumbs__item">
                <a class="breadcrumbs__link" href="/catalog/{{ $product->category->slug }}">
                    {{ $product->category->name }}
                </a>
            </li>
            <li class="breadcrumbs__item"><span class="breadcrumbs__separator">></span></li>
            <li class="breadcrumbs__item">
                <span class="breadcrumbs__current">{{ $product->name }}</span>
            </li>
        </ol>
    </nav>
</div>

<section class="product__page">
    <div class="product__page-container container">
        <div class="product__page-gallery gallery">
            <ul class="gallery__thumbs">
                @foreach ($product->images as $image)
                    <li class="gallery__thumb-item">
                        <img class="gallery__thumb-image"
                             src="{{ asset($image->image_url) }}"
                             alt="{{ $image->alt_text ?? $product->name }}">
                    </li>
                @endforeach
            </ul>

            <div class="gallery__main">
                @if ($mainImage)
                    <img class="gallery__main-image"
                         src="{{ asset($mainImage->image_url) }}"
                         alt="{{ $mainImage->alt_text ?? $product->name }}">
                @else
                    <img class="gallery__main-image"
                         src="{{ asset('img/product-card/main-photo.png') }}"
                         alt="{{ $product->name }}">
                @endif
            </div>

            <div class="product-page__info info-block">
                <div class="info-block__rating rating">
                    <span class="rating__stars">
                        @for ($i = 0; $i < 5; $i++)
                            <img src="{{ asset('img/icons/star.svg') }}" alt="">
                        @endfor
                    </span>
                    <span class="rating__count">
                        {{ number_format($product->rating_cache, 2) }} · {{ $product->reviews_count }} отзывов
                    </span>
                </div>

                <span class="info-block__title">{{ $product->name }}</span>
                <p class="info-block__sku">Артикул: {{ $product->sku }}</p>

                <div class="info-block__price">
                    <div class="price">
                        <h2 class="price__current">
                            {{ number_format($product->price, 0, ',', ' ') }} ₽
                        </h2>

                        @if ($product->old_price && $product->old_price > $product->price)
                            <span class="price__old" style="text-decoration: line-through; color: #999;">
                                {{ number_format($product->old_price, 0, ',', ' ') }} ₽
                            </span>
                        @endif

                        <span class="price__installment">
                            От {{ number_format(round($product->price / 12), 0, ',', ' ') }} ₽ / мес.
                        </span>
                    </div>

                    <button class="info-block__favorite favorite-btn">
                        <img src="{{ asset('img/icons/heart.svg') }}" alt="Избранное">
                    </button>
                </div>

                <div class="info-block__delivery delivery">
                    <h3 class="delivery__title">Доставим на дом</h3>
                    <div class="delivery__option">
                        <span class="delivery__icon"><img src="" alt=""></span>
                        <span class="delivery__text">Курьером — в течение 2 дней</span>
                    </div>
                    <div class="delivery__option">
                        <span class="delivery__icon"><img src="" alt=""></span>
                        <span class="delivery__text">На пункт выдачи — в течение 3 дней</span>
                    </div>
                </div>

                <form method="POST"
                      action="{{ route('cart.add', $product->slug) }}"
                      class="add-to-cart-form">
                    @csrf

                    <input type="hidden" name="quantity" value="1">

                    <button type="submit" class="info-block__add-to-cart add-to-cart-btn">
                        Добавить в корзину
                    </button>
                </form>

                @guest
                    <a href="{{ route('login') }}" class="info-block__add-to-cart add-to-cart-btn buy-now-btn">
                        Купить сейчас
                    </a>
                @else
                    <form method="POST"
                          action="{{ route('cart.add', $product->slug) }}"
                          class="add-to-cart-form">
                        @csrf

                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="redirect" value="checkout">

                        <button type="submit" class="info-block__add-to-cart add-to-cart-btn buy-now-btn">
                            Купить сейчас
                        </button>
                    </form>
                @endguest

                @if (session('cart_success'))
                    <div class="cart-success">
                        {{ session('cart_success') }}
                        <a href="{{ route('cart.index') }}">Перейти в корзину</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="product-page__moreinfo">
        <div class="product-page__description description">
            <div class="description__content">
                @if ($product->description)
                    @foreach (explode("\n", $product->description) as $paragraph)
                        @if (trim($paragraph) !== '')
                            <p class="description__paragraph">{{ $paragraph }}</p>
                        @endif
                    @endforeach
                @else
                    <p class="description__paragraph">Описание товара пока не добавлено.</p>
                @endif
            </div>
        </div>

        <div class="specs">
            <h1 class="specs__title">Характеристики</h1>

            @forelse ($product->specifications as $spec)
                <div class="specs__row">
                    <span class="specs__label">{{ $spec->name }}</span>
                    <span class="specs__line"></span>
                    <span class="specs__value">{{ $spec->value }}</span>
                </div>
            @empty
                <p class="description__paragraph">Характеристики пока не добавлены.</p>
            @endforelse
        </div>

        <button class="specifications__expand-btn">Развернуть все</button>
    </div>

    <div class="reviews__container container" id="reviews">
            <div class="reviews__header">
                <h2 class="reviews__title">Отзывы {{ $product->reviews_count }}</h2>

                @auth
                    @unless ($userReview)
                        <a href="#review-form" class="review__add-btn">
                            Добавить отзыв
                        </a>
                    @endunless
                @else
                    <a href="{{ route('login') }}" class="review__add-btn">
                        Войти, чтобы оставить отзыв
                    </a>
                @endauth
            </div>

            @if (session('success'))
                <div class="review-form__success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="review-form__errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @auth
                @if ($userReview)
                    <div class="review-form__message">
                        @if ($userReview->status === 'pending')
                            Ваш отзыв отправлен на проверку.
                        @else
                            Вы уже оставили отзыв на этот товар.
                        @endif
                    </div>
                @else
                    <form id="review-form"
                          method="POST"
                          action="{{ route('reviews.store', $product->slug) }}"
                          class="review-form">
                        @csrf

                        <label class="review-form__field">
                            <span class="review-form__label">Оценка</span>
                            <select name="rating"
                                    class="review-form__select"
                                    required>
                                <option value="">Выберите оценку</option>

                                @for ($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}"
                                        @selected((string) old('rating') === (string) $i)>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </label>

                        <label class="review-form__field">
                            <span class="review-form__label">Текст отзыва</span>
                            <textarea name="body"
                                      class="review-form__textarea"
                                      rows="5"
                                      maxlength="2000"
                                      placeholder="Расскажите о товаре..."
                                      required>{{ old('body') }}</textarea>
                        </label>

                        <button type="submit" class="review-form__submit">
                            Отправить отзыв
                        </button>
                    </form>
                @endif
            @else
                <div class="review-form__message">
                    Чтобы оставить отзыв, <a href="{{ route('login') }}">войдите в аккаунт</a>.
                </div>
            @endauth

        @forelse ($product->reviews as $review)
            <div class="review__popular">
                <div class="reviewer__info">
                    <img src="{{ $review->user?->avatar ? asset($review->user->avatar) : asset('img/avatar.jpg') }}"
                         alt="Аватар"
                         class="reviewer__avatar">
                    <span class="reviewer__name">
                        {{ trim(($review->user?->first_name ?? '') . ' ' . ($review->user?->last_name ?? '')) ?: 'Пользователь' }}
                    </span>
                </div>

                <div class="rating__box">
                    <span>Оценка:</span>
                    <span class="rating__stars-review">
                        @for ($i = 0; $i < $review->rating; $i++)
                            <img src="{{ asset('img/icons/star.svg') }}" alt="">
                        @endfor
                    </span>
                </div>

                <p class="usage__period">{{ $review->created_at->format('d.m.Y') }}</p>
                <p class="pros__text">{{ $review->body }}</p>
            </div>
        @empty
            <p class="description__paragraph">Отзывов пока нет. Будьте первым!</p>
        @endforelse
    </div>
</section>

@include('templates.footer')
</body>
</html>
