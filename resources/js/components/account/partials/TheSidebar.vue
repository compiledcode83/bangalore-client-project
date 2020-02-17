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
            <h5>My Wish List <span>2 items</span> </h5>
            <section>
                <div class="flex">
                    <img src="/images/bag-thumb.jpg">
                    <span><p>Glittered mini<br> backpacks</p></span>
                </div>
                <button class="btn btn-danger">View Item</button>
                <a class="close"><img src="/images/close.jpg"></a>
            </section><!--/section-->
            <section>
                <div class="flex">
                    <img src="/images/bag-thumb.jpg">
                    <span><p>Glittered mini<br> backpacks</p><strong>75.00 KD</strong></span>
                </div>
                <button class="btn btn-danger">View Item</button>
                <a class="close" id="close"><img src="/images/close.jpg"></a>
            </section><!--/section-->
        </div><!--/.side-wishlist-->

    </div><!--/.col-sm-3-->
</template>

<script>
    export default {
        name: 'myAccountSidebar',
        data(){
            return {
            }
        },
        mounted() {
        },
        methods: {
        }
    }
</script>
