<template>
    <div>
        <my-account-banner></my-account-banner>

        <div class="container innr-cont-area">
            <div class="row">
                <my-account-sidebar></my-account-sidebar>

                <div class="col-sm-9 right-sec my-account">

                    <h4>Contact Information</h4>
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="box">
                                <h5>Account Details</h5>
                                <router-link :to="{name: 'account.info'}" class="edit">EDIT</router-link>
                                <ul class="row">
                                    <li class="col-lg-6">
                                        <small>First Name</small>
                                        MOHAMMED AL BAWI
                                    </li>
                                    <li class="col-lg-6">
                                        <small>Last Name</small>
                                        AL BAWI
                                    </li>
                                    <li class="col-lg-6">
                                        <small>E-MAIL ID</small>
                                        mohammed@gmail.com
                                    </li>
                                    <li class="col-lg-6">
                                        <small>Phone</small>
                                        00965 55676767
                                    </li>
                                </ul>
                            </div>
                        </div><!--/.col-sm-6-->
                        <div class="col-sm-6">
                            <div class="box">
                                <h5>Newsletters</h5>
                                <router-link :to="{name: 'account.newsletter'}" class="edit">EDIT</router-link>
                                <span>You don't subscribe to our newsletter</span>
                            </div>
                        </div><!--/.col-sm-6-->

                    </div><!--/.row-->

                    <br>

                    <h4>Address Book</h4>
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="box">
                                <h5>Default Billing Address </h5>
                                <router-link :to="{name: 'account.addresses'}" class="edit">EDIT</router-link>
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
                                <h5>Default Shipping Address</h5>
                                <router-link :to="{name: 'account.addresses'}" class="edit">EDIT</router-link>
                                <span>
                                  AL SALEM STREET<br>
                                  BLOCK #12<br>
                                  BUILDING NO. 23<br>
                                  SALMIYA
                                </span>
                            </div>
                        </div><!--/.col-sm-6-->

                    </div><!--/.row-->
                    <router-link :to="{name: 'account.addresses'}" class="btn btn-default rounded-0">Add New Address</router-link>

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
