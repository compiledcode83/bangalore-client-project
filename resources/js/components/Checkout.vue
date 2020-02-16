<template>
    <div>
        <div class="innr-banner fullwidth">
            <img src="images/wishlist-banner.jpg">
            <div class="heading">
                <h2>Checkout</h2>
                <ul class="breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li class="active">Checkout</li>
                </ul>
            </div>
        </div><!--/.banner-->
        <div class="container innr-cont-area">
        <div class="row">
            <div class="col-sm-8 checkout">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" :class="statusFirstPanel" @click.prevent="togglePanel"><a href="#Step1" aria-controls="home" role="tab" data-toggle="tab">
                        <span class="number">01</span><br>
                        Shipping
                    </a></li>
                    <li role="presentation" :class="statusSecondPanel" @click.prevent="togglePanel"><a href="#Step2" aria-controls="profile" role="tab" data-toggle="tab">
                        <span class="number">02</span><br>
                        Payment
                    </a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" :class="'tab-pane ' + statusFirstPanel" id="Step1">
                        <h4>SHIPPING Address</h4>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="box">
                                    <label class="radio-btn">
                                        <input type="radio" name="shippingAddress" value="1" v-model="shippingAddress" >
                                        <span class="checkmark"></span>
                                    </label>
                                    <span class="data">
                                      MOHAMMED AL BAWi<br>
                                      AL SALEM STREET<br>
                                      BLOCK #12<br>
                                      BUILDING NO. 23<br>
                                      SALMIYA<br>
                                    </span>
                                </div>
                            </div><!--/.col-sm-6-->
                            <div class="col-sm-6">
                                <div class="box">
                                    <label class="radio-btn">
                                        <input type="radio" name="shippingAddress" value="2" v-model="shippingAddress" >
                                        <span class="checkmark"></span>
                                    </label>
                                    <span class="data">
                                      MOHAMMED AL BAWi<br>
                                      AL SALEM STREET<br>
                                      BLOCK #12<br>
                                      BUILDING NO. 23<br>
                                      SALMIYA<br>
                                    </span>
                                </div>
                            </div><!--/.col-sm-6-->
                            <div class="col-sm-12">
                                <button class="btn btn-default rounded-0">Add New Address</button>
                            </div>
                        </div>
                        <br>
                        <h4>SHIPPING Address</h4>
                        <div class="mt-10">
                            <label class="checkbox-sml">Use as Billing Address<br>9AM to 5PM, Monday - Friday
                                <input type="checkbox" name="billingShipping" value="1" checked v-model="billingShipping">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="mt-30">
                            <h5>Estimated Time</h5>
                            <span class="text-light">3 - 4 Working Dayss</span>
                        </div>
                        <button class="btn btn-primary rounded-0 pull-right" @click.prevent="togglePanel">NEXT</button>
                    </div>
                    <div role="tabpanel" :class="'tab-pane ' + statusSecondPanel" id="Step2">
                        <h4>CHOOSE A PAYMENT METHOD</h4>
                        <div class="row payment-mthd">
                            <div class="col-xs-6 col-sm-6 col-md-3">
                                <div class="bx">
                                    <label class="checkbox"><img src="images/visa.png">
                                        <input type="radio" name="payment" value="visa" v-model="paymentMethod">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-3">
                                <div class="bx">
                                    <label class="checkbox"><img src="images/master-card.png">
                                        <input type="radio" name="payment" value="master" v-model="paymentMethod">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-3">
                                <div class="bx">
                                    <label class="checkbox"><img src="images/knet.png">
                                        <input type="radio" name="payment" value="knet" v-model="paymentMethod">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-3">
                                <div class="bx">
                                    <label class="checkbox"><img src="images/cod.png">
                                        <input type="radio" name="payment" value="cash" v-model="paymentMethod">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <h4 class="mt-30">BILLING ADDRESS</h4>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="box">
                                    <span class="data">
                                      MOHAMMED AL BAWi<br>
                                      AL SALEM STREET<br>
                                      BLOCK #12<br>
                                      BUILDING NO. 23<br>
                                      SALMIYA<br>
                                    </span>
                                    <a href="#" class="pull-right edit" v-if="!billingShipping">Edit Address</a>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary rounded-0 pull-right" @click.prevent="placeOrder"> Place Order </button>
                    </div>
                </div>
            </div><!--/.col-sm-8-->

            <div class="col-sm-4">
                <div class="side-summary">
                    <h3>SUMMARY</h3>
                    <a class="heading" data-toggle="collapse" data-parent="#stacked-menu" href="#summary" aria-expanded="true">{{itemsCount}} Items in Cart</a>
                    <ul class="collapse in listing" id="summary" aria-expanded="true" style="">
                        <li class="row" v-for="cartItem in cart.items">
                            <div class="col-sm-4 img">
                                <img :src="'/uploads/' + cartItem.product_image">
                            </div>
                            <div class="col-sm-5 pl-0 data">
                                {{cartItem.item_name}}
                                Qty: {{cartItem.product_qty}}<br>
                                <span><strong>Color:</strong> {{cartItem.product_color_name}} </span>
                            </div>
                            <div class="col-sm-3 price">
                                {{cartItem.product_price}} KD
                            </div>
                        </li><!--/li-->
                    </ul><!--/nav-->

                    <div class="col-xs-6 list">
                        SUBTOTAL
                    </div>
                    <div class="col-xs-6 list text-right">
                        KD {{subTotalCart}}
                    </div>
                    <div class="col-xs-6 list" v-if="discount">
                        Discount
                    </div>
                    <div class="col-xs-6 list text-right" v-if="discount">
                        KD {{cart.discount}}
                    </div>
                    <!--                                <div class="col-xs-6 list">-->
                    <!--                                    Delivery-->
                    <!--                                </div>-->
                    <!--                                <div class="col-xs-6 list text-right">-->
                    <!--                                    KD 0.000-->
                    <!--                                </div>-->

                    <div class="total clearfix">
                        <div class="col-xs-6">
                            TOTAL
                        </div>
                        <div class="col-xs-6 text-right">
                            KD {{subTotalCart}}
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div><!--/.innr-cont-area-->
    </div>
