import Home from '../pages/Home';
import About from '../pages/About';
import Register from '../pages/Register';
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';

import Search from '../pages/Search.vue';
import ListLibrary from '../pages/libraries/List.vue';
import AddBook from '../components/AddBook.vue';
import DetailBook from '../components/DetailBook.vue';
import ListBook from '../components/Books.vue';
import EditBook from '../components/EditBook.vue';

import DetailLibrary from "../pages/libraries/Detail.vue"

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'about',
        path: '/about',
        component: About
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard
    },
    {
        name: 'search',
        path: '/search',
        component: Search
    },
    {
        name: 'books',
        path: '/books',
        component: ListBook
    },
    {
        name: 'addbook',
        path: '/books/add',
        component: AddBook
    },
    {
        name: 'editbook',
        path: '/books/edit/:id',
        component: EditBook
    },
    {
        name: 'detailbook',
        path: '/book/:id',
        component: DetailBook
    },
    {
        name: 'libraries',
        path: '/libraries',
        component: ListLibrary
    },
    {
        name: 'detail-library',
        path: '/libraries/:id',
        component: DetailLibrary
    },
];

