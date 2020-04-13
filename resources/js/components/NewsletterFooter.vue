<template>
    <div class="col-sm-4 col-md-4 col-lg-3 col-lg-offset-1 newsletter col">
        <h2>{{$t('pages.newsLetter_news')}}<span>{{$t('pages.newsLetter_letter')}}</span></h2>
        <form>
            <input type="email" class="form-control rounded-0" :placeholder="$t('pages.newsLetter_emailPlaceHolder')" v-model="email" required>
            <button class="btn submit" @click.prevent="newsSubscribe">{{$t('pages.newsLetter_submit')}}</button>
        </form>
    </div><!--/.col-sm-4-->
</template>

<script>

    export default {
        name: 'NewsletterFooter',
        data(){
            return {
                email: ''
            }
        },
        methods: {
            newsSubscribe(){
                if(this.email === ''){
                    return this.$swal({
                        title: 'error!',
                        text: "Enter your email!",
                        icon: 'error'
                    });
                }
                if (this.$store.getters['authModule/isAuthenticated']) {
                    axios.post(
                        '/api/v1/email/newsletter',
                        {
                            'newsletter': this.email,
                            headers: {
                                "Authorization" : `Bearer ${this.$store.state.authModule.accessToken}`
                            }
                        }
                    ).then((response) => {
                        if(response.data){
                            this.$swal({
                                title: 'Success!',
                                text: "you subscribed successfully!",
                                icon: 'success'
                            });

                            this.email = '';
                        }else{
                            this.$swal({
                                title: 'Error!',
                                text: "Please add your  email!",
                                icon: 'error'
                            });
                        }
                    });
                }else{
                    this.$swal({
                        title: 'Login!',
                        text: "You have to login to subscribe!",
                        icon: 'warning'
                    });
                }
            }
        }
    }
</script>
