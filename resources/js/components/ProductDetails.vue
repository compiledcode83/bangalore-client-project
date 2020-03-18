<template>
    <div>

        <div class="product-detail-bnr fullwidth text-center">
            <ul class="breadcrumb">
                <li><a href="/">{{$t('pages.home')}}</a></li>
                <li><a href="#">{{$t('pages.productListing')}}</a></li>
                <li class="active">{{product.name_en}}</li>
            </ul>
        </div><!--/.banner-->

        <div class="container innr-cont-area">
            <div class="product-details" data-select2-id="6">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="single-item slider-for">
                                    <div class="single-item-img" v-if="showMainImage">
                                        <img :src="'/uploads/' + product.main_image" :alt="product.name_en" @error="onImageLoadFailure($event, '600x600')">
                                    </div>
                                    <div class="single-item-img" v-for="image in product.main_gallery">
                                        <img :src="'/uploads/' + image" :alt="product.name_en" @error="onImageLoadFailure($event, '600x600')">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="multiple-item slider-nav">
                                    <img :src="'/uploads/' + product.main_image" :alt="product.name_en" v-if="showMainImage">
                                    <img
                                        v-for="image in product.main_gallery"
                                        :src="'/uploads/' + image"
                                        :alt="product.name_en"
                                        @error="onImageLoadFailure($event, '120x120')">
                                </div>
                            </div>
                            <div class="col-sm-12">

                                    <div class="btn-group" data-toggle="buttons">
                                        <label
                                            class="btn active selct-clr"
                                            @click="loadDefaultImages()">
                                            {{$t('pages.d')}}
                                            <input type="radio" name="Default" class="options" autocomplete="off">
                                        </label>
                                        <label
                                            v-for="(color, index) in product.colors"
                                            class="btn active selct-clr"
                                            :style="'background:' + color.color_code"
                                            @click="loadColorImages(color.images, index, color.name)">

                                            <input type="radio" name="options" class="options" autocomplete="off">
                                        </label>
                                    </div>

                            </div>

                        </div>
                    </div><!--/.col-sm-6-->
                    <div class="col-md-6 data">
                        <h2> {{product.name_en}} <span v-if="product.show_left_qty && selected_attribute.stock">( {{$t('pages.only')}} {{selected_attribute.stock}} {{$t('pages.left')}} )</span></h2>
                        <div class="price clearfix">
                            <div class="pull-left" v-if="isAuth">
                                <div v-if="min_price">
                                    <strong v-if="pricesForMinQtyDiscount">{{$t('pages.starting_from')}} {{pricesForMinQty.discount}} {{$t('pages.kd')}}</strong>
                                    <strong v-else>{{$t('pages.starting_from')}} {{pricesForMinQty.price}} {{$t('pages.kd')}}</strong>
                                    <u v-if="pricesForMinQtyDiscount">{{$t('pages.starting_from')}} {{pricesForMinQty.price}} {{$t('pages.kd')}}</u>
                                </div>
                                <b v-else> {{$t('pages.price_based_on_select')}} </b>
                                <p style="line-height: 0;font-size:12px;margin-top:5px;cursor: pointer;"
                                    v-if="min_price" @click="togglePrices"> {{$t('pages.viewPrices')}} </p>
                            </div>
                            <div class="pull-left" v-else>
                               <strong> {{$t('pages.login_to_check_price')}} </strong>
                            </div>
                            <div class="pull-right stock">
                                <span v-if="selected_attribute.stock > 0">{{$t('pages.inStock')}}</span>
                                <strong> {{selected_attribute.sku}} </strong>
                            </div>

                            <div class="prices" v-if="show_prices">
                                <table style="margin-top: 20%;margin-bottom: 5%;">
                                    <tr>
                                        <th scope="row" style="color: #e11b22;">{{$t('pages.quantity')}}</th>
                                        <th scope="col" style="padding-left: 25px;" v-for="(priceElementValue, priceElementKey) in productPrices">{{priceElementKey}}</th>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="color: #e11b22;">{{$t('pages.kd')}}</th>
                                        <td style="padding-left: 25px;" v-for="(priceElementValue, priceElementKey) in productPrices">{{priceElementValue}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <p v-html="product.short_description_en"> </p>
                        <div class="row">
                            <div class="col-sm-6 col-lg-5">
                                <div class="rate-cvr clearfix">
                                    <star-rating active-color="#e01b22" :show-rating="false" :rating=2 :item-size=35 border-color="#fff" read-only></star-rating>
                                </div>

                            </div>
                            <div class="reviews col-sm-6 col-lg-7">
                                <a href="#"><span class="red">10</span>  {{$t('pages.reviews')}}</a>   /
                                <a href="#" @click.prevent="checkUserAbilityToReview">{{$t('pages.addYourReview')}}</a>
                            </div>
                        </div><!--/.row-->

                        <div class="modal fade login-model" id="addReview" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content rounded-0">
                                    <div class="modal-header">{{$t('pages.addYourReview')}}
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <img src="/images/close.png">
                                        </button>
                                    </div>
                                    <div class="modal-body row text-center clearfix add-review-model">
                                        <div class="rate-cvr clearfix">
                                            <div class="rate-big">
                                                <star-rating
                                                    active-color="#e01b22"
                                                    :show-rating="false"
                                                    :item-size=40
                                                    v-model="reviewRating"
                                                    border-color="#fff"></star-rating>
                                            </div>
                                        </div>
                                        <form class="col-lg-10 col-lg-offset-1">
                                            <div class="form-group mt-10 mb-10 fullwidth">
                                                <label for="nickname">{{$t('pages.nickName')}}</label>
                                                <input type="text" class="form-control" id="nickname" aria-describedby="emailHelp" :placeholder="$t('pages.enterYourNickName')" v-model="reviewNickname">
                                            </div>
                                            <div class="form-group mt-10 mb-10 fullwidth">
                                                <label >{{$t('pages.reviewDetails')}}</label>
                                                <textarea class="form-control" name="review" v-model="reviewText"></textarea>
                                            </div>
                                            <br>
                                            <button type="submit" class="btn btn-danger rounded-0"  @click.prevent="submitReview">{{$t('pages.submit')}}</button>
                                        </form>
                                    </div><!--/.modal-body-->
                                </div>
                            </div>
                        </div>
<!--                        <div v-if="isAuth && selected_attribute.stock > 0">-->
                        <div v-if="isAuth">
                            <ul class="file-upload">
                                <li class="row quantity">
                                    <div class="col-sm-3">{{$t('pages.uploads')}} </div>
                                    <div class="col-sm-9">
                                        <div class="form-group user-register">
                                            <input id="uploadFile" class="normal-text-box" :placeholder="$t('pages.uploadOnlyImage')" disabled="disabled" :value="file.name">
                                            <div class="fileUpload">
                                                <span>{{$t('pages.browse')}}</span>
                                                <input class="upload" type="file" id="file" ref="file" @change="handleFileUpload($event)"/>
                                            </div>
                                        </div>
                                    </div>
                                </li><!--/li-->
                            </ul>
                            <ul class="color-load">
                                    <li class="row quantity" v-for="(colorInput, index) in colorInputsCount">
                                        <a v-if="index != 0" class="close" @click.prevent="removeColorInput(index)">X</a>
                                    <div class="col-sm-3 col-xs-6">
<!--                                        <select class="select-colors-product1 color-select form-control"-->
<!--                                                name="colorSelectedByIds[]"-->
<!--                                                v-model="colorInputs[index]"-->
<!--                                                @change="validateInput($event)"-->
<!--                                        required>-->
<!--                                            <option value="null">Choose Color</option>-->
<!--                                            <option-->
<!--                                                v-for="(color, index) in product.colors"-->
<!--                                                :value="index"-->
<!--                                            > {{color.name}}  </option>-->
<!--                                        </select>-->
                                        <select :class="'select-colors-product-'+index+' color-select form-control'"
                                                name="colorSelectedByIds[]"
                                                v-model="colorInputs[index]"
                                                required>
                                            <option
                                                v-for="(color, index) in product.colors"
                                                :value="index+'-'+color.color_code"
                                            >  </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3 col-xs-6">
                                        <input type="text" class="form-control rounded-0" name="qtySelectedWithColors[]" v-model="qtyInputs[index]" @keypress="isNumber($event)" required>
                                    </div>
                                </li><!--/li-->
<!--                                <li class="row quantity">-->
<!--                                    <a class="close" @click.prevent="removeColorInput">X</a>-->
<!--                                    <div class="col-sm-3 col-xs-6">-->
<!--                                        <select class="select-colors-product color-select form-control"-->
<!--                                                name="colorSelectedByIds[]"-->
<!--                                                v-model="colorInputs[index]"-->
<!--                                                @change="validateInput($event)"-->
<!--                                                required>-->
<!--                                            <option-->
<!--                                                v-for="(color, index) in product.colors"-->
<!--                                                :value="color.color_code"-->
<!--                                                :name="index"-->
<!--                                            >  </option>-->
<!--                                        </select>-->
<!--                                    </div>-->
<!--                                    <div class="col-sm-3 col-xs-6"><input type="" class="form-control rounded-0" name="" value="1"></div>-->
<!--                                </li>&lt;!&ndash;/li&ndash;&gt;-->
                            </ul>
                            <button class="more add" @click="addColorInput">{{$t('pages.addMoreColors')}}</button>

                            <div class="row">
                                <div class="col-sm-6"><button class="btn-lg btn-success full-width" @click="submitCart()">{{$t('pages.addToCart')}}</button></div>
                                <div class="col-sm-6"><button class="btn-lg btn-primary full-width" @click="addToWishList(product.id)">{{$t('pages.addToWishList')}}</button></div>
                            </div>
                        </div>
                        <span class="out-stock" v-if="selected_attribute.id && selected_attribute.stock == 0"></span>
                    </div><!--/.col-sm-6-->
                </div><!--/.row-->

                <div class="tab-cvr">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class=""><a href="http://www.mawaqaa.com/clients/demos/itc/html3/product-details.html#Details" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="false">{{$t('pages.details')}}</a></li>
                        <li role="presentation" class=""><a href="http://www.mawaqaa.com/clients/demos/itc/html3/product-details.html#Info" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">moreInformation</a></li>
                        <li role="presentation" class="active"><a href="http://www.mawaqaa.com/clients/demos/itc/html3/product-details.html#Reviews" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="true">{{$t('pages.reviews')}} (6)</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane" id="Details">
                            <p v-html="product.description_en"> </p>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="Info">
                            <p v-html="product.more_information_en"> </p>
                        </div>
                        <div role="tabpanel" class="tab-pane active" id="Reviews">
                            <div class="row" v-for="review in product.reviews">
                                <div class="col-sm-6 col-md-7">
                                    <h4>{{review.nickname}}</h4>
                                </div>
                                <div class="col-sm-6 col-md-5">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-5">
                                            <div class="rate">
                                                <star-rating active-color="#e01b22" :show-rating="false" :rating=review.rating :item-size=20 border-color="#fff" read-only></star-rating>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-7">
                                            <p class="date-rate">{{review.created_at}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <p>{{review.review}}</p>
                                </div>
                            </div><!--/.row-->
                        </div>
                    </div>
                </div>
            </div><!--/.product-details-->
        </div><!--/.innr-cont-area-->

        <div class="related-products">
            <div class="container">
                <h2>{{$t('pages.related')}} <span>{{$t('pages.products')}}</span></h2>
                <ul class="relatedprod-slide">
                    <li class="slide" v-for="product in product.relatedProductsDetails">
                        <ProductBox v-bind:product="product"></ProductBox>
                    </li><!--/li-->
                </ul><!--/ul-->
            </div>
        </div><!--/.related-products-->
    </div>
</template>

<script>
    $(document).ready(function() {

        // $(document).ready(function() {

        // });

            // tags: "true",
            // allowClear: true,
            // placeholder: 'Select an option',
            // templateResult: formatState,
            // templateSelection: formatState
        // );
    });
    function formatState (state) {
        if (!state.id) {
            return state.text;
        }
        // var baseUrl = "img";
        var $state = $(
            // '<span><img src="' + baseUrl + '/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span>'
            '<span><div style="background-color:' + state.element.value.toLowerCase() + '; border-radius:50%;     border: 1px solid #fff; margin-bottom:1px; box-shadow: 0px 0px 0 1px rgba(0, 0, 0, 0.6588235294117647); width:20px; height:20px; margin-top:5px;" class="img-flag" ></div> ' + state.text + '</span>'

        );
        return $state;
    }

    import ProductBox from "./Product-box";
    import {StarRating} from 'vue-rate-it';

    export default {
        components: {ProductBox, StarRating},
        mounted() {
            this.slug = this.$route.params.slug;
            this.loadProductDetails();
        },
        beforeRouteUpdate(to, from, next) {
            this.slug = to.params.slug;
            this.loadProductDetails();
            next();
        },
        methods: {
            addToWishList(productId){
                if (this.$store.getters['authModule/isAuthenticated']) {
                    axios.post(
                        '/api/v1/account/wishlist', {'productId': productId},
                        {headers: {
                                "Authorization" : `Bearer ${this.$store.state.authModule.accessToken}`
                            }
                        }
                    ).then((response) => {
                        this.$swal({
                            title: 'Success!',
                            text: "item Added to wishList successfully!",
                            icon: 'success',
                        });
                    });
                }else{
                    console.log('No authorization');
                }

            },
            isNumber: function(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46 && charCode !== '') {
                    evt.preventDefault();
                } else {
                    return true;
                }
            },
            runSelect2(){
                let selectIndex = 0;
                let _this = this;
                if(this.colorInputsCount){
                    selectIndex = this.colorInputsCount - 1;
                }
                console.log('color run Select '+ selectIndex);
                let jqueryColorSelector = $('.select-colors-product-' + selectIndex);
                if (!jqueryColorSelector.hasClass("select2-hidden-accessible")) {
                    // Select2 has been initialized
                    jqueryColorSelector.select2({
                        // tags: "true",
                        // allowClear: true,
                        // placeholder: 'Select an option',
                        templateResult: this.formatState,
                        templateSelection: this.formatState
                    });

                    jqueryColorSelector.on('select2:select', function (e) {
                        var value = e.params.data.element.value;
                        var colorValue = value.split("-");

                        _this.validateInput(value, selectIndex);
                    });
                }
            },
            formatState (state) {


                if (!state.id) {
                    return state.text;
                }
                var colorValue = state.element.value.split("-");
                // var baseUrl = "img";
                var $state = $(
                    // '<span><img src="' + baseUrl + '/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span>'
                    '<span><div style="background-color:' + colorValue[1] + '; border-radius:50%;     border: 1px solid #fff; margin-bottom:1px; box-shadow: 0px 0px 0 1px rgba(0, 0, 0, 0.6588235294117647); width:20px; height:20px; margin-top:5px;" class="img-flag" ></div> ' + state.text + '</span>'

                );
                return $state;
            },
            loadProductDetails(){
                axios.all([
                    axios.get('/api/v1/products/'+this.slug)
                ]).then(axios.spread((productResponse) => {
                    this.product = productResponse.data;

                    //reset sku
                    this.selected_attribute.sku = this.product.sku;
                    this.defaultMainGallery = productResponse.data.main_gallery;

                    //get prices
                    this.loadProductPrices();
                }));
            },
            loadProductPrices(){
                if(this.isAuth){
                    axios.get('/api/v1/products/'+this.slug+'/prices')
                        .then((response) =>{

                            this.productPrices = response.data.priceTable;
                            this.originalPrice = response.data.originalPrice;
                            this.discountFound = response.data.priceTable;
                            this.min_price = Math.min.apply( null, Object.values(this.productPrices) );
                            let pricesForMinQtyKey = Math.min.apply( null, Object.keys(response.data.priceTableWithDiscount) );
                            this.pricesForMinQty = response.data.priceTableWithDiscount[pricesForMinQtyKey];
                        });
                }
            },
            loadColorImages(images = null, index, colorName = null){

                if(!images){
                    let colorObject  = this.getColorObject(index);
                    images = colorObject.images;
                    colorName = colorObject.name;
                }

                if(images !== this.product.main_gallery) {
                    this.showMainImage = false;

                    //prepare reload sliders
                    this.sliderFor = false;
                    this.sliderNav = false;

                    this.unSlickSliders();
                    if (images.length) {
                        this.product.main_gallery = images;
                    }

                    //select attribute
                    window.attribute = this.product.product_attribute_values.find(function(element) {
                        return element.id == index;
                    });

                    this.selected_attribute.id = attribute.id;
                    this.selected_attribute.sku = attribute.sku;
                    this.selected_attribute.stock = attribute.stock;
                    this.selected_attribute.color_name = colorName;
                }

                this.runSelect2();
                console.log(this.product.colors);
            },
            loadDefaultImages(){
                if(this.defaultMainGallery !== this.product.main_gallery) {
                    this.unSlickSliders();

                    //prepare reload sliders
                    this.sliderFor = false;
                    this.sliderNav = false;

                    if(!this.defaultMainGallery.includes(this.product.main_image)){
                        this.defaultMainGallery.unshift(this.product.main_image);
                    }
                    this.product.main_gallery = this.defaultMainGallery;

                    this.selected_attribute.sku = '';
                    this.selected_attribute.stock = '';
                }
            },
            unSlickSliders(){
                $('.slider-for').slick("unslick");
                $('.slider-nav').slick("unslick");
            },
            submitCart() {
                if(!this.selected_attribute.id){
                    this.$swal({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please select color before adding to cart ...',
                    });

                    return 0;
                }

                //Add the form data we need to submit
                for(let key in this.colorInputs){

                    let colorObjectInput = this.getColorObject(this.colorInputs[key]);
                    if(parseInt(this.qtyInputs[key]) > 0) {
                        this.cartItem = {
                            item_name: this.product.name_en,
                            product_attribute_id: this.colorInputs[key],//this.selected_attribute.id,
                            product_image: colorObjectInput.images[0],
                            product_print_image: '',
                            product_qty: parseInt(this.qtyInputs[key]),
                            product_color_name: colorObjectInput.name,
                            product_price: 0,
                            base_product_prices: this.productPrices,
                            total: 0,
                            status: false
                        };

                        this.cartItem = this.calcItemPrice(this.cartItem);

                        this.addToCart(colorObjectInput, key);
                    }
                }
            },
            addToCart(colorObjectInput, key) {

                //if item has print image and not uploaded before
                if(this.file && this.cartItem.product_print_image === ''){
                    //validate file
                    this.validateFile();

                    //Initialize the form data
                    let formData = new FormData();

                    // upload file
                    formData.append('file', this.file);
                    formData.append('item_name', this.product.name_en);
                    formData.append('product_attribute_id', this.colorInputs[key]);
                    formData.append('product_image', colorObjectInput.images[0]);
                    formData.append('product_qty', this.qtyInputs[key]);
                    formData.append('product_color_name', colorObjectInput.name);
                    formData.append('product_price', this.cartItem.product_price);
                    formData.append('total', '0');

                    /*
                      Make the request to the POST /single-file URL
                    */
                    let  _this = this;

                    axios.post('/api/v1/cart/item',
                        formData,
                        {
                            headers: {
                                'Content-Type': "multipart/form-data"
                            }
                        }
                    ).then(function (response) {
                        _this.cartItem.product_print_image = 'uploads/print_images/'+response.data.fileName;
                        return _this.persistCartItem();
                    }).catch(function (errors) {
                        console.log(errors);
                    });
                }else{
                    this.persistCartItem();
                }
            },
            persistCartItem(){
                let  _this = this;
                this.$store
                    .dispatch('createCalculatedItemPrice', this.cartItem)
                    .then(() => {
                        // this.cart = this.$store.state.cart;
                        this.$swal({
                            title: 'New Item in cart!',
                            text: "Item added to cart successfully!",
                            icon: 'success'
                        });

                        //clean form
                        _this.colorInputs = [];
                        _this.qtyInputs  = [];
                        _this.resetAddToCartInputs();
                        //delete file from input
                        _this.$refs.file.value = null;
                    })
                    .catch(() => {
                        console.log('There was a problem creating your cart')
                    });
            },
            resetAddToCartInputs(){
                this.colorInputsCount = 0;
            },
            // Handles a change on the file upload
            handleFileUpload(event){
                if(this.validateFile()) {
                    this.file = this.$refs.file.files[0];
                }

            },
            validateFile(e){
                if (this.$refs.file.files[0] && this.$refs.file.files[0].size > 1024 * 1024) {
                    this.$swal({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'File too big (> 1MB)!',
                    });
                    //delete file from input
                    this.$refs.file.value = null;
                    return false;
                }
                if(this.$refs.file.files[0] && (this.$refs.file.files[0].type === "image/jpeg" || this.$refs.file.files[0].type === "image/png")){
                    return true;
                }else{
                    this.$swal({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Only JPG/PNG is allowed!',
                    });
                    //delete file from input
                    this.$refs.file.value = null;
                    return false;
                }
            },
            onImageLoadFailure (event, size) {
                event.target.src = '/images/defaule-p.jpg';
            },
            addColorInput(){
                this.colorInputsCount += 1;
            },
            validateInput(idAndColor, selectIndex){

                //id and color concatenated
                var colorValue = idAndColor.split("-");
                // load attribute images by attribute ID
                this.loadColorImages(null, colorValue[0] );
                // select color value by setting select2 input
                $('.select-colors-product-'+selectIndex).val(idAndColor);
                // delete color & quantity inputs if color already selected
                if(this.colorInputs.includes(colorValue[0])){
                    this.$swal({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Color is already added!',
                    }).then(() => {
                        // delete inputs
                        this.colorInputsCount = this.colorInputsCount - 1;
                    });
                }else{
                    // add new attribute color to cart
                    this.colorInputs.push(colorValue[0]);
                }
            },
            getColorObject(index){
                //color object contains name, code, images ...
                let colorObject = null;
                for(let key in this.product.colors){
                    if(key == index){
                        colorObject = this.product.colors[key];
                    }
                }
                return colorObject;
            },
            togglePrices(){
                this.show_prices = !this.show_prices;
            },
            checkUserAbilityToReview(){

                if(!this.selected_attribute.id){
                    this.$swal({
                        title: 'Which Color!',
                        text: "Select color you want to review ...",
                        icon: 'error',
                    });
                    return;
                }

                axios.get('/api/v1/user-ability/review/'+this.selected_attribute.id)
                    .then((response) => {
                        let checkUser = response.data;

                        //if already review it
                        if(checkUser.ability === 'found'){
                            this.$swal({
                                title: 'Already reviewed!',
                                text: "You already reviewed this product!",
                                icon: 'info',
                            });
                            $('#addReview').modal('hide');
                        }else if(checkUser.ability === 'review'){
                            //show review modal
                            $('#addReview').modal('show');
                        }else{
                            this.$swal({
                                title: 'Did you buy it!',
                                text: "You have to buy this item to be able to submit a review!",
                                icon: 'error',
                            });
                            $('#addReview').modal('hide');
                        }
                    });
            },
            submitReview(){
                let postData = {
                    'productAttributeId': this.selected_attribute.id,
                    'rate': this.reviewRating,
                    'nickname': this.reviewNickname,
                    'review': this.reviewText
                };
                axios.post('/api/v1/user/review/', postData)
                    .then((response) => {
                        if(response.data.message === 'success'){
                            this.$swal({
                                title: 'Success!',
                                text: "Your review submitted successfully!",
                                icon: 'success',
                            });

                            //reset form
                            this.reviewRating = 0;
                            this.reviewNickname = '';
                            this.reviewText = '';

                            $('#addReview').modal('hide');
                        }else{
                            this.$swal({
                                title: 'Error!',
                                text: "Something went wrong!",
                                icon: 'error',
                            });
                        }
                    });

            },
            calcItemPrice(item){
                //same in store.js ===> URGENT refactor
                // get base prices defined by admin
                // search for max_qty based on user enter qty
                // calc item price
                // dispatch create item
                let basePrices = item.base_product_prices;
                let qtyIndexSelected = null;
                let itemTotalQty = item.product_qty;
                let qtyPriceSelected = null;
                let searchQtyDefined = null;
                let definedQty  = Object.keys(basePrices);

                definedQty.forEach(function(value){
                    if(parseInt(itemTotalQty) >= value){
                        searchQtyDefined = value;
                    }
                });

                if(!searchQtyDefined){
                    qtyIndexSelected = Math.max.apply(null, definedQty);
                }else{
                    qtyIndexSelected = searchQtyDefined;
                }
                qtyPriceSelected = basePrices[qtyIndexSelected];
                item.product_price = parseInt(qtyPriceSelected);

                return item;
            },
            removeColorInput(index){
                this.colorInputsCount = this.colorInputsCount -  1;
            }

        },
        updated: function () {
            let _this = this;
            let selectIndex = 0;
            if(_this.colorInputsCount){
                selectIndex = _this.colorInputsCount - 1;
            }
            this.$nextTick(function () {
                // Code that will run only after the
                // entire view has been re-rendered
                _this.runSelect2();

                // Item slider inner details page
                if(!this.sliderFor){
                    $('.slider-for').slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: true,
                        fade: true,
                        centerMode: true,
                        asNavFor: '.slider-nav'
                    });
                    this.sliderFor = true;
                }

                if(!this.sliderNav){
                    $('.slider-nav').slick({
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        asNavFor: '.slider-for',
                        dots: false,
                        arrows: false,
                        centerMode: false,
                        focusOnSelect: true,
                    });

                    this.sliderNav =true;
                }

                //related products
                if(!this.relatedSliderOnce){
                    $(".relatedprod-slide").slick({
                        dots: false,
                        autoplay: false,
                        infinite: true,
                        slidesToShow: 4,
                        slideswToScroll: 1,
                        arrows: true,
                        responsive: [
                            {
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: 2
                                }
                            },
                            {
                                breakpoint: 480,
                                settings: {
                                    arrows: false,
                                    centerMode: true,
                                    centerPadding: '40px',
                                    slidesToShow: 1
                                }
                            }
                        ]
                    });

                    this.relatedSliderOnce = true;
                }

            });
        },
        computed: {
            isAuth(){
                return this.$store.getters['authModule/isAuthenticated'];
            },
            pricesForMinQtyDiscount(){
                if(this.pricesForMinQty['discount'] && parseInt(this.pricesForMinQty['discount']) != 0){
                    return this.pricesForMinQty['discount'];
                }
                return null;
            }
        },
        data: function () {
            return {
                showMainImage: true,
                colorInputsCount: 1,
                originalPrice: null,
                discountFound: null,
                productPrices: [],
                min_price: null,
                pricesForMinQty: [],
                show_prices: false,
                colorInputs: [],
                qtyInputs: [],
                defaultMainGallery: Object,
                images: Object,
                product: {
                    main_gallery: Object,
                    colors: Object
                },
                selected_attribute: {
                    id: null,
                    sku: 0,
                    stock: 0,
                    color_name: ''
                },
                relatedSliderOnce: false,
                sliderFor: false,
                sliderNav: false,
                file: '',
                cart_discount: 0,
                cart_product_attributes: {},
                cart: [],
                cartItem: this.$store.state.cartModule.cartItem,
                itemQty: 1,
                reviewRating: 0,
                reviewNickname: '',
                reviewText: ''
            }
        }
    }
</script>
