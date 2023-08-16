@extends('layout.sidenav-layout')
@section('dasboard-body-content')
    @include('components.event.event-list')
    @include('components.event.event-delete')
    @include('components.event.event-create')
    @include('components.event.event-update')
@endsection