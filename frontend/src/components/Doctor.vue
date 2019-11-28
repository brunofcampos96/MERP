<template>
  <div>
    <form
      v-if="this.$route.params.function === 'add'"
      novalidate
      class="md-layout"
      @submit.prevent="validateUser"
    >
      <md-card class="md-layout-item md-size-50 md-small-size-100">
        <md-card-header>
          <div class="md-title">Users</div>
        </md-card-header>

        <md-card-content>
          <div class="md-layout md-gutter">
            <div class="md-layout-item md-small-size-100">
              <md-field :class="getValidationClass('email')">
                <label for="email">E-mail</label>
                <md-input name="email" id="email" v-model="form.email" :disabled="sending" />
                <span class="md-error" v-if="!$v.form.email.required">Email necessário</span>
                <span class="md-error" v-else-if="!$v.form.email.email">Email inválido</span>
              </md-field>
            </div>

            <div class="md-layout-item md-small-size-100">
              <md-field :class="getValidationClass('name')">
                <label for="name">Nome</label>
                <md-input name="name" id="name" v-model="form.name" :disabled="sending" />
                <span class="md-error" v-if="!$v.form.name.required">Preencha o nome</span>
              </md-field>
            </div>

            <div class="md-layout-item md-small-size-100">
              <md-field :class="getValidationClass('specialties')">
                <label for="specialty">Especialidade</label>
                <md-input
                  name="specialty"
                  id="specialty"
                  v-model="form.specialty"
                  :disabled="sending"
                />
                <span
                  class="md-error"
                  v-if="!$v.form.specialty.required"
                >Selecione uma especialidade</span>
              </md-field>
            </div>
          </div>

          <div class="md-layout md-gutter">
            <div class="md-layout-item md-small-size-100">
              <md-field :class="getValidationClass('crm')">
                <label for="crm">Crm</label>
                <md-input type="number" id="crm" name="crm" v-model="form.crm" :disabled="sending" />
                <span class="md-error" v-if="!$v.form.crm.required">Preencha o Crm</span>
              </md-field>
            </div>
          </div>

          <md-field :class="getValidationClass('password')">
            <label for="password">Senha</label>
            <md-input
              type="password"
              name="password"
              id="password"
              v-model="form.password"
              :disabled="sending"
            />
            <span class="md-error" v-if="!$v.form.password.required">Preencha a Senha</span>
          </md-field>
        </md-card-content>

        <md-progress-bar md-mode="indeterminate" v-if="sending" />

        <md-card-actions>
          <md-button type="submit" class="md-primary" :disabled="sending">Create user</md-button>
        </md-card-actions>
      </md-card>

      <md-snackbar :md-active.sync="userSaved">Médico {{ lastUser }} registrado com sucesso!</md-snackbar>
    </form>
  </div>
</template>
<script>
import { validationMixin } from "vuelidate";
import {
  required,
  email,
  minLength,
  maxLength
} from "vuelidate/lib/validators";

export default {
  name: "Doctor",
  mixins: [validationMixin],
  data: () => ({
    form: {
      email: null,
      name: null,
      specialty: null,
      crm: null,
      password: null
    },
    userSaved: false,
    sending: false,
    lastUser: null
  }),
  validations: {
    form: {
      email: {
        required,
        email
      },
      name: {
        required,
        minLength: minLength(3)
      },
      specialties: {
        required,
        maxLength: maxLength(3)
      },
      crm: {
        required
      },
      password: {
        required
      }
    }
  },
  methods: {
    setScreenName() {
      this.$emit("screenName", "Médico");
    },
    getValidationClass(fieldName) {
      const field = this.$v.form[fieldName];

      if (field) {
        return {
          "md-invalid": field.$invalid && field.$dirty
        };
      }
    },
    clearForm() {
      this.$v.$reset();
      this.form.email = null;
      this.form.name = null;
      this.form.specialty = null;
      this.form.crm = null;
      this.form.password = null;
    },
    saveUser() {
      this.sending = true;
      this.$http
        .post(
          "http://localhost/MERP/backend/index.php/doctor/registerPatient",
          {
            email: this.form.email,
            name: this.form.name,
            specialties: this.form.specialties,
            crm: this.form.crm,
            password: this.form.password
          }
        )
        .then(response => {
          if (response.data.error === false) {
            this.lastUser = this.form.name;
            this.userSaved = true;
            this.sending = false;
            this.clearForm();
          } else {
            this.sending = false;
            this.showDialog = true;
          }
        });
    },
    validateUser() {
      this.$v.$touch();

      if (!this.$v.$invalid) {
        this.saveUser();
      }
    }
  },
  mounted() {
    this.setScreenName();
  }
};
</script>
<style scoped>
.md-progress-bar {
  position: absolute;
  top: 0;
  right: 0;
  left: 0;
}
</style>