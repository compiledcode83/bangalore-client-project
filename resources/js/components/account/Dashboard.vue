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
                                <a class="edit" href="#">EDIT</a>
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
                                <a class="edit" href="#">EDIT</a>
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
                                <a class="edit" href="address-edit.html">EDIT</a>
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
                                <a class="edit" href="address-edit.html">EDIT</a>
                                <span>
                                  AL SALEM STREET<br>
                                  BLOCK #12<br>
                                  BUILDING NO. 23<br>
                                  SALMIYA
                                </span>
                            </div>
                        </div><!--/.col-sm-6-->

                    </div><!--/.row-->
                    <button class="btn btn-default rounded-0">Add New Address</button>

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
