@extends('admin.layout')

@section('title', 'Новая категория')

@section('actions')
    <a href="{{ route('admin.categories.index') }}" class="admin__btn admin__btn--muted">
        К списку категорий
    </a>
@endsection

@section('content')
    @include('admin._category_form', ['category' => null, 'categories' => $categories])
@endsection
