<template>
    <div>
        <div class="innr-banner fullwidth">
            <img :src="'/uploads/'+media_banner">
            <div class="heading">
                <h2>{{$t('pages.media')}}</h2>
                <ul class="breadcrumb">
                    <li><a href="/">{{$t('pages.home')}}</a></li>
                    <li class="active">{{$t('pages.media')}}</li>
                </ul>
            </div>
        </div><!--/.banner-->
        <div class="container innr-cont-area">
            <div class="row media" v-for="chunk in mediaChunks">
                <div class="col-sm-4 col-xs-6 w-full media-box" v-for="media in chunk">
                    <img :src="'/uploads/'+media.image">
                    <h4>{{ media.title }}</h4>
                    <span class="date">{{ media.date }}</span>
                    <p v-html="media.short_description.substring(0, 40) + ' ...'"></p>
                    <router-link :to="'media/'+media.id" >{{$t('pages.viewMore')}}</router-link>
                </div><!--/.col-sm-4 col-xs-6 w-full-->
            </div>
            <div class="col-sm-12">
                <div class="text-center d-block" v-if="pagination.total >= 6 && (pagination.last_page > pagination.current_page)">
                    <a class="viewmore-spl" href="#" @click.prevent="loadMoreMediaItems()">{{$t('pages.viewMore')}}</a>
                </div>
            </div>
        </div><!--/.innr-cont-area-->
    </div>
</template>

<script>

    export default {

        data(){
            return {
                media_banner: "",
                mediaItems: {},
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
        computed: {
            mediaChunks(){
                return _.chunk(Object.values(this.mediaItems), 3);
            }
        },
        methods: {
            loadData(lang = this.$store.state.langModule.lang){

                axios.get(
                    '/api/v1/static/media',{
                        headers: {
                            'xLocalization' : lang
                        }}
                ).then((response) => {
                    this.media_banner = response.data.media_banner;
                    this.mediaItems = response.data.mediaItems.data;
                    this.pagination = response.data.mediaItems;
                });
            },
            loadMoreMediaItems(){
                let next_page = this.pagination.current_page + 1;
                axios.get(
                    '/api/v1/static/media?page='+next_page,{
                        headers: {
                            'xLocalization' : this.$store.state.langModule.lang
                        }}
                ).then((response) => {
                    this.pagination = response.data.mediaItems;
                    this.mediaItems.push(...Object.values(response.data.mediaItems.data));
                });
            }
        }
    }
</script>
