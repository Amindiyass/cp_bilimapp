@extends('adminlte::page')

@section('title', 'Редактировать ученика')

@section('content_header')
    <h1 class="m-0 text-dark">Редактировать ученика</h1>
@stop

@section('content')
    <div class="card card-danger">
        {!! Form::open(['url' => 'admin/student/' . $user->id,'method' => 'POST']) !!}
        @csrf
        @method('PUT')
        <div class="card-body">
            <input type="hidden" value="{{$user->id}}" name="user_id">
            <div class="form-group">
                <label>Имя *</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-user"></i></span>
                    </div>
                    <input name="first_name" type="text" class="form-control" value="{{$user->student->first_name}}">
                </div>
            </div>
            <div class="form-group">
                <label>Фамилия *</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-user"></i></span>
                    </div>
                    <input name="last_name" type="text" class="form-control" value="{{$user->student->last_name}}">
                </div>
            </div>
            <div class="form-group">
                <label>Номер телефона *</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input name="phone" type="text" class="form-control" data-inputmask='"mask": "+7 (999) 999-9999"'
                           data-mask value="{{$user->phone}}">
                </div>
            </div>

            <div class="form-group">
                <label>Email *</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input name="email" type="text" class="form-control" value="{{$user->email}}">
                </div>
            </div>

            <div class="form-group">
                <label>Выберите область *</label>
                {!! Form::select('area_id',$areas, $user->student->area_id,
                    [
                        'class' => 'form-control select2bs4',
                         'id' => 'area_id',
                         'style' => 'width: 100%;',
                         'placeholder' => 'Выберите область ...',
                         ]); !!}
            </div>

            <div id="region_div" class="form-group">
                <label>Выберите регион *</label>
                {!! Form::select('region_id',$regions,$user->student->region_id ,
                    ['class' => 'form-control select2bs4 ',
                    'id' => 'region_id',
                    'style' => 'width: 100%;',
                    ]); !!}
            </div>

            <div id="school_div" class="form-group">
                <label>Выберите школу *</label>
                {!! Form::select('school_id',$schools, $user->student->school_id,
                    ['class' => 'form-control select2bs4 ',
                    'id' =>'school_id',
                    'style' => 'width: 100%;']); !!}
            </div>

            <div id="class_div" class="form-group">
                <label>Выберите класс обучение *</label>
                {!! Form::select('class_id',$classes, $user->student->class_id,
                    ['class' => 'form-control select2bs4 ', 'style' => 'width: 100%;']); !!}
            </div>

            <div id="language_div" class="form-group">
                <label>Выберите язык обучение *</label>
                {!! Form::select('language_id',$languages, $user->student->language_id,
                    ['class' => 'form-control select2bs4 ', 'style' => 'width: 100%;']); !!}
            </div>

            <div class="form-group">
                <label>Выберите подписку</label>
                {!! Form::select('subscription_id',$subscriptions, null,
                    ['class' => 'form-control select2bs4 ',
                     'style' => 'width: 100%;']); !!}
            </div>
            <button type="submit" class="btn btn-success float-right">
                Изменить
            </button>
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
            console.log(item_id);

            $.ajax({
                method: 'POST',
                url: '/admin/students/ajax',
                data: {type: type, item_id: item_id},
                success: function (data) {
                    append_items(data, type);
                }
            });
        }

        function append_items(data, type) {
            type = type === 'get_regions' ? 'region_id' : 'school_id';
            console.log(type);
            var place_holder_text;
            if (type === 'region_id') {
                $('#region_div').removeClass('d-none');
                place_holder_text = 'Выберите регион ...';
            }
            if (type === 'school_id') {
                $('#school_div').removeClass('d-none');
                place_holder_text = 'Выберите школу ...';
            }


            $('#' + type).find('option')
                .remove()
                .end();


            $('#' + type)
                .append($("<option></option>")
                    .attr("placeholder", null)
                    .text(place_holder_text));

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
