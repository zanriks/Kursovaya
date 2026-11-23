@extends('admin.layout')

@section('title', 'Изменить роль')

@section('content')
    @include('admin._role_form', [
        'role' => $role,
    ])
@endsection
