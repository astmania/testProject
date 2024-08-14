import { createRouter, createWebHashHistory } from 'vue-router';
import form from '../components/form.vue';
import notFound from '../components/404.vue';

const routes = [
    { path: '/', component: form },
    { path: '/:pathMatch(.*)*', component: notFound },
];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

export default router;
