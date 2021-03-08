<template>
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
                        <select class="custom-select custom-select-sm" id="user" v-model="form.user_id" required>
                            <option :disabled="user.value == ''" v-for="user in form.users" v-bind:value="user.value">
                                {{ user.text }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="priority">Prioridade</label>
                        <select class="custom-select custom-select-sm" id="priority" v-model="form.todo_priority_id">
                            <option v-for="priority in form.priorities" v-bind:value="priority.value">
                                {{ priority.text }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="deadline_at">Deadline</label>
                        <DatePicker v-model="form.deadline_at">
                            <template v-slot="{ inputValue, inputEvents }">
                                <input
                                    class="bg-white border px-2 py-1 rounded"
                                    :value="inputValue"
                                    v-on="inputEvents"
                                    required
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
</template>

<script>
import JetValidationErrors from '@/Jetstream/ValidationErrors'
import moment from 'moment'

export default {
    props: {
        type: String, 
        edit: Object
    },
    components: {
        JetValidationErrors
    },
    data() {
        return {
            form: this.$inertia.form({
                id: '',
                title: '',
                description: '',
                user_id: '',
                users : [
                    { text: 'Selecione', value: '' }
                ],
                todo_priority_id: 1,
                priorities: [],
                deadline_at: new Date()
            })
        }
    },
    mounted(){
        this.fetch('/api/todo-priority', this.form.priorities)
        this.fetch('/api/user', this.form.users)
        if(Object.keys(this.edit).length > 0){
            this.form.id = this.edit.id
            this.form.title = this.edit.title
            this.form.description = this.edit.description
            this.form.user_id = this.edit.user_id
            this.form.todo_priority_id = this.edit.todo_priority_id
            this.form.deadline_at = moment(this.edit.deadline_at).format('YYYY-MM-DD')
        }
    },
    methods: {
        toast(){
            return this.$swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
        },
        submit() {
            let dados = this.form,
                vm = this
            
            dados.deadline_at = moment(dados.deadline_at).format('YYYY-MM-DD')

            if(this.type == 'add'){
                axios.post('api/todo', dados)
                .then(response => {
                    
                    if(response.status == 200){
                        this.toast().fire({
                            icon: 'success',
                            title: 'Tarefa Salva!'
                        })
                    }else{
                        this.toast().fire({
                            icon: 'error',
                            title: 'Ocorreu algum problema!'
                        })
                    }

                    vm.clearFields()
                })
            }else{
                axios.put('api/todo/' + dados.id, dados)
                
                Toast.fire({
                    icon: 'success',
                    title: 'tarefa Editada!'
                })
            }
        },
        fetch(url, vm){
            axios.get(url).then( response => {
                response.data.forEach(el => {
                    vm.push({"text": el.name, "value": el.id})
                });
            })
        },
        clearFields(){
            this.form.title = '',
            this.form.description = ''
            this.form.user_id = ''
            this.form.todo_priority_id = ''
            this.form.deadline_at = new Date()
        }
    }
}
</script>
