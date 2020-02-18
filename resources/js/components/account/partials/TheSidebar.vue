<template>
    <div class="col-sm-3">

        <div class="side-navigation">
            <ul>
                <li>
                    <router-link :to="{ name: 'account.dashboard'}">Account Dashboard</router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'account.info'}">Account Information</router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'account.addresses'}">Address Book</router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'account.orders'}">My Orders</router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'account.track'}">Track My Order</router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'account.newsletter'}">Newsletter Subscriptions</router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'account.reviews'}">My Product Reviews</router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'account.wishlist'}">My Wish List</router-link>
                </li>
            </ul>
        </div><!--/.side-navigation-->
        <div class="side-wishlist">
            <h5>My Wish List <span>{{products.length}} items</span> </h5>
            <section v-for="product in products">
                <div class="flex">
                    <img :src="'/uploads/' + product.main_image"
                         @error="onImageLoadFailure($event, '80x100')" style="max-width: 80px">
                    <span><p>{{product.name_en}}</p></span>
                </div>
                <router-link class="btn btn-danger" :to="'/products/'+product.slug"> View Item </router-link>
                <a class="close"><img src="/images/close.jpg"></a>
            </section><!--/section-->
        </div><!--/.side-wishlist-->

    </div><!--/.col-sm-3-->
</template>

<script>
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

        },
        methods: {
            onImageLoadFailure(event, size) {
                event.target.src = 'https://via.placeholder.com/' + size;
            }
        }
    }
</script>
