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
          <div class="md-title">Marcar Consulta</div>
        </md-card-header>

        <md-card-content>
          <div class="md-layout md-gutter">
            <div class="md-layout-item md-small-size-100">
              <md-field :class="getValidationClass('specialty')">
                <label for="specialty">Especialidade</label>
                <md-select
                  name="specialty"
                  id="specialty"
                  v-model="form.specialty"
                  :disabled="sending"
                >
                <md-option value="M">M</md-option>
                  <md-option value="F">F</md-option>
                </md-select>
                <span class="md-error" v-if="!$v.form.specialty.required">Selecione a especialidade</span>
              </md-field>
            </div>

            <div class="md-layout-item md-small-size-100">
              <md-field :class="getValidationClass('doctor')">
                <label for="doctor">Médico</label>
                <md-select name="doctor" id="doctor" v-model="form.doctor" :disabled="sending">
                    <md-option value="M">M</md-option>
                  <md-option value="F">F</md-option>
                </md-select>
                <span class="md-error" v-if="!$v.form.doctor.required">Selecione o Médico</span>
              </md-field>
            </div>
          </div>

          <div class="md-layout md-gutter">
            <div class="md-layout-item md-small-size-100">
              <md-field :class="getValidationClass('patient')">
                <label for="patient">Paciente</label>
                <md-select name="patient" id="patient" v-model="form.patient" :disabled="sending">
                  <md-option value="M">M</md-option>
                  <md-option value="F">F</md-option>
                </md-select>
                <span class="md-error">Selecione o paciente</span>
              </md-field>
            </div>
          </div>

          <md-field :class="getValidationClass('date')">
            <md-input type="date" name="date" id="date" v-model="form.date" :disabled="sending" />
            <span class="md-error" v-if="!$v.form.date.required">Selecione a Data da Consulta</span>
            <span class="md-error" v-else-if="!$v.form.date.date">Invalid date</span>
          </md-field>
        </md-card-content>

        <md-progress-bar md-mode="indeterminate" v-if="sending" />

        <md-card-actions>
          <md-button type="submit" class="md-primary" :disabled="sending">Create user</md-button>
        </md-card-actions>
      </md-card>

      <md-snackbar :md-active.sync="userSaved">Consulta marcada com sucesso!</md-snackbar>
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
  name: "Appointment",
  mixins: [validationMixin],
  data: () => ({
    form: {
      specialty: null,
      doctor: null,
      patient: null,
      date: null
    },
    userSaved: false,
    sending: false,
    lastUser: null
  }),
  validations: {
    form: {
      specialty: {
        required
      },
      doctor: {
        required
      },
      patient: {
        required
      },
      date: {
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
      this.form.specialty = null;
      this.form.doctor = null;
      this.form.patient = null;
      this.form.date = null;
    },
    saveUser() {
      this.sending = true;
      this.$http
        .post(
          "http://localhost/MERP/backend/index.php/appointment/registerAppointment",
          {
            /* specialty : this.form.specialty,
            doctor : this.form.doctor,
            patient : this.form.patient,
            date : this.form.date */
            specialtyId : 4,
            doctorId : 1,
            patientId : 1,
            date : '29/11/2019 18:00:28'
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





