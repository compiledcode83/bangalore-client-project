<template>
    <div>
        <div class="innr-banner fullwidth">
            <img :src="'/uploads/'+services_banner">
            <div class="heading">
                <h2>{{$t('pages.services')}}</h2>
                <ul class="breadcrumb">
                    <li><a href="/">{{$t('pages.home')}}</a></li>
                    <li class="active">{{$t('pages.services')}}</li>
                </ul>
            </div>
        </div><!--/.banner-->

        <div class="container innr-cont-area">
            <div class="row">
                <div class="col-sm-12 services">
                    <section v-for="service in services">
                        <div class="row">
                        <div class="col-sm-3">
                            <img :src="'/uploads/'+service.image">
                        </div>
                        <div class="col-sm-9">
                            <h4>{{ service.title }}</h4>
                            <p v-html='service.short_description'></p>

                            <router-link :to="'service/'+service.id" >{{$t('pages.viewMore')}}</router-link>
                        </div>
                        </div>
                    </section><!--/section-->
                    <div class="text-center d-block" v-if="pagination.total >= 5 && pagination.last_page > pagination.current_page">
                        <a class="viewmore-spl" href="#" @click.prevent="loadMoreServices()">{{$t('pages.viewMore')}}</a>
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
                services_banner: "",
                services: {},
                pagination: {},
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
                console.log(lang);
                axios.get(
                    '/api/v1/static/service',{
                        headers: {
                            'xLocalization' : lang
                        }}
                ).then((response) => {
                    this.services_banner = response.data.services_banner;
                    this.services = response.data.services.data;
                    this.pagination = response.data.services;
                });
            },
            loadMoreServices(){
                let next_page = this.pagination.current_page + 1;
                axios.get(
                    '/api/v1/static/service?page='+next_page,{
                        headers: {
                            'xLocalization' : this.$store.state.langModule.lang
                        }}
                ).then((response) => {
                    this.pagination = response.data.services;
                    this.services.push(...Object.values(response.data.services.data));
                });
            }
        },
    }
</script>
