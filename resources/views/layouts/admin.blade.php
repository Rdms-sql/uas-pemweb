@extends('adminlte::page')

@section('title', 'KampusCare Admin')

@section('content_header')
    <h1>@yield('header')</h1>
@stop

@section('content')
    @yield('main')
@stop

@section('css')
    @yield('styles')
@stop

@section('js')
    @yield('scripts')
@stop