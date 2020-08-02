import VueRouter from 'vue-router';
import Home from "./routes/Home";
import SingleArticle from "./components/detailcomponents/SingleArticle";
import Articles from './routes/Articles';
import Products from "./routes/Products";
import Videos from "./routes/Videos";
import SingleProduct from "./components/detailcomponents/SingleProduct";
import SingleVideo from "./components/detailcomponents/SingleVideo";
import NotFoundPage from "./routes/NotFoundPage"

let routes = [
    {
        path : '/',
        component : Home
    },
    {
        path: '/articles',
        component : Articles
    },{
        path: '/videos',
        component : Videos
    },
    {
        path: '/products',
        component : Products
    },
    {
        path: '/article/:slug',
        component : SingleArticle
    },
    {
        path: '/product/:slug',
        component : SingleProduct
    },
    {
        path: '/video/:slug',
        component : SingleVideo
    },
    {
        path : "/notFoundPage",
        component : NotFoundPage
    },
    {
        path : "*",
        component : NotFoundPage
    }
];

export default new VueRouter({
    routes
});
