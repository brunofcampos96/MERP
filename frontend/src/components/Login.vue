<template>
    <div id="login">
        <h1>Login</h1>
        <input type="text" name="username" v-model="input.username" placeholder="Username" />
        <input type="password" name="password" v-model="input.password" placeholder="Password" />
        <button type="button" v-on:click="login()">Login</button>
    </div>
</template>
<script>
export default {
    name: 'Login',
    data() {
        return {
            input: {
                username: "",
                password: ""
            }
        }
    },
    methods: {
        login() {
            if(this.input.username != "" && this.input.password != "") {
                this.$http
                    .post('http://localhost/MERP/backend/index.php/user/login',{
                        email: this.input.username,
                        password: this.input.password
                    })
                    .then(response => {
                        this.info = response;
                        this.$emit("authenticated", true);
                        this.$router.replace({ name: "secure" });
                    })
            } else {
                console.log("A username and password must be present");
            }
        }
    }
}
</script>
<style scoped>

</style>