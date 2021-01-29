@extends('adminlte::page')

@section('title', 'Создать предмет')

@section('content_header')
    <h1 class="m-0 text-dark">Создать решение</h1>
@stop

@section('content')
    <div id="app">
        <create-solution-component courses-json="{{ json_encode(\App\Models\Course::pluck('name_ru', 'id')) }}"></create-solution-component>
    </div>
@stop
@section('js')
    <script src="{{ mix('/js/app.js') }}"></script>
@endsection
