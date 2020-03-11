<template>
    <div>
        <my-account-banner
            :bannerTitle="$t('pages.trackOrders')"
        ></my-account-banner>

        <div class="container innr-cont-area">
            <div class="row">
                <my-account-sidebar></my-account-sidebar>

                <!--/ Content Here-->
                <div class="col-sm-9 my-order">
                    <div class="heading">{{$t('pages.trackRecentOrder')}}
<!--                        <a href="#" class="pull-right">View All</a>-->
                    </div>
                    <div class="table-cvr">
                        <table class="table">
                            <thead>
                            <tr>
                                <th width="15%" scope="col">{{$t('pages.orderNumber')}}</th>
                                <th width="15%" scope="col">{{$t('pages.date')}}</th>
                                <th width="15%" scope="col">{{$t('pages.orderTotal')}}</th>
                                <th width="25%" scope="col">{{$t('pages.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="order in orders">
                                <td>{{order.order_code}}</td>
                                <td>{{order.created_at}}</td>
                                <td>KD {{order.total}}</td>
                                <td>
                                    <router-link :to="'/account/track/status/'+order.id">{{$t('pages.trackOrderStatus')}}</router-link>
                                    <a href=""></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div><!--/.col-sm-9-->
                <!--/.col-sm-9-->
            </div>
        </div><!--/.innr-cont-area-->
    </div>
</template>

<script>
    import myAccountSidebar from "./partials/TheSidebar";
    import myAccountBanner from "./partials/TheBanner";
    export default {
        components: {myAccountSidebar, myAccountBanner},
        data(){
            return {
                orders: {}
            }
        },
        mounted() {
            if (this.$store.getters['authModule/isAuthenticated']) {

                axios.get(
                    '/api/v1/account/orders',
                    {
                        headers: {
                            "Authorization" : `Bearer ${this.$store.state.authModule.accessToken}`
                        }
                    }
                ).then((response) => {
                    this.orders = response.data;
                });
            }else{
                console.log('No authorization');
            }

        },
        methods: {
        }
    }
</script>
