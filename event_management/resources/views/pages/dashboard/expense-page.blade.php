@extends('layout.sidenav-layout')
@section('dasboard-body-content')
    @include('components.expense.expense-list')
    {{-- @include('components.expense.expense-delete') --}}
    @include('components.expense.expense-create')
    {{-- @include('components.expense.expense-update') --}}
@endsection