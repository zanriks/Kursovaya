@extends('admin.layout')

@section('title', 'Редактирование товара')

@section('breadcrumb')
    <li class="breadcrumbs__item"><span class="breadcrumbs__separator">></span></li>
    <li class="breadcrumbs__item"><span class="breadcrumbs__current">{{ $category->name }}</span></li>
@endsection

@section('actions')
    <a href="{{ route('admin.categories.index') }}" class="admin__btn admin__btn--muted">
        К списку товаров
    </a>
@endsection

@section('content')
    @include('admin._category_form', ['category' => $category, 'categories' => $categories])
@endsection