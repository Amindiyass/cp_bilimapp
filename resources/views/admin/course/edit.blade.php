<?php
$languages = \App\Models\Language::all()->pluck('name_ru', 'id')->toArray();
$classes = \App\Models\EducationLevel::orderBy('order_number')->pluck('order_number', 'id')->toArray();
$subjects = \App\Models\Subject::all()->pluck('name_ru', 'id')->toArray();

?>
@extends('adminlte::page')

@section('title', 'Редактировать курс')

@section('content_header')
    <h1 class="m-0 text-dark">Редактировать курс</h1>
@stop

@section('content')
    <div class="card card-danger">
        <form action="{{ route('course.update', $course->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label>Название на казахском *</label>
                    <div class="input-group">
                        <input name="name_kz" type="text" value="{{$course->name_kz}}" class="form-control">
                    </div>

                </div>
                <div class="form-group">
                    <label>Название на русском *</label>
                    <div class="input-group">
                        <input name="name_ru" type="text" value="{{$course->name_ru}}" class="form-control">
                    </div>
                </div>


                <div class="form-group">
                    <label>Выберите язык *</label>
                    {!! Form::select('language_id',$languages, $course->language_id,
                        [
                             'class' => 'form-control select2bs4',
                             'id' => 'language_id',
                             'style' => 'width: 100%;',
                             'placeholder' => 'Выберите язык ...',
                             ]); !!}
                </div>

                <div class="form-group">
                    <label>Выберите класс *</label>
                    {!! Form::select('class_id',$classes, $course->class_id,
                        [
                             'class' => 'form-control select2bs4',
                             'id' => 'class_id',
                             'style' => 'width: 100%;',
                             'placeholder' => 'Выберите класс ...',
                             ]); !!}
                </div>

                <div class="form-group">
                    <label>Выберите предмет *</label>
                    {!! Form::select('subject_id',$subjects, $course->subject_id,
                        [
                             'class' => 'form-control select2bs4',
                             'id' => 'subject_id',
                             'style' => 'width: 100%;',
                             'placeholder' => 'Выберите предмет ...',
                             ]); !!}
                </div>

                <div class="form-group">
                    <label for="">Описание на русском *</label>
                    <textarea class="form-control" name="description_ru" cols="30" rows="5">
                        {{$course->description_ru}}
                </textarea>
                </div>

                <div class="form-group">
                    <label for="">Описание на казахском *</label>
                    <textarea class="form-control" name="description_kz" cols="30" rows="5">
                        {{$course->description_kz}}
                </textarea>
                </div>

                <div class="form-group">
                    <label>Приоритет *</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-sort"></i></span>
                        </div>
                        <input name="order" value="{{$course->order}}" type="number" class="form-control">
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
