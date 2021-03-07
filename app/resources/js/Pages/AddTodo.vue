<template>
    <app-layout>
        <template #header>
            <h2 class="h4 font-weight-bold">
                Cadastrar Tarefa
            </h2>
        </template>
        <div class="row justify-content-center my-5">
            <div class="col-md-12">
                <div class="card shadow bg-light">
                    <div class="card-body bg-white px-5 py-3 border-bottom rounded-top">
                        <fieldset>
                            <form @submit.prevent="submit">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="title">Título</label>
                                            <input class="form-control form-control-sm" type="text" id="title" v-model="form.title" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="description">Descrição</label>
                                            <textarea class="form-control form-control-sm" id="description" v-model="form.description" rows="3" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="user">Responsável</label>
                                            <select class="custom-select custom-select-sm" id="user" v-model="form.id_user" required>
                                                <option :disabled="user.value == ''" v-for="user in form.users" v-bind:value="user.value">
                                                    {{ user.text }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="priority">Prioridade</label>
                                            <select class="custom-select custom-select-sm" id="priority" v-model="form.id_todo_priority">
                                                <option v-for="priority in form.priorities" v-bind:value="priority.value">
                                                    {{ priority.text }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="deadline">Deadline</label>
                                            <DatePicker v-model="form.deadline">
                                                <template v-slot="{ inputValue, inputEvents }">
                                                    <input
                                                        class="bg-white border px-2 py-1 rounded"
                                                        :value="inputValue"
                                                        v-on="inputEvents"
                                                    />
                                                </template>
                                            </DatePicker>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-light" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                                                    <font-awesome-icon icon="save" /> Salvar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import JetValidationErrors from '@/Jetstream/ValidationErrors'

export default {

    components: {
        AppLayout,
        JetValidationErrors
    },
    data() {
        return {
            form: this.$inertia.form({
                title: '',
                description: '',
                id_user: '',
                users : [
                    { text: 'Selecione', value: '' }
                ],
                id_todo_priority: 1,
                priorities: [],
                deadline: new Date()
            })
        }
    },
    mounted(){
        this.fetch('/api/todo-priority', this.form.priorities)
        this.fetch('/api/user', this.form.users)
    },
    methods: {
        submit() {
            this.form
                .transform(data => ({
                    ... data,
                    remember: this.form.remember ? 'on' : ''
                }))
                .post('api/todo')
        },
        fetch(url, vm){
            $.get(url, function(data){
                data.forEach(el => {
                    vm.push({"text": el.name, "value": el.id})
                });
            })
        }
    }
}
</script>
