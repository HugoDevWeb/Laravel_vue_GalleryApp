<template>
    <div class="container">
        <div class="card mx-0">
            <div class="card-header">Login</div>
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <form @submit.prevent="onSubmit" style="margin: 25px">

                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" v-model="email" class="form-control" :class="{'is-invalid': errorEmail}"
                                   placeholder="Email">
                            <div class="invalid-feedback">
                                {{ errorEmail }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" v-model="password" class="form-control"
                                   :class="{'is-invalid': errorPassword}" placeholder="Password">
                            <div class="invalid-feedback">
                                {{ errorPassword }}
                            </div>
                        </div>

                        <button :disabled="app.loading" type="submit" class="btn btn-secondary">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "auth.login",
        props: ["app"],
        data() {
            return {

                email: '',
                errorEmail: '',

                password: '',
                errorPassword: '',

                errors: [],

            }
        },

        mounted() {
            if (this.app.user) {
                this.app.$router.push({name: 'album.index'})
            }
        },

        methods: {
            onSubmit() {
                this.errors = [];

                let $this = this;


                if (!$this.email) {
                    this.errorEmail = "An Email is required";
                    this.errorEmail.push(this.errorEmail);
                } else if (!this.app.helper.validateEmail(this.email)) {
                    this.errorEmail = "Incorrect email format.";
                    this.errorPassword.push(this.errorPassword);
                } else {
                    this.errorEmail = null;
                }


                if (!$this.password && $this.password.length < 6) {
                    this.errorPassword = "Password has to be at least 6 characters long";
                    this.errorPassword.push(this.errorPassword);
                } else {
                    this.errorPassword = null;
                }

                if (!this.errors.length) {
                    let data = {
                        email: $this.email,
                        password: $this.password,
                    };
                    this.app.req.post('auth/login', data).then(function (response) {
                        if (response.data.id) {
                            $this.app.user = response.data;
                            $this.app.$router.push({name: 'album.index'});
                        } else if (response.data.error === 401) {
                            $this.errorPassword = 'Could not log you in.';
                            $this.email = '';
                            $this.password = '';
                        }
                    });
                }


            }
        }
    }
</script>
