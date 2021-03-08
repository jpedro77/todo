<template>
    <div class="row justify-content-center my-5">
        <div class="col-md-12">
            <div class="card shadow bg-light">
                <div class="card-body bg-white px-5 py-3 border-bottom rounded-top">
                    <fieldset v-if="!showFormTodoReact">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-right">
                                        <button @click="showFormTodoReact = true" class="btn btn-light" role="button">
                                            <font-awesome-icon icon="plus" /> Adicionar Tarefa
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset v-if="showFormTodoReact">
                        <form-todo :type="typeForm" :edit="editTodo"></form-todo>
                    </fieldset>
                    <fieldset v-if="!showFormTodoReact">
                        <form @submit.prevent="submit">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="number_id">Número</label>
                                        <input class="form-control form-control-sm" type="number" id="number_id" v-model="form.id">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="titleOrDescription">Título/Descrição</label>
                                        <input class="form-control form-control-sm" type="text" id="titleOrDescription" v-model="form.titleOrDescription">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="user">Responsável</label>
                                        <select class="custom-select custom-select-sm" id="user" v-model="form.userSelected">
                                            <option v-for="user in form.users" v-bind:value="user.value">
                                                {{ user.text }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="situation">Situação</label>
                                        <select class="custom-select custom-select-sm" id="situation" v-model="form.situationSelected">
                                            <option v-for="situation in form.situations" v-bind:value="situation.value">
                                                {{ situation.text }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-light" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                                                <font-awesome-icon icon="search" /> Buscar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Número</th>
                                    <th>Título</th>
                                    <th>Responsável</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <row-todo v-for="todo in todosFilter" :todo="todo"></row-todo>
                            </tbody>
                        </table>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import FormTodo from '../Pages/FormTodo.vue'
import rowTodo from './TableRowTodo'

export default {
    components: {
        rowTodo,
        FormTodo
    },
    props: {
        showFormTodo: Boolean
    },
    data: function() {
        return {
            form: this.$inertia.form({
                id: '',
                titleOrDescription: '',
                userSelected: '',
                users : [
                    { text: 'Selecione', value: '' }
                ],
                situationSelected: 1,
                situations: [
                    { text: 'Em andamento', value: 1 },
                    { text: 'Concluída', value: 2 },
                ]
            }),
            todos: [],
            todosFilter: [],
            typeForm: 'add',
            editTodo: [],
            showFormTodoReact: this.showFormTodo
        }
    },
    mounted(){
        let vm = this
        
        axios.get('/api/todo')
        .then( response => {
            vm.todos = response.data

            vm.todosFilter = response.data.filter(item => {
                return item.completed_at == null
            })
        })

        this.fetch('/api/user', this.form.users)
    },
    methods: {
        submit() {
            let vm = this.form

            this.todosFilter = this.todos.filter(item => {
                if(vm.situationSelected == 1){
                    return item.completed_at == null
                }else{
                    return item.completed_at != null
                }
            })

            if(vm.id){
                this.todosFilter = this.todosFilter.filter(item => {
                    return item.id == vm.id
                })
            }

            if(vm.titleOrDescription){
                this.todosFilter = this.todosFilter.filter(item => {
                    return item.title.toLowerCase().indexOf(vm.titleOrDescription.toLowerCase()) > -1 || item.description.toLowerCase().indexOf(vm.titleOrDescription.toLowerCase()) > -1
                })
            }

            if(vm.userSelected){
                this.todosFilter = this.todosFilter.filter(item => {
                    return item.user_id == vm.userSelected
                })
            }

        },
        fetch(url, vm){
            axios.get(url).then( response => {
                response.data.forEach(el => {
                    vm.push({"text": el.name, "value": el.id})
                });
            })
        }
    }
}
</script>
