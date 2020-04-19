<template>
    <div>
        <div class="innr-banner fullwidth">
            <img :src="'/uploads/'+responseData.informations[0].about_img">
            <div class="heading">
            <h2>{{$t('pages.aboutUs')}}</h2>
            <ul class="breadcrumb">
                <li><a href="/">{{$t('pages.home')}}</a></li>
                <li class="active">{{$t('pages.aboutUs')}}</li>
            </ul>
            </div>
        </div><!--/.banner-->

        <div class="container innr-cont-area">
            <div class="row">
                <div class="col-sm-12 about-us">
                   <div v-html='responseData.informations[0].about_description_en'></div>
                    <br>
                    <h4>{{$t('pages.subsidiaries')}}</h4>
                    <div class="subsidiaries-cvr">
                        <ul class="subsi-slides">
                            <li class="slide" v-for="subsidiarie in responseData.subsidiaries">
                                <div class="box">
                                    <img :src="'/uploads/'+subsidiarie.logo">
                                    <p>
                                        {{subsidiarie.description_en}}
                                        <br>
                                        {{$t('pages.visit')}} <a :href="subsidiarie.url" target="blank">{{subsidiarie.url}}</a> {{$t('pages.forMoreInfo')}}.
                                    </p>
                                </div>
                            </li><!--/li-->
                        </ul><!--/ul-->
                    </div>
                </div><!--/.col-sm-12-->
            </div>

            </div><!--/.innr-cont-area-->
    </div>
</template>

<script>

    export default {

        data(){
            return {
                responseData: {
                    informations: [0]
                }
            }
        },
        mounted() {
            axios.get(
                '/api/v1/static/about'
            ).then((response) => {
                this.responseData = response.data;
            });
        },
        updated: function () {
            this.$nextTick(function () {
                // Code that will run only after the
                // entire view has been re-rendered .

                $(".subsi-slides").slick({
                    dots: false,
                    autoplay: false,
                    infinite: true,
                    slidesToShow: 2,
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
            })
        },
        methods: {
        }
    }
</script>
