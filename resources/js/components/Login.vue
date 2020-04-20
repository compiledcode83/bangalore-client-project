<template>
    <div>
        <div class="innr-banner fullwidth">
            <img src="images/wishlist-banner.jpg">
            <div class="heading">
                <h2>{{$t('pages.login')}}</h2>
            </div>
        </div><!--/.banner-->

        <div class="container innr-cont-area">
            <div class="row">
                <div class="col-sm-12 about-us">
                    <form class="col-lg-10 col-lg-offset-1" @submit.prevent="submit">
                        <div class="form-group mt-10 mb-10 fullwidth">
                            <label for="exampleInputEmail1">{{$t('pages.emailAddress')}}</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" :placeholder="$t('pages.email')" v-model="credentials.email">
                        </div>
                        <div class="form-group mt-10 mb-10 fullwidth">
                            <label for="exampleInputPassword1">{{$t('pages.password')}}</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" :placeholder="$t('pages.password')" v-model="credentials.password">
                        </div>
                        <div class="form-check clearfix mt-10 mb-10">
                            <div class="pull-left">
                                <label class="checkbox-sml">{{$t('pages.stayLoggedIn')}}
                                    <input type="checkbox" id="product" value="">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="pull-right">
                                <router-link to="/reset-password" class="forgot-pswrd">
                                    {{$t('pages.forgotPassword')}}
                                </router-link>
                            </div>
                        </div>
                        <br>
                        <button class="btn btn-danger rounded-0">{{$t('pages.login')}}</button>
                    </form>
                </div><!--/.col-sm-12-->
            </div>

        </div><!--/.innr-cont-area-->
    </div>
</template>

<script>
    import { mapActions } from 'vuex';

    export default {
        data() {
            return {
                credentials: {
                    email: '',
                    password: '',
                },
            };
        },
        methods: {
            ...mapActions('authModule', [
                'login',
            ]),
            submit() {
                this.login({ ...this.credentials })
                    .then(() => {

                        axios.get('api/v1/cart/restore',
                            {
                                headers: {
                                    "Authorization": `Bearer ${this.$store.state.authModule.accessToken}`
                                }
                            }).then((cartResponse) => {
                            this.$store
                                .dispatch('setCart', cartResponse.data);
                        });

                        this.$router.push({name: 'home'});
                    })
                    .catch((errors) => {
                        // Handle Errors
                        this.$swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: errors.data.message,
                        });
                    });
            }
        }
    }
</script>
