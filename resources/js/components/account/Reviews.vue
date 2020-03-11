<template>
    <div>
        <my-account-banner
            :bannerTitle="$t('pages.myReviews')"
        ></my-account-banner>

        <div class="container innr-cont-area">
            <div class="row">
                <my-account-sidebar></my-account-sidebar>

                <!--/ Content Here-->
                <div class="col-sm-8 col-md-9 shopping-cart mt-15">
                    <section v-for="review in this.reviews">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="img-bx">
                                    <img :src="'/uploads/'+ review.productImage">
                                </div>
                            </div><!--/.col-sm-3-->
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-lg-8 col-md-7 data">
                                        <h4> {{review.productTitle}} </h4>
                                        <p><strong> {{review.created}} </strong>
                                            <br>
                                            {{review.review}}
                                        </p>
                                    </div>
                                    <div class="col-lg-4 col-md-5 price">
                                        <div class="row">
                                            <div class="rate-cvr clearfix">
                                                <div class="rate">
                                                    <star-rating
                                                        active-color="#e01b22"
                                                        :show-rating="false"
                                                        :rating="review.rate"
                                                        :item-size=30
                                                        border-color="#f4f4f4"
                                                        read-only>
                                                    </star-rating>
                                                </div>
                                            </div>


                                        </div>
                                    </div><!--/.col-md-4-->

                                </div><!--/.row-->
                            </div><!--/.col-sm-9-->
                        </div><!--/.row-->
                    </section><!--/section-->
                </div>
                <!--/.col-sm-9-->
            </div>
        </div><!--/.innr-cont-area-->
    </div>
</template>

<script>
    import myAccountSidebar from "./partials/TheSidebar";
    import myAccountBanner from "./partials/TheBanner";
    import {StarRating} from 'vue-rate-it';

    export default {
        components: {myAccountSidebar, myAccountBanner, StarRating},
        data(){
            return {
                reviews: {

                }
            }
        },
        mounted() {
            axios.get('/api/v1/user/reviews-list')
                .then((response) => {
                    console.log(response.data);
                    this.reviews = response.data;
                });
        },
        methods: {
        }
    }
</script>
