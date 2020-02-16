<template>
    <div class="col-xs-10 col-sm-8 clearfix top-links">
        <ul class="">
            <li>
              <span class="main" href="">
                <span class=""><img src="/images/call.png" alt=""></span>
                <span class="hidden-xs"> {{settings.header_phone}} </span>
              </span>
            </li><!--/li-->
            <li>
                <router-link to="/account/wishlist" class="main" v-if="isAuthenticated">
                    <span class="">
                        <img src="/images/wishlist2.png" alt="wishlist" />
                    </span>
                    <span class="hidden-xs">Wishlist</span>
                </router-link>
            </li><!--/li-->
            <li>
                <a class="main" href="#" id="cartEnable">
                    <span class="">
                        <img src="/images/cart.png" alt="">
                        <i class="noti">{{counter}}</i>
                    </span>
                    <span class="hidden-xs">Shopping Cart</span>
                </a>
                <cart-box></cart-box>
            </li><!--/li-->
            <li>
                <a class="main" href="#" data-toggle="modal" data-target="#register" v-if="!isAuthenticated">
                    <span class=""><img src="/images/user.png" alt=""></span>
                    <span class="hidden-xs">Register</span>
                </a>
            </li><!--/li-->
            <register-modal></register-modal>
            <li>
                <a class="main" href="#" data-toggle="modal" data-target="#login_modal" v-if="!isAuthenticated">
                    <span class=""><img src="/images/login.png" alt=""></span>
                    <span class="hidden-xs">Login</span>
                </a>
            </li><!--/li-->
            <login-modal></login-modal>

            <li>
                <router-link to="/account/dashboard" class="main" v-if="isAuthenticated">
                    <span class="">
                        <img src="/images/user.png" alt="My account" />
                    </span>
                    <span class="hidden-xs">My Account</span>
                </router-link>
            </li><!--/li-->
            <li>
                <a href="#" @click.prevent="submit" class="main" v-if="isAuthenticated">
                    <span class=""><img src="/images/login.png" alt=""></span>
                    <span class="hidden-xs">Logout</span>
                </a>
            </li><!--/li-->
            <li>
                <a class="main" href="#search" >
                    <span class=""><img src="/images/search.png" alt=""></span>
                </a>
            </li><!--/li-->
        </ul>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import { mapActions } from 'vuex';
    import cartBox from "../components/Cart-Box";
    import loginModal from "../components/login-modal";
    import registerModal from "../components/register-modal";

    export default {
        name: 'accountMenu',
        components: {
            cartBox, loginModal, registerModal
        },

        data() {
            return {
                settings: ''
            }
        },
        mounted() {
            axios.get('/api/v1/settings/')
                .then((response) =>{
                    this.settings = response.data;
                });
        },
        methods: {
            ...mapActions('authModule', [
                'logout',
            ]),
            submit() {
                this.logout()
                    .then(() => {
                        this.$router.push({
                            path: '/login'
                        });
                    })
                    .catch((errors) => {
                        // Handle Errors
                        console.log(errors);
                    });
            }
        },
        computed: {
            ...mapGetters('authModule', [
                'isAuthenticated',
            ]),
            counter() {
                return this.$store.state.cartModule.cart.items.length;
            }
        },
    }
</script>
