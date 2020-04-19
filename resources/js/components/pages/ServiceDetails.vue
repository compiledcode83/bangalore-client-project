<template>
    <div>
        <div class="innr-banner fullwidth">
            <img :src="'/uploads/'+responseData.services_banner">
            <div class="heading">
                <h2>{{$t('pages.services')}}</h2>
                <ul class="breadcrumb">
                    <li><a href="/">{{$t('pages.home')}}</a></li>
                    <li class="active">{{$t('pages.services')}}</li>
                </ul>
            </div>
        </div><!--/.banner-->

        <div class="container innr-cont-area">
            <router-link to="/services" class="back-spl">{{$t('pages.back')}}</router-link>
            <div class="row media-details">
                <div class="col-md-6 mt-20">
                    <img :src="'/uploads/'+responseData.services.image" width="100%">
                </div>
                <div class="col-md-6">
                    <h4>{{responseData.services.title}}</h4>
                    <div v-html="responseData.services.full_description"></div>
                </div>
            </div>
            <div class="row media-details">
                <div class="col-md-6 mt-30" v-html="responseData.services.short_description">

                </div>
            </div>
        </div><!--/.innr-cont-area-->
    </div>
</template>

<script>

    export default {

        props: ['id'],
        data(){
            return {
                responseData: {
                    services: {}
                },
            }
        },
        created() {
            var _this = this;
            this.$root.$on('lang_changed', function(currentLang) {
                _this.loadData(currentLang);
            });
        },
        mounted() {
            this.loadData();
        },
        methods: {
            loadData(lang = this.$store.state.langModule.lang){
                axios.get(
                    '/api/v1/static/service-details/'+this.id,{
                        headers: {
                            'xLocalization' : lang
                        }}
                ).then((response) => {
                    this.responseData = response.data;
                });
            }
        }
    }
</script>
