<template>
  <div id="app">
    <div id="nav" v-if="authenticated" >
      <div class="page-container md-layout-column">
        <md-toolbar class="md-primary">
          <md-button class="md-icon-button" @click="showNavigation = true">
            <md-icon>menu</md-icon>
          </md-button>
          <span class="md-title">{{screenName}}</span>
        </md-toolbar>

        <md-drawer :md-active.sync="showNavigation" md-swipeable>
          <md-toolbar class="md-transparent" md-elevation="0">
            <span class="md-title">{{userData.name}}</span>
          </md-toolbar>

          <md-list :md-expand-single="expandSingle">

            <md-list-item @click="toDashboard()" class='button'>
              <md-icon>apps</md-icon>
              <span class="md-list-item-text">Painel de Controle</span>
            </md-list-item>

            <md-list-item md-expand :md-expanded.sync="expandPatient" v-if="userType == 'user'" class='button'>
              <md-icon>list_alt</md-icon>
              <span class="md-list-item-text">Paciente</span>
              <md-list slot="md-expand">
                <md-list-item @click="patient('Cadastro de Paciente', 'add')" class="md-inset">Cadastrar</md-list-item>
                <!-- <md-list-item class="md-inset">Europe</md-list-item> -->
                <!-- <md-list-item class="md-inset">South America</md-list-item> -->
              </md-list>
            </md-list-item>

            <md-list-item md-expand :md-expanded.sync="expandAppointment" v-if="userType == 'user'" class='button'>
              <md-icon>list_alt</md-icon>
              <span class="md-list-item-text">Consultas</span>
              <md-list slot="md-expand">
                <md-list-item @click="appointment('Cadastrar Consulta', 'add')" class="md-inset">Cadastrar</md-list-item>
                <!-- <md-list-item class="md-inset">Europe</md-list-item> -->
                <!-- <md-list-item class="md-inset">South America</md-list-item> -->
              </md-list>
            </md-list-item>

            <md-list-item md-expand :md-expanded.sync="expandDoctor" v-if="userType == 'user'" class='xablau button'>
              <md-icon>person</md-icon>
              <span class="md-list-item-text">Médico</span>
              <md-list slot="md-expand">
                <md-list-item @click="doctor('Cadastrar Médico', 'add')" class="md-inset">Cadastrar</md-list-item>
                <md-list-item @click="doctor('Consulta Médico', 'select')" class="md-inset">Consultar</md-list-item>
                <md-list-item @click="doctor('Excluir Médico', 'delete')" class="md-inset">Excluir</md-list-item>
              </md-list>
            </md-list-item>

            <md-list-item class='button'>
              <md-icon>delete</md-icon>
              <span class="md-list-item-text">Trash</span>
            </md-list-item>

            <md-list-item class='button'>
              <md-icon>error</md-icon>
              <span class="md-list-item-text">Spam</span>
            </md-list-item>

            <md-list-item class='xablau button'>
              <md-icon>exit_to_app</md-icon>
                <span class="md-list-item-text">
                  <router-link class='xablau' to="/login" v-on:click.native="logout()" replace>Logout</router-link>
                </span>
            </md-list-item>
          </md-list>
        </md-drawer>
      </div>
    </div>
    <router-view @authenticated="setAuthenticated" @userData="setUserData" @screenName="setScreenName" @userType="setUserType"/>
  </div>
</template>

<script>
export default {
  name: "App",
  data() {
    return {
      expandAppointment: false,
      expandPatient: false,
      expandDoctor: false,
      expandSingle: false,
      authenticated: false,
      userData: null,
      screenName: null,
      showNavigation: false,
      showSidepanel: false,
      userType: null
    };
  },
  mounted() {
    if (!this.authenticated && this.$router.currentRoute.name != "login") {
      this.$router.replace({ name: "login" });
    }
  },
  methods: {
    patient(screenName, func){
      this.$router.replace({ name: "patient", params:{screenName: screenName, function: func} });
      this.showNavigation = false;  
    },
    appointment(screenName, func){
      this.$router.replace({ name: "appointment", params:{screenName: screenName, function: func} });
      this.showNavigation = false;  
    },
    doctor(screenName, func){
      this.$router.replace({ name: "doctor", params:{screenName: screenName, function: func} });
      this.showNavigation = false;
    },
    setUserType(userType){
      this.userType = userType
    },
    setUserData(userData){
      this.userData = userData;
    },
    setScreenName(screenName){
      this.screenName = screenName;
    },
    setAuthenticated(status) {
      this.authenticated = status;
    },
    logout() {
      this.authenticated = false;
      this.showNavigation = false;
    },
    toDashboard() {
      if (this.$router.currentRoute.name != "dashboard") {
        this.showNavigation = false;
        this.$router.replace({ name: "dashboard", params:{ userType: this.userType, data: this.data}});
        if(this.userType == 'user') this.screenName = 'Painel de Controle'
        else this.screenName = 'Consultas Marcadas'
      }
    }
  }
};
</script>

<style>
body {
  background-color: #f0f0f0;
}
h1 {
  padding: 0;
  margin-top: 0;
}
  .md-app {
    min-height: 350px;
    border: 1px solid rgba(#000, .12);
  }

  .md-drawer {
    width: 230px;
    max-width: calc(100vw - 125px);
  }

  /* .md-content {
    padding: 16px;
  } */
  .button:hover {
    background-color: #cacaca
  }
  .xablau {
    text-decoration: none !important;
    color:rgba(0,0,0,0.87) !important;
  }

  .full-control {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap-reverse;
  }

  .list {
    width: 320px;
  }

  .full-control > .md-list {
    width: 320px;
    max-width: 100%;
    height: 400px;
    display: inline-block;
    overflow: auto;
    border: 1px solid rgba(#000, .12);
    vertical-align: top;
  }

  .control {
    min-width: 250px;
    display: flex;
    flex-direction: column;
    padding: 16px;
  }
</style>
