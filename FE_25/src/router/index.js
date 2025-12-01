import { createRouter, createWebHistory } from "vue-router"; // cài vue-router: npm install vue-router@next --save

const routes = [
    {
        path : '/',
        component: ()=>import('../layout/wrapper/index.vue'),
        meta :{layout:'default'}
    },
    {
        path : '/trang-chu',
        component: ()=>import('../components/admin/homepage/index.vue'),
        meta :{layout:'default'}
    },
    {
        path : '/khach-hang',
        component: ()=>import('../components/admin/khach-hang/index.vue'),
        meta :{layout:'default'}
    },
    {
        path : '/san-pham',
        component: ()=>import('../components/admin/product/index.vue'),
        meta :{layout:'default'}
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes: routes
})

export default router