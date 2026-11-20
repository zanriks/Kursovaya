@php
    $cartItem = $cartItems->get($product->product_id);
@endphp

@if ($cartItem)
    <form method="POST"
          action="{{ route('cart.update', $cartItem) }}"
          class="{{ $formClass }} cart-controls">
        @csrf

        <button type="submit"
                name="action"
                value="decrement"
                class="cart-controls__btn"
                aria-label="Уменьшить количество">
            −
        </button>

        <span class="cart-controls__value">
            {{ $cartItem->quantity }}
        </span>

        <button type="submit"
                name="action"
                value="increment"
                class="cart-controls__btn"
                aria-label="Увеличить количество"
                @disabled($cartItem->quantity >= 99)>
            +
        </button>
    </form>
@else
    <form method="POST"
          action="{{ route('cart.add', $product->slug) }}"
          class="{{ $formClass }}">
        @csrf
        <input type="hidden" name="quantity" value="1">

        <button type="submit" class="{{ $buttonClass }}">
            В корзину
        </button>
    </form>
@endif
