<template>
    <div class="cart_box" id="cart_bx">
        <div class="cart_contents full-width">
            <h2 v-if="subTotalCart">recently adDed to cart</h2>
            <h2 v-else="subTotalCart"> cart is empty </h2>
            <h1 class="ttl-crt" v-if="itemsCount"> {{itemsCount}} items </h1>

            <div class="border_dashed row" v-for="item in cart">
                <div class="col-xs-3">
                    <img :src="'/uploads/' + item.product_image" alt="cart" class="mCS_img_loaded">
                </div>
                <div class="col-xs-9">
                    <div class="row">
                        <div class="col-sm-8">
                            <h1> {{item.item_name}} </h1>
                            <span class="block">Qty : {{item.product_qty}}</span>
                            <span class="block">Color : {{item.product_color_name}}</span>
                        </div>
                        <div class="col-sm-4">
                            <h3>KD {{item.product_price}}</h3>
                            <h3 class="cart-btnx crt-mt-10">
                                <a href="#" class="delete-4-cart" @click.prevent="deleteItemFromCartBox(item)">
                                    <img src="/images/dlt.png">
                                </a>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.border_dashed -->

            <div v-if="subTotalCart">
                <h1 class="crt-total">Total</h1>
                <h1 class="crt-price-ttl">KD {{subTotalCart}}</h1>
            </div>
        </div>
        <!-- /.cart_contents -->
        <router-link to="/cart" class="button-crt" v-if="subTotalCart">
            VIEW SHOPPING BAG
        </router-link>
    </div><!--/.cart_box-->
</template>

<script>
    export default {
        name: 'cartBox',

        data() {
            return {
                cart: this.$store.state.cartModule.cart.items,
            }
        },
        methods: {
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
                            })
                            .catch(() => {
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
            itemsCount(){
                return this.cart.length ? this.cart.length : 0;
            }
        }
    }
</script>
