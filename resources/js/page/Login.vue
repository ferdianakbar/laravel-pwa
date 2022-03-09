<template>
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form>
                            <div class="row mb-3">
                                <label for="email" class="col-md-3 col-form-label text-md-end">Email</label>
                                <div class="col-md-7">
                                    <input type="email" class="form-control"
                                           v-bind:class="[errors.email ? 'is-invalid':'']"
                                           v-model="email"
                                           autocomplete="email" autofocus
                                           id="email" placeholder="your email" name="email" required>

                                    <span v-for=" errMsg in errors.email" class="invalid-feedback">
                                        <strong>{{ errMsg }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="password" class="col-md-3 col-form-label text-md-end">Password</label>
                                <div class="col-md-7">
                                    <input type="password" class="form-control"
                                           v-bind:class="[errors.password ? 'is-invalid':'']"
                                           v-model="password"
                                           v-on:keypress.enter="login"
                                           autocomplete="email" autofocus
                                           id="password" name="password" required>

                                    <span v-for=" errMsg in errors.password" class="invalid-feedback">
                                        <strong>{{ errMsg }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-9 offset-md-3">
                                    <a href="#" class="btn btn-primary" v-on:click="login">
                                        Login
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {saveToken, checkToken} from "../helper";

export default {
    name: "Login",
    data() {
        return {
            email: undefined,
            password: undefined,
            errors: {}
        }
    },
    computed: {
        hasErrors: function () {
            return !_.isEmpty(this.errors);
        }
    },
    beforeMount() {
        checkToken(this);
    },
    methods: {
        login: function () {
            let _this = this;
            axios.post('login', {
                email: _this.email,
                password: _this.password,
                with_token: true
            })
                .then(function (res) {
                    let data = res.data;
                    _this.$router.push({name: 'home'});
                    //token will save for 30 days
                    saveToken(_this, data.access_token, '30d');
                    checkToken(_this);
            })
                .catch(function (err) {
                    if(err.response) {
                        _this.errors = {};
                        let data = err.response.data;
                        _this.errors = data.errors
                    } else {
                        alert(err.messageerror)
                    }
                })
        }
    }
}
</script>

<style scoped>

</style>
