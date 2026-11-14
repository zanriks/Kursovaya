@extends('admin.layout')

@section('title', 'Новый товар')

@section('actions')
    <a href="{{ route('admin.products.index') }}" class="admin__btn admin__btn--muted">
        ← К списку товаров
    </a>
@endsection

@section('content')
    @include('admin._product_form', ['product' => null, 'categories' => $categories])
@endsection
