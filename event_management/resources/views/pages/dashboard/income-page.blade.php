@extends('layout.sidenav-layout')
{{-- @extends('includes.sidebar') --}}
@section('dasboard-body-content')
    @include('components.income.income-list')
    {{-- @include('components.income.income-delete') --}}
    @include('components.income.income-create')
    @include('components.income.product-update')
    {{-- @include('components.income.income-update') --}}
@endsection