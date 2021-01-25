<template>
    <div class="card-body">
        <form @submit.prevent="submitForm">
        <div class="form-group">
            <label>Название на казахском *</label>
            <div class="input-group">
                <input name="name_kz" type="text" class="form-control" v-model="form.name_kz" required>
            </div>

        </div>
        <div class="form-group">
            <label>Название на русском *</label>
            <div class="input-group">
                <input name="name_ru" type="text" class="form-control" v-model="form.name_ru" required>
            </div>
        </div>

        <div class="form-group">
            <label>Выберите курс *</label>
            <select class="form-control select2bs4" name="course_id" v-model="form.course_id" required @change="loadSections">
                <option selected="selected" value="">Выберите курс ...</option>
                <option v-bind:value="key" v-for="(value, key) in courses">{{ value }}</option>
            </select>
        </div>

        <div class="form-group">
            <label>Выберите тему *</label>
            <select class="form-control select2bs4" name="section_id" v-model="form.section_id" required @change="loadLessons">
                <option selected="selected" value="">Выберите тему ...</option>
                <option v-bind:value="section.id" v-for="section in sections">{{ section.name_ru }}</option>
            </select>
        </div>

        <div class="form-group">
            <label>Выберите урок *</label>
            <select class="form-control select2bs4" name="lesson_id" v-model="form.lesson_id" required>
                <option selected="selected" value="">Выберите урок ...</option>
                <option v-bind:value="lesson.id" v-for="lesson in lessons">{{ lesson.name_ru }}</option>
            </select>
        </div>

        <div class="form-group">
            <label>Порядковый номер *</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-sort"></i></span>
                </div>
                <input name="order_number" type="text" class="form-control" v-model="form.order_number" required>
            </div>
        </div>
        <div id="questions_container">
            <div class="form-group questions" v-for="(question, key) in form.questions" :key="key">
                <h4>Вопрос #{{ key+1 }}</h4>
                <div class="row">
                    <div class="col-md-5">
                        <label>
                            Вопрос на казахском *
                        </label>
                        <textarea class="form-control editor" rows="5" cols="50" v-model="question.name_kz" required></textarea>
                    </div>
                    <div class="col-md-5">
                        <label>
                            Вопрос на русском *
                        </label>
                        <textarea class="form-control editor" rows="5" cols="50" v-model="question.name_ru" required></textarea>
                    </div>
                    <div class="col-md-2">
                        <label>
                            Фото
                        </label>
                        <input class="photo" type="file" @change="previewFiles(key)" ref="photos">
                    </div>
                </div>
                <div class="row" v-for="variant in question.variants">
                    <div class="col-md-5">
                        <label>
                            Вариант на казахском *
                        </label>
                        <textarea class="form-control editor kz" rows="5" cols="50" v-model="variant.name_kz" required></textarea>
                    </div>
                    <div class="col-md-5">
                        <label>
                            Вариант на русском *
                        </label>
                        <textarea class="form-control editor ru" rows="5" cols="50" v-model="variant.name_ru" required></textarea>
                    </div>
                    <div class="col-md-2 mt-4 p-4">
                        <label class="">
                            <input class="" type="checkbox" name="variant[0][]" v-model="variant.right_answer"> Правильный ответ
                        </label>
                        <button class="btn btn-primary" type="button" @click="addVariant(key)">Добавить еще
                            вариант
                        </button>
                    </div>
                </div>
                <hr>
            </div>
        </div>
        <div class="btn btn-group float-right">
            <button type="button" class="btn btn-primary" @click="addQuestion">
                Добавить вопрос
            </button>
            <button type="submit" class="btn btn-success">
                Добавить
            </button>
        </div>
        </form>
    </div>
</template>

<script>
    export default {
        props: ['coursesJson'],
        mounted() {
        },
        data() {
            return {
                form: {
                    name_kz: '',
                    name_ru: '',
                    course_id: "",
                    section_id: "",
                    lesson_id: "",
                    order_number: 1,
                    questions: [
                        {
                            name_ru: '',
                            name_kz: '',
                            photo: '',
                            variants: [
                                {
                                    name_kz: '',
                                    name_ru: '',
                                    right_answer: true
                                }
                            ]
                        }
                    ],
                },
                courses: JSON.parse(this.coursesJson),
                lessons: [],
                sections: [],
                files: []
            }
        },
        methods: {
            previewFiles(key) {
                this.files[key] = this.$refs.photos[key].files[0];
            },
            addQuestion() {
                this.form.questions.push({
                    name_ru: '',
                    name_kz: '',
                    photo: '',
                    variants: [
                        {
                            name_kz: '',
                            name_ru: '',
                            right_answer: true
                        }
                    ]
                })
            },
            addVariant(key) {
                this.form.questions[key].variants.push(
                    {
                        name_kz: '',
                        name_ru: '',
                        right_answer: true
                    }
                )
            },
            loadSections() {
                axios.get('/admin/sections/ajax?course_id='+this.form.course_id).then(response => {
                    this.sections = response.data
                })
            },
            loadLessons() {
                axios.get('/admin/lessons/ajax?section_id='+this.form.section_id).then(response => {
                    this.lessons = response.data
                })
            },
            submitForm () {
                let formData = new FormData();
                let data = this.form;
                for (let key in data) {
                    if (Array.isArray(data[key])) {
                        formData.append('questions', JSON.stringify(data[key]))
                    }
                    else {
                        formData.append(key, data[key]);
                    }
                }
                for( var i = 0; i < this.files.length; i++ ){
                    let file = this.files[i];

                    formData.append('files[' + i + ']', file);
                }
                axios.post('/admin/test', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                    window.location.href = "https://admin.bilim.app/admin/test";
                })
            }
        }
    }
</script>
