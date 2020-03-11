<template>
    <div class="innr-banner fullwidth">
        <img src="/images/wishlist-banner.jpg">
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
        mounted() {
        },
        methods: {
        }
    }
</script>
