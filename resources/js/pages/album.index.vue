<template>
    <div class="container">
        <div class="jumbotron text-center">
            <h1 class="display-4">Albums</h1>
        </div>

        <spinner v-if="loading"></spinner>
        <div class="row" v-else>
            <div class="col-md-3" v-for="(album, index) in albums" :key="index">
                <div class="card album" @click="goToAlbum(album)">
                    <img :src="baseUrl + '/storage/images/photos/' + album.latestPhoto.file_name" class="card-img-top" v-if="album.latestPhoto" style="height: 250px" alt="test">
                    <hr>
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ album.title }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        name: 'album.index',
        props: ['app'],
        data() {
            return {
                baseUrl: BASE_URL,
                albums: null,
                loading: false,
            }
        },

        mounted() {
            if (this.app.user === null) {
                this.$router.push({name: 'auth.login'})
            } else {
                this.getAlbums();
            }
        },

        methods: {
            getAlbums() {
                this.app.req.get('album')
                    .then(response => {
                        this.albums = response.data;
                    })
            },

            goToAlbum(album) {
                this.$router.push({name: 'album.show', params: {id: album.id}} )
            }
        }
    }


</script>

<style>
    .card {
        cursor: pointer;
    }
</style>
