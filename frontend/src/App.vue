<template>
  <div id="app">
    <div id="nav" v-if="authenticated" >

      <div class="page-container md-layout-column">
        <md-toolbar class="md-primary">
          <md-button class="md-icon-button" @click="showNavigation = true">
            <md-icon>menu</md-icon>
          </md-button>
          <span class="md-title">{{title}}</span>

          <!-- <div class="md-toolbar-section-end">
            <md-button @click="showSidepanel = true">Favorites</md-button>
          </div> -->
        </md-toolbar>

        <md-drawer :md-active.sync="showNavigation" md-swipeable>
          <md-toolbar class="md-transparent" md-elevation="0">
            <span class="md-title">MERP</span>
          </md-toolbar>

          <md-list>
            <md-list-item class='button'>
              <md-icon>move_to_inbox</md-icon>
              <span class="md-list-item-text">Inbox</span>
            </md-list-item>

            <md-list-item class='button'>
              <md-icon>send</md-icon>
              <span class="md-list-item-text">Sent Mail</span>
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

        <md-drawer class="md-right" :md-active.sync="showSidepanel">
          <md-toolbar class="md-transparent" md-elevation="0">
            <span class="md-title">Favorites</span>
          </md-toolbar>

          <md-list>
            <md-list-item>
              <span class="md-list-item-text">Abbey Christansen</span>

              <md-button class="md-icon-button md-list-action">
                <md-icon class="md-primary">chat_bubble</md-icon>
              </md-button>
            </md-list-item>

            <md-list-item>
              <span class="md-list-item-text">Alex Nelson</span>

              <md-button class="md-icon-button md-list-action">
                <md-icon class="md-primary">chat_bubble</md-icon>
              </md-button>
            </md-list-item>

            <md-list-item>
              <span class="md-list-item-text">Mary Johnson</span>

              <md-button class="md-icon-button md-list-action">
                <md-icon>chat_bubble</md-icon>
              </md-button>
            </md-list-item>
          </md-list>
        </md-drawer>
      </div>
    </div>
    <router-view @authenticated="setAuthenticated" @title="setTitle" />
  </div>
</template>

<script>
export default {
  name: "App",
  data() {
    return {
      authenticated: false,
      title: null,
      showNavigation: false,
      showSidepanel: false
    };
  },
  mounted() {
    if (!this.authenticated && this.$router.currentRoute.name != "login") {
      this.$router.replace({ name: "login" });
    }
  },
  methods: {
    setTitle(title){
      this.title = title;
      console.log(title);
    },
    setAuthenticated(status) {
      this.authenticated = status;
    },
    logout() {
      this.authenticated = false;
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
/* #app {
      width: 1024px;
    margin: auto;
    display: flex;
    align-items: center;
    height: 100vh;
    justify-content: center;
} */

/* .page-container {
    min-height: 100vh;
    overflow: hidden;
    position: relative;
    border: 1px solid rgba(#000, .12);
  } */

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
    text-decoration: none;
    color:rgba(0,0,0,0.87) !important;
  }
</style>
