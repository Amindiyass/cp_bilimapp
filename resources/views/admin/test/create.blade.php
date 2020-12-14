@extends('adminlte::page')

@section('title', 'Добавить тест')

@section('content_header')
    <h1 class="m-0 text-dark">Добавить тест</h1>
@stop

@section('content')
    <div class="card card-danger">
        {!! Form::open(['route' => 'test.store','method' => 'POST']) !!}
        @csrf
        <div class="card-body">

            {{--            @include('admin.test.question_textarea')--}}

            <div class="form-group">
                <label>Название на казахском *</label>
                <div class="input-group">
                    <input name="name_kz" type="text" class="form-control">
                </div>

            </div>
            <div class="form-group">
                <label>Название на русском *</label>
                <div class="input-group">
                    <input name="name_ru" type="text" class="form-control">
                </div>
            </div>


            <div class="form-group">
                <label>Выберите курс *</label>
                {!! Form::select('course_id',$courses, null,
                    [
                         'class' => 'form-control select2bs4',
                         'id' => 'course_id',
                         'style' => 'width: 100%;',
                         'placeholder' => 'Выберите курс ...',
                         ]); !!}
            </div>

            <div class="form-group">
                <label>Выберите тему *</label>
                {!! Form::select('section_id',[], null,
                    [
                         'class' => 'form-control select2bs4',
                         'id' => 'section_id',
                         'disabled' => true,
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
                    <input name="order_number" type="text" class="form-control">
                </div>
            </div>

            <div class="btn btn-group float-right">
                <button type="button" class="btn btn-primary d-none" id="open_add_variants_modal">
                    Добавить вопрос
                </button>
                <button type="submit" class="btn btn-success">
                    Добавить
                </button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="modal fade" id="addVariants" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog" style="max-width: 800px;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Добавить варианты теста</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['route' => 'student.password.change', 'method' => 'post']); !!}
                <div class="modal-body">
                    @csrf
                    {!! Form::hidden('user_id') !!}

                    <label for="password">
                        Ответ на казахском *
                    </label>
                    {!! Form::textarea('variant_in_kz',null , ['class' => 'form-control', 'rows' => 5]); !!}

                    <label for="password">
                        Ответ на русском *
                    </label>
                    {!! Form::textarea('variant_in_ru', null,['class' => 'form-control', 'rows' => 5]); !!}


                    <label for="is_right">
                        Правильный ответ &emsp;
                    </label>
                    {!! Form::checkbox('is_right', true, true); !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Добавить вариант</button>
                </div>
                {!! Form::close(); !!}
            </div>
        </div>
    </div>

    <div class="card d-none">
        <div class="card-header">
            Варианты
        </div>
        <div class="card-body">
            <table style="" id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID-номер</th>
                    <th>Ответ</th>
                    <th>Дата создание</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@stop
@section('js')
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async
            src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js">
    </script>
    <script>

        $("#course_id").change(function () {
            var type = 'get_sections';
            var item_id = $(this).val();
            ajax(item_id, type);
        });

        $('#open_add_variants_modal').click(function () {
            $('#addVariants').modal();
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
