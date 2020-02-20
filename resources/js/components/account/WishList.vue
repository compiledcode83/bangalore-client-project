<template>
    <div>
        <my-account-banner></my-account-banner>

        <div class="container innr-cont-area">
            <div class="row">
                <my-account-sidebar></my-account-sidebar>

                <!--/ Content Here-->
                <div class="col-sm-9 wishlist">
                    <div class="row" v-for="chunk in productChunks">
                        <div class="col-sm-4" v-for="product in chunk" :key="product.id">
                            <div class="prod-bx-cvr">
                                <div class="prod-bx">
                                    <div class="img">
                                        <img :src="'/uploads/' + product.main_image"
                                             @error="onImageLoadFailure($event, '250x250')" style="min-height: 250px">
                                    </div>
                                    <div class="data clearfix">
                                        <h4>{{product.name_en}}</h4>
                                        <div class="price">
                                            Price on request
                                        </div>
                                        <div class="more-data">
                                            <div class="qty">
                                                <div class="flex">
                                                    <router-link class="btn btn-danger" :to="'/products/'+product.slug"> View Item </router-link>
                                                </div>
                                            </div>
                                            <a href="#" class="remove">REMOVE</a>
                                        </div>
                                    </div><!--/.data-->
                                </div><!--/.prod-bx-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/.innr-cont-area-->
    </div>
</template>

<script>
    import myAccountSidebar from "./partials/TheSidebar";
    import myAccountBanner from "./partials/TheBanner";
    import _ from 'lodash';

    export default {
        components: {myAccountSidebar, myAccountBanner},
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
        },
        methods: {
            onImageLoadFailure(event, size) {
                event.target.src = 'https://via.placeholder.com/' + size;
            }
        }
    }
</script>
