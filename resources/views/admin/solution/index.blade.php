@extends('adminlte::page')

@section('title', 'Список решении')

@section('content_header')
    <h1 class="m-0 text-dark">Список предметов</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{route('solution.create')}}" class="btn btn-success">Добавить решение</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body" style="overflow-x: auto;white-space: nowrap;">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Название курса</th>
                </tr>
                </thead>
                <tbody>
                @foreach($solutions as $solution)
                    <tr>
                        <td>{{ $solution->course->name_ru }}</td>
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
