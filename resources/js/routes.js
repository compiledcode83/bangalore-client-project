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
import ProductDetailsCheck from "./components/ProductDetailsCheck";
import NotFound from './components/partials/NotFound';

import About from './components/pages/About';
import Contact from "./components/pages/Contact";
import Services from "./components/pages/Services";
import Media from "./components/pages/Media";
import Pages from "./components/pages/Pages";
import SpecialOffers from "./components/SpecialOffers";

import ForgotPassword from "./components/ForgotPassword";
import ResetPasswordForm from "./components/ResetPasswordForm";
import Layout from "./components/partials/Layout";
import Router from 'vue-router'
import Vue from "vue";

// const routes = new Router({
export default {
    mode: 'history',

    linkActiveClass: 'link-active',

    routes: [
        // {
        //     path: "/:locale",
        //     name: "localezzz",
        //     children: [
        //         {
        //             path: '/products-best',
        //             name: 'best-sellers',
        //             component: BestProductList,
        //         },
        //         {
        //             path: "/categories/:slug",
        //             name: "productListLocale",
        //             component: ProductList,
        //             props: (route) => ({
        //                 filterCategories: route.query.cat,
        //                 filterColor: route.query.color,
        //                 filterMinPrice: route.query.min,
        //                 filterMaxPrice: route.query.max,
        //             })
        //         }
        //     ]
        // },
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
                filterMinPrice: route.query.min,
                filterMaxPrice: route.query.max,
                filterDiscounts: route.query.discount,
            })
        },
        {
            path: '/search',
            component: ProductSearch,
            name: 'searchProducts',
            props: true
        },
        {
            path: '/products-check/:slug',
            name: 'products-check',
            component: ProductDetailsCheck
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
            path: '/account/track/status/:id',
            name: 'account.track.status',
            component: AccountTrackOrderStatus,
            props: true
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
        // { path: '/parent/:id', component: Media,
        //     children: [
        //         {
        //             // UserProfile will be rendered inside User's <router-view>
        //             // when /user/:id/profile is matched
        //             path: 'tt',
        //             component: SpecialOffers
        //         },
        //         {
        //             // UserPosts will be rendered inside User's <router-view>
        //             // when /user/:id/posts is matched
        //             path: 'rr',
        //             component: ForgotPassword
        //         }
        //     ]
        // },
        {
            path: '/offers',
            name: 'offers',
            component: SpecialOffers
        },
        {
            path: '/reset-password',
            name: 'reset-password',
            component: ForgotPassword,
            meta: {
                auth:false
            }
        },
        {
            path: '/reset-password/:token',
            name: 'reset-password-form',
            component: ResetPasswordForm,
            meta: {
                auth:false
            }
        }
    ]
}

// router.beforeEach((to, from, next) => {
//
//     // use the language from the routing param or default language
//     let language = to.params.lang;
//     if (!language) {
//         language = 'en';
//     }
//
//     // set the current language for vuex-i18n. note that translation data
//     // for the language might need to be loaded first
//     Vue.i18n.set(language);
//     next();
//
// });

// export default routes
