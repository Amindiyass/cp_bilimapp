<?php
/** @var \App\Models\Lesson $lesson */
$courses = \App\Models\Course::all()->pluck('name_ru', 'id')->toArray();
$sections = \App\Models\Section::all()->pluck('name_ru', 'id')->toArray();
$videos = $lesson->videos;
$conspectus = $lesson->conspectus;
?>
@extends('adminlte::page')

@section('title', 'Изменить урок')

@section('content_header')
    <h1 class="m-0 text-dark">Добавить урок</h1>
@stop

@section('content')
    <div class="card card-danger">
        <div class="card-body">
            <div class="btn-group float-left">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addVideos">
                    Добавить видео
                    &nbsp;
                    <i class="fa fa-video"></i>
                </button>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#addConspectuses">
                    Добавить конспект
                    &nbsp;
                    <i class="fa fa-pen"></i>
                </button>
            </div>
        </div>
        {!! Form::open(['route' => 'lesson.store','method' => 'POST']) !!}
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label>Название на казахском *</label>
                <div class="input-group">
                    <input value="{{$lesson->name_kz}}" name="name_kz" type="text" class="form-control">
                </div>

            </div>
            <div class="form-group">
                <label>Название на русском *</label>
                <div class="input-group">
                    <input value="{{$lesson->name_ru}}" name="name_ru" type="text" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label>Выберите курс *</label>
                {!! Form::select('course_id',$courses, ($lesson->section && $lesson->section->course ? $lesson->section->course->id : null),
                    [
                         'class' => 'form-control select2bs4',
                         'id' => 'subject_id',
                         'style' => 'width: 100%;',
                         'placeholder' => 'Выберите курс ...',
                         ]); !!}
            </div>

            <div class="form-group">
                <label>Выберите тему *</label>
                {!! Form::select('section_id', $sections, $lesson->section ? $lesson->section->id : null,
                    [
                         'class' => 'form-control select2bs4',
                         'id' => 'section_id',
                         'disabled' => false,
                         'style' => 'width: 100%;',
                         'placeholder' => 'Выберите тему ...',
                         ]); !!}
            </div>

            <div class="form-group">
                <label for="">Описание на русском *</label>
                <textarea class="form-control" name="description_ru" cols="30" rows="5">
                    {{$lesson->description_ru}}
                </textarea>
            </div>

            <div class="form-group">
                <label for="">Описание на казахском *</label>
                <textarea class="form-control" name="description_kz" cols="30" rows="5">
                    {{$lesson->description_kz}}
                </textarea>
            </div>

            <div class="form-group">
                <label>Приоритет *</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-sort"></i></span>
                    </div>
                    <input name="order" value="{{$lesson->order}}" type="text" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-8">
                    <div class="card-body">
                        <h3>Видео</h3>
                        <table style="" id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Название на казахском</th>
                                <th>Название на русском</th>
                                <th>Url-адрес</th>
                                <th>Сорт номер</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($videos as $video)
                                <tr>
                                    <td>{{$video->title_kz}}</td>
                                    <td>{{$video->title_ru}}</td>
                                    <td>{{$video->path}}</td>
                                    <td>{{$video->sort_number}}</td>
                                    <td>
                                        <div class="btn-group" style="position: relative;">
                                            <button type="button" class="btn btn-danger dropdown-toggle"
                                                    data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                Действие
                                            </button>
                                            <div class="dropdown-menu" style="position: absolute;">
                                                <button class="dropdown-item"
                                                        type="button"
                                                        data-toggle="modal"
                                                        data-target="#editVideos">
                                                    Редактировать
                                                    &nbsp;
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <a href="{{ route('lesson.video.reset')}}" class="dropdown-item">
                                                    Сбросить
                                                    &nbsp;
                                                    <i class=" fa fa-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card-body">
                        <h3>Конспект</h3>
                        <table style="" id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Конспект</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($conspectus as $conspect)
                                <tr>
                                    <td>Конспект</td>
                                    <td>
                                        <div class="btn-group" style="position: relative;">
                                            <button type="button" class="btn btn-danger dropdown-toggle"
                                                    data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                Действие
                                            </button>
                                            <div class="dropdown-menu" style="position: absolute;">
                                                <button type="button" onclick="show_conspect()" class="dropdown-item">
                                                    Посмотреть
                                                    &nbsp;
                                                    <i class="fa fa-eye"></i>
                                                </button>

                                                <button type="button" onclick="edit_conspect()" class="dropdown-item">
                                                    Редактировать
                                                    &nbsp;
                                                    <i class="fa fa-edit"></i>
                                                </button>

                                                <a href="{{ route('lesson.conspectus.reset')}}" class="dropdown-item">
                                                    Сбросить
                                                    &nbsp;
                                                    <i class=" fa fa-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="btn btn-group float-right">
                <button type="submit" class="btn btn-success">
                    Создать
                </button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="modal fade" id="addVideos" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog" style="max-width: 800px;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Добавить видео</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['route' => 'lesson.video', 'method' => 'post']); !!}
                <div class="modal-body">
                    @csrf
                    <label for="title_kz">
                        Ответ на казахском *
                    </label>
                    {!! Form::text('title_kz',null , ['class' => 'form-control']); !!}

                    <label for="title_ru">
                        Ответ на русском *
                    </label>
                    {!! Form::text('title_ru', null,['class' => 'form-control']); !!}

                    <label for="path">
                        Url-адрес
                    </label>
                    {!! Form::text('path', null,['class' => 'form-control']); !!}

                    <label for="sort_number">
                        Сортировочный номер
                    </label>
                    {!! Form::number('sort_number', null,['class' => 'form-control']); !!}

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Добавить видео</button>
                </div>
                {!! Form::close(); !!}
            </div>
        </div>
    </div>
    <div class="modal fade" id="editVideos" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog" style="max-width: 800px;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Изменить видео</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @if(!empty($videoArray))
                    {!! Form::open(['route' => 'lesson.video', 'method' => 'post']); !!}
                    <div class="modal-body">
                        @csrf
                        <label for="title_kz">
                            Ответ на казахском *
                        </label>
                        {!! Form::text('title_kz',$videoArray['title_kz'][0] , ['class' => 'form-control']); !!}

                        <label for="title_ru">
                            Ответ на русском *
                        </label>
                        {!! Form::text('title_ru', $videoArray['title_ru'][0],['class' => 'form-control']); !!}

                        <label for="path">
                            Url-адрес
                        </label>
                        {!! Form::text('path', $videoArray['path'][0],['class' => 'form-control']); !!}

                        <label for="sort_number">
                            Сортировочный номер
                        </label>
                        {!! Form::number('sort_number', $videoArray['sort_number'][0],['class' => 'form-control']); !!}

                    </div>
                @endif
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Изменить видео</button>
                </div>
                {!! Form::close(); !!}
            </div>
        </div>
    </div>

    <div class="modal fade" id="addConspectuses" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog" style="max-width: 800px;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Добавить конспект</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['route' => 'lesson.conspectuses', 'method' => 'post']); !!}
                <div class="modal-body">
                    @csrf
                    <label for="body">
                        Конспект
                    </label>
                    {!! Form::textarea('body', null,['class' => 'form-control','id' => 'summernote', 'cols' => 30, 'rows' => 20]); !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Добавить конспект</button>
                </div>
                {!! Form::close(); !!}
            </div>
        </div>
    </div>
    <div class="modal fade" id="editConspectuses" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog" style="max-width: 800px;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Изменить конспект</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @if(!empty($conspectusArray))
                    {!! Form::open(['route' => 'lesson.conspectuses', 'method' => 'post']); !!}
                    <div class="modal-body">
                        @csrf
                        <label for="body">
                            Конспект
                        </label>
                        {!! Form::textarea('body', $conspectusArray['body'][0],['class' => 'form-control','id' => 'summernote2', 'cols' => 30, 'rows' => 20]); !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button id="save_conspectus_button" type="submit" class="btn btn-primary">Изменить конспект
                        </button>
                    </div>
                    {!! Form::close(); !!}
                @endif
            </div>
        </div>
    </div>
@stop
@section('plugins.Summernote', true)
@section('js')

    <script>
        $('#summernote').summernote()
        $('#summernote2').summernote()

        function show_conspect() {
            $('#save_conspectus_button').addClass('d-none');
            $('#editConspectuses').modal();
        }

        function edit_conspect() {
            $('#save_conspectus_button').removeClass('d-none');
            $('#editConspectuses').modal();
        }

        $('#subject_id').bind('change', function () {
            ajax(this.value, 'get_sections');
        });

        function ajax(item_id, type) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: 'POST',
                url: '/admin/lesson/ajax',
                data: {type: type, item_id: item_id},
                success: function (data) {
                    append_items(data);
                }
            });

            function append_items(data) {
                $('#section_id').prop('disabled', false);
                var place_holder_text = 'Выберите тему ...';
                $('#section_id').find('option')
                    .remove()
                    .end();

                $('#section_id')
                    .append($("<option></option>")
                        .attr("placeholder", null)
                        .text(place_holder_text));
                $.each(data, function (index, value) {
                    length = Object.keys(data).length;
                    $('#section_id')
                        .append($("<option></option>")
                            .attr("value", index)
                            .text(value));
                });

            }
        }
    </script>
@endsection
