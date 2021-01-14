<?php
$languages = \App\Models\Language::all()->pluck('name_ru', 'id')->toArray();
$classes = \App\Models\EducationLevel::orderBy('order_number')->pluck('order_number', 'id')->toArray();
$subjects = \App\Models\Subject::all()->pluck('name_ru', 'id')->toArray();

?>
@extends('adminlte::page')

@section('title', 'Добавить курс')

@section('content_header')
    <h1 class="m-0 text-dark">Добавить курс</h1>
@stop

@section('content')
    <div class="card card-danger">

        <div class="card-body">
            <div class="btn-group float-left">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSections">
                    Добавить темы
                    &nbsp;
                    <i class="fa fa-paragraph"></i>
                </button>
            </div>
        </div>

        <div class="card-body">

            {!! Form::open(['route' => 'course.store','method' => 'POST']) !!}
            @csrf
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


            <div class="form-group">
                <label>Выберите язык *</label>
                {!! Form::select('language_id',$languages, null,
                    [
                         'class' => 'form-control select2bs4',
                         'id' => 'language_id',
                         'style' => 'width: 100%;',
                         'placeholder' => 'Выберите язык ...',
                         ]); !!}
            </div>

            <div class="form-group">
                <label>Выберите класс *</label>
                {!! Form::select('class_id',$classes, null,
                    [
                         'class' => 'form-control select2bs4',
                         'id' => 'class_id',
                         'style' => 'width: 100%;',
                         'placeholder' => 'Выберите класс ...',
                         ]); !!}
            </div>

            <div class="form-group">
                <label>Выберите предмет *</label>
                {!! Form::select('subject_id',$subjects, null,
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
                </textarea>
            </div>

            <div class="form-group">
                <label for="">Описание на казахском *</label>
                <textarea class="form-control" name="description_kz" cols="30" rows="5">
                </textarea>
            </div>

            <div class="form-group">
                <label>Приоритет *</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-sort"></i></span>
                    </div>
                    <input name="order" value="100" type="text" class="form-control">
                </div>
            </div>

            <div class="card-body col-8">
                <h3>Темы</h3>
                <table style="" id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Название на казахском</th>
                        <th>Название на русском</th>
                        <th>Сортировачный номер</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $key = sprintf('%s-%s', 'course_section', \session()->getId());
                    $sectionArray = session()->get($key);
                    ?>
                    @if(!empty($sectionArray))
                        @for($i = 0; $i<count($sectionArray['sort_number']); $i++)
                            <tr>
                                <td>{{$sectionArray['name_kz'][$i]}}</td>
                                <td>{{$sectionArray['name_ru'][$i]}}</td>
                                <td>{{$sectionArray['sort_number'][$i]}}</td>
                                <td>
                                    <div class="btn-group" style="position: relative;">
                                        <button type="button" class="btn btn-danger dropdown-toggle"
                                                data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                            Действие
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endfor
                    @endif
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>

            <div class="btn btn-group float-right">
                <button type="submit" class="btn btn-success">
                    Добавить
                </button>
            </div>
        </div>
        {!! Form::close() !!}
        <div class="modal fade" id="addSections" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog" style="max-width: 800px;" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Добавить тему</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {!! Form::open(['route' => 'course.section', 'method' => 'post']); !!}
                    <div class="modal-body">
                        @csrf
                        <label for="name_kz">
                            Названание на казахском *
                        </label>
                        {!! Form::text('name_kz', null,['class' => 'form-control']); !!}

                        <label for="name_ru">
                            Названание на русском *
                        </label>
                        {!! Form::text('name_ru', null,['class' => 'form-control']); !!}

                        <label for="sort_number">
                            Сортировочный номер *
                        </label>
                        {!! Form::number('sort_number', null,['class' => 'form-control']); !!}

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary">Добавить тему</button>
                    </div>
                    {!! Form::close(); !!}
                </div>
            </div>
        </div>
    </div>
@stop
