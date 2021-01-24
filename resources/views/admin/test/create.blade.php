@extends('adminlte::page')

@section('title', 'Добавить тест')

@section('content_header')
    <h1 class="m-0 text-dark">Добавить тест</h1>
@stop

@section('content')
    <div class="card card-danger">
        <div id="app">
            <create-test-component courses-json="{{ json_encode($courses) }}"></create-test-component>
        </div>
{{--        {!! Form::open(['route' => 'test.store','method' => 'POST', 'files' => true]) !!}--}}
{{--        @csrf--}}
{{--        <div class="card-body">--}}

{{--            --}}{{--            @include('admin.test.question_textarea')--}}

{{--            <div class="form-group">--}}
{{--                <label>Название на казахском *</label>--}}
{{--                <div class="input-group">--}}
{{--                    <input name="name_kz" type="text" class="form-control">--}}
{{--                </div>--}}

{{--            </div>--}}
{{--            <div class="form-group">--}}
{{--                <label>Название на русском *</label>--}}
{{--                <div class="input-group">--}}
{{--                    <input name="name_ru" type="text" class="form-control">--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="form-group">--}}
{{--                <label>Выберите курс *</label>--}}
{{--                {!! Form::select('course_id',$courses, null,--}}
{{--                    [--}}
{{--                         'class' => 'form-control select2bs4',--}}
{{--                         'id' => 'course_id',--}}
{{--                         'style' => 'width: 100%;',--}}
{{--                         'placeholder' => 'Выберите курс ...',--}}
{{--                         ]); !!}--}}
{{--            </div>--}}

{{--            <div class="form-group">--}}
{{--                <label>Выберите тему *</label>--}}
{{--                {!! Form::select('section_id',[], null,--}}
{{--                    [--}}
{{--                         'class' => 'form-control select2bs4',--}}
{{--                         'id' => 'section_id',--}}
{{--                         'disabled' => true,--}}
{{--                         'style' => 'width: 100%;',--}}
{{--                         'placeholder' => 'Выберите тему ...',--}}
{{--                    ]); !!}--}}
{{--            </div>--}}

{{--            <div class="form-group">--}}
{{--                <label>Выберите урок *</label>--}}
{{--                {!! Form::select('lesson_id', [], null,--}}
{{--                    [--}}
{{--                         'class' => 'form-control select2bs4',--}}
{{--                         'id' => 'lesson_id',--}}
{{--                         'style' => 'width: 100%;',--}}
{{--                         'disabled' => true,--}}
{{--                         'placeholder' => 'Выберите урок ...',--}}
{{--                         ]); !!}--}}
{{--            </div>--}}

