import Login from './pages/auth.login'
import Register from './pages/auth.register'
import AlbumCreate from './pages/album.create'
import AlbumIndex from './pages/album.index'
import AlbumShow from './pages/album.show'
import PhotoCreate from './pages/photo.create'

const routes = [
    {
        path: '/login',
        component: Login,
        name: 'auth.login'
    },
    {
        path: '/register',
        component: Register,
        name: 'auth.register'
    },
    {
        path: '/album/create',
        component: AlbumCreate,
        name: 'album.create'
    },
    {
        path: '/',
        component: AlbumIndex,
        name: 'album.index'
    },

    {
        path: '/album/show/:id',
        component: AlbumShow,
        name: 'album.show'
    },
    {
        path: '/photo/create/:albumId',
        component: PhotoCreate,
        name: 'photo.create'
    },


];


export default routes;

