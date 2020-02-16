<template>
    <div>
        <div class="innr-banner fullwidth">
            <img src="images/wishlist-banner.jpg">
            <div class="heading">
                <h2>Login</h2>
            </div>
        </div><!--/.banner-->

        <div class="container innr-cont-area">
            <div class="row">
                <div class="col-sm-12 about-us">
                    <form class="col-lg-10 col-lg-offset-1" @submit.prevent="submit">
                        <div class="form-group mt-10 mb-10 fullwidth">
                            <label for="exampleInputEmail1">User ID</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" v-model="credentials.email">
                        </div>
                        <div class="form-group mt-10 mb-10 fullwidth">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" v-model="credentials.password">
                        </div>
                        <div class="form-check clearfix mt-10 mb-10">
                            <div class="pull-left">
                                <label class="checkbox-sml">Stay Signed In
                                    <input type="checkbox" id="product" value="">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="pull-right">
                                <a href="#" class="forgot-pswrd">Forgot Password</a>
                            </div>
                        </div>
                        <br>
                        <button class="btn btn-danger rounded-0">Log In</button>
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
                        if(this.$router.currentRoute.name !== 'home'){
                            this.$router.push({name: 'home'});
                        }
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
