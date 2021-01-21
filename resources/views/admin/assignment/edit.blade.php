<?php

$subjects = \App\Models\Subject::all()->pluck('name_ru', 'id')->toArray();
$sections = \App\Models\Section::all()->pluck('name_ru', 'id')->toArray();
$lessons = \App\Models\Lesson::all()->pluck('name_ru', 'id')->toArray();
?>
@extends('adminlte::page')

@section('title', 'Изменить задание')

@section('content_header')
    <h1 class="m-0 text-dark">Изменить задание</h1>
@stop

@section('content')
    <div class="card card-danger">
        <form action="{{route('assignment.update', ['assignment' => $assignment->id])}}" method="POST">
            @method('PUT')
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="content">Задание *</label>
                    {!! Form::textarea('content', $assignment->content,['class' => 'form-control','id' => 'summernote', 'cols' => 30, 'rows' => 20]); !!}
                </div>
                <div class="form-group">
                    <label for="answer">Ответ *</label>
                    <textarea name="answer" type="text" class="form-control" rows="2">
                    {{$assignment->answer}}
                </textarea>
                </div>

                <div class="form-group">
                    <label>Выберите предмет *</label>
                    {!! Form::select('subject_id',$subjects, $assignment->subject_id,
                        [
                            'class' => 'form-control select2bs4',
                             'id' => 'subject_id',
                             'style' => 'width: 100%;',
                             'placeholder' => 'Выберите предмет ...',
                             ]); !!}
                </div>

                <div id="section_div" class="form-group">
                    <label>Выберите тему *</label>
                    {!! Form::select('section_id',$sections, $assignment->section_id,
                        ['class' => 'form-control select2bs4 ',
                        'id' => 'section_id',
                        'disabled' => true,
                        'style' => 'width: 100%;',
                        'placeholder' => 'Выберите тему ...',
                        ]); !!}
                </div>

                <div id="lesson_div" class="form-group">
                    <label>Выберите урок *</label>
                    {!! Form::select('lesson_id',$lessons, $assignment->lesson_id,
                        ['class' => 'form-control select2bs4 ',
                        'id' =>'lesson_id',
                        'disabled' => true,
                        'placeholder' => 'Выберите урок ...',
                        'style' => 'width: 100%;']); !!}
                </div>

                <div class="form-group">
                    <label for="order_number">Сортировочный номер *</label>
                    <input name="order_number" type="number" class="form-control" value="{{$assignment->order_number}}">
                </div>

                <div class="form-group">
                    <label for="solutuion">Решение задачи *</label>
                    {!! Form::textarea('solution', ($assignment->solution ? $assignment->solution->content : null) ,['class' => 'form-control','id' => 'summernote2', 'cols' => 30, 'rows' => 20]); !!}
                </div>


                <button type="submit" class="btn btn-success float-right">
                    Изменить
                </button>
            </div>
        </form>
    </div>
@stop
@section('plugins.Summernote', true)
@section('js')
    <script>
        $('#summernote').summernote()
        $('#summernote2').summernote()


        $('#subject_id').change(function () {
            var type = 'get_sections';
            var item_id = $(this).val();
            ajax(item_id, type);
        });

        $('#section_id').change(function () {
            var type = 'get_lessons';
            var item_id = $(this).val();
            ajax(item_id, type);
        });


        function ajax(item_id, type) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            console.log(item_id);

            $.ajax({
                method: 'POST',
                url: '/admin/assignment/ajax',
                data: {type: type, item_id: item_id},
                success: function (data) {
                    append_items(data, type);
                }
            });
        }

        function append_items(data, type) {
            type = type === 'get_sections' ? 'section_id' : 'lesson_id';
            var place_holder_text;
            if (type === 'section_id') {
                $('#section_id').prop('disabled', false);
                place_holder_text = 'Выберите тему  ...';
            }
            if (type === 'lesson_id') {
                $('#lesson_id').prop('disabled', false);
                place_holder_text = 'Выберите урок ...';
            }


            $('#' + type).find('option')
                .remove()
                .end();

            $('#' + type)
                .append($("<option></option>")
                    .attr("placeholder", null)
                    .text(place_holder_text));
            $.each(data, function (index, value) {
                length = Object.keys(data).length;
                $('#' + type)
                    .append($("<option></option>")
                        .attr("value", index)
                        .text(value));
            });
        }
    </script>
@endsection
