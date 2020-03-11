<template>
    <div>
        <div class="innr-banner fullwidth">
            <img src="/images/contact-banner.jpg">
            <div class="heading">
                <h2>{{$t('pages.forgotPassword')}}</h2>
                <ul class="breadcrumb">
                    <li><a href="/">{{$t('pages.home')}}</a></li>
                    <li class="active">{{$t('pages.forgotPassword')}}</li>
                </ul>
            </div>
        </div><!--/.banner-->

        <div class="container innr-cont-area">
            <form autocomplete="off" @submit.prevent="requestResetPassword" method="post">
                <div class="get-touch">
                    <h3>{{$t('pages.forgotPassword')}}</h3>
                    <p>{{$t('pages.forgotPassword_enterYourEmail')}} </p>
                    <div class="row">

                        <div class="col-sm-6 mt-10 mb-10">
                            <input type="email" class="form-control" :placeholder="$t('pages.email')" v-model="email" required>
                        </div>

                        <div class="col-sm-12 mt-30 text-center">
                            <button class="btn-lg btn-primary rounded-0" style="width:400px;" :disabled="hasSubmitted">{{$t('pages.sendPasswordResetLink')}}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div><!--/.innr-cont-area-->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                email: null,
                has_error: false,
                hasSubmitted: false,
            }
        },
        methods: {
            requestResetPassword() {
                this.hasSubmitted = true;
                axios.post("/api/v1/reset-password", {email: this.email
                }).then(result => {
                    this.response = result.data;
                    if(result.data.data){
                        this.$swal({
                            icon: 'success',
                            title: 'Sent Successfully!',
                            text: result.data.message,
                        });
                    }else if(result.data.message){
                        this.$swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: result.data.message,
                        });
                    }
                    this.hasSubmitted = false;
                }).catch(function (errors) {
                    this.hasSubmitted = false;
                });
            }
        }
    }
</script>
