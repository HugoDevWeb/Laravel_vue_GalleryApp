<template>
    <div class="container">
        <spinner v-if="loading"></spinner>
        <div v-else-if="album">
            <div class="jumbotron text-center">
                <h1 class="display-4">{{ album.title }}</h1>
            </div>

            <div class="card">
                <div class="card-header">
                    {{ album.title }}
                    <router-link :to="{name: 'photo.create', params: {albumId: album.id}}" class="float-right">Upload photo</router-link>
                </div>
            </div>

            <div class="row" v-if="album.photos.length > 0" style="margin-top: 25px">
                <div class="col-md-3"  v-for="(photo, index) in album.photos" v-bind:key="index">
                    <div class="card photo" @click="showPhoto(photo)">
                        <img class="card-img-top"
                             :src="baseUrl + '/storage/images/photos/' + photo.file_name"
                             style="height: 250px" />
                        <div class="card-body" style="text-align: center" v-if="photo.desc">
                            <h5 class="card-title">{{ photo.desc }}</h5>
                        </div>
                    </div>
                </div>

            </div>

            <div v-else class="alert alert-secondary" role="alert" style="margin-top: 20px">
                No photos exist.
            </div>

            <photo-big id="photo-big" :app="app" :photo="currentPhoto"></photo-big>
        </div>
    </div>
</template>

<script>
    import PhotoBig from '../components/photo.big'
    export default {

        name: 'album.show',
        components:  {PhotoBig},
        props: ['app'],
        data() {
            return{
                albumId: this.app.$route.params.id,
                album: null,
                loading: false,
                currentPhoto: null,
                baseUrl: BASE_URL,
            }
        },

        mounted() {
            if (this.app.user === null) {
                this.$router.push({name: 'auth.login'})
            } else {
                this.loadAlbum();
            }
        },

        methods: {
            showPhoto(photo) {
                this.currentPhoto = photo;
                $('#photo-big').modal('show')
            },
            loadAlbum() {
                this.loading = true;

                this.app.req.get("album/" + this.albumId)
                    .then(response => {
                        this.album = response.data;
                        this.loading = false;
                    })
            }
        }
    }
</script>

<style scoped>
    .photo {
        cursor: pointer;
        margin-bottom: 25px;
    }
</style>
