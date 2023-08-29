@extends('layout.sidenav-layout')
{{-- @extends('includes.sidebar') --}}
@section('dasboard-body-content')
    @include('components.report.report-list')
    @include('components.report.report-update')
@endsection