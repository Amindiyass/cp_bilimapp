@extends('adminlte::page')

@section('title', 'Редактировать ученика')

@section('content_header')
    <h1 class="m-0 text-dark">Редактировать вопрос</h1>
@stop

@section('content')
    <div class="card card-danger">
        <form action="{{ route('question.update', $question->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label>Вопрос на казахском *</label>
                    <div class="input-group">
                        <textarea
                            style="{display:block;}"
                            name="body_kz"
                            type="text"
                            class="form-control"
                            rows="6">
                            {{$question->body_kz}}
                        </textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label>Вопрос на русском *</label>
                    <div class="input-group">
                        <textarea name="body_ru"
                                  type="text"
                                  class="form-control"
                                  rows="6">
                            {{$question->body_ru}}
                        </textarea>
                    </div>
                </div>
                <div class="btn btn-group float-right">
                    <button type="button" id="open_modal_add_variants" class="btn btn-success">
                        Добавить варианты
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Изменить
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-header">
            Варианты
        </div>
        <div class="card-body">
            <table style="" id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID-номер</th>
                    <th>Вариант</th>
                    <th>Правильный ответ</th>
                    <th>Дата создание</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($variants as $variant)
                    <tr>
                        <td>{{$variant->id}}</td>
                        <td>{{$variant->variant_in_ru}}</td>
                        <td>
                            @if($variant->is_right())
                                <span class="badge badge-success">
                                    Да
                                </span>
                            @else
                                <span class="badge badge-danger">
                                    Нет
                                </span>
                            @endif
                        </td>
                        <td>{{date('Y-m-d H:i:s',strtotime($variant->created_at))}}</td>
                        <td>
                            <div class="btn-group" style="position: relative;">
                                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    Действие
                                </button>
                                <div class="dropdown-menu" style="position: absolute;">
                                    <button
                                        onclick="open_modal_edit_variants(this)"
                                        class="dropdown-item"
                                        data-variant_id="{{$variant->id}}">
                                        Редактировать
                                        &nbsp;
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <form action="{{ route('variant.destroy', $variant->id) }}" method="POST">
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
                {!! Form::open(['route' => 'variant.add', 'method' => 'post']); !!}
                <div class="modal-body">
                    @csrf

                    {{Form::hidden('question_id', $question->id)}}
                    <label for="variant_in_kz">
                        Вариант на казахском *
                    </label>
                    {!! Form::textarea('variant_in_kz',null , ['class' => 'form-control', 'rows' => 5]); !!}

                    <label for="variant_in_kz">
                        Вариант на русском *
                    </label>
                    {!! Form::textarea('variant_in_ru', null,['class' => 'form-control', 'rows' => 5]); !!}


                    <label for="is_right">
                        Правильный вариант
                    </label>
                    &nbsp;
                    {!! Form::checkbox('is_right', null, false) !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Добавить вариант</button>
                </div>
                {!! Form::close(); !!}
            </div>
        </div>
    </div>

    <div class="modal fade" id="editVariants" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog" style="max-width: 800px;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Изменить варианты теста</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('variant.modify')}}" method="POST">
                    <div class="modal-body">
                        @csrf

                        {{Form::hidden('variant_id', null)}}
                        <label for="variant_in_kz">
                            Вариант на казахском *
                        </label>
                        {!! Form::textarea('variant_in_kz',null , ['class' => 'form-control', 'id' => 'edit_variant_in_kz', 'rows' => 5]); !!}

                        <label for="variant_in_kz">
                            Вариант на русском *
                        </label>
                        {!! Form::textarea('variant_in_ru', null,['class' => 'form-control','id' => 'edit_variant_in_ru', 'rows' => 5]); !!}


                        <label for="is_right">
                            Правильный вариант
                        </label>
                        &nbsp;
                        {!! Form::checkbox('is_right', null, false) !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary">Изменить вариант</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script>
        $('#open_modal_add_variants').click(function () {
            $('#addVariants').modal();
        });

        function open_modal_edit_variants(object){
            var variant_id = $(object).data('variant_id');
            var result = ajax(variant_id, 'get_test_variants_by_id');
            $('#editVariants').modal();
        };

        function ajax(item_id, type) {
            var result;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: 'POST',
                url: '/admin/variant/ajax',
                data: {type: type, item_id: item_id},
                success: function (data) {
                    append_to_edit_modal(data);
                }
            });
        }

        function append_to_edit_modal(data) {
            var modal = $('#editVariants');
            modal.find('textarea[name=variant_in_kz]').val(data['variant_in_kz']);
            modal.find('textarea[name=variant_in_ru]').val(data['variant_in_ru']);
            modal.find('input[name=is_right]').prop('checked', data['is_right']);
            modal.find('input[name=variant_id]').val(data['id']);

        }
    </script>
@endsection
