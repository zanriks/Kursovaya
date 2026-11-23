@extends('admin.layout')

@section('title', 'Изменить пользователя')

@section('content')
    @include('admin._user_form', [
        'user' => $user,
        'roles' => $roles,
    ])
@endsection
