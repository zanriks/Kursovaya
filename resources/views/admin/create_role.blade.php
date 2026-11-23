@extends('admin.layout')

@section('title', 'Добавить роль')

@section('content')
    @include('admin._role_form', [
        'role' => $role,
    ])
@endsection
