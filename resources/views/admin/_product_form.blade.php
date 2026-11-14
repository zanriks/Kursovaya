@php
    $editing = $product !== null;

    $imageRows = old('images', $editing ? $product->images->map(fn ($image) => [
        'image_url' => $image->image_url,
        'alt_text' => $image->alt_text,
        'is_primary' => $image->is_primary,
    ])->all() : [[
        'image_url' => '',
        'alt_text' => '',
        'is_primary' => true,
    ]]);

    $specRows = old('specifications', $editing ? $product->specifications->map(fn ($spec) => [
        'name' => $spec->name,
        'value' => $spec->value,
    ])->all() : [[
        'name' => '',
        'value' => '',
    ]]);

    if (! is_array($imageRows) || count($imageRows) === 0) {
        $imageRows = [['image_url' => '', 'alt_text' => '', 'is_primary' => true]];
    }

    if (! is_array($specRows) || count($specRows) === 0) {
        $specRows = [['name' => '', 'value' => '']];
    }
@endphp

<form method="POST"
      action="{{ $editing ? route('admin.products.update', $product) : route('admin.products.store') }}"
      enctype="multipart/form-data"
      class="admin-form">
    @csrf

    @if ($editing)
        @method('PUT')
    @endif

    <div class="admin-form__section">
        <h2 class="admin-form__section-title">Основные данные</h2>

        <div class="admin-form__grid">
            <label class="admin-form__label admin-form__label--full">
                Название
                <input type="text"
                       name="name"
                       class="admin-form__input"
                       value="{{ old('name', $product?->name) }}"
                       required>
            </label>

            <label class="admin-form__label">
                Категория
                <select name="category_id" class="admin-form__input" required>
                    <option value="">— Выберите категорию —</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->category_id }}"
                                @selected((string) old('category_id', $product?->category_id ?? '') === (string) $category->category_id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label class="admin-form__label">
                Артикул (SKU)
                <input type="text"
                       name="sku"
                       class="admin-form__input"
                       value="{{ old('sku', $product?->sku) }}"
                       required>
            </label>

            <label class="admin-form__label">
                Slug
                <input type="text"
                       name="slug"
                       class="admin-form__input"
                       value="{{ old('slug', $product?->slug) }}"
                       placeholder="Если пусто — создастся из названия">
            </label>

            <label class="admin-form__label">
                Цена, ₽
                <input type="number"
                       name="price"
                       class="admin-form__input"
                       value="{{ old('price', $product?->price) }}"
                       min="0"
                       step="0.01"
                       required>
            </label>

            <label class="admin-form__label">
                Старая цена, ₽
                <input type="number"
                       name="old_price"
                       class="admin-form__input"
                       value="{{ old('old_price', $product?->old_price) }}"
                       min="0"
                       step="0.01">
            </label>

            <label class="admin-form__label">
                Рейтинг (0–5)
                <input type="number"
                       name="rating_cache"
                       class="admin-form__input"
                       value="{{ old('rating_cache', $product?->rating_cache ?? 0) }}"
                       min="0"
                       max="5"
                       step="0.01">
            </label>

            <label class="admin-form__label admin-form__label--full">
                Описание
                <textarea name="description" class="admin-form__input" rows="6">{{ old('description', $product?->description) }}</textarea>
            </label>
        </div>

        <div class="admin-form__checks">
            <input type="hidden" name="is_active" value="0">
            <label class="admin-form__checkbox">
                <input type="checkbox"
                       name="is_active"
                       value="1"
                       @checked((bool) old('is_active', $product?->is_active ?? true))>
                Активен
            </label>

            <input type="hidden" name="is_hit" value="0">
            <label class="admin-form__checkbox">
                <input type="checkbox"
                       name="is_hit"
                       value="1"
                       @checked((bool) old('is_hit', $product?->is_hit ?? false))>
                Хит продаж
            </label>
        </div>
    </div>

    <div class="admin-form__section">
        <div class="admin-form__section-head">
            <h2 class="admin-form__section-title">Изображения</h2>
            <button type="button" class="admin__btn admin__btn--small" data-add-image>
                + Добавить изображение
            </button>
        </div>

        <p class="admin-form__hint">
            Можно указать путь к уже существующему изображению или загрузить новый файл.
            Если изображений нет, на сайте будет показана заглушка.
        </p>

        <div id="images-list" class="admin-repeat">
            @foreach ($imageRows as $index => $image)
                @php($image = is_array($image) ? $image : [])
                @php($imageUrl = $image['image_url'] ?? '')
                @php($imageSrc = $imageUrl
                    ? (\Illuminate\Support\Str::startsWith($imageUrl, ['http://', 'https://'])
                        ? $imageUrl
                        : asset($imageUrl))
                    : null)

                <div class="admin-repeat__row image-row">
                    <div class="admin-repeat__preview">
                        @if ($imageSrc)
                            <img src="{{ $imageSrc }}" alt="">
                        @else
                            <span>Нет фото</span>
                        @endif
                    </div>

                    <div class="admin-repeat__fields">
                        <label class="admin-form__label">
                            Путь к изображению
                            <input type="text"
                                   name="images[{{ $index }}][image_url]"
                                   class="admin-form__input"
                                   value="{{ $imageUrl }}"
                                   placeholder="img/... или uploads/...">
                        </label>

                        <label class="admin-form__label">
                            Или загрузить файл
                            <input type="file"
                                   name="images[{{ $index }}][image_file]"
                                   class="admin-form__input"
                                   accept=".jpg,.jpeg,.png,.webp">
                        </label>

                        <label class="admin-form__label">
                            Alt-текст
                            <input type="text"
                                   name="images[{{ $index }}][alt_text]"
                                   class="admin-form__input"
                                   value="{{ $image['alt_text'] ?? '' }}">
                        </label>

                        <label class="admin-form__checkbox">
                            <input type="checkbox"
                                   name="images[{{ $index }}][is_primary]"
                                   value="1"
                                   @checked(! empty($image['is_primary']))>
                            Сделать основной
                        </label>
                    </div>

                    <button type="button"
                            class="admin__btn admin__btn--danger admin__btn--small"
                            data-remove-row>
                        Удалить
                    </button>
                </div>
            @endforeach
        </div>

        <template id="image-row-template">
            <div class="admin-repeat__row image-row">
                <div class="admin-repeat__preview">
                    <span>Новое</span>
                </div>

                <div class="admin-repeat__fields">
                    <label class="admin-form__label">
                        Путь к изображению
                        <input type="text"
                               name="images[__INDEX__][image_url]"
                               class="admin-form__input"
                               value=""
                               placeholder="img/... или uploads/...">
                    </label>

                    <label class="admin-form__label">
                        Или загрузить файл
                        <input type="file"
                               name="images[__INDEX__][image_file]"
                               class="admin-form__input"
                               accept=".jpg,.jpeg,.png,.webp">
                    </label>

                    <label class="admin-form__label">
                        Alt-текст
                        <input type="text"
                               name="images[__INDEX__][alt_text]"
                               class="admin-form__input"
                               value="">
                    </label>

                    <label class="admin-form__checkbox">
                        <input type="checkbox"
                               name="images[__INDEX__][is_primary]"
                               value="1">
                        Сделать основной
                    </label>
                </div>

                <button type="button"
                        class="admin__btn admin__btn--danger admin__btn--small"
                        data-remove-row>
                    Удалить
                </button>
            </div>
        </template>
    </div>

    <div class="admin-form__section">
        <div class="admin-form__section-head">
            <h2 class="admin-form__section-title">Характеристики</h2>
            <button type="button" class="admin__btn admin__btn--small" data-add-spec>
                + Добавить характеристику
            </button>
        </div>

        <div id="specs-list" class="admin-repeat">
            @foreach ($specRows as $index => $spec)
                @php($spec = is_array($spec) ? $spec : [])

                <div class="admin-repeat__row admin-repeat__row--spec">
                    <label class="admin-form__label">
                        Название
                        <input type="text"
                               name="specifications[{{ $index }}][name]"
                               class="admin-form__input"
                               value="{{ $spec['name'] ?? '' }}">
                    </label>

                    <label class="admin-form__label">
                        Значение
                        <input type="text"
                               name="specifications[{{ $index }}][value]"
                               class="admin-form__input"
                               value="{{ $spec['value'] ?? '' }}">
                    </label>

                    <button type="button"
                            class="admin__btn admin__btn--danger admin__btn--small"
                            data-remove-row>
                        Удалить
                    </button>
                </div>
            @endforeach
        </div>

        <template id="spec-row-template">
            <div class="admin-repeat__row admin-repeat__row--spec">
                <label class="admin-form__label">
                    Название
                    <input type="text"
                           name="specifications[__INDEX__][name]"
                           class="admin-form__input"
                           value="">
                </label>

                <label class="admin-form__label">
                    Значение
                    <input type="text"
                           name="specifications[__INDEX__][value]"
                           class="admin-form__input"
                           value="">
                </label>

                <button type="button"
                        class="admin__btn admin__btn--danger admin__btn--small"
                        data-remove-row>
                    Удалить
                </button>
            </div>
        </template>
    </div>

    <div class="admin-form__actions">
        <button type="submit" class="admin__btn admin__btn--primary">
            {{ $editing ? 'Сохранить изменения' : 'Создать товар' }}
        </button>

        <a href="{{ route('admin.products.index') }}" class="admin__btn admin__btn--muted">
            Отмена
        </a>
    </div>
</form>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const imagesList = document.getElementById('images-list');
            const imageTemplate = document.getElementById('image-row-template');
            let imageIndex = {{ count($imageRows) }};

            document.querySelector('[data-add-image]')?.addEventListener('click', function () {
                if (!imagesList || !imageTemplate) {
                    return;
                }

                imagesList.insertAdjacentHTML(
                    'beforeend',
                    imageTemplate.innerHTML.replace(/__INDEX__/g, imageIndex)
                );

                imageIndex++;
            });

            const specsList = document.getElementById('specs-list');
            const specTemplate = document.getElementById('spec-row-template');
            let specIndex = {{ count($specRows) }};

            document.querySelector('[data-add-spec]')?.addEventListener('click', function () {
                if (!specsList || !specTemplate) {
                    return;
                }

                specsList.insertAdjacentHTML(
                    'beforeend',
                    specTemplate.innerHTML.replace(/__INDEX__/g, specIndex)
                );

                specIndex++;
            });

            document.addEventListener('click', function (event) {
                const removeButton = event.target.closest('[data-remove-row]');

                if (!removeButton) {
                    return;
                }

                const row = removeButton.closest('.admin-repeat__row');
                const list = row?.parentElement;

                if (!row || !list) {
                    return;
                }

                if (list.querySelectorAll('.admin-repeat__row').length > 1) {
                    row.remove();
                    return;
                }

                row.querySelectorAll('input').forEach(function (input) {
                    if (input.type === 'checkbox') {
                        input.checked = false;
                    } else {
                        input.value = '';
                    }
                });
            });
        });
    </script>
@endpush
