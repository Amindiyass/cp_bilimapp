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
            <div id="questions_container">
            <div class="form-group questions" id="0">
                <div class="row">
                    <div class="col-md-5">
                        <label for="password">
                            Вопрос на казахском *
                        </label>
                        {!! Form::textarea('question_in_kz[0]',null , ['class' => 'form-control editor question_kz', 'rows' => 5]); !!}
                    </div>
                    <div class="col-md-5">
                        <label for="password">
                            Вопрос на русском *
                        </label>
                        {!! Form::textarea('question_in_ru[0]',null , ['class' => 'form-control editor question_ru', 'rows' => 5]); !!}
                    </div>
                </div>
                <div class="row" id="0">
                    <div class="col-md-5">
                        <label for="password">
                            Вариант на казахском *
                        </label>
                        {!! Form::textarea('variant_in_kz[0][0]',null , ['class' => 'form-control editor kz', 'rows' => 5]); !!}
                    </div>
                    <div class="col-md-5">
                        <label for="password">
                            Вариант на русском *
                        </label>
                        {!! Form::textarea('variant_in_ru[0][0]',null , ['class' => 'form-control editor ru', 'rows' => 5]); !!}
                    </div>
                    <div class="col-md-2 mt-4">
                        <input class="form-check-input" type="checkbox" name="variant[0][]">
                        <label class="form-check-label">Правильный ответ</label>
                        <button class="btn btn-primary" type="button" onclick="addVariant(this)">Добавить еще вариант</button>
                    </div>
                </div>
            </div>
            </div>
            <div class="btn btn-group float-right">
                <button type="button" class="btn btn-primary" onclick="addQuestion()">
                    Добавить вопрос
                </button>
                <button type="submit" class="btn btn-success">
                    Добавить
                </button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@stop
@section('js')
{{--    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>--}}
{{--    <script id="MathJax-script" src="https://cdn.jsdelivr.net/npm/mathjax@3.0.1/es5/tex-mml-chtml.js"></script>--}}
{{--    <script type="text/javascript" id="MathJax-script-s"--}}
{{--            src="https://cdn.jsdelivr.net/npm/mathjax@3.0.0/es5/tex-chtml.js">--}}
{{--        </script>--}}
    <script src="/ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replaceAll( 'editor' );
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

        let template = $('.questions').clone();
        function addQuestion()
        {
            let newId = parseInt(template.first().attr('id'))+1;
            template.first().attr('id', newId);
            template.find('.question_kz').attr('name', 'question_in_kz['+newId+']')
            template.find('.question_ru').attr('name', 'question_in_ru['+newId+']')
            template.find('.cke').remove()
            $('#questions_container').append(template);
            CKEDITOR.replaceAll( 'editor' );
        }

        function addVariant(context)
        {
            let questionId = $(context).parent().parent().parent().attr('id');
            let container = $(context).parent().parent().clone();
            let newId = parseInt(container.attr('id'))+1;
            container.attr('id', newId);
            console.log(container);
            container.find('.kz').attr('name', 'variant_in_kz['+questionId+']['+newId+']')
            container.find('.ru').attr('name', 'variant_in_ru['+questionId+']['+newId+']')
            container.find('.form-check-input').attr('name', 'variant['+questionId+']['+newId+']')
            container.find('.cke').remove()
            $(context).parent().parent().parent().append(container)
            CKEDITOR.replaceAll( 'editor' );
        }
    </script>
@endsection
