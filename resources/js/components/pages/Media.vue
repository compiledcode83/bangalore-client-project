<template>
    <div>
        <div class="innr-banner fullwidth">
            <img :src="'/uploads/'+responseData.informations[0].media_banner">
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
                    <h4>{{ media.title_en }}</h4>
                    <span class="date">{{ media.date }}</span>
                    <p v-html='media.short_description_en'>{{ media.short_description_en }}</p>
                    <a :href="'media-details/'+media.id">{{$t('pages.viewMore')}}</a>
                </div><!--/.col-sm-4 col-xs-6 w-full-->
            </div>
            <div class="col-sm-12">
                <div class="text-center d-block">
                    <a class="viewmore-spl" href="#">{{$t('pages.viewMore')}}</a>
                </div>
            </div>
        </div><!--/.innr-cont-area-->
    </div>
</template>

<script>

    export default {

        data(){
            return {
                responseData: {
                    informations: [0],
                    medias : []
                }
            }
        },
        mounted() {
            axios.get(
                '/api/v1/static/media'
            ).then((response) => {
                this.responseData = response.data;
            });
        },
        computed: {
            mediaChunks(){
                return _.chunk(Object.values(this.responseData.medias), 3);
            }
        },
        methods: {
        }
    }
</script>
