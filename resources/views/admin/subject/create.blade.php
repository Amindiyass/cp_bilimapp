@extends('adminlte::page')

@section('title', 'Создать предмет')

@section('content_header')
    <h1 class="m-0 text-dark">Создать предмет</h1>
@stop

@section('content')
    <div class="card card-danger">
        {!! Form::open(['route' => 'subject.store','method' => 'POST']) !!}
        @csrf
        <div class="card-body">

            {{--            @include('admin.test.question_textarea')--}}

            <div class="form-group">
                <label>Название на казахском *</label>
                <div class="input-group">
                    <input name="name_kz" type="text" class="form-control">
                </div>

            </div>
            <div class="form-group">
                <label>Название на русском *</label>
                <div class="input-group">
                    <input name="name_ru" type="text" class="form-control">
                </div>
            </div>

            <div class="btn btn-group float-right">
                <button type="button" class="btn btn-primary d-none" id="open_add_variants_modal">
                    Добавить вопрос
                </button>
                <button type="submit" class="btn btn-success">
                    Добавить
                </button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@stop
