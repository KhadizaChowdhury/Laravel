@extends('layout.sidenav-layout')
{{-- @extends('includes.sidebar') --}}
@section('dasboard-body-content')
    @include('components.profile.profile-list')
    {{-- @include('components.profile.profile-delete') --}}
    {{-- @include('components.profile.profile-create') --}}
    {{-- @include('components.profile.profile-update') --}}
@endsection