<template>
    <div>
        <my-account-banner></my-account-banner>

        <div class="container innr-cont-area">
            <div class="row">
                <my-account-sidebar></my-account-sidebar>

                <!--/ Content Here-->
                <div class="col-sm-9 right-sec addrss-book">
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
                                  <br>
                                  BLOCK #12<br>
                                  BUILDING NO. 23<br>
                                  SALMIYA
                                </span>
                            </div>
                        </div><!--/.col-sm-6-->
                    </div><!--/.row-->
                    <br>
                    <h4>Add New Address</h4>
                    <div class="add-newaddrss">
                        <form class="row">
                            <div class="col-sm-6">
                                <input type="text" class="form-control rounded-0" placeholder="First Name *" name="">
                            </div><!--/.col-sm-6-->
                            <div class="col-sm-6">
                                <input type="text" class="form-control rounded-0" placeholder="Last Name *" name="">
                            </div><!--/.col-sm-6-->
                            <div class="col-sm-6">
                                <div class="phonewithcontry">
                                    <select class="form-control contry">
                                        <option>+965</option>
                                    </select>
                                    <input type="text" class="form-control rounded-0 phone" placeholder="Phone Number *" name="">
                                </div>
                            </div><!--/.col-sm-6-->
                            <div class="col-sm-6">
                                <input type="text" class="form-control rounded-0" placeholder="Fax *" name="">
                            </div><!--/.col-sm-6-->
                            <div class="col-sm-6">
                                <input type="text" class="form-control rounded-0" placeholder="City *" name="">
                            </div><!--/.col-sm-6-->
                            <div class="col-sm-6">
                                <input type="text" class="form-control rounded-0" placeholder="Company *" name="">
                            </div><!--/.col-sm-6-->
                            <div class="col-sm-6">
                                <input type="text" class="form-control rounded-0" placeholder="Zip Code *" name="">
                            </div><!--/.col-sm-6-->
                            <div class="col-sm-6">
                                <select class="form-control">
                                    <option>STATE *</option>
                                    <option>Kuwait</option>
                                    <option>UAE</option>
                                    <option>Soudi Arabia</option>
                                    <option>Jordan</option>
                                </select>
                            </div><!--/.col-sm-6-->
                            <div class="col-sm-6">
                                <label class="checkbox-sml mt-20">Use as my default billing address
                                    <input type="checkbox" id="product" value="">
                                    <span class="checkmark"></span>
                                </label>
                            </div><!--/.col-sm-6-->
                            <div class="col-sm-6">
                                <label class="checkbox-sml mt-20">Use as my default shipping address
                                    <input type="checkbox" id="product" value="">
                                    <span class="checkmark"></span>
                                </label>
                            </div><!--/.col-sm-6-->
                            <div class="col-sm-12 mt-30">
                                <button class="btn-lg btn-success rounded-0">Save Address</button>
                            </div><!--/.col-sm-12-->
                        </form>
                    </div><!--/.row-->
                </div><!--/.col-sm-9-->
                <!--/.col-sm-9-->
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
