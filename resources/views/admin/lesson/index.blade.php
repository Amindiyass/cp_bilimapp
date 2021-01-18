@extends('adminlte::page')

@section('title', 'Список уроков')

@section('content_header')
    <h1 class="m-0 text-dark">Список уроков</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{route('lesson.create')}}" class="btn btn-success">Добавить урок</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body" style="overflow-x: auto;white-space: nowrap;">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID-номер</th>
                    <th>Название на казахском</th>
                    <th>Название на русском</th>
                    <th>Кол-во разделов</th>
                    <th>Дата создание</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($lessons as $lesson)
                    <tr>
                        <td>{{$lesson->id}}</td>
                        <td>{{$lesson->name_kz}}</td>
                        <td>{{$lesson->name_ru}}</td>
                        <td>{{$lesson->section_count}}</td>
                        <td> {{date('Y-m-d H:i:s',strtotime($lesson->created_at))}}</td>
                        <td>
                            <div class="btn-group" style="position: relative;">
                                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    Действие
                                </button>
                                <div class="dropdown-menu" style="position: absolute;">
                                    <a href="{{route('lesson.edit', ['lesson' => $lesson->id])}}" class="dropdown-item"
                                       data-user_id="{{$lesson->id}}">
                                        Редактировать
                                        &nbsp;
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('lesson.destroy', $lesson->id) }}" method="POST">
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
            <div class="float-right">
                {{ $lessons->links() }}
            </div>
        </div>

    </div>
@stop
@section('plugins.Datatables', true)
@section('plugins.Select2', true)
@section('js')
    <script>
        $('.select2').select2()

        $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false,
            'paging': false,
        });
    </script>
@stop
