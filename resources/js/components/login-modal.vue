<template>
    <!-- Modal For Login-->
    <div class="modal fade login-model" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header">{{$t('pages.login')}}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <img src="/images/close.png">
                    </button>
                </div>
                <div class="modal-body row text-center clearfix">
                    <form class="col-lg-10 col-lg-offset-1" @submit.prevent="submit">
                        <div class="form-group mt-10 mb-10 fullwidth">
                            <label for="exampleInputEmail1"> {{$t('login.emailAddress')}} </label>
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
                                <a href="#" class="forgot-pswrd" @click.prevent="forgotPassword">{{$t('pages.forgotPassword')}}</a>
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-danger rounded-0">{{$t('pages.login')}}</button>
                    </form>
                </div><!--/.modal-body-->
            </div>
        </div>
    </div>
</template>

<script>
    import { mapActions } from 'vuex';
    export default {
        name: 'loginModal',
        data() {
            return {
                credentials: {
                    email: '',
                    password: '',
                },
            };
        },
        methods:  {
            ...mapActions('authModule', [
                'login',
            ]),
            submit() {
                this.login({ ...this.credentials })
                    .then(() => {
                        this.hideModal();
                        if(this.$router.currentRoute.name !== 'home'){
                            this.$router.push({name: 'home'});
                        }
                    })
                    .catch((errors) => {
                        // Handle Errors
                        // this.hideModal();
                        this.$swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: errors.data.message,
                        });
                    });
            },
            hideModal(){
                $('#login_modal').modal('hide');
            },
            forgotPassword(){
                $('#login_modal').modal('hide');
                this.$router.push({name: 'reset-password'});
            }
        }
    }
</script>
