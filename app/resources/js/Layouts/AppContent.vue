<template>
    <div class="row justify-content-center my-5">
        <div class="col-md-12">
            <div class="card shadow bg-light">
                <div class="card-body bg-white px-5 py-3 border-bottom rounded-top">
                    <fieldset>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-right">
                                        <a class="btn btn-light" href="/add-todo" role="button">Adicionar Tarefa</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <form @submit.prevent="submit">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="number_id">Número</label>
                                        <input class="form-control form-control-sm" type="text" id="number_id" v-model="form.id">
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
                                            <option :disabled="user.value == ''" v-for="user in form.users" v-bind:value="user.value">
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
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    data: function() {
        return {
            form: this.$inertia.form({
                id: '',
                tituloOuDescricao: '',
                titleOrDescription: '',
                users : [
                    { text: 'Selecione', value: '' },
                    { text: 'JP', value: 1 },
                    { text: 'JP2', value: 2 },
                    { text: 'JP3', value: 3 }
                ],
                situationSelected: 1,
                situations: [
                    { text: 'Em andamento', value: 1 },
                    { text: 'Concluída', value: 2 },
                ]
            }),
            showModal: false
        }
    },
    methods: {
        submit() {
            console.log(this.form)
            // this.form
            // .transform(data => ({
            //     ... data,
            //     remember: this.form.remember ? 'on' : ''
            // }))
            // .post(this.route('login'), {
            //     onFinish: () => this.form.reset('password'),
            // })
        }
    }
}
</script>
