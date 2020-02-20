import Home from './components/Home';
import ProductList from "./components/ProductList";
import ProductDetails from "./components/ProductDetails";
import Login  from "./components/Login";
import Cart from "./components/Cart";
import Checkout from "./components/Checkout";
import CheckoutReceipt from "./components/CheckoutReceipt";
import BestProductList from "./components/BestProductList";
import AccountDashboard from "./components/account/Dashboard";
import AccountAddresses from "./components/account/Addresses";
import AccountInformation from "./components/account/Information";
import AccountNewsLetter from "./components/account/NewsLetter";
import AccountOrders from "./components/account/Orders";
import AccountViewOrder from "./components/account/ViewOrder";
import AccountReviews from "./components/account/Reviews";
import AccountTrackOrders from "./components/account/TrackOrders";
import AccountTrackOrderStatus from "./components/account/TrackOrderStatus";
import AccountWishList from "./components/account/WishList";
import ProductSearch from "./components/ProductSearch";
import NotFound from './components/NotFound';

import About from './components/pages/About';
import Contact from "./components/pages/Contact";
import Services from "./components/pages/Services";
import Media from "./components/pages/Media";
import Pages from "./components/pages/Pages";

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
            name: 'home',
            component: Home
        },
        {
            path: '/categories/:slug',
            component: ProductList,
            name: 'productList',
            props: (route) => ({
                filterCategories: route.query.cat,
                filterColor: route.query.color,
            })
        },
        {
            path: '/search',
            component: ProductSearch,
            name: 'searchProducts',
            props: true
        },
        {
            path: '/products/:slug',
            name: 'products',
            component: ProductDetails
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/cart',
            component: Cart
        },
        {
            path: '/checkout',
            name: 'checkout',
            component: Checkout,
        },
        {
            path: '/thank-you/:code',
            name: 'checkoutReceipt',
            component: CheckoutReceipt,
            props: true,
        },
        {
            path: '/products-best',
            name: 'best-sellers',
            component: BestProductList,
        },
        {
            path: '/account/dashboard',
            name: 'account.dashboard',
            component: AccountDashboard,
        },
        {
            path: '/account/addresses',
            name: 'account.addresses',
            component: AccountAddresses,
        },
        {
            path: '/account/info',
            name: 'account.info',
            component: AccountInformation,
        },
        {
            path: '/account/newsletter',
            name: 'account.newsletter',
            component: AccountNewsLetter,
        },
        {
            path: '/account/orders',
            name: 'account.orders',
            component: AccountOrders,
        },
        {
            path: '/account/order/details/:id',
            name: 'account.order.details',
            component: AccountViewOrder,
            props: true
        },
        {
            path: '/account/reviews',
            name: 'account.reviews',
            component: AccountReviews,
        },
        {
            path: '/account/track',
            name: 'account.track',
            component: AccountTrackOrders,
        },
        {
            path: '/account/track/status',
            name: 'account.track.status',
            component: AccountTrackOrderStatus,
        },
        {
            path: '/account/wishlist',
            name: 'account.wishlist',
            component: AccountWishList,
        },
        //static pages
        {
            path: '/about',
            name: 'pages.about',
            component: About
        },
        {
            path: '/contact',
            name: 'pages.contact',
            component: Contact
        },
        {
            path: '/services',
            name: 'pages.services',
            component: Services
        },
        {
            path: '/media',
            name: 'pages.media',
            component: Media
        },
        {
            path: '/pages/:slug',
            name: 'pages',
            component: Pages
        },
    ]
}
