<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <router-link :to="{ name: 'album.index' }" class="navbar-brand" href="#">Gallery App</router-link>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto mr-5">
                <li class="nav-item active" v-if="app.user">
                    <router-link :to="{name: 'album.index'}" class="nav-link" href="#">Albums <span class="sr-only">(current)</span></router-link>
                </li>
                <li class="nav-item">
                    <router-link :to="{name: 'album.create'}" class="nav-link" href="#">Create album</router-link>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="#"
                       id="navbarDropdown"
                       role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true"
                       aria-expanded="false">
                        {{ app.user ? app.user.name : "Account"}}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                       <div v-if="!app.user">
                           <router-link :to="{name: 'auth.login'}" class="dropdown-item" >Login</router-link>
                           <router-link :to="{name: 'auth.register'}" class="dropdown-item" >Register</router-link>
                       </div>

                        <a href="javascript:" v-if="app.user" @click="logout" class="dropdown-item">Logout</a>
                    </div>
                </li>


            </ul>
        </div>
    </nav>
</template>

<script>
    export default {
        name: 'navbar',
        props:  ['app'],
        data() {
            return {

            }
        },

        methods: {
            logout() {
                this.app.req.post("auth/logout")
                    .then(response => {
                        this.app.user = null;
                        this.$router.push({name: 'auth.login'})
                    })
            }
        }
    }
</script>
