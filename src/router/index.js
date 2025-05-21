import { createRouter, createWebHistory } from 'vue-router';
import Home from '@/pages/Home.vue';
import Posts from '@/components/Posts.vue';
import PostsView from '@/components/PostsView.vue';
import PostsEdit from '@/components/PostsEdit.vue';
import PostsAdd from '@/components/PostsAdd.vue';
import Login from '@/components/login.vue'; // Pastikan path-nya sesuai

const routes = [
    { path: '/home', name: "home", component: Home },
    { path: '/', name: 'login', component: Login },
    { path: '/posts', name: "posts", component: Posts, meta: { requiresAuth: true } },
    { path: '/posts/add', name: "postsAdd", component: PostsAdd, meta: { requiresAuth: true } },
    { path: '/posts/:id', name: "postsView", component: PostsView, meta: { requiresAuth: true } },
    { path: '/posts/edit/:id', name: "postsEdit", component: PostsEdit, meta: { requiresAuth: true } },
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
});

// Global navigation guard to check authentication
router.beforeEach((to, from, next) => {
    // If the route requires authentication
    if (to.meta.requiresAuth) {
        // Check if there is user data in localStorage (or use any other method for authentication)
        const user = localStorage.getItem('user');
        if (user) {
            next(); // If the user is authenticated, allow access
        } else {
            next('/login'); // Redirect to login page if not authenticated
        }
    } else {
        next(); // If the route does not require authentication, continue normally
    }
});

export default router;
