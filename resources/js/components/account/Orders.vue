<template>
    <div>
        <my-account-banner></my-account-banner>

        <div class="container innr-cont-area">
            <div class="row">
                <my-account-sidebar></my-account-sidebar>

                <!--/ Content Here-->
                <div class="col-sm-9 my-order">
                    <div class="heading">Recent Orders <a href="#" class="pull-right">View All</a></div>
                    <div class="table-cvr">
                        <table class="table">
                            <thead>
                            <tr>
                                <th width="15%" scope="col">Order #</th>
                                <th width="15%" scope="col">Date</th>
                                <th width="15%" scope="col">Order Total</th>
                                <th width="15%" scope="col">Status</th>
                                <th width="25%" scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>98766788</td>
                                <td>11/23/18</td>
                                <td>KD 175.00</td>
                                <td>Pending</td>
                                <td>
                                    <router-link to="/account/order/details">
                                        {{$t('pages.view_order')}}
                                    </router-link>
                                    /
                                    <a href="#">Reorder</a>
                                </td>
                            </tr>
                            <tr>
                                <td>9938374</td>
                                <td>11/23/18</td>
                                <td>KD 175.00</td>
                                <td>Pending</td>
                                <td><a href="#">View Order</a> / <a href="#">Reorder</a></td>
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
            }
        },
        mounted() {
        },
        methods: {
        }
    }
</script>
