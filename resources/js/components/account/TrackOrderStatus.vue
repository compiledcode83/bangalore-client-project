<template>
    <div>
        <my-account-banner
            :bannerTitle="$t('pages.trackOrderStatus')"
        ></my-account-banner>

        <div class="container innr-cont-area">
            <div class="row">
                <my-account-sidebar></my-account-sidebar>

                <!--/ Content Here-->
                <div class="col-sm-9 trackmy-order">
                    <div class="heading">{{$t('pages.orderTrackingStatus')}} - <strong> {{order.order_code}} </strong></div>
                    <table class="table table-striped">
                        <thead>
                        <tr v-if="order.order_statuses.length > 0">
                            <th scope="col">{{$t('pages.status')}}</th>
                            <th scope="col">{{$t('pages.date')}}</th>
                        </tr>
                        <tr v-else>
                            <th scope="col"> {{$t('pages.orderHasNoRecords')}} </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="orderStatus in order.order_statuses">
                            <td>{{$t('pages.order')}} {{orderStatus.status.name_en}}</td>
                            <td>{{orderStatus.created_at}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div><!--/.col-sm-9-->

                </div><!--/.innr-cont-area-->
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
        props: ['id'],
        data(){
            return {
                order: {
                    order_statuses: {}
                }
            }
        },
        mounted() {
            if (this.$store.getters['authModule/isAuthenticated']) {

                axios.get(
                    '/api/v1/account/order/'+this.id+'/status',
                    {
                        headers: {
                            "Authorization" : `Bearer ${this.$store.state.authModule.accessToken}`
                        }
                    }
                ).then((response) => {
                    this.order = response.data;
                });
            }else{
                console.log('No authorization');
            }
        },
        methods: {
        }
    }
</script>
