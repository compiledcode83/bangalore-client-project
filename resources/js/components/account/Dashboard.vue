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
                                    <li class="col-lg-6" v-if="accountType == '1'">
                                        <small>{{$t('pages.firstName')}}</small>
                                        {{account.first_name}}
                                    </li>
                                    <li class="col-lg-6" v-if="accountType == '1'">
                                        <small>{{$t('pages.lastName')}}</small>
                                        {{account.last_name}}
                                    </li>
                                    <li class="col-lg-6" v-if="accountType == '2'">
                                        <small>{{$t('pages.company')}}</small>
                                        {{account.company}}
                                    </li>
                                    <li class="col-lg-6">
                                        <small>{{$t('pages.emailId')}}</small>
                                        {{account.email}}
                                    </li>
                                    <li class="col-lg-6">
                                        <small>{{$t('pages.phone')}}</small>
                                        {{account.phone}}
                                    </li>
                                </ul>
                            </div>
                        </div><!--/.col-sm-6-->
                        <div class="col-sm-6">
                            <div class="box">
                                <h5>{{$t('pages.newsletter')}}</h5>
                                <router-link :to="{name: 'account.newsletter'}" class="edit">{{$t('pages.edit')}}</router-link>
                                <span v-if="account.is_subscribed == '1'"> {{$t('pages.subscribed')}} </span>
                                <span v-else>{{$t('pages.notSubscribed')}}</span>
                            </div>
                        </div><!--/.col-sm-6-->

                    </div><!--/.row-->

                    <br>

                    <h4>{{$t('pages.addressBook')}}</h4>
                    <div class="row">
                        <div class="col-sm-6" v-if="defaultBillingAddresses">
                            <div class="box">
                                <h5> {{$t('pages.defaultBillingAddress')}} </h5>
                                <span v-if="accountType == '1'">
                                  {{$t('pages.governotate')}}: {{defaultBillingAddresses.governorateName}}<br>
                                  {{$t('pages.area')}}: {{defaultBillingAddresses.areaName}}<br>
                                  {{$t('pages.blockNumber')}}: {{defaultBillingAddresses.block}}<br>
                                  {{$t('pages.street')}}: {{defaultBillingAddresses.street}}<br>
                                  {{$t('pages.buildingNumber')}}: {{defaultBillingAddresses.building}}<br>
                                  {{$t('pages.floorNumber')}}: {{defaultBillingAddresses.floor}}<br>
                                  {{$t('pages.houseNumber')}}: {{defaultBillingAddresses.house_number}}<br>
                                </span>
                                <span v-if="accountType == '2'">
                                  {{$t('pages.governotate')}}: {{defaultBillingAddresses.governorateName}}<br>
                                  {{$t('pages.area')}}: {{defaultBillingAddresses.areaName}}<br>
                                  {{$t('pages.blockNumber')}}: {{defaultBillingAddresses.block}}<br>
                                  {{$t('pages.street')}}: {{defaultBillingAddresses.street}}<br>
                                  {{$t('pages.buildingNumber')}}: {{defaultBillingAddresses.building}}<br>
                                  {{$t('pages.floorNumber')}}: {{defaultBillingAddresses.floor}}<br>
                                  {{$t('pages.officeAddress')}}: {{defaultBillingAddresses.office_address}}<br>
                                  {{$t('pages.officeNumber')}}: {{defaultBillingAddresses.office_number}}<br>
                                </span>
                            </div>
                        </div><!--/.col-sm-6-->
                        <div class="col-sm-6" v-if="defaultShippingAddresses">
                            <div class="box">
                                <h5> {{$t('pages.defaultShippingAddress')}} </h5>
                                <span v-if="accountType == '1'">
                                  {{$t('pages.governotate')}}: {{defaultShippingAddresses.governorateName}}<br>
                                  {{$t('pages.area')}}: {{defaultShippingAddresses.areaName}}<br>
                                  {{$t('pages.blockNumber')}}: {{defaultShippingAddresses.block}}<br>
                                  {{$t('pages.street')}}: {{defaultShippingAddresses.street}}<br>
                                  {{$t('pages.buildingNumber')}}: {{defaultShippingAddresses.building}}<br>
                                  {{$t('pages.floorNumber')}}: {{defaultShippingAddresses.floor}}<br>
                                  {{$t('pages.houseNumber')}}: {{defaultShippingAddresses.house_number}}<br>
                                </span>
                                <span v-if="accountType == '2'">
                                  {{$t('pages.governotate')}}: {{defaultShippingAddresses.governorateName}}<br>
                                  {{$t('pages.area')}}: {{defaultShippingAddresses.areaName}}<br>
                                  {{$t('pages.blockNumber')}}: {{defaultShippingAddresses.block}}<br>
                                  {{$t('pages.street')}}: {{defaultShippingAddresses.street}}<br>
                                  {{$t('pages.buildingNumber')}}: {{defaultShippingAddresses.building}}<br>
                                  {{$t('pages.floorNumber')}}: {{defaultShippingAddresses.floor}}<br>
                                  {{$t('pages.officeAddress')}}: {{defaultShippingAddresses.office_address}}<br>
                                  {{$t('pages.officeNumber')}}: {{defaultShippingAddresses.office_number}}<br>
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
                defaultBillingAddresses: {},
                defaultShippingAddresses: {},
                account: {},
                accountType: null
            }
        },
        mounted() {
            if (this.$store.getters['authModule/isAuthenticated']) {
                axios.get(
                    '/api/v1/account/info',
                    {headers: {
                            "Authorization" : `Bearer ${this.$store.state.authModule.accessToken}`
                        }
                    }
                ).then((response) => {
                    this.account = response.data;
                    this.accountType = response.data.type;
                });

                axios.get(
                    '/api/v1/account/addresses',
                    {
                        headers: {
                            "Authorization" : `Bearer ${this.$store.state.authModule.accessToken}`
                        }
                    }
                ).then((response) => {
                    this.defaultShippingAddresses = response.data.defaultShipping;
                    this.defaultBillingAddresses = response.data.defaultBilling;
                    console.log(response);
                });
            }else{
                console.log('No authorization');
            }
        },
        methods: {
        }
    }
</script>
