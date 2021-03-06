<template>
  <jet-action-section>
    <template #title>
      Autenticação de Dois Fatores
    </template>

    <template #description>
      Adicione segurança adicional à sua conta usando autenticação de dois fatores.
    </template>

    <template #content>
      <h3 class="h5 font-weight-bold" v-if="twoFactorEnabled">
        Você habilitou a autenticação de dois fatores.
      </h3>

      <h3 class="h5 font-weight-bold" v-else>
        Você não habilitou a autenticação de dois fatores.
      </h3>

      <div class="mt-3">
        <p>
          Quando a autenticação de dois fatores está habilitada, você será solicitado a fornecer um token aleatório seguro durante a autenticação. Você pode recuperar este token do aplicativo Google Authenticator do seu telefone.
        </p>
      </div>

      <div v-if="twoFactorEnabled">
        <div v-if="qrCode">
          <div class="mt-3">
            <p>
              A autenticação de dois fatores agora está habilitada. Leia o seguinte código QR usando o aplicativo autenticador do seu telefone.
            </p>
          </div>

          <div class="mt-3" v-html="qrCode">
          </div>
        </div>

        <div v-if="recoveryCodes.length > 0">
          <div class="mt-3">
            <p>
              Armazene esses códigos de recuperação em um gerenciador de senhas seguro. Eles podem ser usados para recuperar o acesso à sua conta se o seu dispositivo de autenticação de dois fatores for perdido.
            </p>
          </div>

          <div class="w-75 bg-light rounded p-3">
            <div v-for="code in recoveryCodes">
              {{ code }}
            </div>
          </div>
        </div>
      </div>

      <div class="mt-3">
        <div v-if="! twoFactorEnabled">
          <jet-confirms-password @confirmed="enableTwoFactorAuthentication">
            <jet-button type="button" :class="{ 'text-white-50': enabling }" :disabled="enabling">
              Habilitar
            </jet-button>
          </jet-confirms-password>
        </div>

        <div v-else>
          <jet-confirms-password @confirmed="regenerateRecoveryCodes">
            <jet-secondary-button class="mr-3"
                                  v-if="recoveryCodes.length > 0">
              Códigos de recuperação regenerados
            </jet-secondary-button>
          </jet-confirms-password>

          <jet-confirms-password @confirmed="showRecoveryCodes">
            <jet-secondary-button class="mr-3" v-if="recoveryCodes.length == 0">
              Mostrar códigos de recuperação
            </jet-secondary-button>
          </jet-confirms-password>

          <jet-confirms-password @confirmed="disableTwoFactorAuthentication">
            <jet-danger-button
                :class="{ 'text-white-50': disabling }"
                :disabled="disabling">
              Desabilitar
            </jet-danger-button>
          </jet-confirms-password>
        </div>
      </div>
    </template>
  </jet-action-section>
</template>

<script>
import JetActionSection from '@/Jetstream/ActionSection'
import JetButton from '@/Jetstream/Button'
import JetConfirmsPassword from '@/Jetstream/ConfirmsPassword'
import JetDangerButton from '@/Jetstream/DangerButton'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'

export default {
  components: {
    JetActionSection,
    JetButton,
    JetConfirmsPassword,
    JetDangerButton,
    JetSecondaryButton,
  },

  data() {
    return {
      enabling: false,
      disabling: false,

      qrCode: null,
      recoveryCodes: [],
    }
  },

  methods: {
    enableTwoFactorAuthentication() {
      this.enabling = true

      this.$inertia.post('/user/two-factor-authentication', {}, {
        preserveScroll: true,
        onSuccess: () => Promise.all([
          this.showQrCode(),
          this.showRecoveryCodes(),
        ]),
        onFinish: () => (this.enabling = false),
      })
    },

    showQrCode() {
      return axios.get('/user/two-factor-qr-code')
          .then(response => {
            this.qrCode = response.data.svg
          })
    },

    showRecoveryCodes() {
      return axios.get('/user/two-factor-recovery-codes')
          .then(response => {
            this.recoveryCodes = response.data
          })
    },

    regenerateRecoveryCodes() {
      axios.post('/user/two-factor-recovery-codes')
          .then(response => {
            this.showRecoveryCodes()
          })
    },

    disableTwoFactorAuthentication() {
      this.disabling = true

      this.$inertia.delete('/user/two-factor-authentication', {
        preserveScroll: true,
        onSuccess: () => (this.disabling = false),
      })
    },
  },

  computed: {
    twoFactorEnabled() {
      return ! this.enabling && this.$page.props.user.two_factor_enabled
    }
  }
}
</script>
