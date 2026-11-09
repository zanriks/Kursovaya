<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Инструменты', 'slug' => 'instrumenty', 'image_url' => 'img/categories_main/instrumenti_main.png'],
            ['name' => 'Водоснабжение', 'slug' => 'vodosnabzhenie', 'image_url' => 'img/catalog_photos/vodosnabzhenie.png'],
            ['name' => 'Плитка', 'slug' => 'plitka', 'image_url' => 'img/categories_main/plitka_main.webp'],
            ['name' => 'Напольные покрытия', 'slug' => 'napolnye-pokrytiya', 'image_url' => 'img/catalog_photos/napolnie_pokritiya.png'],
            ['name' => 'Краски', 'slug' => 'kraski', 'image_url' => 'img/catalog_photos/kraski.png'],
            ['name' => 'Стройматериалы', 'slug' => 'stroymaterialy', 'image_url' => 'img/catalog_photos/smesi.png'],
            ['name' => 'Ручной инструмент', 'slug' => 'ruchnoy-instrument', 'image_url' => 'img/categories_main/molotok.png'],
            ['name' => 'Электрика', 'slug' => 'elektrika', 'image_url' => 'img/catalog_photos/electrika.png'],
            ['name' => 'Сантехника', 'slug' => 'santehnika', 'image_url' => 'img/catalog_photos/santehnika.png'],
            ['name' => 'Освещение', 'slug' => 'osveshchenie', 'image_url' => 'img/catalog_photos/osveshenie.png'],
            ['name' => 'Отопительное оборудование', 'slug' => 'otopitelnoe-oborudovanie', 'image_url' => 'img/catalog_photos/otopitelnoe_oborudovanie.png'],
            ['name' => 'Крепеж и фурнитура', 'slug' => 'krepezh-i-furnitura', 'image_url' => 'img/categories_main/gvozdi_main.png'],
            ['name' => 'Силовая техника', 'slug' => 'silovaya-tekhnika', 'image_url' => 'img/categories_main/generator.png'],
            ['name' => 'Двери', 'slug' => 'dveri', 'image_url' => 'img/catalog_photos/door.png'],
            ['name' => 'Климат и вентиляция', 'slug' => 'klimat-i-ventilyatsiya', 'image_url' => 'img/catalog_photos/klimat_i_ventilyacia.png'],
        ];

        foreach ($categories as $index => $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
            [
                'name' => $category['name'],
                'image_url' => $category['image_url'],
                'sort_order' => $index,
                'is_active' => true,
            ]
            );
        }
    }
}