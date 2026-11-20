<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, string $slug)
    {
        $product = Product::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $data = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'body' => ['required', 'string', 'min:10', 'max:2000'],
        ], [
            'rating.required' => 'Поставьте оценку.',
            'rating.integer' => 'Оценка должна быть числом.',
            'rating.between' => 'Оценка должна быть от 1 до 5.',

            'body.required' => 'Напишите текст отзыва.',
            'body.min' => 'Отзыв должен содержать минимум 10 символов.',
            'body.max' => 'Отзыв не должен быть длиннее 2000 символов.',
        ]);

        $user = $request->user();

        // Один пользователь — один отзыв на товар
        $alreadyExists = Review::query()
            ->where('product_id', $product->product_id)
            ->where('user_id', $user->user_id)
            ->exists();

        if ($alreadyExists) {
            return back()
                ->withErrors(['review' => 'Вы уже оставили отзыв на этот товар.'])
                ->withInput();
        }

        Review::create([
            'product_id' => $product->product_id,
            'user_id' => $user->user_id,
            'rating' => $data['rating'],
            'body' => $data['body'],

            'status' => 'approved',
        ]);

        $this->recalculateRating($product);

        return redirect()
            ->route('product.show', $product->slug)
            ->with('success', 'Отзыв добавлен.');
    }

    private function recalculateRating(Product $product): void
    {
        $average = $product->reviews()
            ->where('status', 'approved')
            ->avg('rating');

        $product->rating_cache = $average ? round($average, 2) : 0;
        $product->save();
    }
}
