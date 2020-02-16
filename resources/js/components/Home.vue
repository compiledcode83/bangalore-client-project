<template>
    <div>
        <div class="banner fullwidth">
            <ul class="bannerSlider">
                <li class="slide" v-for="slide in slides">
                    <a :href="slide.link" target="_blank">
                        <div class="slide-text">
                            <h2> {{slide.title}} </h2>
                            <H4> {{slide.sub_title}} </H4>
                        </div>
                        <div class="slide-image">
                            <img :src="'/uploads/'+slide.image" alt="" style="width: 1700px;" />
                        </div>
                    </a>
                </li>
            </ul>
        </div><!--/.banner-->

        <div class="new-arrival fullwidth" v-if="arrivals">
            <div class="container">
                <h2>NEW <span>ARRIVALS</span></h2>
                <p class="spl">check out whats new in itc promotions</p>
                <div class="row">
                    <div class="col-sm-4" v-for="newArrival in arrivals.left">
                        <div class="newarrive-box">
                            <a :href="newArrival.link">
                                <img :src="'/uploads/' + newArrival.image"></a>
                            <div class="data">
                                <h3>{{newArrival.title_en}}</h3>
                                <a class="newin" :href="newArrival.link">New In</a>
                            </div>
                        </div><!--/.newarrive-box-->
                    </div><!--/.col-sm-4-->
                    <div class="col-sm-4">
                        <div class="newarrive-box" v-for="newArrival in arrivals.middle">
                            <a :href="newArrival.link">
                                <img :src="'/uploads/' + newArrival.image"></a>
                            <div class="data">
                                <h3>{{newArrival.title_en}}</h3>
                                <a class="newin" :href="newArrival.link">New In</a>
                            </div>
                        </div><!--/.newarrive-box-->
                    </div><!--/.col-sm-4-->
                    <div class="col-sm-4" v-for="newArrival in arrivals.right">
                        <div class="newarrive-box">
                            <a :href="newArrival.link">
                                <img :src="'/uploads/' + newArrival.image"></a>
                            <div class="data">
                                <h3>{{newArrival.title_en}}</h3>
                                <a class="newin" :href="newArrival.link">New In</a>
                            </div>
                        </div><!--/.newarrive-box-->
                    </div><!--/.col-sm-4-->
                </div><!--/.row-->
            </div><!--/.container-->
        </div><!--/.new-arrival-->

        <div class="best-sellers fullwidth">
            <div class="container">
                <h2>OUR BEST <span>SELLERS</span></h2>
                <p class="spl">get the best of itc promotions from this section</p>
                <ul class="bestseller-slide">
                    <li class="slide" v-for="product in products">
                        <div class="sellerbox">
                            <div class="img">
                                <img :src="'/uploads/' + product.main_image"
                                     @error="onImageLoadFailure($event)" style="width: 370px;height: 360px;">
                                <a href="#" class="quick-view" data-toggle="modal" data-target="#QuickView" tabindex="-1">Quick View</a>
                            </div>
                            <h3>{{product.name_en}}</h3>
                            <p>{{product.short_description}}</p>
                            <div class="price clearfix">
