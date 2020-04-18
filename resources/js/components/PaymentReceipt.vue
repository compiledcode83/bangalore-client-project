<template>
    <div>
        <div class="innr-banner fullwidth">
            <img src="/images/contact-banner.jpg">
            <div class="heading">
                <h2>{{$t('pages.thankYou')}}</h2>
                <ul class="breadcrumb">
                    <li>
                        <a href="/">{{$t('pages.home')}}</a>
                    </li>
                    <li class="active">{{$t('pages.receipt')}}</li>
                </ul>
            </div>
        </div><!--/.banner-->

        <div class="container innr-cont-area">
            <div class="get-touch">
                <h3 style="text-align: center;">{{$t('pages.yourOrderHasBeenPlaced')}}</h3>
                <p style="text-align: center;">{{$t('pages.thankYouForYourOrderVisit')}}
                    <router-link to="/" exact>{{$t('pages.shopMore')}}</router-link>
                </p>
                <div class="row">
                    <div class="well col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <address>
                                    <strong>{{$t('pages.customer')}}: {{order.customr}}</strong>
                                    {{order.address}}
                                    <abbr title="Phone">{{$t('pages.p')}}:</abbr> {{order.phone}}
                                </address>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                                <p>
                                    <em>{{$t('pages.date')}}: {{order.created}}</em>
                                </p>
                                <p>
                                    <em>{{$t('pages.receiptNumber')}}: {{code}}</em>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="text-center">
                                <h1>{{$t('pages.receipt')}}</h1>
                            </div>
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>{{$t('pages.product')}}</th>
                                    <th>{{$t('pages.qty')}}</th>
                                    <th class="text-center">{{$t('pages.price')}}</th>
                                    <th class="text-center">{{$t('pages.total')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in order.items">
                                    <td class="col-md-9"><em> {{item.name}} -- {{item.color}} </em></h4></td>
                                    <td class="col-md-1" style="text-align: center"> {{item.qty}} </td>
                                    <td class="col-md-1 text-center">{{item.price}}</td>
                                    <td class="col-md-1 text-center">{{item.total}}</td>
                                </tr>

                                <tr>
                                    <td>   </td>
                                    <td class="text-right" colspan="2">
                                        <p>
                                            <strong>{{$t('pages.payment_id')}}: </strong>
                                        </p>
                                        <!--                                        <p>-->
                                        <!--                                            <strong>Discount: </strong>-->
                                        <!--                                        </p>-->
                                    </td>
                                    <td class="text-center" >
                                        <p>
                                            <strong>{{order.payment.payment_id}}</strong>
                                        </p>
                                        <!--                                        <p>-->
                                        <!--                                            <strong>$6.94</strong>-->
                                        <!--                                        </p>-->
                                    </td>
                                </tr>
                                <tr>
                                    <td>   </td>
                                    <td class="text-right" colspan="2">
                                        <p>
                                            <strong>{{$t('pages.result')}}: </strong>
                                        </p>
                                        <!--                                        <p>-->
                                        <!--                                            <strong>Discount: </strong>-->
                                        <!--                                        </p>-->
                                    </td>
                                    <td class="text-center"  >
                                        <p>
                                            <strong>{{order.payment.result}}</strong>
                                        </p>
                                        <!--                                        <p>-->
                                        <!--                                            <strong>$6.94</strong>-->
                                        <!--                                        </p>-->
                                    </td>
                                </tr>
                                <tr>
                                    <td>   </td>
                                    <td class="text-right" colspan="2">
                                        <p>
                                            <strong>{{$t('pages.reference')}}: </strong>
                                        </p>
                                        <!--                                        <p>-->
                                        <!--                                            <strong>Discount: </strong>-->
                                        <!--                                        </p>-->
                                    </td>
                                    <td class="text-center"  >
                                        <p>
                                            <strong>{{order.payment.reference}}</strong>
                                        </p>
                                        <!--                                        <p>-->
                                        <!--                                            <strong>$6.94</strong>-->
                                        <!--                                        </p>-->
                                    </td>
                                </tr>
                                <tr>
                                    <td>   </td>
                                    <td class="text-right"  colspan="2">
                                        <p>
                                            <strong>{{$t('pages.track_id')}}: </strong>
                                        </p>
                                        <!--                                        <p>-->
                                        <!--                                            <strong>Discount: </strong>-->
                                        <!--                                        </p>-->
                                    </td>
                                    <td class="text-center">
                                        <p>
                                            <strong>{{order.payment.track_id}}</strong>
                                        </p>
                                        <!--                                        <p>-->
                                        <!--                                            <strong>$6.94</strong>-->
                                        <!--                                        </p>-->
                                    </td>
                                </tr>
                                <tr>
                                    <td>   </td>
                                    <td>   </td>
                                    <td class="text-right">
                                        <p>
                                            <strong>{{$t('pages.subtotal')}}: </strong>
                                        </p>
                                        <!--                                        <p>-->
                                        <!--                                            <strong>Discount: </strong>-->
                                        <!--                                        </p>-->
                                    </td>
                                    <td class="text-center">
                                        <p>
                                            <strong>{{order.total}}</strong>
                                        </p>
                                        <!--                                        <p>-->
                                        <!--                                            <strong>$6.94</strong>-->
                                        <!--                                        </p>-->
                                    </td>
                                </tr>
                                <tr>
                                    <td>   </td>
                                    <td>   </td>
                                    <td class="text-right"><h4><strong>{{$t('pages.total')}}: </strong></h4></td>
                                    <td class="text-center text-danger"><h4><strong>{{order.total}}</strong></h4></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div><!--/.innr-cont-area-->
    </div>
</template>

<script>
    export default {

        props: ['code'],
        data(){
            return {
                order: {},
                paymentMethod: 'cash'
            }
        },
        mounted(){
            // User MUST BE authenticated
            // this.checkUserAuth();
            this.loadOrder(this.code)
        },
        methods: {
            loadOrder(code){
                var Object  =(this.$route.query) ;
                var queryString = $.param(Object);
                 axios.get('/api/v1/paymentReturn/'+code+'?'+queryString)
                    .then((response) => {
                        this.order = response.data;
                    });
            },
            checkUserAuth(){
                if (!this.$store.getters['authModule/isAuthenticated']) {

                    this.$swal({
                        title: 'Must login to checkout!',
                        text: "You must login to be able to see this page.",
                        icon: 'info',
                        showCloseButton: true,
                        showCancelButton: true,
                        focusConfirm: true,
                        confirmButtonText: 'Go to login!',
                        cancelButtonText: 'Back to Home!',
                    }).then((result) => {
                        if (result.dismiss === 'cancel') {
                            return this.$router.push({path: '/'});
                        }
                        return this.$router.push({path: '/login'});
                    });
                }
            }
        },
        computed: {

        }
    }
</script>
