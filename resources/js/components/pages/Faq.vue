<template>
    <div>
        <div class="innr-banner fullwidth">
            <img :src="'/uploads/'+banner">
            <div class="heading">
                <h2>{{$t('pages.faq')}}</h2>
                <ul class="breadcrumb">
                    <li><a href="/">{{$t('pages.home')}}</a></li>
                    <li class="active">{{$t('pages.faq')}}</li>
                </ul>
            </div>
        </div><!--/.banner-->
        <div class="container innr-cont-area">
            <div class="row">
                <div class="col-sm-12 faq">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                        <div class="panel panel-default" v-for="item in faqItems">
                            <div class="panel-heading" role="tab" :id="'heading'+item.id">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" :href="'#collapse'+item.id" aria-expanded="false" aria-controls="collapseTwo">
                                    {{item.title}}
                                </a>
                            </div>
                            <div :id="'collapse'+item.id" class="panel-collapse collapse" role="tabpanel" :aria-labelledby="'heading'+item.id">
                                <div class="panel-body">
                                    {{item.description}}
                                </div>
                            </div>
                        </div>
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
                banner: '',
                faqItems: {}
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
                    '/api/v1/static/faq',{
                        headers: {
                            'xLocalization' : lang
                        }}
                ).then((response) => {
                    this.banner = response.data.banner;
                    this.faqItems = response.data.faqItems;
                });
            }
        }
    }
</script>
