<template>
    <div class="col-sm-3">

        <div class="side-navigation">
            <ul>
                <li>
                    <router-link :to="{ name: 'account.dashboard'}">{{$t('pages.accountDashboard')}}</router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'account.info'}">{{$t('pages.accountInformation')}}</router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'account.addresses'}">{{$t('pages.addressBook')}}</router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'account.orders'}">{{$t('pages.myOrders')}}</router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'account.track'}">{{$t('pages.trackMyOrders')}}</router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'account.newsletter'}">{{$t('pages.newsletterSubscriptions')}}</router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'account.reviews'}">{{$t('pages.myProductReviews')}}</router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'account.wishlist'}">{{$t('pages.myWishList')}}</router-link>
                </li>
            </ul>
        </div><!--/.side-navigation-->
        <div class="side-wishlist">
            <h5>{{$t('pages.myWishList')}} <span>{{products.length}} {{$t('pages.items')}}</span> </h5>
            <section v-for="product in products">
                <div class="flex">
                    <img :src="'/uploads/' + product.main_image"
                         @error="onImageLoadFailure($event, '80x100')" style="max-width: 80px">
                    <span><p>{{product.name_en}}</p></span>
                </div>
                <router-link class="btn btn-danger" :to="'/products/'+product.slug"> {{$t('pages.viewItem')}} </router-link>
                <a class="close">
                    <img src="/images/close.jpg" @click.prevent="removeWishItem(product.id)">
                </a>
            </section><!--/section-->
        </div><!--/.side-wishlist-->

    </div><!--/.col-sm-3-->
</template>

<script>
    import EventBus from '../event-bus.js'

    export default {
        name: 'myAccountSidebar',
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

            let _this  = this;
            EventBus.$on('update-wishList-sideBar', function (data) {
                _this.products = data;
            });

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

                                //remove it also from Main
                                EventBus.$emit('update-wishList-main', this.products)
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
