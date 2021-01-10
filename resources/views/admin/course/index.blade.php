@extends('adminlte::page')

@section('title', 'Список курсов')

@section('content_header')
    <h1 class="m-0 text-dark">Список курсов</h1>
@stop

@section('content')
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
                @foreach($courses as $course)
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
            <div class="mt-3">
                {{ $courses->links() }}
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
        });
@stop
