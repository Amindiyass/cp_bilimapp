<?php

use App\User;
use Spatie\Permission\Models\Role;

$roles = Role::where('id', '!=', User::ROLE_STUDENT)->pluck('name', 'id')->toArray();
?>
@extends('adminlte::page')

@section('title', 'Изменить сотрудника')

@section('content_header')
    <h1 class="m-0 text-dark">Изменить сотрудника</h1>
@stop

@section('content')
    <div class="card card-danger">
        <form action="{{route('stuff.update', $stuff->id)}}" method="POST">
            @method('PUT')
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Имя *</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-user"></i></span>
                        </div>
                        <input value="{{$stuff->name}}" name="name" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label>Email *</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        <input value="{{$stuff->email}}" name="email" type="text" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label>Выберите роль *</label>
                    {!! Form::select('role_id',$roles, $stuff->roles->pluck('id')[0],
                        [
                            'class' => 'form-control select2bs4',
                             'id' => 'role_id',
                             'style' => 'width: 100%;',
                             'placeholder' => 'Выберите роль ...',
                             ]); !!}
                </div>

                <button type="submit" class="btn btn-success float-right">
                    Изменить
                </button>
            </div>
        </form>
    </div>
@stop
@section('plugins.inputmask', true)
@section('js')
    <script>
        $('[data-mask]').inputmask();

    </script>
@endsection
