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
          <div class="md-title">Cadastro de Paciente</div>
        </md-card-header>

        <md-card-content>
          <div class="md-layout md-gutter">
            <div class="md-layout-item md-small-size-100">
              <md-field :class="getValidationClass('name')">
                <label for="name">Nome</label>
                <md-input
                  name="name"
                  id="name"
                  autocomplete="given-name"
                  v-model="form.name"
                  :disabled="sending"
                />

                <span class="md-error" v-if="!$v.form.name.required">Preencha o nome</span>
              </md-field>
            </div>
            <div class="md-layout-item md-small-size-100">
              <md-field :class="getValidationClass('address')">
                <label for="address">Endereço</label>
                <md-input id="address" name="address" v-model="form.address" :disabled="sending" />
                <span class="md-error" v-if="!$v.form.address.required">Preencha o endereço</span>
              </md-field>
            </div>
          </div>

          <div class="md-layout md-gutter">
            <div class="md-layout-item md-small-size-100">
              <md-field :class="getValidationClass('cpf')">
                <label for="cpf">CPF</label>
                <md-input name="cpf" id="cpf" v-model="form.cpf" :disabled="sending" />
                <span class="md-error" v-if="!$v.form.cpf.required">Preencha o cpf</span>
                <span class="md-error" v-if="!$v.form.cpf.minLength">Necesário 11 dígitos</span>
              </md-field>
            </div>
            <div class="md-layout-item md-small-size-100">
              <md-field :class="getValidationClass('sex')">
                <label for="sex">Sexo</label>
                <md-select name="sex" id="sex" v-model="form.sex" md-dense :disabled="sending">
                  <md-option></md-option>
                  <md-option value="M">M</md-option>
                  <md-option value="F">F</md-option>
                </md-select>
                <span class="md-error" v-if="!$v.form.sex.required">Preencha o sexo</span>
              </md-field>
            </div>

            <div class="md-layout-item md-small-size-100">
              <md-field :class="getValidationClass('birthdate')">
                <md-input
                  type="date"
                  id="birthdate"
                  name="birthdate"
                  v-model="form.birthdate"
                  :disabled="sending"
                />
                <span
                  class="md-error"
                  v-if="!$v.form.birthdate.required"
                >Preencha a data de nascimento</span>
              </md-field>
            </div>
            
          </div>
          <div class="md-layout md-gutter">
            

            <div class="md-layout-item md-small-size-100">
              <md-field>
                <label for="phone">Telefone</label>
                <md-input id="phone" name="phone" v-model="form.phone" :disabled="sending" />
              </md-field>
            </div>

            <div class="md-layout-item md-small-size-100">
              <md-field>
                <label for="health_insurance">Plano de Saúde</label>
                <md-input
                  id="health_insurance"
                  name="health_insurance"
                  v-model="form.health_insurance"
                  :disabled="sending"
                />
              </md-field>
            </div>

            <div class="md-layout-item md-small-size-100">
              <md-field>
                <label for="number_covenant">Número Plano Saúde</label>
                <md-input
                  id="number_covenant"
                  name="number_covenant"
                  v-model="form.number_covenant"
                  :disabled="sending"
                />
              </md-field>
            </div>
          </div>
        </md-card-content>

        <md-progress-bar md-mode="indeterminate" v-if="sending" />

        <md-card-actions>
          <md-button type="submit" class="md-primary" :disabled="sending">Cadastrar Paciente</md-button>
        </md-card-actions>
      </md-card>

      <md-snackbar :md-active.sync="userSaved">Paciente {{ lastUser }} cadastrado com sucesso!</md-snackbar>
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
  name: "Patient",
  mixins: [validationMixin],
  data: () => ({
    form: {
      name: null,
      cpf: null,
      sex: null,
      birthdate: null,
      address: null,
      phone: null,
      health_insurance: null,
      number_covenant: null
    },
    userSaved: false,
    sending: false,
    lastUser: null
  }),
  validations: {
    form: {
      name: {
        required
      },
      cpf: {
        required,
        minLength: minLength(11),
        maxLength: maxLength(11)
      },
      sex: {
        required
      },
      birthdate: {
        required
      },
      address: {
        required
      }
    }
  },
  methods: {
    setScreenName() {
      this.$emit("screenName", this.$route.params.screenName);
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
      this.form.name = null;
      this.form.cpf = null;
      this.form.sex = null;
      this.form.birthdate = null;
      this.form.address = null;
      this.form.phone = null;
      this.form.health_insurance = null;
      this.form.number_covenant = null;
    },
    saveUser() {
      this.sending = true;
      this.$http
        .post(
          "http://localhost/MERP/backend/index.php/patient/registerPatient",
          {
            cpf: this.form.cpf,
            name: this.form.name,
            sex: this.form.sex,
            birthdate: this.form.birthdate,
            address: this.form.address,
            phone: this.form.phone,
            health_insurance: this.form.health_insurance,
            number_covenant: this.form.number_covenant
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