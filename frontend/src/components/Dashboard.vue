<template>
  <div>
    <div v-if="this.$route.params.userType == 'user'">
      <md-card v-for="appointment in appointments" :key="appointment.id" md-with-hover>
        <md-ripple>
          <md-card-header>
            <div class="md-title">{{appointment.patient.name}}</div>
            <div class="md-subhead">{{appointment.doctor.name}}</div>
          </md-card-header>
          <md-card-actions>
            <md-button>Action</md-button>
            <md-button>Action</md-button>
          </md-card-actions>
        </md-ripple>
      </md-card>
    </div>
    <div v-if="this.$route.params.userType == 'doctor' && this.appointments">
      <md-card v-for="appointment in appointments" :key="appointment.id" md-with-hover>
        <md-ripple>
          <md-card-header>
            <div class="md-title">{{appointment.patient.name}}</div>
            <div class="md-subhead">{{appointment.doctor.name}}</div>
          </md-card-header>

          <md-card-content>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio itaque ea, nostrum odio. Dolores, sed accusantium quasi non.</md-card-content>

          <md-card-actions>
            <md-button>Action</md-button>
            <md-button>Action</md-button>
          </md-card-actions>
        </md-ripple>
      </md-card>
    </div>
  </div>
</template>
<script>
export default {
  name: "Dashboard",
  data: () => ({
    appointments: null,
    userType: null,
    userId: null
  }),
  methods: {
    getAppointments() {
      let id = 0;
      if(this.userType == 'doctor'){
        id = this.userId
      }
      console.log(this.userType)
      this.$http
        .get(
          `http://localhost/MERP/backend/index.php/appointment/?doctorId=` + id
        )
        .then(response => {
          if (response.data.error === false) {
            this.appointments = response.data.appointments;
          } else {
          }
        });
    }
  },
  mounted (){
    this.getAppointments();
  },
  created (){
    this.userId = this.$route.params.data.id
    this.userType = this.$route.params.userType
  }
};
</script>

<style scoped>
.md-card {
  width: 320px;
  margin: 4px;
  display: inline-block;
  vertical-align: top;
}
</style>