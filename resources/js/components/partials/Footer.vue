<template>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-md-4 col-lg-4 col">
                    <h2> {{$t('pages.quickLinks_quick')}} <span>{{$t('pages.quickLinks_links')}}</span></h2>
                    <div class="row">
                        <ul class="ft-links col-sm-6">

                            <li><router-link to="/about"> {{$t('pages.quickLinks_aboutUs')}} </router-link></li>
                            <li><router-link to="/services">{{$t('pages.quickLinks_ourServices')}}</router-link></li>
                            <li v-if="settings.enable_offers_page"><router-link to="/offers">{{$t('pages.quickLinks_specialOffers')}}</router-link></li>
                            <li><router-link to="/pages/clients">{{$t('pages.quickLinks_ourClients')}}</router-link></li>
                            <li><router-link to="/media">{{$t('pages.quickLinks_media')}}</router-link></li>
                        </ul>
                        <ul class="ft-links col-sm-6">
                            <li><router-link to="/contact">{{$t('pages.quickLinks_contactUs')}}</router-link></li>
                            <li><router-link to="/pages/privacy">{{$t('pages.quickLinks_privacyPolice')}}</router-link></li>
                            <li><router-link to="/pages/terms">{{$t('pages.quickLinks_termsConditions')}}</router-link></li>
                            <li><router-link to="/pages/faqs">{{$t('pages.quickLinks_faqs')}}</router-link></li>
                            <li><router-link to="/pages/sitemap">{{$t('pages.quickLinks_siteMap')}}</router-link></li>
                        </ul>
                    </div><!--/.row-->
                </div><!--/.col-sm-4-->
                <div class="col-sm-4 col-md-4 col-lg-4 col">
                    <Social></Social>
                </div><!--/.col-sm-4-->
                <newsletter-footer></newsletter-footer>
            </div><!--/.row-->
            <hr>
            <div class="copyright">
                <span>{{$t('pages.copyRights')}}</span>
                <span>{{$t('pages.poweredBy')}} <a href="http://www.mawaqaa.com/" target="blank"><img src="/images/mawaqaa.png"></a></span>
            </div>
        </div><!--/.container-->
    </footer><!--/footer-->
</template>

<script>
    import Social from "../Social";
    import NewsletterFooter from "../NewsletterFooter";

    export default {
        name: 'siteFooter',
        components: {
            Social, NewsletterFooter
        },
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
