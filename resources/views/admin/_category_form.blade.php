@php
    $editing = $category !== null;
    $imageUrl = old('image_url', $category?->image_url ?? '');
    $imageSrc = $imageUrl
        ? (\Illuminate\Support\Str::startsWith($imageUrl, ['http://', 'https://'])
            ? $imageUrl
            : asset($imageUrl))
        : null;
@endphp

<form method="POST"
      action="{{ $editing ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
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
                       value="{{ old('name', $category?->name) }}"
                       required>
            </label>

            <label class="admin-form__label">
                Родительская категория
                <select name="parent_id" class="admin-form__input">
                    <option value="">— Корневая категория —</option>
                    @foreach ($categories as $item)
                        <option value="{{ $item->category_id }}"
                                @selected((string) old('parent_id', $category?->parent_id ?? '') === (string) $item->category_id)>
                            {{ $item->name }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label class="admin-form__label">
                Slug
                <input type="text"
                       name="slug"
                       class="admin-form__input"
                       value="{{ old('slug', $category?->slug) }}"
                       placeholder="Если пусто — создастся из названия">
            </label>

            <label class="admin-form__label">
                Порядок сортировки
                <input type="number"
                       name="sort_order"
                       class="admin-form__input"
                       value="{{ old('sort_order', $category?->sort_order ?? 0) }}"
                       min="0"
                       step="1">
            </label>

            <label class="admin-form__label admin-form__label--full">
                Описание
                <textarea name="description" class="admin-form__input" rows="6">{{ old('description', $category?->description) }}</textarea>
            </label>
        </div>

        <div class="admin-form__checks">
            <input type="hidden" name="is_active" value="0">
            <label class="admin-form__checkbox">
                <input type="checkbox"
                       name="is_active"
                       value="1"
                       @checked((bool) old('is_active', $category?->is_active ?? true))>
                Активна
            </label>
        </div>
    </div>

    <div class="admin-form__section">
        <div class="admin-form__section-head">
            <h2 class="admin-form__section-title">Изображение</h2>
        </div>

        <p class="admin-form__hint">
            Можно указать путь к уже существующему изображению или загрузить новый файл.
            Если изображения нет, на сайте будет показана заглушка.
        </p>

        <div class="admin-repeat">
            <div class="admin-repeat__row image-row">
                <div class="admin-repeat__preview">
                    @if ($imageSrc)
                        <img src="{{ $imageSrc }}" alt="{{ $category?->name ?? '' }}">
                    @else
                        <span>Нет фото</span>
                    @endif
                </div>

                <div class="admin-repeat__fields">
                    <label class="admin-form__label">
                        Путь к изображению
                        <input type="text"
                               name="image_url"
                               class="admin-form__input"
                               value="{{ $imageUrl }}"
                               placeholder="img/... или uploads/...">
                    </label>

                    <label class="admin-form__label">
                        Или загрузить файл
                        <input type="file"
                               name="image_file"
                               class="admin-form__input"
                               accept=".jpg,.jpeg,.png,.webp">
                    </label>

                    @if ($imageSrc)
                        <label class="admin-form__checkbox">
                            <input type="checkbox" name="remove_image" value="1">
                            Удалить текущее изображение
                        </label>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="admin-form__actions">
        <button type="submit" class="admin__btn admin__btn--primary">
            {{ $editing ? 'Сохранить изменения' : 'Создать категорию' }}
        </button>
        <a href="{{ route('admin.categories.index') }}" class="admin__btn admin__btn--muted">
            Отмена
        </a>
    </div>
</form>
