<template>
    <div>
        <my-account-banner
            :bannerTitle="$t('pages.viewOrder')"
        ></my-account-banner>

        <div class="container innr-cont-area">
            <div class="row">
                                <div class="col-sm-12 col-md-3 mt-15 view-orderspage smry">
                    <div class="summary">
                        <h3>{{$t('pages.orderSummery')}}</h3>
                        <div class="data clearfix">
                            <div class="collapse in listing clearfix" id="summary" aria-expanded="true" style="">
                                <div class="col-xs-12 list">
                                    <small>{{$t('pages.subTotal')}}</small>
                                    <h4>{{$t('pages.kd')}} {{orderDetails.sub_total}}</h4>
                                </div>
                                <div class="col-xs-12 list">
                                    <small>{{$t('pages.totalDiscount')}}</small>
                                    <h4>{{$t('pages.kd')}} {{orderDetails.total_discount}}</h4>
                                </div>
                                <div class="col-xs-12 list">
                                    <small>{{$t('pages.deliveryCharges')}}</small>
                                    <h4>{{$t('pages.kd')}} {{orderDetails.delivery_charges}}</h4>
                                </div>
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
                                <h4> {{orderDetails.payment_method}} </h4>
                            </div>
                        </div><!--/.data--->
                    </div>

                </div>
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
                                            <div class="vendorname-m-over-cart" v-if="item.print_image"> {{$t('pages.printImage')}}
                                                 <a :href="'/'+item.print_image" target="_blank" style="color: #337ab7;"> {{$t('pages.openPrintImage')}} </a><br>
                                                <strong> {{printImageStatus(item.is_print_image_accepted)}} </strong>
                                            </div>
                                            <div class="vendorname-m-over-cart" style="padding-top: 10px;"> {{$t('pages.color')}}
                                                <div :title="item.product_attribute_value.attribute_value.value_en" :style="'margin-bottom: -5px;width: 20px;height: 20px;display: inline-table; background-color:' +item.product_attribute_value.attribute_value.other_value"></div>
                                            </div>
                                            <p style="padding-top: 10px;">{{item.product_attribute_value.product.short_description_en.replace(/<\/?[^>]+(>|$)/g, "").substring(0, 40) + ' ...'}}</p>
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
            printImageStatus(status){
                if(status == '0'){
                    return this.$t('pages.printImagePending');
                }
                if(status == '1'){
                    return this.$t('pages.printImageApproved');
                }
                if(status == '2'){
                    return this.$t('pages.printImageRejected');
                }
            }
        }
    }
</script>
