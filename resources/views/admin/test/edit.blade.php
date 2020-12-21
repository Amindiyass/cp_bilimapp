@extends('adminlte::page')

@section('title', 'Редактировать тест')

@section('content_header')
    <h1 class="m-0 text-dark">Редактировать тест</h1>
@stop

@section('content')
    <div class="card card-danger">
        <form action="{{ route('test.update', $test->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">

                {{--            @include('admin.test.question_textarea')--}}

                <div class="form-group">
                    <label>Название на казахском *</label>
                    <div class="input-group">
                        <input name="name_kz" value="{{$test->name_kz}}" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label>Название на русском *</label>
                    <div class="input-group">
                        <input name="name_ru" value="{{$test->name_ru}}" type="text" class="form-control">
                    </div>
                </div>


                <div class="form-group">
                    <label>Выберите курс *</label>
                    {!! Form::select('course_id',$courses,$test->section->course->id,
                        [
                             'class' => 'form-control select2bs4',
                             'id' => 'course_id',
                             'style' => 'width: 100%;',
                             'placeholder' => 'Выберите курс ...',
                             ]); !!}
                </div>

                <div class="form-group">
                    <label>Выберите тему *</label>
                    {!! Form::select('section_id',$sections, $test->section->id,
                        [
                             'class' => 'form-control select2bs4',
                             'id' => 'section_id',
                             'disabled' => false,
                             'style' => 'width: 100%;',
                             'placeholder' => 'Выберите тему ...',
                        ]); !!}
                </div>

                <div class="form-group">
                    <label>Порядковый номер *</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-sort"></i></span>
                        </div>
                        <input value="{{$test->order_number}}" name="order_number" type="text" class="form-control">
                    </div>
                </div>

                <div class="btn btn-group float-right">
                    <button type="button" class="btn btn-primary" id="open_add_questions_modal">
                        Добавить вопрос
                    </button>
                    <button type="submit" class="btn btn-success">
                        Изменить
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="card">
        <div class="card-header">
            Вопросы
        </div>
        <div class="card-body">
            <table style="" id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID-номер</th>
                    <th>Вопрос</th>
                    <th>Кол-во вариантов</th>
                    <th>Кол-во правильных ответов</th>
                    <th>Дата создание</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($questions as $question)
                    <tr>
                        <td>{{$question->id}}</td>
                        <td>{{$question->body_ru}}</td>
                        <td>{{count($question->variants)}}</td>
                        <td>{{$question->right_variants()}}</td>
                        <td>{{date('Y-m-d H:i:s',strtotime($question->created_at))}}</td>
                        <td>
                            <div class="btn-group" style="position: relative;">
                                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    Действие
                                </button>
                                <div class="dropdown-menu" style="position: absolute;">
                                    <a href="{{route('question.edit', ['question' => $question->id])}}"
                                       class="dropdown-item"
                                       data-user_id="{{$question->id}}">
                                        Редактировать
                                        &nbsp;
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('question.destroy', $question->id) }}" method="POST">
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
            </table>
        </div>
    </div>

    {{--    modals  --}}

    <div class="modal fade" id="addQuestions" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog" style="max-width: 800px;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Добавить вопросы теста</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['route' => 'question.add', 'method' => 'post']); !!}
                <div class="modal-body">
                    @csrf
                    {!! Form::hidden('test_id', $test->id) !!}

                    <label for="password">
                        Вопрос на казахском *
                    </label>
                    {!! Form::textarea('body_kz',null , ['class' => 'form-control', 'rows' => 5]); !!}

                    <label for="password">
                        Вопрос на русском *
                    </label>
                    {!! Form::textarea('body_ru', null,['class' => 'form-control', 'rows' => 5]); !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Добавить вариант</button>
                </div>
                {!! Form::close(); !!}
            </div>
        </div>
    </div>


@stop
@section('js')
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async
            src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js">
    </script>
    <script>

        $("#course_id").click(function () {
            var type = 'get_sections';
            var item_id = $(this).val();
            ajax(item_id, type);
        });

        $('#open_add_questions_modal').click(function () {
            $('#addQuestions').modal();
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
                url: '/admin/tests/ajax',
                data: {type: type, item_id: item_id},
                success: function (data) {
                    append_items(data, 'section_id');
                }
            });
        }

        function append_items(data, type) {
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
    </script>
@endsection
