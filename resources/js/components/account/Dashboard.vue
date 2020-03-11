<template>
    <div>
        <my-account-banner
            :bannerTitle="$t('pages.dashboard')"
        ></my-account-banner>

        <div class="container innr-cont-area">
            <div class="row">
                <my-account-sidebar></my-account-sidebar>

                <div class="col-sm-9 right-sec my-account">

                    <h4>{{$t('pages.accountDetails')}}</h4>
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="box">
                                <h5>{{$t('pages.accountDetails')}}</h5>
                                <router-link :to="{name: 'account.info'}" class="edit">{{$t('pages.edit')}}</router-link>
                                <ul class="row">
                                    <li class="col-lg-6">
                                        <small>{{$t('pages.firstName')}}</small>
                                        MOHAMMED AL BAWI
                                    </li>
                                    <li class="col-lg-6">
                                        <small>{{$t('pages.lastName')}}</small>
                                        AL BAWI
                                    </li>
                                    <li class="col-lg-6">
                                        <small>{{$t('pages.emailId')}}</small>
                                        mohammed@gmail.com
                                    </li>
                                    <li class="col-lg-6">
                                        <small>{{$t('pages.phone')}}</small>
                                        00965 55676767
                                    </li>
                                </ul>
                            </div>
                        </div><!--/.col-sm-6-->
                        <div class="col-sm-6">
                            <div class="box">
                                <h5>{{$t('pages.newsletter')}}</h5>
                                <router-link :to="{name: 'account.newsletter'}" class="edit">{{$t('pages.edit')}}</router-link>
                                <span>{{$t('pages.notSubscribed')}}</span>
                            </div>
                        </div><!--/.col-sm-6-->

                    </div><!--/.row-->

                    <br>

                    <h4>{{$t('pages.addressBook')}}</h4>
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="box">
                                <h5>{{$t('pages.useAsDefaultBilling')}} </h5>
                                <router-link :to="{name: 'account.addresses'}" class="edit">{{$t('pages.edit')}}</router-link>
                                <span>
                                  AL SALEM STREET<br>
                                  BLOCK #12<br>
                                  BUILDING NO. 23<br>
                                  SALMIYA
                                </span>
                            </div>
                        </div><!--/.col-sm-6-->
                        <div class="col-sm-6">
                            <div class="box">
                                <h5>{{$t('pages.useAsDefaultShipping')}}</h5>
                                <router-link :to="{name: 'account.addresses'}" class="edit">{{$t('pages.edit')}}</router-link>
                                <span>
                                  AL SALEM STREET<br>
                                  BLOCK #12<br>
                                  BUILDING NO. 23<br>
                                  SALMIYA
                                </span>
                            </div>
                        </div><!--/.col-sm-6-->

                    </div><!--/.row-->
                    <router-link :to="{name: 'account.addresses'}" class="btn btn-default rounded-0">{{$t('pages.addNewAddress')}}</router-link>

                </div><!--/.col-sm-9-->
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
            }
        },
        mounted() {
        },
        methods: {
        }
    }
</script>
