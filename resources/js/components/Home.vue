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
                <h2> {{$t('pages.newArrival_new')}} <span> {{$t('pages.newArrival_arrivals')}} </span></h2>
                <p class="spl">{{$t('pages.newArrival_description')}}</p>
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
                <h2> {{$t('pages.bestSellers_our_best')}} <span> {{$t('pages.bestSellers_sellers')}} </span></h2>
                <p class="spl">{{$t('pages.bestSellers_description')}}</p>
                <ul class="bestseller-slide">
                    <li class="slide" v-for="product in products">
                        <router-link :to="'/products/'+product.slug">
                            <div class="sellerbox">
                                <img :src="'/uploads/' + product.main_image"
                                     @error="onImageLoadFailure($event)" style="width: 370px;height: 360px;">
                                <h3>{{product.name_en}}</h3>
                                <p v-if="product.short_description_en">{{product.short_description_en.replace(/<\/?[^>]+(>|$)/g, "").substring(0, 40) + ' ...'}}</p>
                                <div class="price clearfix">
                                    <div v-if="product.price  && product.price.discount">
                                        <div class="pull-left old"> {{product.price.baseOriginal}} KD</div>
                                        <div class="pull-right new"> {{product.price.discount}} KD</div>
                                    </div>
                                    <div v-if="product.price  && !product.price.discount">
                                        <div class="pull-right new"> {{product.price.baseOriginal}} KD</div>
                                    </div>
                                </div>
                            </div>
                        </router-link>
                    </li><!--/li-->
                </ul><!--/ul-->
                <div class="text-center fullwidth">
                    <router-link :to="'/products-best'" class="view-all">
                        {{$t('pages.bestSellers_view_all')}}
                    </router-link>
                </div>
            </div><!--/.container-->
        </div><!--/.best-sellers-->

        <div class="special-offr fullwidth" v-if="offers && siteSettings.enable_offers_page">
            <div class="container">
                <h2> {{$t('pages.specialOffers_special')}} <span>{{$t('pages.specialOffers_offers')}}</span></h2>
                <p class="spl">{{$t('pages.specialOffers_description')}}</p>
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
                                    <a class="more":href="offer.link"> {{$t('pages.specialOffers_more')}} </a>
                                </div>
                        </div><!--/.offr-box-->
                    </div><!--/.col-sm-4-->
                </div><!--/.row-->
            </div><!--/.container-->
        </div><!--/.special-offr-->

        <div class="container">
            <div class="register-home clearfix">
                <div class="col-sm-8">
                    <h3> {{$t('pages.registerNow_title')}} </h3>
                    <p> {{$t('pages.registerNow_description')}} </p>
                </div><!--/.col-sm-8-->
                <div class="col-sm-4">
                    <button class="btn register" @click="openRegisterModel"> {{$t('pages.registerNow_register')}} </button>
                </div><!--/.col-sm-4-->
            </div><!--/.register-home-->
        </div><!--/.container-->
    </div>
</template>

<script>

    export default {

        created() {

            axios.get('/api/v1/settings/')
            .then((response) =>{
                this.siteSettings = response.data;
            });

            this.loadData();
            this.$Progress.finish();

            let _this = this;
            this.$root.$on('lang_changed', function(currentLang) {
                //reload the component
                console.log('lang chnaged');
                axios.all([
                    axios.get('/api/v1/home-sliders', {headers: {'xLocalization' : currentLang}}),
                    axios.get('/api/v1/home-arrivals', {headers: {'xLocalization' : currentLang}}),
                    axios.get('/api/v1/home-offers', {headers: {'xLocalization' : currentLang}}),
                    axios.get('/api/v1/home-best-sellers', {headers: {'xLocalization' : currentLang}})
                ]).then(axios.spread((slidersResponse, arrivalsResponse, offersResponse, bestSellersResponse) => {

                        _this.slides     = slidersResponse.data;
                        _this.arrivals   = arrivalsResponse.data;
                        _this.offers     = offersResponse.data;
                        _this.products   = bestSellersResponse.data;

                    }));
            })

        },

        updated: function () {
            this.$nextTick(function () {
                // Code that will run only after the
                // entire view has been re-rendered
                if(!this.slidersRunning){

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

                    this.slidersRunning = true;
                }

                $('.register').click(function(){
                    $('#Register').modal('show');
                });
            })
        },

        methods: {
            openRegisterModel() {
                $('#register').modal('show');
            },
            onImageLoadFailure (event) {
                event.target.src = '/images/default-product.jpg'
            },
            loadData(){
                axios.all([
                    axios.get('/api/v1/home-sliders', {headers: {'xLocalization' : this.$store.state.langModule.lang}}),
                    axios.get('/api/v1/home-arrivals', {headers: {'xLocalization' : this.$store.state.langModule.lang}}),
                    axios.get('/api/v1/home-offers', {headers: {'xLocalization' : this.$store.state.langModule.lang}}),
                    axios.get('/api/v1/home-best-sellers', {
                        headers: {
                            'xLocalization' : this.$store.state.langModule.lang,
                            "Authorization": `Bearer ${this.$store.state.authModule.accessToken}`
                        }})
                ])
                    .then(axios.spread((slidersResponse, arrivalsResponse, offersResponse, bestSellersResponse) => {

                        this.slides     = slidersResponse.data;
                        this.arrivals   = arrivalsResponse.data;
                        this.offers     = offersResponse.data;
                        this.products   = bestSellersResponse.data;

                        console.log(this.products)

                    }));
            }
        },

        data: function () {
            return {
                slides: null,
                arrivals: null,
                offers: null,
                products: null,
                slidersRunning: false,
                siteSettings: {}
            }
        }
    }
</script>
