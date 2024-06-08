import {createRouter, createWebHistory} from 'vue-router'
import Home from "../view/Home/Home.vue"
import Admin from "../view/Admin/Index.vue"
import Registration from "../view//Account/Registration.vue"
import Profile from "../view//Account/Profile.vue"
import Login from "../view//Account/Login.vue"
import Catalog from '../view/Catalog/Index.vue'
import Result from '../view/Catalog/Result.vue'
import ProfileSection from "../components/sections/profile/Profile.vue"
import FavoriteSection from "../components/sections/profile/Favorite.vue"
import CartSection from "../components/sections/profile/Cart.vue"
import Product from "../view/Product/Index.vue";

import AdminUsersSection from "../components/sections/admin/Users.vue";
import AdminOrdersSection from "../components/sections/admin/Orders.vue";
import AdminProductsSection from "../components/sections/admin/Products.vue";
import AdminCategoriesSection from "../components/sections/admin/Categories.vue";
import NotFound from '../components/sections/errors/NotFound.vue'



let routes = [
    {
        path: "/",
        component: Home,
        name: 'home',
        children: [

        ]
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
    {
        path: "/admin",
        component: Admin,
        name: 'admin',
        children: [
            {
                path: "orders",
                component: AdminOrdersSection,
                name: 'orders'
            },
            {
                path: "users",
                component: AdminUsersSection,
                name: 'users'
            },
            {
                path: "products",
                component: AdminProductsSection,
                name: 'products'
            },
            {
                path: "categories",
                component: AdminCategoriesSection,
                name: 'categories'
            },
        ]
    },
    {
        path: "/product/id:id",
        component: Product,
        name: 'Product',
        props: true
    },
    {
        path: "/profile",
        component: Profile,
        name: 'Profile',
        children: [
            {
                path: "me",
                component: ProfileSection,
                name: 'Me'
            },
            {
                path: "favorite",
                component: FavoriteSection,
                name: 'Favorite'
            },
            {
                path: "cart",
                component: CartSection,
                name: 'Cart'
            },
        ]
    },
    {
        path: "/catalog",
        component: Catalog,
        name: 'catalog'
    },
    {
        path: "/catalog/:category/",
        component: Result,
        name: 'result',
        props: true
    },
    {
        path: "/catalog/:category/:subcategory",
        component: Result,
        name: 'result2',
        props: true
    },
    {
        path: "/:patchMatch(.*)*",
        component: NotFound,
        name: "NotFound"
    },
]


let router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
