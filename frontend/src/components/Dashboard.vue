<template>
  <div>
    <div v-if="this.$route.params.userType == 'user'">
      <md-card md-with-hover>
        <md-ripple>
          <md-card-header>
            <div class="md-title">{{this.appointments[0].patient.name}}</div>
            <div class="md-subhead">{{this.appointments[0].doctor.name}}</div>
          </md-card-header>
          <md-card-actions>
            <md-button>Action</md-button>
            <md-button>Action</md-button>
          </md-card-actions>
        </md-ripple>
      </md-card>
    </div>
    <div v-if="this.$route.params.userType == 'doctor'">
      <md-card md-with-hover>
        <md-ripple>
          <md-card-header>
            <div class="md-title">{{this.$route.params.data.name}}</div>
            <div class="md-subhead">It also have a ripple</div>
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
    appointments: null
  }),
  methods: {
    getAppointments(id){
      this.$http
          .get(`http://localhost/MERP/backend/index.php/appointment/?doctorid=id`)
          .then(response => {
            if ( response.data.error === false) {
              this.appointments = response.data.appointments
            } else {

            }
          });
    }
  },
  mounted() {
    this.getAppointments(1)
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