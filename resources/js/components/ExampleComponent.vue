<template>
    <div class="card-body">
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
            <select class="form-control select2bs4" id="course_id" style="width: 100%;" name="course_id"><option selected="selected" value="">Выберите курс ...</option><option value="37">Алгебра | 10 сынып</option><option value="38">Алгебра | 11 сынып</option><option value="2">Қазақ тілі | 7 сынып</option><option value="1">Қазақ тілі | 6 сынып</option><option value="3">Қазақ тілі | 8 сынып</option><option value="4">Қазақ тілі | 9 сынып
            </option><option value="5">Қазақ тілі | 10 сынып
            </option><option value="6">Қазақ тілі | 11 сынып
            </option><option value="7">Қазақстан тарихы | 6 сынып</option><option value="8">Қазақстан тарихы | 7 сынып</option><option value="9">Қазақстан тарихы | 8 сынып</option><option value="10">Қазақстан тарихы | 9 сынып</option><option value="11">Қазақстан тарихы | 10 сынып</option><option value="12">Қазақстан тарихы | 11 класс</option><option value="13">Дүниежүзі тарихы | 6 сынып</option><option value="14">Дүниежүзі тарихы | 7 сынып</option><option value="15">Дүниежүзі тарихы | 8 сынып</option><option value="39">Геометрия | 7 сынып</option><option value="45">Ағылшын тілі</option><option value="34">Алгебра | 7 сынып</option><option value="35">Алгебра | 8 сынып</option><option value="36">Алгебра | 9 сынып</option><option value="16">Дүниежүзі тарихы | 9 сынып</option><option value="17">Дүниежүзі тарихы | 10 сынып</option><option value="18">Дүниежүзі тарихы | 11 сынып</option><option value="19">Физика | 7 сынып</option><option value="20">Физика | 8 сынып</option><option value="21">Физика | 9 сынып</option><option value="22">Физика | 10 сынып</option><option value="23">Физика | 11 сынып</option><option value="24">Химия | 7 сынып</option><option value="25">Химия | 8 сынып</option><option value="26">Химия | 9 сынып</option><option value="27">Химия | 10 сынып</option><option value="28">Химия | 11 сынып</option><option value="29">Биология | 7 сынып</option><option value="30">Биология | 8 сынып</option><option value="31">Биология | 9 сынып</option><option value="32">Биология | 10 сынып</option><option value="33">Биология | 11 сынып</option><option value="40">Геометрия | 8 сынып</option><option value="41">Геометрия | 9 сынып</option><option value="42">Геометрия | 10 сынып</option><option value="43">Геометрия | 11 сынып</option><option value="44">Математика | 6 сынып</option><option value="46">Ағылшын тілі</option><option value="47">Ағылшын тілі</option><option value="48">Ағылшын тілі</option><option value="49">Ағылшын тілі</option><option value="50">Ағылшын тілі</option></select>
        </div>

        <div class="form-group">
            <label>Выберите тему *</label>
            <select class="form-control select2bs4" id="section_id" disabled="" style="width: 100%;" name="section_id"><option selected="selected" value="">Выберите тему ...</option></select>
        </div>

        <div class="form-group">
            <label>Выберите урок *</label>
            <select class="form-control select2bs4" id="lesson_id" style="width: 100%;" disabled="" name="lesson_id"><option selected="selected" value="">Выберите урок ...</option></select>
        </div>

        <div class="form-group">
            <label>Порядковый номер *</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-sort"></i></span>
                </div>
                <input name="order_number" type="text" class="form-control" value="1">
            </div>
        </div>
        <div id="questions_container">
            <div class="form-group questions">
                <h4>Вопрос #<span id="question_number">1</span></h4>
                <div class="row">
                    <div class="col-md-5">
                        <label for="password">
                            Вопрос на казахском *
                        </label>
                        <textarea class="form-control editor question_kz" rows="5" name="question_in_kz[0]" cols="50"></textarea>
                    </div>
                    <div class="col-md-5">
                        <label for="password">
                            Вопрос на русском *
                        </label>
                        <textarea class="form-control editor question_ru" rows="5" name="question_in_ru[0]" cols="50"></textarea>
                    </div>
                    <div class="col-md-2">
                        <label>
                            Фото
                        </label>
                        <input class="photo" name="photos[0]" type="file">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <label>
                            Вариант на казахском *
                        </label>
                        <textarea class="form-control editor kz" rows="5" name="variant_in_kz[0][0]" cols="50"></textarea>
                    </div>
                    <div class="col-md-5">
                        <label>
                            Вариант на русском *
                        </label>
                        <textarea class="form-control editor ru" rows="5" name="variant_in_ru[0][0]" cols="50"></textarea>
                    </div>
                    <div class="col-md-2 mt-4 p-4">
                        <label class="">
                            <input class="" type="checkbox" name="variant[0][]"> Правильный ответ
                        </label>
                        <button class="btn btn-primary" type="button" onclick="addVariant(this)">Добавить еще
                            вариант
                        </button>
                    </div>
                </div>
                <hr>
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
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
