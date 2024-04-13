import {createRouter, createWebHistory} from 'vue-router'
import Home from "../components/Home/Home.vue"
import Registration from "../components//Account/Registration.vue"
import Login from "../components//Account/Login.vue"


let routes = [
    {
        path: "/",
        component: Home,
        name: 'home'
    },
    {
        path: "/registration",
        component: Registration,
        name: 'Registration'
    },
    {
        path: "/login",
        component: Login,
        name: 'login'
    },
]


let router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
