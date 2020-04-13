<template>
    <div>
        <div class="col-xs-2 col-sm-4">
            <div class="dropdown language">
                <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{$t('pages.choose_language')}}
                </button>
                <div class="dropdown-menu rounded-0" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" @click.prevent="changeLang('en')">{{$t('pages.english')}}</a>
                    <a class="dropdown-item" href="#" @click.prevent="changeLang('ar')">{{$t('pages.arabic')}}</a>
                </div>
            </div>
        </div><!--/.col-sm-4-->
        <div class="col-xs-10 col-sm-8 clearfix top-links">
            <ul class="">
                <li>
                  <!-- <span class="main" href="">
                    <span class=""><img src="/images/call.png" alt=""></span>
                    <span class="hidden-xs"> {{settings.header_phone}} </span>
                  </span> -->
                  <a class="main" href="tel:{{settings.header_phone}}" id="cartEnable">
                         <span class=""><img src="/images/call.png" alt=""></span>
                    <span class="hidden-xs"> {{settings.header_phone}} </span>
                    </a>
                </li><!--/li-->
                <li>
                    <router-link to="/account/wishlist" class="main" v-if="isAuthenticated">
                        <span class="">
                            <img src="/images/wishlist2.png" alt="wishlist" />
                        </span>
                        <span class="hidden-xs">{{$t('pages.wishlist')}}</span>
                    </router-link>
                </li><!--/li-->
                <li>
                    <a class="main" href="#" id="cartEnable">
                        <span class="">
                            <img src="/images/cart.png" alt="">
                            <i class="noti">{{counter}}</i>
                        </span>
                        <span class="hidden-xs">{{$t('pages.shopping_cart')}}</span>
                    </a>
                    <cart-box></cart-box>
                </li><!--/li-->
                <li>
                    <a class="main" href="#" data-toggle="modal" data-target="#register" v-if="!isAuthenticated">
                        <span class=""><img src="/images/user.png" alt=""></span>
                        <span class="hidden-xs">{{$t('pages.register')}}</span>
                    </a>
                </li><!--/li-->
                <register-modal></register-modal>
                <li>
                    <a class="main" href="#" data-toggle="modal" data-target="#login_modal" v-if="!isAuthenticated">
                        <span class=""><img src="/images/login.png" alt=""></span>
                        <span class="hidden-xs">{{$t('pages.login')}}</span>
                    </a>
                </li><!--/li-->
                <login-modal></login-modal>

                <li>
                    <router-link to="/account/dashboard" class="main" v-if="isAuthenticated">
                        <span class="">
                            <img src="/images/user.png" alt="My account" />
                        </span>
                        <span class="hidden-xs">{{$t('pages.account')}}</span>
                    </router-link>
                </li><!--/li-->
                <li>
                    <a href="#" @click.prevent="submit" class="main" v-if="isAuthenticated">
                        <span class=""><img src="/images/login.png" alt=""></span>
                        <span class="hidden-xs">{{$t('pages.logout')}}</span>
                    </a>
                </li><!--/li-->
                <li>
                    <a class="main" href="#search">
                        <span class=""><img src="/images/search.png" alt=""></span>
                    </a>
                </li><!--/li-->
            </ul>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import { mapActions } from 'vuex';
    import cartBox from "../Cart-Box";
    import loginModal from "../login-modal";
    import registerModal from "../register-modal";
    import store from "../../store";

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
            changeLang(currentLang){

                // this.$i18n.locale = lang;
                if(currentLang == 'ar'){
                    $('link[rel="stylesheet"]').each(function () {
                        if (this.href.indexOf('style.css')>=0) {
                            this.href = this.href.replace('style.css', 'style-rtl.css');
                        }
                        if (this.href.indexOf('bootstrap.css')>=0) {
                            this.href = this.href.replace('bootstrap.css', 'bootstrap-rtl.css');
                        }
                    });
                }else{
                    $('link[rel="stylesheet"]').each(function () {
                        if (this.href.indexOf('style-rtl.css')>=0) {
                            this.href = this.href.replace('style-rtl.css', 'style.css');
                        }
                        if (this.href.indexOf('bootstrap-rtl.css')>=0) {
                            this.href = this.href.replace('bootstrap-rtl.css', 'bootstrap.css');
                        }
                    });
                }

                //change i18n default lang to load dictionary
                this.$i18n.locale = currentLang;

                this.$root.$emit('lang_changed', currentLang);

                //persist lang to store
                this.$store
                    .dispatch('langModule/switchLang', currentLang);

            },
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
