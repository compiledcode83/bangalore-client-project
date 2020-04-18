<template>

    <div>
        <div class="innr-banner fullwidth">
            <img src="images/wishlist-banner.jpg">
            <div class="heading">
                <h2>{{$t('pages.shoppingCart')}}</h2>
                <ul class="breadcrumb">
                    <li><a href="/">{{$t('pages.home')}}</a></li>
                    <li class="active">{{$t('pages.shoppingCart')}}</li>
                </ul>
            </div>
        </div><!--/.banner-->

        <div class="container innr-cont-area">
            <div class="row">
                <div class="col-sm-12 clearfix filtering mb-15">
                    <div class="pull-left">
                        {{cartItemsCount}} {{$t('pages.items')}}
                    </div>
                </div>
                <div class="col-sm-8 col-md-9 shopping-cart mt-15">
                    <section v-for="cartItem in cart.items">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="img-bx">
                                    <img :src="'/uploads/' + cartItem.product_image">
                                </div>
                            </div><!--/.col-sm-3-->
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-lg-8 col-md-7 data">
                                        <h4> {{cartItem.item_name}} </h4>
                                        <strong>Color</strong> - {{cartItem.product_color_name}}<br>
                                        <p v-if="cartItem.item_description">{{cartItem.item_description}}</p>
                                        <div v-if="cartItem.product_print_image">
                                            <strong>Print Image</strong> - <a :href="cartItem.product_print_image" target="_blank"> Open Print Image </a><br>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-5 price">
                                        <div class="row">
                                            <div class="col-xs-6 pb-5">
                                                {{$t('pages.price')}} <span class="pull-right">:</span>
                                            </div>
                                            <div class="col-xs-6 pb-5">
                                                <strong>{{cartItem.product_price}} {{$t('pages.kd')}}</strong>
                                            </div>
                                            <div class="col-xs-6 pt-5 pb-5">
                                                {{$t('pages.qty')}} <span class="pull-right">:</span>
                                            </div>
                                            <div class="col-xs-6 pt-5 pb-5">
                                                <input type="number"
                                                       class="form-control"
                                                       :min="minimumQty"
                                                       name="qty"
                                                       v-model.number="cartItem.product_qty"
                                                       @change="validateQty(cartItem)"
                                                       :disabled="cartItem.status === false">
                                            </div>
                                            <div class="col-xs-6 pt-5 pb-5">
                                                {{$t('pages.total')}} <span class="pull-right">:</span>
                                            </div>
                                            <div class="col-xs-6 pt-5 pb-5ss">
                                                <strong>{{calcItemTotal(cartItem)}} {{$t('pages.kd')}}</strong>
                                            </div>
                                        </div>
                                    </div><!--/.col-md-4-->
                                    <div class="col-md-12 mt-30">
                                        <div class="pull-left">
                                            <a href="#" class="move" @click.prevent="addToWishList(cartItem.product_attribute_id)">{{$t('pages.moveToWishList')}}</a>
                                        </div>
                                        <div class="pull-right">
                                            <a @click.prevent="activateCartQtyInput(cartItem.product_attribute_id)" class="icons" style="cursor: pointer;">
                                                <img :src="imageStatus(cartItem)">
                                            </a>
                                            <a @click.prevent="deleteItem(cartItem)" class="icons" style="cursor: pointer;"><img src="images/dlt2.png"></a>
                                        </div>
                                    </div>
                                </div><!--/.row-->
                            </div><!--/.col-sm-9-->
                        </div><!--/.row-->
                    </section><!--/section-->
                </div><!--/.col-sm-9-->
                <div class="col-sm-4 col-md-3 mt-15">
                    <div class="summary">
                        <h3>{{$t('pages.summary')}}</h3>
                        <div class="data clearfix">
                            <a class="heading" data-toggle="collapse" data-parent="#stacked-menu" href="#summary" aria-expanded="true">{{$t('pages.estimateShipping')}}</a>
                            <div class="collapse in listing clearfix" id="summary" aria-expanded="true" style="">
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
                                    {{$t('pages.kd')}} {{calcDiscount}}
                                </div>
<!--                                <div class="col-xs-6 list">-->
<!--                                    Delivery-->
<!--                                </div>-->
<!--                                <div class="col-xs-6 list text-right">-->
<!--                                    KD 0.000-->
<!--                                </div>-->
                            </div>
                            <div class="total clearfix">
                                <div class="col-xs-6">
                                    {{$t('pages.total')}}
                                </div>
                                <div class="col-xs-6 text-right">
                                    {{$t('pages.kd')}} {{totalCart}}
                                </div>
                            </div>
                        </div><!--/.data--->
                        <div class="mt-30">
                            <router-link to="/checkout" class="btn-lg btn-success">
                                {{$t('pages.proceedToCheckout')}}
                            </router-link>
                            <router-link to="/" class="btn-lg btn-primary" exact>
                                {{$t('pages.continueShopping')}}
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>

        </div><!--/.innr-cont-area-->
    </div>

</template>

<script>
    export default {
        data(){
            return {
                cart: this.$store.state.cartModule.cart,
                discount: 0,
                minimumQty: 1
            }
        },
        mounted() {
            $('.cart_box').hide(600);
            this.discount = this.calcDiscount;
            console.log(this.cart);
        },
        methods: {
            addToWishList(productId){
                if (this.$store.getters['authModule/isAuthenticated']) {
                    axios.post(
                        '/api/v1/account/wishlist/attribute', {'attributeId': productId},
                        {headers: {
                                "Authorization" : `Bearer ${this.$store.state.authModule.accessToken}`
                            }
                        }
                    ).then((response) => {
                        this.$swal({
                            title: 'Success!',
                            text: "item Added to wishList successfully!",
                            icon: 'success',
                        });
                    });
                }else{
                    console.log('No authorization');
                }

            },
            activateCartQtyInput(itemId){
                let item = this.cart.items.find(cart => cart.product_attribute_id == itemId);
                //change status => input status
                item.status = !item.status;
                this.validateQty(item);
            },
            imageStatus(item){
                if(item.status){
                    return '/images/save.png';
                }
                return '/images/edit2.png';
            },
            calcItemTotal(item){
                return  item.product_price * item.product_qty;
            },
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
            deleteItem(item) {
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
                                }).then(() => {
                                    if(!this.cart.items.length){
                                        this.$router.push({
                                            path: '/'
                                        });
                                    }
                                });
                            })
                            .catch(() => {
                                console.log('There was a problem removing from your cart')
                            });
                    }
                });
            },
        },
        computed: {
            cartItemsCount(){
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
            totalCart(){
                return this.subTotalCart - this.calcDiscount;
            },
            calcDiscount(){

                let discount = 0;
                this.cart.items.forEach(function(item){
                    if(item.product_discount > 0){
                        discount += (item.product_discount * item.product_qty);
                    }
                });

                return discount;

            }
        }

    }
</script>
