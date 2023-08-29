@extends('layout.sidenav-layout')
@section('dasboard-body-content')
    @include('components.leaveCategory.leaveCategory-list')
    @include('components.leaveCategory.leaveCategory-delete')
    @include('components.leaveCategory.leaveCategory-create')
    @include('components.leaveCategory.leaveCategory-update')
@endsection