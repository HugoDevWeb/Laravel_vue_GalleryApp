<template>
    <div class="container">
        <div class="card mx-0">
            <div class="card-header">Register</div>
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <form @submit.prevent="onSubmit" style="margin: 25px">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" v-model="name" :class="{'is-invalid': errorName}" placeholder="Name">
                            <div class="invalid-feedback">
                                {{ errorName }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" v-model="email" class="form-control" :class="{'is-invalid': errorEmail}" placeholder="Email">
                            <div class="invalid-feedback">
                                {{ errorEmail }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" v-model="password" class="form-control" :class="{'is-invalid': errorPassword}" placeholder="Password">
                            <div class="invalid-feedback">
                                {{ errorPassword }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Password Again</label>
                            <input type="password" v-model="passwordConf" class="form-control" :class="{'is-invalid': errorPasswordConf}" placeholder="Password Again" >
                            <div class="invalid-feedback">
                                {{ errorPasswordConf }}
                            </div>
                        </div>

                        <button :disabled="app.loading" type="submit" class="btn btn-secondary">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "auth-register",
        props: ["app"],
        data(){
            return{
                name:'',
                errorName:'',

                email:'',
                errorEmail:'',

                password:'',
                passwordConf:'',
                errorPassword: '',
                errorPasswordConf: '',

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

                if (!$this.name) {
                    this.errorName = "A name is required";
                    this.errors.push(this.errorName);
                } else {
                    this.errorName = null;
                }


                if (!$this.email) {
                    this.errorEmail = "An Email is required";
                    this.errors.push(this.errorEmail);
                } else if (!this.app.helper.validateEmail(this.email)) {
                    this.errorEmail = "Incorrect email format.";
                    this.errors.push(this.errorPassword);
                } else {
                    this.errorEmail = null;
                }


                if (!$this.password && $this.password.length < 6) {
                    this.errorPassword = "Password has to be at least 6 characters long";
                    this.errors.push(this.errorPassword);
                } else {
                    this.errorPassword = null;
                }

                if ($this.password !== $this.passwordConf) {
                    this.errorPasswordConf = "You did not enter the same password";
                    this.errors.push(this.errorPasswordConf);
                } else {
                    this.errorPasswordConf = null
                }

                if (!this.errors.length) {
                    let data = {
                        name: $this.name,
                        email: $this.email,
                        password: $this.password
                    };

                    this.app.req.post('auth/register', data)
                        .then(response => {
                            if (response.data.id) {
                                $this.app.user = response.data;
                                $this.app.$router.push({name: 'categories'})
                            } else if (response.data.error === 'email_taken') {
                                $this.errorEmail = 'This email is taken';
                                $this.email = ''
                            }
                        });
                }


            }
        }
    }
</script>
