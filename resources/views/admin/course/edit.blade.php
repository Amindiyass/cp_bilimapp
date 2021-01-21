<?php
$languages = \App\Models\Language::all()->pluck('name_ru', 'id')->toArray();
$classes = \App\Models\EducationLevel::orderBy('order_number')->pluck('order_number', 'id')->toArray();
$subjects = \App\Models\Subject::all()->pluck('name_ru', 'id')->toArray();

?>
@extends('adminlte::page')

@section('title', 'Изменить курс')

@section('content_header')
    <h1 class="m-0 text-dark">Изменить курс</h1>
@stop

@section('content')
    <div class="card card-danger">
        <form action="{{route('course.update', ['course' => $course->id])}}" method="POST">
            @method('PUT')
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Название на казахском *</label>
                    <div class="input-group">
                        <input value="{{$course->name_kz}}" name="name_kz" type="text" class="form-control">
                    </div>

                </div>
                <div class="form-group">
                    <label>Название на русском *</label>
                    <div class="input-group">
                        <input value="{{$course->name_ru}}" name="name_ru" type="text" class="form-control">
                    </div>
                </div>


                <div class="form-group">
                    <label>Выберите язык *</label>
                    {!! Form::select('language_id',$languages, $course->language ?
                        $course->language->id : null,
                        [
                             'class' => 'form-control select2bs4',
                             'id' => 'language_id',
                             'style' => 'width: 100%;',
                             'placeholder' => 'Выберите язык ...',
                             ]); !!}
                </div>

                <div class="form-group">
                    <label>Выберите класс *</label>
                    {!! Form::select('class_id',$classes, $course->class->id,
                        [
                             'class' => 'form-control select2bs4',
                             'id' => 'class_id',
                             'style' => 'width: 100%;',
                             'placeholder' => 'Выберите класс ...',
                             ]); !!}
                </div>

                <div class="form-group">
                    <label>Выберите предмет *</label>
                    {!! Form::select('subject_id',$subjects, $course->subject->id,
                        [
                             'class' => 'form-control select2bs4',
                             'id' => 'subject_id',
                             'style' => 'width: 100%;',
                             'placeholder' => 'Выберите предмет ...',
                             ]); !!}
                </div>

                <div class="form-group">
                    <label for="">Описание на русском *</label>
                    <textarea class="form-control" name="description_ru" cols="30" rows="5">
                        {{$course->description_ru}}
                </textarea>
                </div>

                <div class="form-group">
                    <label for="">Описание на казахском *</label>
                    <textarea class="form-control" name="description_kz" cols="30" rows="5">
                        {{$course->description_kz}}
                </textarea>
                </div>

                <div class="form-group">
                    <label>Приоритет *</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-sort"></i></span>
                        </div>
                        <input name="order" value="{{$course->order}}" type="text" class="form-control">
                    </div>
                </div>
            </div>
            <div class="card-header">
                <h2><i class="fa fa-paragraph"></i> Темы</h2>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="dynamicTable">
                    <tr>
                        <th>Названание на казахском *</th>
                        <th>Названание на русском *</th>
                        <th>Сортировочный номер *</th>
                        <th>Действие</th>
                    </tr>
                    <?php $counter = 0; ?>
                    @foreach((isset($course->sections) ? $course->sections : []) as $key => $section)

                        <tr>
                            <td><input value="{{$section->name_kz}}" type="text" name="addmore[{{$counter}}][name_kz]"
                                       placeholder="Названание на казахском "
                                       class="form-control"/></td>
                            <td><input value="{{$section->name_ru}}" type="text" name="addmore[{{$counter}}][name_ru]"
                                       placeholder="Названание на русском"
                                       class="form-control"/></td>
                            <td><input value="{{$section->sort_number}}" type="number"
                                       name="addmore[{{$counter}}][sort_number]"
                                       placeholder="Сортировочный номер"
                                       class="form-control"/>
                                <input value="{{$section->id}}" type="hidden" name="addmore[{{$counter}}][section_id]"/>
                            </td>
                            <?php $counter++; ?>
                            @if($counter ==1)
                                <td>
                                    <button type="button" name="add" id="add" class="btn btn-success">Добавить больше
                                    </button>
                                </td>
                            @else
                                <td>
                                    <button type="button" class="btn btn-danger remove-tr">Удалить</button>
                                </td>
                            @endif
                        </tr>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="btn btn-group float-right">
                <button type="submit" class="btn btn-success">
                    Изменить
                </button>
            </div>
        </form>
    </div>
@stop
@section('js')
    <script>
        var i = 0;

        $("#add").click(function () {
            ++i;
            $("#dynamicTable").append('<tr><td><input type="text" name="addmore[' + i + '][name_kz]" placeholder="Названание на казахском" class="form-control" /></td><td><input type="text" name="addmore[' + i + '][name_ru]" placeholder="Названание на русском" class="form-control" /></td><td><input type="number" name="addmore[' + i + '][sort_number]" placeholder="Сортировочный номер" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr">Удалить</button></td></tr>');
        });

        $(document).on('click', '.remove-tr', function () {
            $(this).parents('tr').remove();
        });
    </script>
@endsection
