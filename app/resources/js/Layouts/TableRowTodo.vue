<template>
    <tr :class="[todo.completed_at ? 'table-success' : '']">
        <td>{{ todo.id }}</td>
        <td>{{ todo.title }}</td>
        <td>{{ todo.user.name }}</td>
        <td>
            <div v-if="!todo.completed_at">
                <button @click="editTodo(todo)" class="btn btn-outline-secondary mx-1">
                    Editar
                </button>
                <button @click="deleteTodo(todo)" class="btn btn-outline-danger mx-1">
                    Excluir
                </button>
                <button @click="concludeTodo(todo)" class="btn btn-outline-success mx-1">
                    Concluir
                </button>
            </div>
            <span v-else>
                Concluído ({{ moment(todo.completed_at).format('DD/MM/YYYY') }})
            </span>
        </td>
    </tr>
</template>

<script>
import moment from 'moment'

export default {
    props: ['todo'],
    methods: {
        deleteTodo(todo){
            let index = this.$parent.todos.indexOf(todo), indexFilter = this.$parent.todosFilter.indexOf(todo)
            this.$parent.todos.splice(index, 1)
            this.$parent.todosFilter.splice(indexFilter, 1)
            axios.delete('/api/todo/' + todo.id)
        },
        editTodo(todo){
            this.$parent.typeForm = 'edit'
            this.$parent.editTodo = todo
            this.$parent.showFormTodoReact = true
        },
        concludeTodo(todo){
            const Toast = this.$swal.mixin({
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

            this.todo.completed_at = moment().format()
            axios.put('api/todo/conclude/' + todo.id, {completed_at: moment().format()})
            Toast.fire({
                icon: 'success',
                title: 'Tarefa concluída!'
            })
        }
    },
    created(){
        this.moment = moment
    }
}
</script>