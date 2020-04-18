<template>
    <div class="prod-bx">
        <div class="img">
            <router-link :to="'/products/'+product.slug">
                <!--                                    <a href="product-details.html">-->
                <img :src="'/uploads/' + product.main_image"
                     @error="onImageLoadFailure($event, '250x250')" style="min-height: 250px">
                <!--                                    </a>-->
            </router-link>
            <span class="new" v-if="product.newIcon"></span>
        <!--            <div class="hover" :style="'opacity:'+ product.whishlisted">-->
        <!--                <img src="/images/favourite.png" style="cursor: pointer;">-->
        <!--            </div>-->
        </div>
        <div class="data clearfix">
            <h4>{{product.name_en}}</h4>
            <strong class="sku">sku - {{product.sku}}</strong>
            <div class="price" v-if="isAuthenticated">
                <div v-if="product.price  && product.price.discount">
                    {{product.price.discount}} KD <span>{{product.price.baseOriginal}} KD</span>
                </div>
                <div v-else>
                    {{product.price.baseOriginal}} KD
                </div>
            </div>
            <div class="price" v-else>
                {{$t('pages.login_to_check_price')}}
            </div>
            <div class="rate-cvr clearfix">
                <div class="rate">
                    <star-rating
                        active-color="#e01b22"
                        :show-rating="false"
                        :rating="product.rating"
                        :item-size=20
                        border-color="#f4f4f4"
                        read-only>
                    </star-rating>
                </div>
            </div>
            <div class="btn-group" data-toggle="buttons" v-if="product.colors">
                <label class="btn selct-clr" v-for="color in product.colors" :style="'background:' + color + ';cursor: default;'">
                    <input type="radio" name="options" autocomplete="off" chacked="" style="">
                </label>
            </div>
        </div>
        <!--/.data-->
    </div>
</template>

<script>
    import {StarRating} from 'vue-rate-it';
    import {mapGetters} from "vuex";
    export default {
        props: ['product'],
        components:{
            StarRating
        },
        methods: {
            onImageLoadFailure(event, size) {
                event.target.src = 'https://via.placeholder.com/' + size;
            }
        },
        computed: {
            ...mapGetters('authModule', [
                'isAuthenticated',
            ])
        }
    }
</script>
