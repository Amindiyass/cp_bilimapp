@extends('adminlte::page')

@section('title', 'Добавить ученика')

@section('content_header')
    <h1 class="m-0 text-dark">Добавить ученика</h1>
@stop

@section('content')
    <div class="card card-danger">
        {!! Form::open(['route' => 'student.store']) !!}
        <div class="card-body">
            <div class="form-group">
                <label>Имя *</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-user"></i></span>
                    </div>
                    <input name="first_name" type="text" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label>Фамилия *</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-user"></i></span>
                    </div>
                    <input name="second_name" type="text" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label>Номер телефона *</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input name="phone" type="text" class="form-control" data-inputmask='"mask": "+7 (999) 999-9999"'
                           data-mask>
                </div>
            </div>

            <div class="form-group">
                <label>Выберите область *</label>
                {!! Form::select('area_id',$areas, null,
                    [
                        'class' => 'form-control select2bs4',
                         'id' => 'area_id',
                         'style' => 'width: 100%;',
                         'placeholder' => 'Выберите область ...',
                         ]); !!}
            </div>

            <div id="region_div" class="form-group d-none">
                <label>Выберите регион *</label>
                {!! Form::select('region_id',[], null,
                    ['class' => 'form-control select2bs4 ',
                    'id' => 'region_id',
                    'style' => 'width: 100%;',
                    ]); !!}
            </div>

            <div id="school_div" class="form-group d-none">
                <label>Выберите школу *</label>
                {!! Form::select('school_id',[], null,
                    ['class' => 'form-control select2bs4 ',
                    'id' =>'school_id',
                    'style' => 'width: 100%;']); !!}
            </div>

            <div id="class_div" class="form-group">
                <label>Выберите класс обучение *</label>
                {!! Form::select('class_id',$classes, null,
                    ['class' => 'form-control select2bs4 ', 'style' => 'width: 100%;']); !!}
            </div>

            <div id="language_div" class="form-group">
                <label>Выберите язык обучение *</label>
                {!! Form::select('language_id',$languages, null,
                    ['class' => 'form-control select2bs4 ', 'style' => 'width: 100%;']); !!}
            </div>

            <div class="form-group">
                <label>Выберите подписку</label>
                {!! Form::select('subscription_id',$subscriptions, null,
                    ['class' => 'form-control select2bs4 ',
                     'style' => 'width: 100%;']); !!}
            </div>
        </div>


        {!! Form::close() !!}
    </div>
@stop
@section('plugins.inputmask', true)
@section('js')
    <script>
        $('[data-mask]').inputmask();

        $('#area_id').change(function () {
            var type = 'get_regions';
            var item_id = $(this).val();
            ajax(item_id, type);
        });

        $('#region_id').change(function () {
            var type = 'get_schools';
            var item_id = $(this).val();
            ajax(item_id, type);
        });


        function ajax(item_id, type) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: 'POST',
                url: '/admin/student/ajax',
                data: {type: type, item_id: item_id},
                success: function (data) {
                    append_items(data, type);
                }
            });
        }

        function append_items(data, type) {
            type = type === 'get_regions' ? 'region_id' : 'school_id';
            console.log(type);
            if (type === 'region_id') {
                $('#region_div').removeClass('d-none');
            }
            if (type === 'school_id') {
                $('#school_div').removeClass('d-none');
            }


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
