<template>
    <div>
        <my-account-banner></my-account-banner>

        <div class="container innr-cont-area">
            <div class="row">
                <my-account-sidebar></my-account-sidebar>

                <!--/ Content Here-->
                <div class="col-sm-9 wishlist">
<!--                    <div class="row" v-for="chunk in productChunks">-->
<!--                        <div class="col-sm-4" v-for="product in chunk">-->
<!--                            <ProductBox v-bind:product="product"></ProductBox>-->
<!--                            &lt;!&ndash;/.prod-bx&ndash;&gt;-->
<!--                        </div>-->
<!--                        &lt;!&ndash;/.col-sm-4&ndash;&gt;-->
<!--                    </div>-->
                </div><!--/.col-sm-9-->
                <!--/.col-sm-9-->
            </div>
        </div><!--/.innr-cont-area-->
    </div>
</template>

<script>
    import myAccountSidebar from "./partials/TheSidebar";
    import myAccountBanner from "./partials/TheBanner";
    import ProductBox from "../Product-box";
    import _ from 'lodash';

    export default {
        components: {myAccountSidebar, myAccountBanner, ProductBox},
        data(){
            return {
                products: {}
            }
        },
        mounted() {
            if (this.$store.getters['authModule/isAuthenticated']) {
                axios.get(
                    '/api/v1/account/wishlist',
                    {headers: {
                            "Authorization" : `Bearer ${this.$store.state.authModule.accessToken}`
                        }
                    }
                ).then((response) => {
                    this.products = response.data;
                });
            }else{
                console.log('No authorization');
            }

        },
        computed: {
            productChunks(){
                return _.chunk(Object.values(this.products), 3);
            }
        }
    }
</script>
