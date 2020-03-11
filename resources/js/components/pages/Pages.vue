<template>
    <div>
        <div class="innr-banner fullwidth">
            <img :src="'/uploads/'+responseData.page.banner">
            <div class="heading">
                <h2>{{ responseData.page.title_en }}</h2>
                <ul class="breadcrumb">
                    <li><a href="/">{{$t('pages.home')}}</a></li>
                    <li class="active">{{ responseData.page.title_en }}</li>
                </ul>
            </div>
        </div><!--/.banner-->
        <div class="container innr-cont-area">
            <div class="row">
                <div class="col-sm-12 terms" v-html='responseData.page.body_en'>
                    {{ responseData.page.body_en }}
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
                    page : []
                }
            }
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
            loadPageData(){
                axios.get(
                    '/api/v1/static/page/'+this.slug
                ).then((response) => {
                    this.responseData = response.data;
                });
            }
        }
    }
</script>
