<template>
  <div class="outer">
    <div class="middle">
      <div id="container">
        <form novalidate @submit.prevent="validateLogin">
          <md-card>
            <md-card-header>
              <div class="md-title">Login</div>
            </md-card-header>

            <md-card-content>
              <md-field :class="getValidationClass('email')">
                <label for="email">Email</label>
                <md-input
                  type="email"
                  name="email"
                  id="email"
                  autocomplete="email"
                  v-model="form.email"
                  :disabled="sending"
                />
                <span class="md-error" v-if="!$v.form.email.required">E-mail obrigatório</span>
                <span class="md-error" v-else-if="!$v.form.email.email">E-mail inválido</span>
              </md-field>
              <md-field :class="getValidationClass('password')">
                <label for="password">Senha</label>
                <md-input
                  type="password"
                  name="password"
                  id="password"
                  autocomplete="password"
                  v-model="form.password"
                  :disabled="sending"
                />
                <span class="md-error" v-if="!$v.form.password.required">Senha obrigatória</span>
              </md-field>
            </md-card-content>

            <md-progress-bar md-mode="indeterminate" v-if="sending" />

            <md-card-actions>
              <md-button type="submit" class="md-primary" :disabled="sending">Login</md-button>
            </md-card-actions>
          </md-card>
        </form>

        <md-dialog :md-active.sync="showDialog">
          <md-tabs md-dynamic-height>
            <md-tab md-label="Aviso">
              <p>E-mail ou senha inválidos.</p>
            </md-tab>
          </md-tabs>

          <md-dialog-actions>
            <md-button class="md-primary" @click="showDialog = false">Fechar</md-button>
          </md-dialog-actions>
        </md-dialog>
      </div>
    </div>
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
  name: "Login",
  mixins: [validationMixin],
  data: () => ({
    sending: false,
    showDialog: false,
    form: {
      email: null,
      password: null
    }
  }),
  validations: {
    form: {
      email: {
        required,
        email
      },
      password: {
        required
      }
    }
  },
  methods: {
    login() {
      this.sending = true;
      if (this.form.email != "" && this.form.password != "") {
        this.$http
          .post("http://localhost/MERP/backend/index.php/user/login", {
            email: this.form.email,
            password: this.form.password
          })
          .then(response => {
            this.info = response;
            if ( response.data.error === false && response.data.validLogin === true ) {
              this.$emit("authenticated", true);
              this.$emit("username", response.data.userName);
              this.$emit("userData", response.data.user);
              this.$emit("screenName", "Painel de Controle");
              this.$emit("userType", "user");
              this.$router.push({ name: "dashboard", params:{ userType: 'user', data: response.data}});
            } else {
                this.$http
                .post("http://localhost/MERP/backend/index.php/doctor/login", {
                    email: this.form.email,
                    password: this.form.password
                })
                .then(response => {
                    if( response.data.error === false && response.data.validLogin === true ){
                        this.$emit("authenticated", true);
                        this.$emit("username", response.data.doctor.name);
                        this.$emit("userData", response.data.doctor);
                        this.$emit("screenName", 'Consultas Marcadas');
                        this.$emit("userType", 'doctor');
                        this.$router.push({ name: "dashboard", params:{ userType: 'doctor', data: response.data.doctor}});
                    }else {
                        this.sending = false;
                        this.showDialog = true;
                    }
                })
            }
          });
      }
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
      this.form.password = null;
    },
    validateLogin() {
      this.$v.$touch();

      if (!this.$v.$invalid) {
        this.login();
      }
    }
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

#container {
  margin-left: auto;
  margin-right: auto;
  width: 550px;
}

.md-dialog {
  max-width: 768px;
}
.outer {
  display: table;
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
}

.middle {
  display: table-cell;
  vertical-align: middle;
}
</style>