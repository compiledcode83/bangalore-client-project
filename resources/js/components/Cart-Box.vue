<template>
    <div class="cart_box" id="cart_bx">
        <div class="cart_contents full-width">
            <h2 v-if="subTotalCart">{{$t('pages.recentlyAddedToCart')}}</h2>
            <h2 v-else="subTotalCart"> {{$t('pages.cartIsEmpty')}} </h2>
            <h1 class="ttl-crt" v-if="itemsCount"> {{itemsCount}} {{$t('pages.items')}} </h1>

            <div class="border_dashed row" v-for="item in cart">
                <div class="col-xs-3">
                    <img :src="'/uploads/' + item.product_image" alt="cart" class="mCS_img_loaded">
                </div>
                <div class="col-xs-9">
                    <div class="row">
                        <div class="col-sm-8 col-xs-8">
                            <h1> {{item.item_name}} </h1>
                            <span class="block">{{$t('pages.qty')}} :
<!--                                {{item.product_qty}}-->
                                <input type="number"
                                       class="form-control"
                                       :min="minimumQty"
                                       name="qty"
                                       v-model.number="item.product_qty"
                                       @change="validateQty(item)"
                                       :disabled="item.status === false"
                                        style="width: 45px;display: inline-block;height: 35px;">
                            </span>
                            <span class="block">{{$t('pages.color')}} : {{item.product_color_name}}</span>
                        </div>
                        <div class="col-sm-4 col-xs-4">
                            <h3>{{$t('pages.kd')}} {{item.product_price}}</h3>
                            <h3 class="cart-btnx crt-mt-10">
                                <a href="#" @click.prevent="activateCartQtyInput(item.product_attribute_id)">
                                    <img :src="imageStatus(item)" alt="" style="width: 25%;">
                                </a>
                                <a href="#" class="delete-4-cart" @click.prevent="deleteItemFromCartBox(item)">
                                    <img src="/images/dlt.png">
                                </a>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.border_dashed -->

            <div v-if="subTotalCart" class="col-xs-6">
                <h1 class="crt-total">{{$t('pages.subtotal')}}</h1>
            </div>
            <div v-if="subTotalCart" class="col-xs-6 text-right">
                <h1 class="crt-price-ttl">{{$t('pages.kd')}} {{subTotalCart}}</h1>
            </div>
            <div v-if="calcDiscount" class="col-xs-6">
                <h1 class="crt-total">{{$t('pages.discount')}}</h1>
            </div>
            <div v-if="calcDiscount" class="col-xs-6 text-right">
                <h1 class="crt-price-ttl">{{$t('pages.kd')}} {{calcDiscount}}</h1>
            </div>
            <div v-if="totalCart" class="col-xs-6">
                <h1 class="crt-total">{{$t('pages.total')}}</h1>
            </div>
            <div v-if="totalCart" class="col-xs-6 text-right">
                <h1 class="crt-price-ttl">{{$t('pages.kd')}} {{totalCart}}</h1>
            </div>

        </div>
        <!-- /.cart_contents -->
        <router-link to="/cart" class="button-crt" v-if="subTotalCart">
            {{$t('pages.viewShoppingBag')}}
        </router-link>
    </div><!--/.cart_box-->
</template>

<script>
    export default {
        name: 'cartBox',

        data() {
            return {
                cart: this.$store.state.cartModule.cart.items,
                minimumQty: 1,
                discount: this.calcDiscount ? this.calcDiscount: 0
            }
        },
        mounted(){
            // this.discount = this.calcDiscount();
        },
        methods: {
            validateQty(item){
                if(item.product_qty < this.minimumQty){
                    item.product_qty = this.minimumQty;
                }
                if(item.product_qty > item.stock){
                    item.product_qty = item.stock;
                }
                // check if price need to update
                this.$store
                    .dispatch('updateItemPriceAfterQtyChanged', item)
                    .then(() => {
                        console.log('update success!')
                    })
                    .catch(() => {
                        console.log('There was a problem creating your cart')
                    });
            },
            activateCartQtyInput(itemId){
                let item = this.cart.find(cart => cart.product_attribute_id == itemId);
                //change status => input status
                item.status = !item.status;
                this.validateQty(item);
            },
            imageStatus(item){
                if(item.status){
                    return '/images/save.png';
                }
                return '/images/edit.png';
            },
            deleteItemFromCartBox(item) {
                this.$swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        //delete item
                        this.$store
                            .dispatch('removeItemFromCart', item)
                            .then(() => {
                                this.$swal({
                                    title: 'Deleted!',
                                    text: "Your item has been deleted.",
                                    icon: 'success'
                                });
                            }).then(() => {
                                if(this.itemsCount === 1){
                                    return this.$router.push({path: '/'});
                                }
                            }).catch(() => {
                                console.log('There was a problem removing from your cart')
                            });

                    }
                });
            },
        },
        computed: {
            subTotalCart(){
                let total = 0;
                if(this.cart.length > 0 ){
                    this.cart.forEach(function(item){
                        total += (item.product_price * item.product_qty);
                    });
                }

                return total;
            },
            totalCart(){
                if(this.calcDiscount){
                    return this.subTotalCart - this.calcDiscount;
                }
                return this.subTotalCart;
            },
            itemsCount(){
                return this.cart.length ? this.cart.length : 0;
            },
            calcDiscount(){

                let discount = 0;
                this.cart.forEach(function(item){
                    if(item.product_discount > 0){
                        discount += (item.product_discount * item.product_qty);
                    }
                });

                return discount;

            }
        }
    }
</script>
