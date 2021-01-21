<?php
/** @var \App\Models\Assignment $assignment */
$subjects = \App\Models\Subject::all()->pluck('name_ru', 'id')->toArray();
$sections = \App\Models\Section::all()->pluck('name_ru', 'id')->toArray();
$lessons = \App\Models\Lesson::all()->pluck('name_ru', 'id')->toArray();
?>
@extends('adminlte::page')

@section('title', 'Список заданий')

@section('content_header')
    <h1 class="m-0 text-dark">Список заданий</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-header">
                <h3 class="card-title">Фильтровать по ..</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>По предметам.</label>
                            {!! Form::select('subject_id',$subjects, session('subjects') ?? null,
                            [
                                'class' => 'select2',
                                'id' => 'subject_id',
                                'multiple' => 'multiple',
                                'style' => 'width: 100%;',
                                'data-placeholder' => 'Выберите предмет ...',
                            ]); !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>По темам.</label>
                            {!! Form::select('section_id',$sections,session('sections') ?? null,
                            [
                                'class' => 'select2',
                                'id' => 'section_id',
                                'multiple' => 'multiple',
                                'style' => 'width: 100%;',
                                'data-placeholder' => 'Выберите тему ...',
                            ]); !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>По урокам.</label>
                            {!! Form::select('lesson_id',$lessons, session('lessons') ?? null,
                               [
                                   'class' => 'select2',
                                   'id' => 'lesson_id',
                                   'multiple' => 'multiple',
                                   'style' => 'width: 100%;',
                                   'data-placeholder' => 'Выберите урок ...',
                               ]); !!}
                        </div>
                    </div>
                </div>
                <button id="filter_btn" type="button" class="btn btn-primary float-right">Фильтровать</button>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <a href="{{route('assignment.create')}}" class="btn btn-success">Добавить задачу</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body" style="overflow-x: auto;white-space: nowrap;">
            <table style="" id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID-номер</th>
                    <th>Предмет</th>
                    <th>Тема</th>
                    <th>Урок</th>
                    <th>Ответ</th>
                    <th>Решение</th>
                    <th>Сортировачный номер</th>
                    <th>Дата создание</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach((session('assignments') ?? $assignments) as $assignment)
                    <?php
                    $subject_name = $assignment->subject ? $assignment->subject->name_ru : 'Не указано';

                    $section_name = $assignment->section ? $assignment->section->name_ru : 'Не указано';

                    $lesson_name = $assignment->lesson ? $assignment->lesson->name_ru : 'Не указано';

                    ?>
                    <tr>
                        <td>{{$assignment->id}}</td>
                        <td>{{$subject_name}}</td>
                        <td>{{$section_name}}</td>
                        <td>{{$lesson_name}}</td>
                        <td>{{$assignment->answer}}</td>
                        @if($assignment->solution)
                            <td><span class="badge badge-success">Есть</span></td>
                        @else
                            <td><span class="badge badge-danger">Нету</span></td>
                        @endif
                        <td>{{$assignment->order_number}}</td>
                        <td>{{$assignment->created_at}}</td>
                        <td>
                            <div class="btn-group" style="position: relative;">
                                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    Действие
                                </button>
                                <div class="dropdown-menu" style="position: absolute;">
                                    <form action="{{ route('assignment.destroy', $assignment->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item">
                                            Удалить
                                            &nbsp;
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                    <a href="{{route('assignment.edit' ,['assignment' => $assignment->id])}}"
                                       type="button"
                                       class="dropdown-item">
                                        Редактировать
                                        &nbsp;
                                        <i class="fa fa-edit"></i>
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
@stop
@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('js')
    <script>
        $('.select2').select2()

        $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false,
        });


        function ajax(item_id, type) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: 'POST',
                url: '/admin/students/ajax',
                data: {type: type, item_id: item_id},
                success: function (data) {
                    append_items(data, type);
                }
            });

            function append_items(data, type) {
                type = type === 'get_regions' ? 'region_id' : 'school_id';
                $('#' + type).prop('disabled', false);
                $('#' + type).find('option')
                    .remove()
                    .end();

                $.each(data, function (index, value) {
                    length = Object.keys(data).length;
                    $('#' + type)
                        .append($("<option></option>")
                            .attr("value", index)
                            .text(value));
                });
            }
        }

        $('#filter_btn').click(function () {
            url = '/admin/assignment/filter?';

            area = $('#subject_id').val();
            url = set_delimiter(url, area, 'subjects');

            region = $('#section_id').val();
            url = set_delimiter(url, region, 'sections');

            school = $('#lesson_id').val();
            url = set_delimiter(url, school, 'lessons');

            console.log(url);
            window.location = url;
        });

        function set_delimiter(url, item, param_name) {
            console.log(item.length);
            if (Array.isArray(item) && item.length) {
                url = url + '&' + param_name + '=' + item.join();
            }
            return url;
        }


    </script>
@stop
