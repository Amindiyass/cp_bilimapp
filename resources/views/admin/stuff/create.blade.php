<?php

use App\User;
use Spatie\Permission\Models\Role;

$roles = Role::where('id', '!=', User::ROLE_STUDENT)->pluck('name', 'id')->toArray();
?>
@extends('adminlte::page')

@section('title', 'Добавить сотрудника')

@section('content_header')
    <h1 class="m-0 text-dark">Добавить сотрудника</h1>
@stop

@section('content')
    <div class="card card-danger">
        {!! Form::open(['route' => 'stuff.store','method' => 'POST']) !!}
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label>Имя *</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-user"></i></span>
                    </div>
                    <input name="name" type="text" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label>Email *</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input name="email" type="text" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label>Выберите роль *</label>
                {!! Form::select('role_id',$roles, null,
                    [
                        'class' => 'form-control select2bs4',
                         'id' => 'role_id',
                         'style' => 'width: 100%;',
                         'placeholder' => 'Выберите роль ...',
                         ]); !!}
            </div>

            <div class="form-group">
                <label>Пароль *</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input name="password" type="password" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label>Подтверждение пароля *</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input name="password_confirmation" type="password" class="form-control">
                </div>
            </div>

            <button type="submit" class="btn btn-success float-right">
                Добавить
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
