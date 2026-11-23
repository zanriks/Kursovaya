@extends('admin.layout')

@section('title', 'Добавить пользователя')

@section('content')
    @include('admin._user_form', [
        'user' => $user,
        'roles' => $roles,
    ])
@endsection
