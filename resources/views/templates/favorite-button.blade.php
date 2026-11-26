@php
    $icon = $icon ?? 'img/header-icon/heart.svg';
    $active = isset($favoriteIds) && $favoriteIds->has($product->product_id);
@endphp

@auth
    <form method="POST"
          action="{{ route('favorites.toggle', $product) }}"
          class="favorite-form">
        @csrf

        <button type="submit"
                class="{{ $buttonClass }} {{ $active ? 'is-favorite' : '' }}"
                aria-label="{{ $active ? 'Убрать из избранного' : 'Добавить в избранное' }}">
            <img src="{{ asset($icon) }}" alt="Избранное">
        </button>
    </form>
@else
    <a href="{{ route('login') }}" class="{{ $buttonClass }}">
        <img src="{{ asset($icon) }}" alt="Избранное">
    </a>
@endauth