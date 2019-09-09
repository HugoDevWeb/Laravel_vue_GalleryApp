<template>
    <div class="container">
        <div class="jumbotron text-center">
            <h1 class="display-4">Upload photo</h1>
        </div>

        <div class="card">
            <div class="card-header">Upload Photo</div>
            <input type="file" name="items" data-max-files="1" required style="margin: 20px">
        </div>
    </div>
</template>

<script>
    import * as FilePond from 'filepond';
    import 'filepond/dist/filepond.min.css';

    export default {
        name: 'photo.create',
        props:  ['app'],

        data(){
            return{
                albumId: this.$route.params.albumId
            }
        },

        mounted() {
            if (this.app.user === null) {
                this.app.$router.push({name: 'auth.login'})
            } else {
                const inputElement = document.querySelector('input[type="file"]');

                FilePond.setOptions({
                    server: BASE_URL + '/photo?album_id=' + this.albumId,
                    allowRevert: false,
                    allowMultiple: true,
                    instantUpload: false
                });

                const pond = FilePond.create(inputElement);
                pond.on('processfile', (error, file) => {
                    if (error) {
                        console.log(error);
                    } else {
                        console.log(file);
                        this.goToAlbum(this.albumId);
                    }
                })
            }
        },


        methods: {
            goToAlbum(id){
                this.$router.push({name: 'album.show', params: {id: id}})
            }
        }
    }
</script>

<style scoped>
    .filepond--root{
        margin: 20px;
    }
</style>
