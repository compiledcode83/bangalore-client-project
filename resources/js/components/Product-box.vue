<template>
    <div class="prod-bx">
        <div class="img">
            <router-link :to="'/products/'+product.slug">
                <!--                                    <a href="product-details.html">-->
                <img :src="'/uploads/' + product.main_image"
                     @error="onImageLoadFailure($event, '250x250')" style="min-height: 250px">
                <!--                                    </a>-->
            </router-link>
            <div class="hover">
                <a href="#"><img src="/images/favourite.png"></a>
                <!--                                        <a href="#"><img src="/images/cart1.png"></a>-->
            </div>
        </div>
        <div class="data clearfix">
            <h4>{{product.name_en}}</h4>
            <div class="price">
                Login to check price
                <!--                                        24.00 KD <span>30.00 KD</span>-->
            </div>
            <div class="rate-cvr clearfix">
                <div class="rate">
                    <input type="radio" value="5" :checked="product.rating == 5" disabled>
                    <label title="text">5 stars</label>
                    <input type="radio"  value="4" :checked="product.rating == 4" disabled>
                    <label title="text">4 stars</label>
                    <input type="radio" value="3" :checked="product.rating == 3" disabled>
                    <label title="text">3 stars</label>
                    <input type="radio" value="2" :checked="product.rating == 2" disabled>
                    <label title="text">2 stars</label>
                    <input type="radio" value="1" :checked="product.rating == 1" disabled>
                    <label title="text">1 star</label>
                </div>

            </div>
            <div class="btn-group" data-toggle="buttons" v-if="product.colors">
                <label class="btn selct-clr" v-for="color in product.colors" :style="'background:' + color">
                    <input type="radio" name="options" autocomplete="off" chacked="">
                </label>
            </div>
        </div>
        <!--/.data-->
    </div>
</template>

<script>
    export default {
        props: ['product'],
        methods: {
            onImageLoadFailure(event, size) {
                event.target.src = 'https://via.placeholder.com/' + size;
            }
        }
    }
</script>
