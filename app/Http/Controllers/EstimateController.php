<?php

namespace App\Http\Controllers;

use App\Models\Estimate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstimateController extends Controller
{
    public function index()
    {
        return view('estimate.index');
    }

    public function calculate(Request $request)
    {
        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],

            'items' => ['required', 'array', 'max:20'],
            'items.*.description' => ['nullable', 'string', 'max:255'],
            'items.*.quantity' => ['nullable', 'integer', 'min:0'],
            'items.*.unit' => ['nullable', 'string', 'max:50'],
            'items.*.unit_price' => ['nullable', 'numeric', 'min:0'],
        ], [
            'items.required' => 'Добавьте хотя бы одну позицию.',
            'items.max' => 'Максимум 20 позиций.',

            'items.*.description.string' => 'Некорректное описание позиции.',
            'items.*.quantity.integer' => 'Количество должно быть целым числом.',
            'items.*.quantity.min' => 'Количество не может быть отрицательным.',
            'items.*.unit.string' => 'Некорректное обозначение единицы измерения.',
            'items.*.unit_price.numeric' => 'Цена должна быть числом.',
            'items.*.unit_price.min' => 'Цена не может быть отрицательной.',
        ]);

        $rows = [];

        foreach ($data['items'] as $item) {
            $description = trim((string) ($item['description'] ?? ''));
            $quantity = $item['quantity'] ?? '';
            $unit = trim((string) ($item['unit'] ?? ''));
            $unitPrice = $item['unit_price'] ?? '';

            // Полностью пустую строку пропускаем
            if ($description === '' && $quantity === '' && $unit === '' && $unitPrice === '') {
                continue;
            }

            // Если строка начата, но заполнена не полностью — ошибка
            if ($description === '' || $quantity === '' || $unitPrice === '') {
                return back()
                    ->withErrors([
                        'items' => 'В каждой добавленной строке заполните описание, количество и цену.',
                    ])
                    ->withInput();
            }

            $lineTotal = round((float) $quantity * (float) $unitPrice, 2);

            $rows[] = [
                'description' => $description,
                'quantity' => (int) $quantity,
                'unit' => $unit,
                'unit_price' => (float) $unitPrice,
                'line_total' => $lineTotal,
            ];
        }

        if (count($rows) === 0) {
            return back()
                ->withErrors(['items' => 'Заполните хотя бы одну позицию сметы.'])
                ->withInput();
        }

        $total = round(collect($rows)->sum('line_total'), 2);

        $name = trim((string) ($data['name'] ?? ''));
        $name = $name !== '' ? $name : 'Смета от ' . now()->format('d.m.Y H:i');

        $saved = null;

        // Сохраняем смету только для авторизованных пользователей
        if (auth()->check()) {
            $saved = DB::transaction(function () use ($rows, $total, $name) {
                $estimate = Estimate::create([
                    'user_id' => auth()->id(),
                    'name' => $name,
                    'parameters' => [
                        'source' => 'calculator',
                    ],
                    'total_amount' => $total,
                ]);

                foreach ($rows as $row) {
                    $estimate->items()->create([
                        'description' => $row['description'],
                        'quantity' => $row['quantity'],
                        'unit' => $row['unit'] !== '' ? $row['unit'] : null,
                        'unit_price' => $row['unit_price'],
                        'line_total' => $row['line_total'],
                    ]);
                }

                return $estimate;
            });
        }

        return view('estimate.result', compact('rows', 'total', 'name', 'saved'));
    }

    public function history()
    {
        $estimates = auth()->user()
            ->estimates()
            ->latest()
            ->get();

        return view('estimate.history', compact('estimates'));
    }

    public function show(Estimate $estimate)
    {
        abort_unless(
            auth()->check() && (int) $estimate->user_id === (int) auth()->id(),
            403
        );

        $estimate->load('items');

        return view('estimate.show', compact('estimate'));
    }
}