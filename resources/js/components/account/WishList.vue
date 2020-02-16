<template>
    <div>
        <my-account-banner></my-account-banner>

        <div class="container innr-cont-area">
            <div class="row">
                <my-account-sidebar></my-account-sidebar>

                <!--/ Content Here-->
                <div class="col-sm-9 wishlist">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="prod-bx-cvr">
                                <div class="prod-bx">
                                    <div class="img">
                                        <img src="/images/prod1.jpg">
                                    </div>
                                    <div class="data clearfix">
                                        <h4>Drawstring bag</h4>
                                        <div class="price">
                                            24.00 KD
                                        </div>
                                        <div class="more-data">
                                            <div class="qty">
                                                <div class="flex">
                                                    <button class="btn btn-danger">View Item</button>
                                                </div>
                                            </div>
                                            <a href="#" class="remove">REMOVE</a>
                                        </div>
                                    </div><!--/.data-->
                                </div><!--/.prod-bx-->
                            </div>
                        </div>
<!--                        <div class="col-sm-4">-->
<!--                            <div class="prod-bx-cvr">-->
<!--                                <div class="prod-bx">-->
<!--                                    <div class="img">-->
<!--                                        <img src="/images/prod2.jpg">-->
<!--                                    </div>-->
<!--                                    <div class="data clearfix">-->
<!--                                        <h4>Drawstring bag</h4>-->
<!--                                        <div class="price">-->
<!--                                            24.00 KD-->
<!--                                        </div>-->
<!--                                        <div class="more-data">-->
<!--                                            <textarea class="form-control" placeholder="Comment"></textarea>-->
<!--                                            <div class="qty">-->
<!--                                                <h5>Qty</h5>-->
<!--                                                <div class="flex">-->
<!--                                                    <input type="" style="width: 70px;" class="form-control" name="" value="1">-->
<!--                                                    <button class="btn btn-danger">Add To Cart</button>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <a href="#" class="edit">EDIT</a> | <a href="#" class="remove">REMOVE</a>-->
<!--                                        </div>-->
<!--                                    </div>&lt;!&ndash;/.data&ndash;&gt;-->
<!--                                </div>&lt;!&ndash;/.prod-bx&ndash;&gt;-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="col-sm-4">-->
<!--                            <div class="prod-bx-cvr">-->
<!--                                <div class="prod-bx">-->
<!--                                    <div class="img">-->
<!--                                        <img src="/images/prod3.jpg">-->
<!--                                    </div>-->
<!--                                    <div class="data clearfix">-->
<!--                                        <h4>Drawstring bag</h4>-->
<!--                                        <div class="price">-->
<!--                                            24.00 KD-->
<!--                                        </div>-->
<!--                                        <div class="more-data">-->
<!--                                            <textarea class="form-control" placeholder="Comment"></textarea>-->
<!--                                            <div class="qty">-->
<!--                                                <h5>Qty</h5>-->
<!--                                                <div class="flex">-->
<!--                                                    <input type="" style="width: 70px;" class="form-control" name="" value="1">-->
<!--                                                    <button class="btn btn-danger">Add To Cart</button>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <a href="#" class="edit">EDIT</a> | <a href="#" class="remove">REMOVE</a>-->
<!--                                        </div>-->
<!--                                    </div>&lt;!&ndash;/.data&ndash;&gt;-->
<!--                                </div>&lt;!&ndash;/.prod-bx&ndash;&gt;-->
<!--                            </div>-->
<!--                        </div>-->
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
