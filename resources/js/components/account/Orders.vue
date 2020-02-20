<template>
    <div>
        <my-account-banner></my-account-banner>

        <div class="container innr-cont-area">
            <div class="row">
                <my-account-sidebar></my-account-sidebar>

                <!--/ Content Here-->
                <div class="col-sm-9 my-order">
                    <div class="heading">Recent Orders
<!--                        <a href="#" class="pull-right">View All</a>-->
                    </div>
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
                            <tr v-for="order in orders">
                                <td>{{order.order_code}}</td>
                                <td>{{order.created_at}}</td>
                                <td>KD {{order.total}}</td>
                                <td>{{order.final_status}}</td>
                                <td>
                                    <router-link :to="'/account/order/details/' + order.id" >
                                        {{$t('pages.view_order')}}
                                    </router-link> / <a href="#" @click.prevent="tryToReorder(order.id)">Reorder</a>
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
            tryToReorder($orderId){
                axios.post(
                    '/api/v1/account/reorder',
                    {
                        'orderId' : $orderId
                    }
                ).then((response) => {
                    console.log(response.data);

                    //call persistCartItem with response.data
                });
            },
            persistCartItem(){
                let  _this = this;
                this.$store
                    .dispatch('createCalculatedItemPrice', this.cartItem)
                    .then(() => {
                        // this.cart = this.$store.state.cart;
                        this.$swal({
                            title: 'New Item in cart!',
                            text: "Item added to cart successfully!",
                            icon: 'success'
                        });

                        //clean form
                        _this.colorInputs = [];
                        _this.qtyInputs  = [];
                        //delete file from input
                        _this.$refs.file.value = null;
                    })
                    .catch(() => {
                        console.log('There was a problem creating your cart')
                    });
            }
        }
    }
</script>
