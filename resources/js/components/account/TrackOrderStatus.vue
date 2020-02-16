<template>
    <div>
        <my-account-banner></my-account-banner>

        <div class="container innr-cont-area">
            <div class="row">
                <my-account-sidebar></my-account-sidebar>

                <!--/ Content Here-->
                <div class="col-sm-9 trackmy-order">
                    <div class="heading">Order Tracking Status - <strong>456789999</strong></div>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">STATUS</th>
                            <th scope="col">Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Order Placed</td>
                            <td>30 - 11 - 2018 Monday</td>
                        </tr>
                        <tr>
                            <td>Order Shipped</td>
                            <td>01 - 12 - 2018 Tuesday</td>
                        </tr>
                        <tr>
                            <td>Order Delivered</td>
                            <td>03 - 11 - 2018 Thursday</td>
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
