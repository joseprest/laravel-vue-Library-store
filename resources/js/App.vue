<template>
    <v-app id="main">
        <div class="text-center" style="margin: 20px 0px 20px 0px">
            <span class="text-secondary">Book/Library Store</span>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <!-- for logged-in user-->
                <div class="navbar-nav" v-if="isLoggedIn">
                    <router-link to="/dashboard" class="nav-item nav-link"
                        >Dashboard</router-link
                    >
                    <router-link to="/search" class="nav-item nav-link"
                        >Search</router-link
                    >
                    <router-link to="/libraries" class="nav-item nav-link"
                        >Libraries</router-link
                    >
                    <router-link to="/books" class="nav-item nav-link"
                        >Books</router-link
                    >
                    <a
                        class="nav-item nav-link"
                        style="cursor: pointer"
                        @click="logout"
                        >Logout</a
                    >
                </div>
                <!-- for non-logged user-->
                <div class="navbar-nav" v-else>
                    <router-link to="/" class="nav-item nav-link"
                        >Home</router-link
                    >
                    <router-link to="/about" class="nav-item nav-link"
                        >About</router-link
                    >
                    <router-link to="/login" class="nav-item nav-link"
                        >Login</router-link
                    >
                    <router-link to="/register" class="nav-item nav-link"
                        >Register
                    </router-link>
                </div>
            </div>
        </nav>
        <v-main>
            <v-container>
                <router-view></router-view>
            </v-container>
        </v-main>

        <app-footer></app-footer>
    </v-app>
</template>

<script>
import Footer from "./layouts/Footer.vue";

export default {
    name: "App",
    components: { "app-footer": Footer },
    data() {
        return {
            isLoggedIn: false,
        };
    },
    created() {
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true;
        }
    },
    methods: {
        logout(e) {
            e.preventDefault();
            this.$axios.get("/sanctum/csrf-cookie").then((response) => {
                this.$axios
                    .post("/api/logout")
                    .then((response) => {
                        if (response.data.success) {
                            window.location.href = "/";
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            });
        },
    },
};
</script>
