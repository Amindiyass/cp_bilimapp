@extends('adminlte::page')

@section('title', 'Список курсов')

@section('content_header')
    <h1 class="m-0 text-dark">Список курсов</h1>
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
                            <label>По предмету.</label>
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
                            <label>По классу.</label>
                            {!! Form::select('class_id',$classes,session('classes') ?? null,
                            [
                                'class' => 'select2',
                                'id' => 'class_id',
                                'multiple' => 'multiple',
                                'style' => 'width: 100%;',
                                'data-placeholder' => 'Выберите класс ...',
                            ]); !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>По языку обучение</label>
                            {!! Form::select('language_id',$languages, session('languages') ?? null,
                                [
                                    'class' => 'select2',
                                    'id' => 'language_id',
                                    'multiple' => 'multiple',
                                    'style' => 'width: 100%;',
                                    'data-placeholder' => 'Выберите язык ...',
                                ]); !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="is_active">Удаленные</label>
                        {!! Form::checkbox('is_active', 'value', true); !!}
                    </div>
                </div>
                <button id="filter_btn" type="button" class="btn btn-primary float-right">Фильтровать</button>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <a href="{{route('course.create')}}" class="btn btn-success">Добавить курс</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body" style="overflow-x: auto;white-space: nowrap;">
            <table style="" id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID-номер</th>
                    <th>Название на казахском</th>
                    <th>Название на русском</th>
                    <th>Язык</th>
                    <th>Предмет</th>
                    <th>Класс</th>
                    <th>Приоритет</th>
                    <th>Дата создание</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach((session('courses') ?? $courses) as $course)
                    <tr>
                        <td>{{$course->id}}</td>
                        <td>{{$course->name_kz}}</td>
                        <td>{{$course->name_ru}}</td>
                        <td>{{$course->language->name_ru}}</td>
                        <td>{{$course->subject->name_ru}}</td>
                        <td>{{$course->education_level->order_number}}</td>
                        <td>{{$course->order}}</td>
                        <td> {{date('Y-m-d H:i:s',strtotime($course->created_at))}}</td>
                        <td>
                            <div class="btn-group" style="position: relative;">
                                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    Действие
                                </button>
                                <div class="dropdown-menu" style="position: absolute;">
                                    <a href="{{route('course.edit', ['course' => $course->id])}}" class="dropdown-item"
                                       data-user_id="{{$course->id}}">
                                        Редактировать
                                        &nbsp;
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('course.destroy', $course->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item">
                                            Удалить
                                            &nbsp;
                                            <i class=" fa fa-trash"></i>
                                        </button>
                                    </form>
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

        $('#filter_btn').click(function () {
            url = '/admin/course/filter?';

            subject = $('#subject_id').val();
            url = set_delimiter(url, subject, 'subject_id');

            langauge = $('#language_id').val();
            url = set_delimiter(url, langauge, 'languages');

            classes = $('#class_id').val();
            url = set_delimiter(url, classes, 'classes');

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
