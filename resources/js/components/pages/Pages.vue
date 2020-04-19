<template>
    <div>
        <div class="innr-banner fullwidth">
            <img :src="'/uploads/'+responseData.page.banner">
            <div class="heading">
                <h2>{{ responseData.page.title }}</h2>
                <ul class="breadcrumb">
                    <li><a href="/">{{$t('pages.home')}}</a></li>
                    <li class="active">{{ responseData.page.title }}</li>
                </ul>
            </div>
        </div><!--/.banner-->
        <div class="container innr-cont-area">
            <div class="row clients">
                <div class="col-sm-12 terms" v-html='responseData.page.body'></div><!--/.col-sm-12-->
                <ul class="col-sm-12 client-logo" v-if="responseData.page.clientLogos">
                    <li v-for="client in responseData.page.clientLogos">
                        <a :href="client.url" target="blank">
                            <img :src="'/uploads/'+client.image" style="max-width:140px;">
                        </a>
                    </li>
                </ul>
            </div>
        </div><!--/.innr-cont-area-->
    </div>
</template>

<script>

    export default {

        data(){
            return {
                responseData: {
                    page : []
                }
            }
        },
        created() {
            var _this = this;
            this.$root.$on('lang_changed', function(currentLang) {
                _this.loadPageData(currentLang);
            });
        },
        mounted() {
            this.slug = this.$route.params.slug;
            this.loadPageData();
        },
        watch: {
            '$route' (to, from) {
                this.slug = to.params.slug;
                this.loadPageData();
            }
        },
        methods: {
            loadPageData(lang = this.$store.state.langModule.lang){
                axios.get(
                    '/api/v1/static/page/'+this.slug,{
                        headers: {
                            'xLocalization' : lang
                        }}
                ).then((response) => {
                    console.log(response.data);
                    this.responseData = response.data;
                });
            }
        }
    }
</script>
