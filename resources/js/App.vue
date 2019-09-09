<template>
    <div>
        <navbar :app="this"></navbar>

        <spinner v-if="loading"></spinner>
        <div v-else>
            <router-view :app="this" class="mt-4"></router-view>
        </div>
    </div>

</template>



<script>
    import Navbar from './components/Navbar'
    import Helper from "./utils/helpers"
    export default{
        name: 'app',
        components: { Navbar },

        data(){
            return {
                req: axios.create({
                    baseURL: BASE_URL
                }),
                user: null,
                loading: false,
                helper: Helper,

            }
        },
        mounted(){
            this.init();
        },
        methods: {
            init(){
                this.loading = true;
                this.req.get('auth/init')
                    .then(response => {
                        if (response.data.id) {
                            this.user = response.data;
                        }

                        this.loading = false;
                    })
            }
        }


    }

</script>






<style>

</style>
