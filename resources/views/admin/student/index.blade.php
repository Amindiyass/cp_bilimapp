@extends('adminlte::page')

@section('title', 'Список учеников')

@section('content_header')
    <h1 class="m-0 text-dark">Список учеников</h1>
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
                            <label>По области.</label>
                            {!! Form::select('area_id',$areas, session('areas') ?? null,
                            [
                                'class' => 'select2',
                                'id' => 'area_id',
                                'multiple' => 'multiple',
                                'style' => 'width: 100%;',
                                'data-placeholder' => 'Выберите область ...',
                            ]); !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>По региону.</label>
                            {!! Form::select('region_id',$regions,session('regions') ?? null,
                            [
                                'class' => 'select2',
                                'id' => 'region_id',
                                'multiple' => 'multiple',
                                'style' => 'width: 100%;',
                                'data-placeholder' => 'Выберите регион ...',
                            ]); !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>По школе</label>
                            {!! Form::select('school_id',$schools, session('schools') ?? null,
                               [
                                   'class' => 'select2',
                                   'id' => 'school_id',
                                   'multiple' => 'multiple',
                                   'style' => 'width: 100%;',
                                   'data-placeholder' => 'Выберите школу ...',
                               ]); !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>По классу</label>
                            {!! Form::select('class_id',$classes, session('classes') ?? null,
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
                    <div class="col-md-6">
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
            <a href="{{route('student.create')}}" class="btn btn-success">Добавить студента</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body" style="overflow-x: auto;white-space: nowrap;">
            <table style="" id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID-номер</th>
                    <th>ФИО</th>
                    <th>E-почта</th>
                    <th>Телефон</th>
                    <th>Регион</th>
                    <th>Школа</th>
                    <th>Язык обучение</th>
                    <th>Подписка</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach((session('students') ?? $students) as $student)
                    <tr>
                        <td>{{$student->id}}</td>
                        <td>{{sprintf('%s %s', $student->studentfirst_name, $student->student->last_name)}}</td>
                        <td>{{$student->email}}</td>
                        <td>{{$student->phone}}</td>
                        <td>{{$student->student->region->name_ru}}</td>
                        <td>{{$student->student->school->name_ru}}</td>
                        <td>{{$student->student->language->name_ru}}</td>
                        <td><span class="badge badge-success">есть</span></td>
                        <td>
                            <div class="btn-group" style="position: relative;">
                                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    Действие
                                </button>
                                <div class="dropdown-menu" style="position: absolute;">
                                    <form action="{{ route('student.destroy', $student->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item">
                                            Деактивировать
                                        </button>
                                    </form>
                                    <a class="dropdown-item" href="{{route('student.edit', ['student' => $student])}}">Редактировать</a>
                                    <a type="button" id="open_change_password" class="dropdown-item"
                                       data-user_id="{{$student->id}}">
                                        Изменить пароль
                                    </a>
                                    <a type="button" id="open_add_subscription" class="dropdown-item"
                                       data-user_id="{{$student->id}}">
                                        Добавить подписку
                                    </a>
                                    <a type="button" id="open_extend_subscription" class="dropdown-item"
                                       data-user_id="{{$student->id}}">
                                        Продлить подписку
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
    <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Изменить пароль</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['route' => 'student.password.change', 'method' => 'post']); !!}
                <div class="modal-body">

                    @csrf
                    <label for="password">
                        Новый пароль *
                    </label>
                    {!! Form::password('password', ['class' => 'form-control']); !!}

                    {!! Form::hidden('user_id') !!}
                    <label for="password_confirmation">
                        Повторите новый пароль *
                    </label>
                    {!! Form::password('password_confirmation', ['class' => 'form-control']); !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Изменить пароль</button>
                </div>
                {!! Form::close(); !!}
            </div>
        </div>
    </div>
    <div class="modal fade" id="addSubscription" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Добавить подписку</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => 'student.add.subscription', 'method' => 'post']); !!}
                    <div class="form-group">
                        {!! Form::hidden('user_id') !!}
                        <label>Выберите подписку *</label>
                        {!! Form::select('subscription_id',$subscriptions, null,
                            ['class' => 'form-control select2bs4 ', 'style' => 'width: 100%;']); !!}
                    </div>
                    <button class="btn btn-primary float-right" type="submit">
                        Добавить
                    </button>
                    {!! Form::close(); !!}
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="extendSubscription" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Продлить подписку</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => 'student.extend.subscription', 'method' => 'post']); !!}

                    {!! Form::close(); !!}
                </div>
            </div>

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

        $('#open_change_password').bind('click', function () {
            var user_id = $(this).data('user_id');
            $('input[name=user_id]').val(user_id);
            $('#passwordModal').modal();

        });

        $('#open_add_subscription').bind('click', function () {
            var user_id = $(this).data('user_id');
            $('input[name=user_id]').val(user_id);
            $('#addSubscription').modal();
        });

        $('#open_extend_subscription').bind('click', function () {
            var user_id = $(this).data('user_id');
            $('input[name=user_id]').val(user_id);
            $('#extendSubscription').modal();
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
            url = '/admin/students/filter?';

            area = $('#area_id').val();
            url = set_delimiter(url, area, 'area');

            region = $('#region_id').val();
            url = set_delimiter(url, region, 'region');

            school = $('#school_id').val();
            url = set_delimiter(url, school, 'school');

            langauge = $('#language_id').val();
            url = set_delimiter(url, langauge, 'language');

            classes = $('#class_id').val();
            url = set_delimiter(url, classes, 'class');

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
