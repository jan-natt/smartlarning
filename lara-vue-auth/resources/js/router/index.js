import { createRouter, createWebHistory } from 'vue-router'
import login from '../views/Login.vue'
import Dashboard from '../views/Dashboard.vue'
import Register from '../views/Register.vue'

const routes = [
    { path: '/', redirect: '/login'},
    {path: '/login', name: 'login', component: login},
    {path: '/register', name: 'register', component: Register},
    {path: '/dashboard', name: 'dashboard', component: Dashboard}
];

export default createRouter({
    history: createWebHistory(),
    routes,
});