{{--            <div class="form-group">--}}
{{--                <label>Порядковый номер *</label>--}}
{{--                <div class="input-group">--}}
{{--                    <div class="input-group-prepend">--}}
{{--                        <span class="input-group-text"><i class="fa fa-sort"></i></span>--}}
{{--                    </div>--}}
{{--                    <input name="order_number" type="text" class="form-control" value="1">--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div id="questions_container">--}}
{{--                <div class="form-group questions" id="0">--}}
{{--                    <h4>Вопрос #<span id="question_number">1</span></h4>--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-5">--}}
{{--                            <label for="password">--}}
{{--                                Вопрос на казахском *--}}
{{--                            </label>--}}
{{--                            {!! Form::textarea('question_in_kz[0]',null , ['class' => 'form-control editor question_kz', 'rows' => 5]); !!}--}}
{{--                        </div>--}}
{{--                        <div class="col-md-5">--}}
{{--                            <label for="password">--}}
{{--                                Вопрос на русском *--}}
{{--                            </label>--}}
{{--                            {!! Form::textarea('question_in_ru[0]',null , ['class' => 'form-control editor question_ru', 'rows' => 5]); !!}--}}
{{--                        </div>--}}
{{--                        <div class="col-md-2">--}}
{{--                            <label>--}}
{{--                                Фото--}}
{{--                            </label>--}}
{{--                            {!! Form::file('photos[0]', ['class' => 'photo']) !!}--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="row" id="0">--}}
{{--                        <div class="col-md-5">--}}
{{--                            <label for="password">--}}
{{--                                Вариант на казахском *--}}
{{--                            </label>--}}
{{--                            {!! Form::textarea('variant_in_kz[0][0]',null , ['class' => 'form-control editor kz', 'rows' => 5]); !!}--}}
{{--                        </div>--}}
{{--                        <div class="col-md-5">--}}
{{--                            <label for="password">--}}
{{--                                Вариант на русском *--}}
{{--                            </label>--}}
{{--                            {!! Form::textarea('variant_in_ru[0][0]',null , ['class' => 'form-control editor ru', 'rows' => 5]); !!}--}}
{{--                        </div>--}}
{{--                        <div class="col-md-2 mt-4 p-4">--}}
{{--                            <label class="">--}}
{{--                                <input class="" type="checkbox" name="variant[0][]"> Правильный ответ--}}
{{--                            </label>--}}
{{--                            <button class="btn btn-primary" type="button" onclick="addVariant(this)">Добавить еще--}}
{{--                                вариант--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <hr/>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="btn btn-group float-right">--}}
{{--                <button type="button" class="btn btn-primary" onclick="addQuestion()">--}}
{{--                    Добавить вопрос--}}
{{--                </button>--}}
{{--                <button type="submit" class="btn btn-success">--}}
{{--                    Добавить--}}
{{--                </button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        {!! Form::close() !!}--}}
    </div>
@stop
@section('js')
    <script src="{{ mix('/js/app.js') }}"></script>
    {{--    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>--}}
    {{--    <script id="MathJax-script" src="https://cdn.jsdelivr.net/npm/mathjax@3.0.1/es5/tex-mml-chtml.js"></script>--}}
    {{--    <script type="text/javascript" id="MathJax-script-s"--}}
    {{--            src="https://cdn.jsdelivr.net/npm/mathjax@3.0.0/es5/tex-chtml.js">--}}
    {{--        </script>--}}
    {{--    <script src="/ckeditor/ckeditor.js"></script>--}}
    <script>
        // CKEDITOR.replaceAll( 'editor' );
        // $("#course_id").change(function () {
        //     var type = 'get_sections';
        //     var item_id = $(this).val();
        //     ajax(item_id, type, 'section_id');
        // });
        // $('#section_id').change(function () {
        //     var type = 'get_lessons';
        //     var item_id = $(this).val();
        //     ajax(item_id, type, 'lesson_id');
        // });
        //
        // $('#open_add_variants_modal').click(function () {
        //     $('#addVariants').modal();
        // });
        //
        // function ajax(item_id, type, container) {
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //     console.log(item_id);
        //
        //     $.ajax({
        //         method: 'POST',
        //         url: '/admin/tests/ajax',
        //         data: {type: type, item_id: item_id},
        //         success: function (data) {
        //             append_items(data, container);
        //         }
        //     });
        // }
        //
        // function append_items(data, type) {
        //     $('#' + type).prop('disabled', false);
        //     $('#' + type).find('option')
        //         .remove()
        //         .end();
        //     $('#' + type).append('<option value="" disabled selected>Выберите</option>')
        //
        //     $.each(data, function (index, value) {
        //         length = Object.keys(data).length;
        //         $('#' + type)
        //             .append($("<option></option>")
        //                 .attr("value", index)
        //                 .text(value));
        //     });
        // }
        // let templateHtml = $('#questions_container').html();
        //
        // function addQuestion() {
        //     //let template = $('.questions:last-child').clone();
        //     let template = $(templateHtml)
        //     let newId = $('.questions').length;
        //     template.find('input').val('')
        //     template.find('textarea').val('')
        //     template.first().attr('id', newId);
        //     template.find('.questions').attr('id', newId)
        //     template.find('.question_kz').attr('name', 'question_in_kz[' + newId + ']')
        //     template.find('.question_ru').attr('name', 'question_in_ru[' + newId + ']')
        //     template.find('.photo').attr('name', 'photos['+newId+']')
        //     template.find('[type=checkbox]').attr('name', 'variant[' + newId + '][0]')
        //     template.find('.kz').attr('name', 'variant_in_kz[' + newId + '][0]')
        //     template.find('.ru').attr('name', 'variant_in_ru[' + newId + '][0]')
        //     template.find('.cke').remove()
        //     template.find('#question_number').text(newId+1)
        //     $('#questions_container').append(template);
        //     // CKEDITOR.replaceAll( 'editor' );
        // }
        //
        // function addVariant(context) {
        //     let questionId = $(context).parent().parent().parent().attr('id');
        //     let container = $(context).parent().parent().clone();
        //     let newId = parseInt(container.attr('id')) + 1;
        //     container.attr('id', newId);
        //     container.find('.kz').attr('name', 'variant_in_kz[' + questionId + '][' + newId + ']')
        //     container.find('.ru').attr('name', 'variant_in_ru[' + questionId + '][' + newId + ']')
        //     container.find('[type=checkbox]').attr('name', 'variant[' + questionId + '][' + newId + ']')
        //     container.find('.cke').remove()
        //     $(context).parent().parent().parent().append(container)
        //     // CKEDITOR.replaceAll( 'editor' );
        // }
    </script>
@endsection
