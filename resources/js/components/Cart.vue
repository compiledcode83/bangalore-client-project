<template>

    <div>
        <div class="innr-banner fullwidth">
            <img src="images/wishlist-banner.jpg">
            <div class="heading">
                <h2>Shopping Cart</h2>
                <ul class="breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li class="active">Shopping Cart</li>
                </ul>
            </div>
        </div><!--/.banner-->

        <div class="container innr-cont-area">
            <div class="row">
                <div class="col-sm-12 clearfix filtering mb-15">
                    <div class="pull-left">
                        {{cartItemsCount}} items
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
                                        <p v-if="cartItem.description">we want to make you sure that all those goods you will find among...</p>
                                    </div>
                                    <div class="col-lg-4 col-md-5 price">
                                        <div class="row">
                                            <div class="col-xs-6 pb-5">
                                                Price <span class="pull-right">:</span>
                                            </div>
                                            <div class="col-xs-6 pb-5">
                                                <strong>{{cartItem.product_price}} KD</strong>
                                            </div>
                                            <div class="col-xs-6 pt-5 pb-5">
                                                Qty <span class="pull-right">:</span>
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
                                                Total <span class="pull-right">:</span>
                                            </div>
                                            <div class="col-xs-6 pt-5 pb-5ss">
                                                <strong>{{calcItemTotal(cartItem)}} KD</strong>
                                            </div>
                                        </div>
                                    </div><!--/.col-md-4-->
                                    <div class="col-md-12 mt-30">
                                        <div class="pull-left">
                                            <a href="#" class="move">Move to Wishlist</a>
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
                        <h3>Summary</h3>
                        <div class="data clearfix">
                            <a class="heading" data-toggle="collapse" data-parent="#stacked-menu" href="#summary" aria-expanded="true">Estimate Shipping And Tax</a>
                            <div class="collapse in listing clearfix" id="summary" aria-expanded="true" style="">
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
                            </div>
                            <div class="total clearfix">
                                <div class="col-xs-6">
                                    total
                                </div>
                                <div class="col-xs-6 text-right">
                                    KD {{totalCart}}
                                </div>
                            </div>
                        </div><!--/.data--->
                        <div class="mt-30">
                            <router-link to="/checkout" class="btn-lg btn-success">
                                Proceed to Checkout
                            </router-link>
                            <router-link to="/" class="btn-lg btn-primary" exact>
                                Continue Shopping
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
        },
        methods: {
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

                return this.subTotalCart - this.discount;
            },
        }

    }
</script>
