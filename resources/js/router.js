import Home from "./page/Home";
import Login from "./page/Login";
import ArticleDetail from "./page/ArticleDetail";
import NotFound from "./page/NotFound";

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/article/:id',
        name: 'article',
        component: ArticleDetail
    },
    {
        path: '/404',
        name: 'notFound',
        component: NotFound
    },

];

export {
    routes
};
