<template>
    <div>
        <my-account-banner
            :bannerTitle="$t('pages.viewOrder')"
        ></my-account-banner>

        <div class="container innr-cont-area">
            <div class="row">
                <div class="col-sm-12 col-md-9 view-orderspage mt-15">
                    <h5><small>{{$t('pages.orderId')}}:</small> # {{orderDetails.order_code}} </h5><h5><small>{{$t('pages.orderDate')}} :</small> {{orderDetails.created_at}}</h5>


                    <div class="table-cvr">
                        <table>
                            <thead>
                            <tr>
                                <th width="50%">Item</th>
                                <th width="8%" style="text-align:center; ">{{$t('pages.qty')}}</th>
                                <th width="15%" style="text-align:center">{{$t('pages.amountPerUnit')}}</th>
                                <th width="11%" style="text-align:center">{{$t('pages.total')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in orderDetails.order_items">
                                <td>
                                    <div class="item-nameimage-hold">
                                        <div class="cart-page-pro-image-icon">
                                            <img :src="'/uploads/' + item.product_attribute_value.main_images[0]">
                                        </div>
                                        <div class="cartpage-pro-values smallbtn">
                                            <h4> {{item.product_attribute_value.product.name_en}}</h4>
                                            <div class="vendorname-m-over-cart"> {{$t('pages.color')}}
                                                <div :title="item.product_attribute_value.attribute_value.value_en" :style="'margin-bottom: 2px;width: 20px; height: 20px; background-color:' +item.product_attribute_value.attribute_value.other_value"></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="cart-page-pro-status confirmed">
                                        <div class="status-txt"> {{item.qty}} </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="item-amnt">
                                        {{$t('pages.kd')}} {{item.unit_price}}
                                    </div>
                                </td>
                                <td>
                                    <div class="item-amnt">
                                        {{$t('pages.kd')}} {{item.unit_price * item.qty}}
                                    </div>
                                </td>
                            </tr><!--/tr-->

                            </tbody>
                        </table>
                    </div>
                </div><!--/.col-sm-9-->
                <div class="col-sm-12 col-md-3 mt-15 view-orderspage">
                    <div class="summary">
                        <h3>{{$t('pages.orderSummery')}}</h3>
                        <div class="data clearfix">
                            <div class="collapse in listing clearfix" id="summary" aria-expanded="true" style="">
                                <div class="col-xs-12 list">
                                    <small>{{$t('pages.totalAmount')}}</small>
                                    <h4>{{$t('pages.kd')}} {{orderDetails.total}}</h4>
                                </div>
                            </div>
                        </div><!--/.data--->
                    </div>

                    <div class="summary mt-20">
                        <h3>{{$t('pages.shippingAddress')}}</h3>
                        <div class="data clearfix">
                            <div class="col-xs-12">
                                {{orderDetails.address}}
                            </div>
                            <div class="col-xs-12 mt-20 list">
                                <small>{{$t('pages.paymentMethod')}}</small>
                                <h4>{{$t('pages.cash')}}</h4>
                            </div>
                        </div><!--/.data--->
                    </div>

                </div>
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
                orderDetails: {}
            }
        },
        mounted() {
            if (this.$store.getters['authModule/isAuthenticated']) {

                axios.get(
                    '/api/v1/account/orders/'+this.id,
                    {
                        headers: {
                            "Authorization" : `Bearer ${this.$store.state.authModule.accessToken}`
                        }
                    }
                ).then((response) => {
                    console.log(response.data);
                    this.orderDetails = response.data;
                });
            }else{
                console.log('No authorization');
            }
        },
        methods: {
        }
    }
</script>
