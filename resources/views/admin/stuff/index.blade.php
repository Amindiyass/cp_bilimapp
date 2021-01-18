@extends('adminlte::page')

@section('title', 'Список учеников')

@section('content_header')
    <h1 class="m-0 text-dark">Список сотрудников</h1>
@stop

@section('content')
    {{--    <div class="card">--}}
    {{--        <div class="card-header">--}}
    {{--            <div class="card-header">--}}
    {{--                <h3 class="card-title">Фильтровать по ..</h3>--}}
    {{--                <div class="card-tools">--}}
    {{--                    <button type="button" class="btn btn-tool" data-card-widget="collapse">--}}
    {{--                        <i class="fas fa-minus"></i>--}}
    {{--                    </button>--}}
    {{--                    <button type="button" class="btn btn-tool" data-card-widget="remove">--}}
    {{--                        <i class="fas fa-times"></i>--}}
    {{--                    </button>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--            <div class="card-body">--}}
    {{--                <div class="row">--}}
    {{--                    <div class="col-md-6">--}}
    {{--                        <div class="form-group">--}}
    {{--                            <label>По области.</label>--}}
    {{--                            {!! Form::select('area_id',$areas, session('areas') ?? null,--}}
    {{--                            [--}}
    {{--                                'class' => 'select2',--}}
    {{--                                'id' => 'area_id',--}}
    {{--                                'multiple' => 'multiple',--}}
    {{--                                'style' => 'width: 100%;',--}}
    {{--                                'data-placeholder' => 'Выберите область ...',--}}
    {{--                            ]); !!}--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                    <div class="col-md-6">--}}
    {{--                        <div class="form-group">--}}
    {{--                            <label>По региону.</label>--}}
    {{--                            {!! Form::select('region_id',$regions,session('regions') ?? null,--}}
    {{--                            [--}}
    {{--                                'class' => 'select2',--}}
    {{--                                'id' => 'region_id',--}}
    {{--                                'multiple' => 'multiple',--}}
    {{--                                'style' => 'width: 100%;',--}}
    {{--                                'data-placeholder' => 'Выберите регион ...',--}}
    {{--                            ]); !!}--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                    <div class="col-md-12">--}}
    {{--                        <div class="form-group">--}}
    {{--                            <label>По школе</label>--}}
    {{--                            {!! Form::select('school_id',$schools, session('schools') ?? null,--}}
    {{--                               [--}}
    {{--                                   'class' => 'select2',--}}
    {{--                                   'id' => 'school_id',--}}
    {{--                                   'multiple' => 'multiple',--}}
    {{--                                   'style' => 'width: 100%;',--}}
    {{--                                   'data-placeholder' => 'Выберите школу ...',--}}
    {{--                               ]); !!}--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                    <div class="col-md-6">--}}
    {{--                        <div class="form-group">--}}
    {{--                            <label>По классу</label>--}}
    {{--                            {!! Form::select('class_id',$classes, session('classes') ?? null,--}}
    {{--                                [--}}
    {{--                                    'class' => 'select2',--}}
    {{--                                    'id' => 'class_id',--}}
    {{--                                    'multiple' => 'multiple',--}}
    {{--                                    'style' => 'width: 100%;',--}}
    {{--                                    'data-placeholder' => 'Выберите класс ...',--}}
    {{--                                ]); !!}--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                    <div class="col-md-6">--}}
    {{--                        <div class="form-group">--}}
    {{--                            <label>По языку обучение</label>--}}
    {{--                            {!! Form::select('language_id',$languages, session('languages') ?? null,--}}
    {{--                                [--}}
    {{--                                    'class' => 'select2',--}}
    {{--                                    'id' => 'language_id',--}}
    {{--                                    'multiple' => 'multiple',--}}
    {{--                                    'style' => 'width: 100%;',--}}
    {{--                                    'data-placeholder' => 'Выберите язык ...',--}}
    {{--                                ]); !!}--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                    <div class="col-md-6">--}}
    {{--                        <label for="is_active">Удаленные</label>--}}
    {{--                        {!! Form::checkbox('is_active', 'value', true); !!}--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <button id="filter_btn" type="button" class="btn btn-primary float-right">Фильтровать</button>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    <div class="card">
        <div class="card-header">
            <a href="{{route('stuff.create')}}" class="btn btn-success">Добавить сотрудника</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body" style="overflow-x: auto;white-space: nowrap;">
            <table style="" id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID-номер</th>
                    <th>Имя</th>
                    <th>E-почта</th>
                    <th>Роль</th>
                    <th>Активный</th>
                    <th>Дата создание</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($stuffs as $stuff)
                    <tr>
                        <td>{{$stuff->id}}</td>
                        <td>{{$stuff->name}}</td>
                        <td>{{$stuff->email}}</td>
                        <td>{{ $stuff->getRoleName($stuff->id)}}</td>

                        <td><span
                                class="badge badge-{{$stuff->is_active ? 'success' : 'danger'}}">{{$stuff->is_active ? 'Да' : 'Нет'}}</span>
                        </td>
                        <td>{{ $stuff->created_at}}</td>
                        <td>
                            <div class="btn-group" style="position: relative;">
                                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    Действие
                                </button>
                                <div class="dropdown-menu" style="position: absolute;">
                                    @if($stuff->is_active)
                                        <form action="{{ route('stuff.deactivate') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="stuff_id" value="{{$stuff->id}}">
                                            <button type="submit" class="dropdown-item">
                                                Деактивировать
                                                &nbsp;
                                                <i class="fa fa-power-off"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('stuff.activate') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="stuff_id" value="{{$stuff->id}}">
                                            <button type="submit" class="dropdown-item">
                                                Активировать
                                                &nbsp;
                                                <i class="fa fa-power-off"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('stuff.destroy', $stuff->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item">
                                            Удалить
                                            &nbsp;
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                    <a class="dropdown-item" href="{{route('stuff.edit', ['stuff' => $stuff])}}">
                                        Редактировать
                                        &nbsp;
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a type="button" id="open_change_password" class="dropdown-item"
                                       data-user_id="{{$stuff->id}}">
                                        Изменить пароль
                                        &nbsp;
                                        <i class="fa fa-key"></i>
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
            <div class="float-right">
                {{ $stuffs->links() }}
            </div>
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
                {!! Form::open(['route' => 'stuff.password.change', 'method' => 'post']); !!}
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


    </script>
@stop
