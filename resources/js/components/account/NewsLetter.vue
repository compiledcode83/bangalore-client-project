<template>
    <div>
        <my-account-banner
            :bannerTitle="$t('pages.mySubscription')"
        ></my-account-banner>

        <div class="container innr-cont-area">
            <div class="row">
                <my-account-sidebar></my-account-sidebar>

                <!--/ Content Here-->
                <div class="col-sm-9 right-sec my-account">
                    <h4>{{$t('pages.subscribeToNewsLetter')}}</h4>
                    <div class="row">
                        <div class="col-sm-6 mt-10 mb-10">
                            <label class="checkbox-sml mt-20">{{$t('pages.yesSubscribeToNewsLetter')}}
                                <input type="checkbox" id="product" v-model="newsletter" >
                                <span class="checkmark"></span>
                            </label>
                        </div><!--/.col-sm-6-->


                    </div><!--/.row-->

                    <button class="btn btn-default rounded-0" @click.prevent="updateNewsletter">{{$t('pages.save')}}</button>
                </div>
                <!--/.col-sm-9-->
            </div>
        </div><!--/.innr-cont-area-->
    </div>
</template>

<script>
    import myAccountSidebar from "./partials/TheSidebar";
    import myAccountBanner from "./partials/TheBanner";
    export default {
        components: {myAccountSidebar, myAccountBanner},
        data(){
            return {
                newsletter: 0
            }
        },
        mounted() {
            if (this.$store.getters['authModule/isAuthenticated']) {

                axios.get(
                    '/api/v1/account/newsletter',
                    {
                        headers: {
                            "Authorization" : `Bearer ${this.$store.state.authModule.accessToken}`
                        }
                    }
                ).then((response) => {
                    this.newsletter = response.data;
                });
            }else{
                console.log('No authorization');
            }
        },
        methods: {
            updateNewsletter(){
                if (this.$store.getters['authModule/isAuthenticated']) {
                    axios.post(
                        '/api/v1/account/newsletter',
                        {
                            'newsletter': this.newsletter,
                            headers: {
                                "Authorization" : `Bearer ${this.$store.state.authModule.accessToken}`
                            }
                        }
                    ).then((response) => {
                        this.newsletter = response.data;
                        if(response.data){
                            this.$swal({
                                title: 'Congratulations!',
                                text: "You subscribed successfully!",
                                icon: 'success',
                            });
                        }else{
                            this.$swal({
                                title: 'Good buy!',
                                text: "You unsubscribed successfully!",
                                icon: 'success',
                            });
                        }
                    });
                }else{
                    console.log('No authorization');
                }
            }
        }
    }
</script>