</template>

<script>
    import CartService from "../services/CartService";
    export default {

        data(){
            return {
                cart: this.$store.state.cartModule.cart,
                discount: 0,
                shippingAddress: 0,
                billingShipping: false,
                paymentMethod: 'cash',
                statusFirstPanel: 'active',
                statusSecondPanel: '',
                placeOrderResponse: null
            }
        },
        mounted(){
            // User MUST BE authenticated
            this.checkUserAuth();
        },
        methods: {
            checkUserAuth(){
                if (!this.$store.getters['authModule/isAuthenticated']) {

                    this.$swal({
                        title: 'Must login to checkout!',
                        text: "You must login to be able to checkout.",
                        icon: 'info',
                        showCloseButton: true,
                        showCancelButton: true,
                        focusConfirm: true,
                        confirmButtonText: 'Go to login!',
                        cancelButtonText: 'Back to cart!',
                    }).then((result) => {
                        if (result.dismiss === 'cancel') {
                            return this.$router.push({path: '/cart'});
                        }
                        return this.$router.push({path: '/login'});
                    });
                }
            },
            togglePanel(){
                if(this.statusFirstPanel !== ''){
                    this.statusFirstPanel = '';
                    this.statusSecondPanel = 'active';
                }else{
                    this.statusFirstPanel = 'active';
                    this.statusSecondPanel = '';
                }
            },
            placeOrder(){

                CartService.placeOrder()
                    .then((response) => {
                        this.placeOrderResponse = response.data;

                        this.$store
                            .dispatch('clearCart');

                        this.$swal({
                            title: 'Order placed!',
                            text: "Your order has been placed successfully ",
                            icon: 'success',
                        }).then(() => {
                            this.$router.push({
                                path: '/thank-you/'+ this.placeOrderResponse
                            });
                        });
                    })
                    .catch(error => {
                        console.log('There was an error:', error.response)
                    })
            }
        },
        computed: {
            itemsCount(){
                return this.cart.items.length;
            },
            subTotalCart(){
                let total = 0;
                if(this.cart.items.length > 0 ){
                    this.cart.items.forEach(function(item){
                        total += (item.product_price * item.product_qty);
                    });
                }

                return total;
            },
        }
    }
</script>