<!--                                <div class="pull-left old">KD.420.000</div>-->
                                <div class="pull-right new">KD {{product.individual_unit_price}}</div>
                            </div>
                        </div>
                    </li><!--/li-->
                </ul><!--/ul-->
                <div class="text-center fullwidth">
                    <router-link :to="'/products-best'" class="view-all">
                        view all best sellers
                    </router-link>
                </div>
            </div><!--/.container-->
        </div><!--/.best-sellers-->

        <div class="special-offr fullwidth" v-if="offers">
            <div class="container">
                <h2>Special <span>Offers</span></h2>
                <p class="spl">check out whats new in itc promotions</p>
                <div class="row">
                    <div class="col-sm-4" v-for="offer in offers.left">
                        <div class="offr-box">
                            <a :href="offer.link">
                                <img :src="'/uploads/' + offer.image"></a>
                            <div class="data">
                                <h3>{{offer.title_en}}</h3>
                                <a class="more" :href="offer.link">More</a>
                            </div>
                        </div><!--/.offr-box-->
                    </div><!--/.col-sm-4-->
                    <div class="col-sm-4">
                        <div class="offr-box" v-for="offer in offers.middle">
                            <a :href="offer.link">
                                <img :src="'/uploads/' + offer.image"></a>
                            <div class="data">
                                <h3>{{offer.title_en}}</h3>
                                <a class="more":href="offer.link">More</a>
                            </div>
                        </div><!--/.offr-box-->
                    </div><!--/.col-sm-4-->
                    <div class="col-sm-4" v-for="offer in offers.right">
                        <div class="offr-box">
                            <a :href="offer.link">
                                <img :src="'/uploads/' + offer.image"></a>
                                <div class="data">
                                    <h3>{{offer.title_en}}</h3>
                                    <a class="more":href="offer.link">More</a>
                                </div>
                        </div><!--/.offr-box-->
                    </div><!--/.col-sm-4-->
                </div><!--/.row-->
            </div><!--/.container-->
        </div><!--/.special-offr-->

        <div class="container">
            <div class="register-home clearfix">
                <div class="col-sm-8">
                    <h3>Register NOW </h3>
                    <p>For best experience with ITC Promotions, be our  registered customer.</p>
                </div><!--/.col-sm-8-->
                <div class="col-sm-4">
                    <button class="btn register">REGISTER</button>
                </div><!--/.col-sm-4-->
            </div><!--/.register-home-->
        </div><!--/.container-->

        <!-- Modal For Quick View-->
        <div class="modal fade login-model" id="QuickView" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog quick-view-model" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <img src="/images/close.png">
                        </button>
                        <div class="row">
                            <div class="col-sm-6">
                                <img src="/images/seller1.jpg">
                            </div>
                            <div class="col-sm-6 data">
                                <h3>Johnson's Face</h3>
                                <p class="price">50.00 KD</p>
                                <h5>Available Colors</h5>
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn selct-clr" style="background: #d1bda1;">
                                        <input type="radio" name="options" id="option1" autocomplete="off" chacked="">
                                    </label>
                                    <label class="btn selct-clr" style="background: #232323;">
                                        <input type="radio" name="options1" id="option2" autocomplete="off">
                                    </label>
                                    <label class="btn selct-clr" style="background: #506cbb;">
                                        <input type="radio" name="options2" id="option3" autocomplete="off">
                                    </label>
                                    <label class="btn selct-clr active" style="background: #b5b5b5;">
                                        <input type="radio" name="options3" id="option4" autocomplete="off">
                                    </label>

                                </div>
                                <button class="btn-lg btn-success full-width">ADD TO CART</button>
                            </div>
                        </div>
                    </div><!--/.modal-body-->
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {

        mounted() {

            axios.all([
                axios.get('/api/v1/home-sliders'),
                axios.get('/api/v1/home-arrivals'),
                axios.get('/api/v1/home-offers'),
                axios.get('/api/v1/home-best-sellers')
            ])
            .then(axios.spread((slidersResponse, arrivalsResponse, offersResponse, bestSellersResponse) => {

                this.slides     = slidersResponse.data;
                this.arrivals   = arrivalsResponse.data;
                this.offers     = offersResponse.data;
                this.products   = bestSellersResponse.data;

            }));
        },

        updated: function () {
            this.$nextTick(function () {
                // Code that will run only after the
                // entire view has been re-rendered
                $(".bannerSlider").slick({
                    dots: true,
                    autoplay: false,
                    infinite: true,
                    slidesToShow: 1,
                    slideswToScroll: 1,
                    arrows: false,
                    fade: true,
                    cssEase: 'cubic-bezier(0.7, 0, 0.3, 1)',
                    speed: 900,
                    touchThreshold: 100
                });

                $(".bestseller-slide").slick({
                    dots: false,
                    autoplay: false,
                    infinite: true,
                    slidesToShow: 3,
                    slideswToScroll: 1,
                    arrows: true,
                    responsive: [
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 2
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                arrows: false,
                                centerMode: true,
                                centerPadding: '40px',
                                slidesToShow: 1
                            }
                        }
                    ]
                });

                $('.register').click(function(){
                    $('#Register').modal('show');
                });
            })
        },

        methods: {
            onImageLoadFailure (event) {
                event.target.src = '/images/default-product.jpg'
            }
        },

        data: function () {
            return {
                slides: null,
                arrivals: null,
                offers: null,
                products: null
            }
        }
    }
</script>
