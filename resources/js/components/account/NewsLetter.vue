<template>
    <div>
        <my-account-banner></my-account-banner>

        <div class="container innr-cont-area">
            <div class="row">
                <my-account-sidebar></my-account-sidebar>

                <!--/ Content Here-->
                <div class="col-sm-9 right-sec my-account">
                    <h4>Subscribe to Newsletter</h4>
                    <div class="row">
                        <div class="col-sm-6 mt-10 mb-10">
                            <label class="checkbox-sml mt-20">Yes. Subscribe me to Newsletter.
                                <input type="checkbox" id="product" value="">
                                <span class="checkmark"></span>
                            </label>
                        </div><!--/.col-sm-6-->


                    </div><!--/.row-->

                    <button class="btn btn-default rounded-0">SAVE</button>
                </div>
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
