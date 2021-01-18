@extends('adminlte::page')

@section('title', 'Список предметов')

@section('content_header')
    <h1 class="m-0 text-dark">Список предметов</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{route('subject.create')}}" class="btn btn-success">Добавить предмет</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body" style="overflow-x: auto;white-space: nowrap;">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID-номер</th>
                    <th>Название на казахском</th>
                    <th>Название на русском</th>
                    <th>Дата создание</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($subjects as $subject)
                    <tr>
                        <td>{{$subject->id}}</td>
                        <td>{{$subject->name_kz}}</td>
                        <td>{{$subject->name_ru}}</td>
                        <td> {{date('Y-m-d H:i:s',strtotime($subject->created_at))}}</td>
                        <td>
                            <div class="btn-group" style="position: relative;">
                                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    Действие
                                </button>
                                <div class="dropdown-menu" style="position: absolute;">
                                    <a href="{{route('subject.edit', $subject->id)}}"
                                       class="dropdown-item">
                                        Редактировать
                                        &nbsp;
                                        <i class=" fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('subject.destroy', $subject->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item">
                                            Деактивировать
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
@section('plugins.Datatables', true)
@section('plugins.Select2', true)
@section('js')
    <script>
        $('.select2').select2()

        $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
    </script>
@stop
