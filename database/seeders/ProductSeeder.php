<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSpecification;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'sku' => 'BOSCH-GBH-240',
                'category' => 'instrumenty',
                'name' => 'Перфоратор Bosch GBH 240 [SDS-plus, 790 Вт, 2.7 Дж, 930 об/мин, 4200 уд/мин, кейс, 2.8 кг]',
                'slug' => 'perforator-bosch-gbh-240',
                'description' => 'Перфоратор Bosch GBH 240 предназначен для сверления и долбления бетона, кирпича и камня.',
                'price' => 26640,
                'rating_cache' => 4.60,
                'is_hit' => true,
                'images' => [
                    ['image_url' => 'img/hits-photo/perforator.png', 'alt_text' => 'Перфоратор Bosch GBH 240', 'is_primary' => true],
                ],
                'specs' => [
                    ['name' => 'Тип', 'value' => 'Перфоратор'],
                    ['name' => 'Мощность', 'value' => '790 Вт'],
                    ['name' => 'Энергия удара', 'value' => '2.7 Дж'],
                    ['name' => 'Частота вращения', 'value' => '930 об/мин'],
                    ['name' => 'Частота ударов', 'value' => '4200 уд/мин'],
                    ['name' => 'Патрон', 'value' => 'SDS-plus'],
                    ['name' => 'Вес', 'value' => '2.8 кг'],
                ],
            ],
            [
                'sku' => 'DEKO-RH2500',
                'category' => 'instrumenty',
                'name' => 'Перфоратор DEKO RH2500 [SDS-plus, 2500 Вт, 3.5 Дж, кейс]',
                'slug' => 'perforator-deko-rh2500',
                'description' => 'Мощный перфоратор для строительных и ремонтных работ.',
                'price' => 8990,
                'rating_cache' => 4.30,
                'is_hit' => false,
                'images' => [
                    ['image_url' => 'img/hits-photo/perforator.png', 'alt_text' => 'Перфоратор DEKO RH2500', 'is_primary' => true],
                ],
                'specs' => [
                    ['name' => 'Мощность', 'value' => '2500 Вт'],
                    ['name' => 'Энергия удара', 'value' => '3.5 Дж'],
                    ['name' => 'Патрон', 'value' => 'SDS-plus'],
                ],
            ],
            [
                'sku' => 'GKL-V-1200-2500-12-5',
                'category' => 'stroymaterialy',
                'name' => 'Гипсокартон влагостойкий (ГКЛВ), лист 1200x2500x12,5 мм',
                'slug' => 'gipsokarton-vlagostoykiy-gklv',
                'description' => 'Влагостойкий гипсокартонный лист для отделки помещений с повышенной влажностью.',
                'price' => 550,
                'rating_cache' => 4.84,
                'is_hit' => true,
                'images' => [
                    ['image_url' => 'img/hits-photo/gipsokarton.png', 'alt_text' => 'Гипсокартон влагостойкий', 'is_primary' => true],
                ],
                'specs' => [
                    ['name' => 'Размер', 'value' => '1200x2500x12,5 мм'],
                    ['name' => 'Тип', 'value' => 'Влагостойкий'],
                    ['name' => 'Толщина', 'value' => '12,5 мм'],
                ],
            ],
            [
                'sku' => 'SPC-DUB-SPB',
                'category' => 'napolnye-pokrytiya',
                'name' => 'SPC плитка Дуб Санкт-Петербург класс 43 толщина 4 мм 2.16 м²',
                'slug' => 'spc-plitka-dub-sankt-peterburg',
                'description' => 'SPC-плитка с реалистичной текстурой дуба для жилых и коммерческих помещений.',
                'price' => 1220,
                'rating_cache' => 4.90,
                'is_hit' => true,
                'images' => [
                    ['image_url' => 'img/hits-photo/spc-plitka.webp', 'alt_text' => 'SPC плитка Дуб Санкт-Петербург', 'is_primary' => true],
                ],
                'specs' => [
                    ['name' => 'Класс', 'value' => '43'],
                    ['name' => 'Толщина', 'value' => '4 мм'],
                    ['name' => 'Площадь', 'value' => '2.16 м²'],
                    ['name' => 'Покрытие', 'value' => 'SPC'],
                ],
            ],
            [
                'sku' => 'CERESIT-CM-14-25',
                'category' => 'stroymaterialy',
                'name' => 'Ceresit Клей для плитки эластичный CM 14, 25 кг',
                'slug' => 'ceresit-cm-14-25-kg',
                'description' => 'Эластичный плиточный клей для внутренних и наружных работ.',
                'price' => 940,
                'rating_cache' => 4.60,
                'is_hit' => true,
                'images' => [
                    ['image_url' => 'img/hits-photo/ceresit.png', 'alt_text' => 'Ceresit Клей для плитки CM 14', 'is_primary' => true],
                ],
                'specs' => [
                    ['name' => 'Вес', 'value' => '25 кг'],
                    ['name' => 'Тип', 'value' => 'Плиточный клей'],
                    ['name' => 'Эластичность', 'value' => 'Повышенная'],
                ],
            ],
            [
                'sku' => '533574540',
                'category' => 'silovaya-tekhnika',
                'name' => 'Сварочный аппарат IRMIG 200 SYN LED с горелкой 250A',
                'slug' => 'svarochnyy-apparat-irmig-200-syn-led',
                'description' => 'Инверторный сварочный аппарат с режимами MMA, MIG/MAG и TIG Lift, LED-подсветкой и цифровым управлением.',
                'price' => 32540,
                'rating_cache' => 4.80,
                'is_hit' => false,
                'images' => [
                    ['image_url' => 'img/product-card/main-photo.png', 'alt_text' => 'Сварочный аппарат IRMIG 200 SYN LED', 'is_primary' => true],
                    ['image_url' => 'img/product-card/vid-sboku.jpg', 'alt_text' => 'Вид сбоку'],
                    ['image_url' => 'img/product-card/vid-Speredi.jpg', 'alt_text' => 'Вид спереди'],
                    ['image_url' => 'img/product-card/vid-szadi.jpg', 'alt_text' => 'Вид сзади'],
                    ['image_url' => 'img/product-card/complekt-s-maskoy.jpg', 'alt_text' => 'Комплект с маской'],
                    ['image_url' => 'img/product-card/panel-upravleniya.jpg', 'alt_text' => 'Панель управления'],
                ],
                'specs' => [
                    ['name' => 'Тип', 'value' => 'Сварочный аппарат'],
                    ['name' => 'Режимы сварки', 'value' => 'MMA, MIG/MAG, TIG Lift'],
                    ['name' => 'Сварочный ток', 'value' => '15-200 А'],
                    ['name' => 'Напряжение', 'value' => '220 В'],
                    ['name' => 'Вес', 'value' => '5 кг'],
                ],
            ],
        ];

        foreach ($products as $data) {
            $categoryId = Category::where('slug', $data['category'])->value('category_id');

            $product = Product::updateOrCreate(
                ['sku' => $data['sku']],
                [
                    'category_id' => $categoryId,
                    'name' => $data['name'],
                    'slug' => $data['slug'],
                    'description' => $data['description'] ?? null,
                    'price' => $data['price'],
                    'old_price' => $data['old_price'] ?? null,
                    'rating_cache' => $data['rating_cache'] ?? 0,
                    'is_active' => true,
                    'is_hit' => $data['is_hit'] ?? false,
                ]
            );

            foreach ($data['images'] as $index => $image) {
                ProductImage::updateOrCreate(
                    [
                        'product_id' => $product->product_id,
                        'image_url' => $image['image_url'],
                    ],
                    [
                        'alt_text' => $image['alt_text'] ?? $product->name,
                        'sort_order' => $index,
                        'is_primary' => $image['is_primary'] ?? ($index === 0),
                    ]
                );
            }

            foreach ($data['specs'] as $index => $spec) {
                ProductSpecification::updateOrCreate(
                    [
                        'product_id' => $product->product_id,
                        'name' => $spec['name'],
                    ],
                    [
                        'value' => $spec['value'],
                        'sort_order' => $index,
                    ]
                );
            }
        }
    }
}