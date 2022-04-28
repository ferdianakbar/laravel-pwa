<template>
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <router-link :to="{name: 'home'}" class="navbar-brand">{{$root.siteName}}</router-link>
            <template v-if="$root.darkMode">
                <button type="button" class="btn btn-light" v-on:click="$root.toLightMode">Light Mode</button>
            </template>
            <template v-else>
                <button type="button" class="btn btn-dark" v-on:click="$root.toDarkMode">Dark Mode</button>
            </template>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse " id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <router-link :to="{name: 'home'}" class="nav-link">Home</router-link>
                    </li>

                    <li class="nav-item" v-if="!$root.loggedIn">
                        <router-link :to="{name: 'login'}" class="nav-link">Login</router-link>
                    </li>
                    <template v-if="$root.loggedIn != null && $root.loggedIn">
                        <li class="nav-item">
                            <a v-on:click="logout" href="#" class="nav-link">Logout</a>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import axios from "axios";

export default {
    name: "Navigation",
    methods: {
        logout: function (){
            let _this = this;
            axios.post('/logout').then(function (){
                _this.$cookies.remove('token');
                _this.$axios.defaults.headers.common['Authorization'] = undefined;
                _this.$root.loggedIn = false;
                _this.$router.push({name: 'login'});
            }).catch(function (err){
                console.log(err);
            })
        }
    }
}
</script>
