<template>
    <div>
        <div class="innr-banner fullwidth">
            <img :src="'/uploads/'+banner">
            <div class="heading">
                <h2>{{$t('pages.sitemap')}}</h2>
                <ul class="breadcrumb">
                    <li><a href="/">{{$t('pages.home')}}</a></li>
                    <li class="active">{{$t('pages.sitemap')}}</li>
                </ul>
            </div>
        </div><!--/.banner-->

        <div class="container innr-cont-area">
            <div class="row">
                <div class="col-sm-12 sitemap">
                    <div class="text-center"><a href="/" class="home">{{$t('pages.home')}}</a></div>
                    <ul>
                        <li v-for="item in categories">
                            <a :href="'categories/'+item.slug" v-if="item.slug">{{item.name_en}}</a>
                        </li>
                        <li v-for="item in pages">
                            <a :href="item.link">{{item.title}}</a>
                        </li>
                    </ul>
                </div><!--/.col-sm-12-->
            </div>

        </div><!--/.innr-cont-area-->

    </div>
</template>

<script>

    export default {

        data(){
            return {
                banner: '',
                pages: {},
                categories: {}
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
                    '/api/v1/static/sitemap',{
                        headers: {
                            'xLocalization' : lang
                        }}
                ).then((response) => {
                    this.banner = response.data.banner;
                    this.pages = response.data.pages;
                    this.categories = response.data.categories;
                });
            }
        }
    }
</script>
