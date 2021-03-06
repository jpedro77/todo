<template>
  <jet-action-section>
    <template #title>
      Deletar conta
    </template>

    <template #description>
      Exclua permanentemente sua conta.
    </template>

    <template #content>
      <div>
        Depois que sua conta for excluída, todos os seus recursos e dados serão excluídos permanentemente. Antes de excluir sua conta, baixe todos os dados ou informações que deseja reter.
      </div>

      <div class="mt-3">
        <jet-danger-button @click="confirmUserDeletion">
          Deletar conta
        </jet-danger-button>
      </div>

      <!-- Delete Account Confirmation Modal -->
      <jet-dialog-modal id="confirmingUserDeletionModal">
        <template #title>
          Deletar conta
        </template>

        <template #content>
          Tem certeza que deseja deletar sua conta? Depois que sua conta for excluída, todos os seus recursos e dados serão excluídos permanentemente. Digite sua senha para confirmar que deseja excluir permanentemente sua conta.

          <div class="mt-4">
            <jet-input type="password" placeholder="Senha"
                       ref="password"
                       v-model="form.password"
                       :class="{ 'is-invalid': form.errors.password }"
                       @keyup.enter="deleteUser" />

            <jet-input-error :message="form.errors.password" />
          </div>
        </template>

        <template #footer>
          <jet-secondary-button data-dismiss="modal" @click="closeModal">
            Cancelar
          </jet-secondary-button>

          <jet-danger-button @click="deleteUser" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
            Deletar conta
          </jet-danger-button>
        </template>
      </jet-dialog-modal>
    </template>
  </jet-action-section>
</template>

<script>
import JetActionSection from '@/Jetstream/ActionSection'
import JetDialogModal from '@/Jetstream/DialogModal'
import JetDangerButton from '@/Jetstream/DangerButton'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'

export default {
  components: {
    JetActionSection,
    JetDangerButton,
    JetDialogModal,
    JetInput,
    JetInputError,
    JetSecondaryButton,
  },

  data() {
    return {
      modal: null,
      confirmingUserDeletion: false,

      form: this.$inertia.form({
        password: '',
      })
    }
  },

  methods: {
    confirmUserDeletion() {
      this.form.password = '';

      this.modal = new Bootstrap.Modal(document.getElementById('confirmingUserDeletionModal'))
      this.modal.toggle()

      setTimeout(() => this.$refs.password.focus(), 250)
    },

    deleteUser() {
      this.form.delete(route('current-user.destroy'), {
        preserveScroll: true,
        onSuccess: () => this.closeModal(),
        onError: () => this.$refs.password.focus(),
        onFinish: () => this.form.reset(),
      })
    },

    closeModal() {
      this.confirmingUserDeletion = false

      this.form.reset()

      this.modal.toggle()
    },
  },
}
</script>
