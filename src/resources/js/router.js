import Vue from 'vue';
import VueRouter from 'vue-router';
import IndexTalksPage from './pages/IndexTalksPage';
import RegisterPage from "./pages/RegisterPage";
import LoginPage from "./pages/LoginPage";
import store from './store';
import UserTalksPage from "./pages/UserTalksPage";
import CreateTalkPage from "./pages/CreateTalkPage";

Vue.use(VueRouter);

const router = new VueRouter({
    routes: [
        {
            path: '/',
            name: 'index',
            component: IndexTalksPage
        },
        {
            path: '/register',
            name: 'register',
            component: RegisterPage,
            meta: {
                guest: true
            }
        },
        {
            path: '/login',
            name: 'login',
            component: LoginPage,
            meta: {
                guest: true
            }
        },
        {
            path: '/my-talks',
            name: 'user_talks',
            component: UserTalksPage,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/talks/new',
            name: 'add_talk',
            component: CreateTalkPage,
            meta: {
                requiresAuth: true
            }
        },
    ]
});

router.beforeEach((to, from, next) => {
    const isAuthenticated = store.state.isAuthenticated;
    if (to.matched.some(record => record.meta.requiresAuth)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (!isAuthenticated) {
            next({
                name: 'login',
                query: { redirect: to.fullPath }
            })
        } else {
            next()
        }
    } else if(to.matched.some(record => record.meta.guest)) {
        if (isAuthenticated) {
            next({
                name: 'index'
            })
        } else {
            next()
        }
    }
    else {
        next() // make sure to always call next()!
    }
})

export default router;
