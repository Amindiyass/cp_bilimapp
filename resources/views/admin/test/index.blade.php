@extends('adminlte::page')

@section('title', 'Список тестов')

@section('content_header')
    <h1 class="m-0 text-dark">Список учеников</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{route('test.create')}}" class="btn btn-success">Добавить тест</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body" style="overflow-x: auto;white-space: nowrap;">
            <table style="" id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID-номер</th>
                    <th>Название</th>
                    <th>Тема</th>
                    <th>Сортировочный номер</th>
                    <th>Кол-во вопросов</th>
                    <th>Дата создание</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($tests as $test)
                    <tr>
                        <td>{{$test->id}}</td>
                        <td>{{$test->name_kz}}</td>
                        <td>{{$test->section?$test->section->name_ru:null}}</td>
                        <td>{{$test->order_number}}</td>
                        <td>{{count($test->questions) ?? 0}}</td>
                        <td>{{date('Y-m-d H:i:s', strtotime($test->created_at))}}</td>
                        <td>
                            <div class="btn-group" style="position: relative;">
                                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    Действие
                                </button>
                                <div class="dropdown-menu" style="position: absolute;">
                                    <a href="{{route('test.edit', ['test' => $test->id])}}" class="dropdown-item"
                                       data-user_id="{{$test->id}}">
                                        Редактировать
                                        &nbsp;
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('test.destroy', $test->id) }}" method="POST">
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
    {{--        <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog"--}}
    {{--             aria-hidden="true">--}}
    {{--            <div class="modal-dialog" role="document">--}}
    {{--                <div class="modal-content">--}}
    {{--                    <div class="modal-header">--}}
    {{--                        <h5 class="modal-title" id="exampleModalLabel">Изменить пароль</h5>--}}
    {{--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
    {{--                            <span aria-hidden="true">&times;</span>--}}
    {{--                        </button>--}}
    {{--                    </div>--}}
    {{--                    {!! Form::open(['route' => 'student.password.change', 'method' => 'post']); !!}--}}
    {{--                    <div class="modal-body">--}}

    {{--                        @csrf--}}
    {{--                        <label for="password">--}}
    {{--                            Новый пароль *--}}
    {{--                        </label>--}}
    {{--                        {!! Form::password('password', ['class' => 'form-control']); !!}--}}

    {{--                        {!! Form::hidden('user_id') !!}--}}
    {{--                        <label for="password_confirmation">--}}
    {{--                            Повторите новый пароль *--}}
    {{--                        </label>--}}
    {{--                        {!! Form::password('password_confirmation', ['class' => 'form-control']); !!}--}}
    {{--                    </div>--}}
    {{--                    <div class="modal-footer">--}}
    {{--                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>--}}
    {{--                        <button type="submit" class="btn btn-primary">Изменить пароль</button>--}}
    {{--                    </div>--}}
    {{--                    {!! Form::close(); !!}--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--        <div class="modal fade" id="addSubscription" tabindex="-1" role="dialog"--}}
    {{--             aria-hidden="true">--}}
    {{--            <div class="modal-dialog" role="document">--}}
    {{--                <div class="modal-content">--}}
    {{--                    <div class="modal-header">--}}
    {{--                        <h5 class="modal-title" id="exampleModalLabel">Добавить подписку</h5>--}}
    {{--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
    {{--                            <span aria-hidden="true">&times;</span>--}}
    {{--                        </button>--}}
    {{--                    </div>--}}
    {{--                    <div class="modal-body">--}}
    {{--                        {!! Form::open(['route' => 'student.add.subscription', 'method' => 'post']); !!}--}}
    {{--                        <div class="form-group">--}}
    {{--                            {!! Form::hidden('user_id') !!}--}}
    {{--                            <label>Выберите подписку *</label>--}}
    {{--                            {!! Form::select('subscription_id',$subscriptions, null,--}}
    {{--                                ['class' => 'form-control select2bs4 ', 'style' => 'width: 100%;']); !!}--}}
    {{--                        </div>--}}
    {{--                        <button class="btn btn-primary float-right" type="submit">--}}
    {{--                            Добавить--}}
    {{--                        </button>--}}
    {{--                        {!! Form::close(); !!}--}}
    {{--                    </div>--}}
    {{--                </div>--}}

    {{--            </div>--}}
    {{--        </div>--}}
    {{--        <div class="modal fade" id="extendSubscription" tabindex="-1" role="dialog"--}}
    {{--             aria-hidden="true">--}}
    {{--            <div class="modal-dialog" role="document">--}}
    {{--                <div class="modal-content">--}}
    {{--                    <div class="modal-header">--}}
    {{--                        <h5 class="modal-title" id="exampleModalLabel">Продлить подписку</h5>--}}
    {{--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
    {{--                            <span aria-hidden="true">&times;</span>--}}
    {{--                        </button>--}}
    {{--                    </div>--}}
    {{--                    <div class="modal-body">--}}
    {{--                        {!! Form::open(['route' => 'student.extend.subscription', 'method' => 'post']); !!}--}}

    {{--                        {!! Form::close(); !!}--}}
    {{--                    </div>--}}
    {{--                </div>--}}

    {{--            </div>--}}
    {{--        </div>--}}
@stop
@section('plugins.Select2', true)
@section('plugins.Datatables', true)
{{--        @section('js')--}}
{{--            <script>--}}
{{--                $('.select2').select2()--}}

{{--                $("#example1").DataTable({--}}
{{--                    "responsive": true,--}}
{{--                    "autoWidth": false,--}}
{{--                });--}}

{{--                // $('#area_id').change(function () {--}}
{{--                //     var type = 'get_regions';--}}
{{--                //     var item_id = $(this).val();--}}
{{--                //     console.log(item_id);--}}
{{--                //     ajax(item_id, type);--}}
{{--                // });--}}
{{--                //--}}
{{--                // $('#region_id').change(function () {--}}
{{--                //     var type = 'get_schools';--}}
{{--                //     var item_id = $(this).val();--}}
{{--                //     ajax(item_id, type);--}}
{{--                // });--}}

{{--                $('#open_change_password').bind('click', function () {--}}
{{--                    var user_id = $(this).data('user_id');--}}
{{--                    $('input[name=user_id]').val(user_id);--}}
{{--                    $('#passwordModal').modal();--}}

{{--                });--}}

{{--                $('#open_add_subscription').bind('click', function () {--}}
{{--                    var user_id = $(this).data('user_id');--}}
{{--                    $('input[name=user_id]').val(user_id);--}}
{{--                    $('#addSubscription').modal();--}}
{{--                });--}}

{{--                $('#open_extend_subscription').bind('click', function () {--}}
{{--                    var user_id = $(this).data('user_id');--}}
{{--                    $('input[name=user_id]').val(user_id);--}}
{{--                    $('#extendSubscription').modal();--}}
{{--                });--}}


{{--                function ajax(item_id, type) {--}}
{{--                    $.ajaxSetup({--}}
{{--                        headers: {--}}
{{--                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
{{--                        }--}}
{{--                    });--}}
{{--                    $.ajax({--}}
{{--                        method: 'POST',--}}
{{--                        url: '/admin/students/ajax',--}}
{{--                        data: {type: type, item_id: item_id},--}}
{{--                        success: function (data) {--}}
{{--                            append_items(data, type);--}}
{{--                        }--}}
{{--                    });--}}

{{--                    function append_items(data, type) {--}}
{{--                        type = type === 'get_regions' ? 'region_id' : 'school_id';--}}
{{--                        $('#' + type).prop('disabled', false);--}}
{{--                        $('#' + type).find('option')--}}
{{--                            .remove()--}}
{{--                            .end();--}}

{{--                        $.each(data, function (index, value) {--}}
{{--                            length = Object.keys(data).length;--}}
{{--                            $('#' + type)--}}
{{--                                .append($("<option></option>")--}}
{{--                                    .attr("value", index)--}}
{{--                                    .text(value));--}}
{{--                        });--}}
{{--                    }--}}
{{--                }--}}

{{--                $('#filter_btn').click(function () {--}}
{{--                    url = '/admin/students/filter?';--}}

{{--                    area = $('#area_id').val();--}}
{{--                    url = set_delimiter(url, area, 'area');--}}

{{--                    region = $('#region_id').val();--}}
{{--                    url = set_delimiter(url, region, 'region');--}}

{{--                    school = $('#school_id').val();--}}
{{--                    url = set_delimiter(url, school, 'school');--}}

{{--                    langauge = $('#language_id').val();--}}
{{--                    url = set_delimiter(url, langauge, 'language');--}}

{{--                    classes = $('#class_id').val();--}}
{{--                    url = set_delimiter(url, classes, 'class');--}}


{{--                    console.log(url);--}}
{{--                    window.location = url;--}}
{{--                });--}}

{{--                function set_delimiter(url, item, param_name) {--}}
{{--                    console.log(item.length);--}}
{{--                    if (Array.isArray(item) && item.length) {--}}
{{--                        url = url + '&' + param_name + '=' + item.join();--}}
{{--                    }--}}
{{--                    return url;--}}
{{--                }--}}


{{--            </script>--}}
{{--@stop--}}
