@extends('adminlte::page')

@section('title', 'Редактировать предмет')

@section('content_header')
    <h1 class="m-0 text-dark">Редактировать предмет</h1>
@stop

@section('content')
    <div class="card card-danger">
        <form action="{{ route('subject.update', $subject->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">


                <div class="form-group">
                    <label>Название на казахском *</label>
                    <div class="input-group">
                        <input name="name_kz" type="text" class="form-control" value="{{$subject->name_kz}}">
                    </div>

                </div>
                <div class="form-group">
                    <label>Название на русском *</label>
                    <div class="input-group">
                        <input name="name_ru" type="text" class="form-control" value="{{$subject->name_ru}}">
                    </div>
                </div>

                <div class="btn btn-group float-right">
                    <button type="submit" class="btn btn-success">
                        Изменить
                    </button>
                </div>
            </div>
        </form>
    </div>
@stop
