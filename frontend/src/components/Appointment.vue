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
                  @md-selected="loadDoctors"
                  name="specialty"
                  id="specialty"
                  v-model="form.specialty"
                  :disabled="sending"
                >
                <md-option v-for="specialty in avSpecialties" :value="specialty.id" :key="specialty.id">{{specialty.description}}</md-option>
                </md-select>
                <span class="md-error" v-if="!$v.form.specialty.required">Selecione a especialidade</span>
              </md-field>
            </div>

            <div class="md-layout-item md-small-size-100">
              <md-field :class="getValidationClass('doctor')">
                <label for="doctor">Médico</label>
                <md-select name="doctor" id="doctor" v-model="form.doctor" :disabled="sending || !form.specialty">
                  <md-option v-for="doctor in doctors" :value="doctor.id" :key="doctor.id">{{doctor.name}}</md-option>
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
                  <md-option v-for="patient in patients" :value="patient.id" :key="patient.id">{{patient.name}}</md-option>
                </md-select>
                <span class="md-error">Selecione o paciente</span>
              </md-field>
            </div>
          </div>

          <md-field :class="getValidationClass('date')">
            <md-input type="datetime-local" name="date" id="date" v-model="form.date" :disabled="sending" />
            <span class="md-error" v-if="!$v.form.date.required">Selecione a Data da Consulta</span>
            <span class="md-error" v-else-if="!$v.form.date.date">Invalid date</span>
          </md-field>
        </md-card-content>

        <md-progress-bar md-mode="indeterminate" v-if="sending" />

        <md-card-actions>
          <md-button type="submit" class="md-primary" :disabled="sending">Marcar consulta</md-button>
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
    lastUser: null,
    avSpecialties : null,
    doctors: null,
    patients: null
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
    loadDoctors(){
      this.doctors = null;
      this.form.doctor = null;
      this.$http
        .get(
          "http://localhost/MERP/backend/index.php/doctor/?specialty="+this.form.specialty)
        .then(response => {
          if (response.data.error === false) {
            this.doctors = response.data.doctors
          }
        });
    },
    loadPatients(){
      this.$http
        .get(
          "http://localhost/MERP/backend/index.php/patient/")
        .then(response => {
          if (response.data.error === false) {
            this.patients = response.data.patients
          }
        });
    },
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
            specialtyId : this.form.specialty,
            doctorId : this.form.doctor,
            patientId : this.form.patient,
            date : this.form.date
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
    },
    loadSpecialties(){
      this.$http
        .get(
          "http://localhost/MERP/backend/index.php/specialty/")
        .then(response => {
          if (response.data.error === false) {
            this.avSpecialties = response.data.specialties
          }
        });
    }
  },
  mounted() {
    this.setScreenName();
    this.loadSpecialties();
    this.loadPatients();
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





