<template>
    <div>
        <div class="innr-banner fullwidth">
            <img src="/images/contact-banner.jpg">
            <div class="heading">
                <h2>{{$t('pages.resetPassword')}}</h2>
                <ul class="breadcrumb">
                    <li><a href="/">{{$t('pages.home')}}</a></li>
                    <li class="active">{{$t('pages.resetPassword')}}</li>
                </ul>
            </div>
        </div><!--/.banner-->

        <div class="container innr-cont-area">

            <form autocomplete="off" @submit.prevent="resetPassword" method="post">
                <div class="get-touch">
                    <h3>{{$t('pages.resetPassword')}}</h3>
                    <p>{{$t('pages.enterPassword')}} </p>
                    <div class="row">

                        <div class="col-sm-4 mt-10 mb-10">
                            <input type="password" id="password" class="form-control" :placeholder="$t('pages.password')" v-model="password" required>
                        </div>
                        <div class="col-sm-4 mt-10 mb-10">
                            <input type="password" id="password_confirmation" class="form-control" :placeholder="$t('pages.confirmPassword')" v-model="password_confirmation" required>
                        </div>

                        <div class="col-sm-12 mt-30 text-center">
                            <button class="btn-lg btn-primary rounded-0">{{$t('pages.resetPassword')}}</button>
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
                token: null,
                password: null,
                password_confirmation: null,
                has_error: false
            }
        },
        methods: {
            resetPassword() {
                axios.post("/api/v1/reset/password/", {
                    token: this.$route.params.token,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                })
                    .then(result => {
                        if(result.data.success){
                            this.$swal({
                                icon: 'success',
                                title: 'Congratulations!',
                                text: result.data.success + ' Now you can go to login and enter your new password.',
                            }).then(() => {
                                this.$router.push({name: 'login'});
                            });
                        }else if(result.data.message) {
                            this.$swal({
                                icon: 'error',
                                title: 'Oops...',
                                text: result.data.message,
                            });
                        }
                    }).catch(errors => {

                    if (errors.response.status == 422){
                        this.$swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: errors.response.data.errors.password[0],
                        });
                    }else {
                        console.log(errors);
                        this.$swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Server error 990!',
                        });
                    }
                });
            }
        }
    }
</script>
