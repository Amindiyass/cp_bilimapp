<?php
$courses = \App\Models\Course::all()->pluck('name_ru', 'id')->toArray();
$key = sprintf('%s-%s', 'lesson_video', \session()->getId());
$videoArray = session()->get($key);

$key = sprintf('%s-%s', 'lesson_conspectus', \session()->getId());
$conspectusArray = session()->get($key);

?>
@extends('adminlte::page')

@section('title', 'Добавить урок')

@section('content_header')
    <h1 class="m-0 text-dark">Добавить урок</h1>
@stop

@section('content')
    <div class="card card-danger">
        <div class="card-header">
            <h3>Урок</h3>
        </div>
        {!! Form::open(['route' => 'lesson.store','method' => 'POST', 'files' => true]) !!}
        @csrf
        <div class="card-body">
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
                <label>Выберите курс *</label>
                {!! Form::select('course_id',$courses, null,
                    [
                         'class' => 'form-control select2bs4',
                         'id' => 'subject_id',
                         'style' => 'width: 100%;',
                         'placeholder' => 'Выберите курс ...',
                         ]); !!}
            </div>

            <div class="form-group">
                <label>Выберите тему *</label>
                {!! Form::select('section_id',[], null,
                    [
                         'class' => 'form-control select2bs4',
                         'id' => 'section_id',
                         'disabled' => true,
                         'style' => 'width: 100%;',
                         'placeholder' => 'Выберите тему ...',
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
            <div class="form-group">
                <label>Файл решения</label>
                <div class="input-group">
                    <input name="solutions_file_url" type="file" class="form-control-file">
                </div>
            </div>


        </div>
        <div class="card-header">
            <h3>Видео</h3>
        </div>
        <div class="card-body">
            <label for="title_kz">
                Название на казахском *
            </label>
            {!! Form::text('title_kz',null , ['class' => 'form-control']); !!}

            <label for="title_ru">
                Название на русском *
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

        <div class="card-header">
            <h3>Конспект</h3>
        </div>
        <div class="card-body">
            <label for="body">
                Конспект
            </label>
            {!! Form::textarea('body', null,['class' => 'form-control','id' => 'summernote', 'cols' => 30, 'rows' => 20]); !!}
        </div>
        <div class="btn btn-group float-right">
            <button type="submit" class="btn btn-success">
                Создать
            </button>
        </div>
        {!! Form::close() !!}
    </div>
@stop
@section('plugins.Summernote', true)
@section('js')

    <script>
        $('#summernote').summernote()

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
