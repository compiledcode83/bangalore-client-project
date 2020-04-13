<template>
    <div class="innr-banner fullwidth">
        <img :src="'/uploads/'+settings.account_banner">
        <div class="heading">
            <h2> {{bannerTitle}} </h2>
            <ul class="breadcrumb">
                <li>
                    <router-link to="/">{{$t('pages.home')}}</router-link>
                </li>
                <li class="active" style="color: #ffffff"> {{bannerTitle}} </li>
            </ul>
        </div>
    </div><!--/.banner-->
</template>

<script>
    export default {
        name: 'myAccountBanner',
        props: ['bannerTitle'],
        data() {
            return {
                settings: {}
            }
        },
        mounted() {
            axios.get('/api/v1/settings/')
                .then((response) =>{
                    this.settings = response.data;
                });
        },
    }
</script>
