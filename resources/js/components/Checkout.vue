<template>
    <div>
        <div class="innr-banner fullwidth">
            <img src="images/wishlist-banner.jpg">
            <div class="heading">
                <h2>{{$t('pages.checkout')}}</h2>
                <ul class="breadcrumb">
                    <li><a href="index.html">{{$t('pages.home')}}</a></li>
                    <li class="active">{{$t('pages.checkout')}}</li>
                </ul>
            </div>
        </div><!--/.banner-->
        <div class="container innr-cont-area">
        <div class="row">
                        <div class="col-sm-4 smry">
                <div class="side-summary">
                    <h3>{{$t('pages.summery')}}</h3>
                    <a class="heading" data-toggle="collapse" data-parent="#stacked-menu" href="#summary" aria-expanded="true">{{itemsCount}} {{$t('pages.itemsInCart')}}</a>
                    <ul class="collapse in listing" id="summary" aria-expanded="true" style="">
                        <li class="row" v-for="cartItem in cart.items">
                            <div class="col-sm-4 img">
                                <img :src="'/uploads/' + cartItem.product_image">
                            </div>
                            <div class="col-sm-5 pl-0 data">
                                {{cartItem.item_name}}
                                {{$t('pages.qty')}}: {{cartItem.product_qty}}<br>
                                <span><strong>{{$t('pages.color')}}:</strong> {{cartItem.product_color_name}} </span>
                            </div>
                            <div class="col-sm-3 price">
                                {{cartItem.product_price}} {{$t('pages.kd')}}
                            </div>
                        </li><!--/li-->
                    </ul><!--/nav-->

                    <div class="col-xs-6 list">
                        {{$t('pages.subtotal')}}
                    </div>
                    <div class="col-xs-6 list text-right">
                        {{$t('pages.kd')}} {{subTotalCart}}
                    </div>
                    <div class="col-xs-6 list" v-if="discount">
                        {{$t('pages.discount')}}
                    </div>
                    <div class="col-xs-6 list text-right" v-if="discount">
                        {{$t('pages.kd')}} {{discount}}
                    </div>
                    <div class="col-xs-6 list" v-if="deliveryCharges">
                        Delivery
                    </div>
                    <div class="col-xs-6 list text-right" v-if="deliveryCharges">
                        KD {{deliveryCharges}}
                    </div>

                    <div class="total clearfix">
                        <div class="col-xs-6">
                            {{$t('pages.total')}}
                        </div>
                        <div class="col-xs-6 text-right">
                            {{$t('pages.kd')}} {{calcTotal}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-8 checkout">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" :class="statusFirstPanel" @click.prevent="togglePanel"><a href="#Step1" aria-controls="home" role="tab" data-toggle="tab">
                        <span class="number">01</span><br>
                        {{$t('pages.shipping')}}
                    </a></li>
                    <li role="presentation" :class="statusSecondPanel" @click.prevent="togglePanel"><a href="#Step2" aria-controls="profile" role="tab" data-toggle="tab">
                        <span class="number">02</span><br>
                        {{$t('pages.payment')}}
                    </a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" :class="'tab-pane ' + statusFirstPanel" id="Step1">
                        <h4>{{$t('pages.shippingAddress')}}</h4>
                        <div class="row" v-for="chunk in addressesChunks">
                            <div class="col-sm-6" v-for="address in chunk">
                                <div class="box">
                                    <label class="radio-btn">
                                        <input type="radio" checked="checked" :value="address.id" v-model="shippingAddress">
                                        <span class="checkmark"></span>
                                    </label>
                                    <span class="data">
                                      {{address.governorate}}, {{address.area}}<br>
                                      {{$t('pages.block')}}: {{address.block}}, {{$t('pages.street')}}: {{address.street}}<br>
                                      {{$t('pages.building')}}: {{address.building}}, {{$t('pages.floor')}}: {{address.floorNo}}<br>
                                        <p v-if="address.userType == '1'"> {{$t('pages.home')}}: {{address.house_number}}</p>
                                        <p v-else> {{$t('pages.office')}}: {{address.office_number}}, {{$t('pages.officeAddress')}}: {{address.office_address}}</p>
                                    </span>
                                </div>
                            </div><!--/.col-sm-6-->
                        </div>
                        <div class="col-sm-12" style="padding-left: 0px;padding-bottom: 10px;">
                            <router-link to="/account/addresses" class="btn btn-default rounded-0" exact>{{$t('pages.addNewAddress')}}</router-link>
                        </div>
                        <br>
                        <h4>{{$t('pages.shippingAddress')}}</h4>
                        <div class="mt-10">
                            <label class="checkbox-sml">{{$t('pages.useAsBillingAddress')}}<br>{{$t('pages.workingHoursAndDays')}}
                                <input type="checkbox" name="billingShipping" :value='shippingAddress' checked v-model="billingShipping">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="mt-30">
                            <h5>{{$t('pages.estimatedTime')}}</h5>
                            <span class="text-light" v-if="isPrinting">{{$t('pages.printingShippingDays')}}</span>
                            <span class="text-light" v-else>{{$t('pages.withoutPrintingShippingDays')}} </span>
                        </div>
                        <button class="btn btn-primary rounded-0 pull-right" @click.prevent="togglePanel">{{$t('pages.next')}}</button>
                    </div>
                    <div role="tabpanel" :class="'tab-pane ' + statusSecondPanel" id="Step2">
                        <h4>{{$t('pages.choosePaymentMethod')}}</h4>
                        <div class="row payment-mthd">
                            <div class="col-xs-6 col-sm-6 col-md-3">
                                <div class="bx">
                                    <label class="checkbox"><img :src="'/uploads/'+siteSettings.cod_logo" style="max-width: 84px;max-height: 55px;">
                                        <input type="radio" name="payment" value="cash" v-model="paymentMethod">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-3">
                                <div class="bx">
                                    <label class="checkbox"><img :src="'/uploads/'+siteSettings.tab_logo" style="max-width: 84px;max-height: 55px;">
                                        <input type="radio" name="payment" value="tab" v-model="paymentMethod">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <h4 class="mt-30">{{$t('pages.billingAddress')}}</h4>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="box">
                                    <span class="data" v-if="billingShipping">
                                      {{selectedAddress.governorate}}, {{selectedAddress.area}}<br>
                                      {{$t('pages.block')}}: {{selectedAddress.block}}, {{$t('pages.street')}}: {{selectedAddress.street}}<br>
                                      {{$t('pages.building')}}: {{selectedAddress.building}}, {{$t('pages.floor')}}: {{selectedAddress.floorNo}}<br>
                                        <p v-if="selectedAddress.userType == '1'"> {{$t('pages.home')}}: {{selectedAddress.house_number}}</p>
                                        <p v-else> {{$t('pages.office')}}: {{selectedAddress.office_number}}, {{$t('pages.officeAddress')}}: {{selectedAddress.office_address}}</p>
                                    </span>
                                    <span class="data" v-else>
                                      {{defaultBillingAddress.governorate}}, {{defaultBillingAddress.area}}<br>
                                      {{$t('pages.block')}}: {{defaultBillingAddress.block}}, {{$t('pages.street')}}: {{defaultBillingAddress.street}}<br>
                                      {{$t('pages.building')}}: {{defaultBillingAddress.building}}, {{$t('pages.floor')}}: {{defaultBillingAddress.floorNo}}<br>
                                        <p v-if="defaultBillingAddress.userType == '1'"> {{$t('pages.home')}}: {{defaultBillingAddress.house_number}}</p>
                                        <p v-else> {{$t('pages.office')}}: {{defaultBillingAddress.office_number}}, {{$t('pages.officeAddress')}}: {{defaultBillingAddress.office_address}}</p>
                                    </span>
                                    <router-link to="/account/addresses" class="pull-right edit" v-if="!billingShipping" exact>{{$t('pages.editAddress')}}</router-link>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary rounded-0 pull-right" @click.prevent="placeOrder" :disabled="hasPlacedOrder"> {{$t('pages.placeOrder')}} </button>
                    </div>
                </div>
            </div><!--/.col-sm-8-->



        </div>

    </div><!--/.innr-cont-area-->
    </div>
</template>

<script>
    import _ from 'lodash';
    import CartService from "../services/CartService";
    export default {

        data(){
            return {
                cart: this.$store.state.cartModule.cart,
                discount: 0,
                userAddresses: {},
                shippingAddress: 0,
                billingShipping: false,
                paymentMethod: 'cash',
                statusFirstPanel: 'active',
                statusSecondPanel: '',
                placeOrderResponse: null,
                hasPlacedOrder: false,
                deliveryCharges: null,
                selectedAddress: {},
                defaultBillingAddress: {},
                siteSettings: {},
            }
        },
        watch: {
            shippingAddress : function(value){
                let _this = this;
                this.selectedAddress = this.userAddresses.find(function(element) {
                    return element.id == _this.shippingAddress;
                });
                // User MUST BE authenticated
                this.checkUserAuth();

                axios.post(
                    '/api/v1/checkout/delivery-charges', {id: value},
                    {
                        headers: {
                            "Authorization" : `Bearer ${this.$store.state.authModule.accessToken}`
                        }
                    }
                ).then((response) => {
                    this.deliveryCharges = response.data;
                });
            }
        },
        mounted(){
            this.discount = this.calcDiscount;
            // User MUST BE authenticated
            if(this.cart.length < 1){
                return this.$router.push({path: '/'});
            }
            this.checkUserAuth();

            axios.get(
                '/api/v1/account/checkout/addresses',
                {
                    headers: {
                        "Authorization" : `Bearer ${this.$store.state.authModule.accessToken}`
                    }
                }
            ).then((response) => {
                this.userAddresses = response.data;
                let _this = this;
                this.userAddresses.find(function(element) {
                    if(element.is_default_shipping){
                        _this.shippingAddress = element.id;
                    }

                    if(element.is_default_billing){
                        _this.defaultBillingAddress = element;
                    }
                });
                console.log(this.userAddresses);
            });

            axios.get('/api/v1/settings/')
                .then((response) =>{
                    this.siteSettings = response.data;
                });
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
                if(this.shippingAddress){
                    if(this.statusFirstPanel !== ''){
                        this.statusFirstPanel = '';
                        this.statusSecondPanel = 'active';
                    }else{
                        this.statusFirstPanel = 'active';
                        this.statusSecondPanel = '';
                    }
                }else{
                    this.$swal({
                        title: 'Address missing!',
                        text: "please select address ",
                        icon: 'error',
                    })
                }

            },
            placeOrder(){
                this.hasPlacedOrder = true;

                let _this = this;
                axios.get('/api/v1/settings/')
                    .then((response) =>{
                        if(response.data.enable_offers_page == '0' && this.calcDiscount > 0){
                            this.$swal({
                                title: 'Order Has Discount!',
                                text: "Unfortunately discount Expired! Do you want continue without discount?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Yes, Order without discount!'
                            }).then((result) => {
                                if (result.value) {
                                    this.placeVerifiedOrder();
                                }else{
                                    this.hasPlacedOrder = false;
                                    this.removeDiscount();

                                }
                            });
                        }else{
                            this.placeVerifiedOrder();
                        }
                    });
            },
            placeVerifiedOrder(){
                CartService.placeOrder({'discount':this.calcDiscount,'delivery': this.deliveryCharges,'defaultBillingAddress': this.defaultBillingAddress,'shippingAddress': this.shippingAddress, 'billingShipping': this.billingShipping, 'paymentMethod': this.paymentMethod})
                    .then((response) => {
                        this.placeOrderResponse = response.data;

                        this.$store
                            .dispatch('clearCart');

                        this.$swal({
                            title: 'Order placed!',
                            text: "Your order has been placed successfully ",
                            icon: 'success',
                        }).then(() => {
                            if(!this.placeOrderResponse.cod)
                            {
                                this.$swal({
                                    title: 'Order placed!',
                                    text: "You will be redirect to Payment!",
                                    icon: 'info',
                                }).then(()=>{
                                    window.location.href = this.placeOrderResponse.PaymentUrl;
                                });
                            }
                            else
                            {
                                this.$router.push({
                                    path: '/thank-you/'+ this.placeOrderResponse.orderCode
                                });
                            }

                        });
                    })
                    .catch(error => {
                        this.$swal({
                            title: 'Error!',
                            text: error.response.data.message,
                            icon: 'error',
                        });
                        this.hasPlacedOrder = false;
                        console.log('There was an error:', error.response)
                    });
            },
            removeDiscount(){
                this.cart.items.forEach(function(item){
                    if(item.product_discount > 0){
                        item.product_discount = 0;
                    }
                });
            }
        },
        computed: {
            itemsCount(){
                return this.cart.items.length;
            },
            subTotalCart(){
                console.log(this.cart);
                let total = 0;
                if(this.cart.items.length > 0 ){
                    this.cart.items.forEach(function(item){
                        total += (item.product_price * item.product_qty);
                    });
                }

                return total;
            },
            isPrinting(){
                let printing = 0;
                if(this.cart.items.length > 0 ){
                    this.cart.items.forEach(function(item){
                        if(item.product_print_image !== ''){
                            printing = 1;
                        }
                    });
                }

                return printing;
            },
            addressesChunks(){
                return _.chunk(Object.values(this.userAddresses), 2);
            },
            calcDiscount(){

                let discount = 0;
                this.cart.items.forEach(function(item){
                    if(item.product_discount > 0){
                        discount += (item.product_discount * item.product_qty);
                    }
                });

                return discount;

            },
            calcTotal(){
                return this.subTotalCart + this.deliveryCharges - this.discount;
            }
        }
    }

    $(document).ready(function () {
        $('.radio-btn input').click(function () {
            $('.radio-btn input:not(:checked)').parent().parent().css("border", "3px solid #efefef");
            $('.radio-btn input:checked').parent().parent().css("border", "3px solid #f99d1c");
        });
    });
</script>
