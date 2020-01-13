import Home from './components/Home';
import About from './components/About';
import ProductList from "./components/ProductList";
import NotFound from './components/NotFound';

export default {
    mode: 'history',

    linkActiveClass: 'link-active',

    routes: [
        {
            path: '*',
            component: NotFound
        },
        {
            path: '/',
            component: Home
        },
        {
            path: '/about',
            component: About
        },
        {
            path: '/categories/:slug',
            component: ProductList
        }
    ]
}
