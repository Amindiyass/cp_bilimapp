<template>
    <div class="card">
        <form>
            <div class="card-body">
                <div class="form-group mb-2">
                    <label>Название курса</label>
                    <select v-model="form.course_id" class="form-control" required>
                        <option>Выберите курс</option>
                        <option v-for="(course, key) in courses" :value="key">{{ course }}</option>
                    </select>
                </div>
                <hr />
                <div class="form-group" v-for="(solution, key) in form.solutions" :key="key">
                    <div class="row">
                        <div class="col-3">
                            <label>Вопрос #{{ key+1 }}</label>
                            <textarea v-model="solution.question" class="form-control" required></textarea>
                        </div>
                        <div class="col-2">
                            <label>Картинка вопроса</label>
                            <input ref="question_image" type="file" class="form-control-file">
                        </div>
                        <div class="col-3">
                            <label>Ответ</label>
                            <textarea v-model="solution.answer" class="form-control" required></textarea>
                        </div>
                        <div class="col-2">
                            <label>Картинка ответа</label>
                            <input ref="answer_image" type="file" class="form-control-file">
                        </div>
                        <div class="col-2">
                            <button @click="addSolution" type="button" class="btn btn-primary">Добавить</button>
                            <button @click="deleteSolution(key)" type="button" class="btn btn-danger">Удалить</button>
                        </div>
                    </div>
                </div>
                <div class="btn btn-success" type="submit">Отправить</div>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    name: "CreateSolutionComponent",
    props: ['coursesJson'],
    data() {
        return {
            courses: JSON.parse(this.coursesJson),
            form: {
                course_id: '',
                solutions: [
                    {
                        question: '',
                        answer: '',
                        question_image: '',
                        answer_image: '',
                    }
                ]
            }
        }
    },
    methods: {
        addSolution(){
            this.form.solutions.push({
                question: '',
                answer: '',
                question_image: '',
                answer_image: '',
            })
        },
        deleteSolution(key) {
            this.form.solutions.splice(key, 1)
        }
    }
}
</script>

<style scoped>

</style>
