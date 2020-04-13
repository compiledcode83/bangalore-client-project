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
                            <span class="block">{{$t('pages.qty')}} : {{item.product_qty}}</span>
                            <span class="block">{{$t('pages.color')}} : {{item.product_color_name}}</span>
                        </div>
                        <div class="col-sm-4 col-xs-4">
                            <h3>{{$t('pages.kd')}} {{item.product_price}}</h3>
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
                <h1 class="crt-total">{{$t('pages.total')}}</h1>
                <h1 class="crt-price-ttl">{{$t('pages.kd')}} {{subTotalCart}}</h1>
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
            itemsCount(){
                return this.cart.length ? this.cart.length : 0;
            }
        }
    }
</script>
