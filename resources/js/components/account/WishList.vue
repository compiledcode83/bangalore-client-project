<template>
    <div>
        <my-account-banner
            :bannerTitle="$t('pages.wishList')"
        ></my-account-banner>

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
                                            {{$t('pages.priceOnRequest')}}
                                        </div>
                                        <div class="more-data">
                                            <div class="qty">
                                                <div class="flex">
                                                    <router-link class="btn btn-danger full-width" :to="'/products/'+product.slug"> {{$t('pages.viewItem')}} </router-link>
                                                    <a style="cursor: pointer; margin: 0px 15px; color: #e11b22;     text-transform: uppercase; vertical-align: middle; width: 100%; text-align: center; border: 1px solid #e11b22; line-height: 36px;" class="remove" @click.prevent="removeWishItem(product.id)"> {{$t('pages.remove')}} <span style="" class="glyphicon glyphicon-trash"></span> </a>
                                                </div>
                                            </div>
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
            },
            removeWishItem(productId){
                this.$swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        //delete item
                        if (this.$store.getters['authModule/isAuthenticated']) {
                            axios.get(
                                '/api/v1/account/wishlist/remove/'+productId,
                                {headers: {
                                        "Authorization" : `Bearer ${this.$store.state.authModule.accessToken}`
                                    }
                                }
                            ).then((response) => {
                                this.$swal({
                                    title: 'Deleted!',
                                    text: "Your item has been deleted successfully!",
                                    icon: 'success'
                                });
                                this.products = response.data;
                            });
                        }else{
                            console.log('No authorization');
                        }
                    }
                });
            }
        }
    }
</script>
