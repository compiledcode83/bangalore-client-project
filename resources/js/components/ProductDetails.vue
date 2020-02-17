<template>
    <div>

        <div class="product-detail-bnr fullwidth text-center">
            <ul class="breadcrumb">
                <li><a href="http://www.mawaqaa.com/clients/demos/itc/html3/index.html">Home</a></li>
                <li><a href="http://www.mawaqaa.com/clients/demos/itc/html3/bags.html">Product Listing</a></li>
                <li class="active">Product Name</li>
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
                                            D
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
                        <h2> {{product.name_en}} <span v-if="product.show_left_qty && selected_attribute.stock">( Only {{selected_attribute.stock}} left )</span></h2>
                        <div class="price clearfix">
                            <div class="pull-left" v-if="isAuth">
                                <div v-if="min_price">
                                    <strong v-if="pricesForMinQtyDiscount">{{$t('pages.starting_from')}} {{pricesForMinQty.discount}} {{$t('pages.kd')}}</strong>
                                    <strong v-else>{{$t('pages.starting_from')}} {{pricesForMinQty.price}} {{$t('pages.kd')}}</strong>
                                    <u v-if="pricesForMinQtyDiscount">{{$t('pages.starting_from')}} {{pricesForMinQty.price}} {{$t('pages.kd')}}</u>
                                </div>
                                <b v-else> {{$t('pages.price_based_on_select')}} </b>
                                <p style="line-height: 0;font-size:12px;margin-top:5px;cursor: pointer;"
                                    v-if="min_price" @click="togglePrices"> view prices </p>
                            </div>
                            <div class="pull-left" v-else>
                               <strong> {{$t('pages.login_to_check_price')}} </strong>
                            </div>
                            <div class="pull-right stock">
                                <span v-if="selected_attribute.stock > 0">In stock</span>
                                <strong> {{selected_attribute.sku}} </strong>
                            </div>

                            <div class="prices" v-if="show_prices">
                                <svg width='100%' height='100%' xmlns='http://www.w3.org/2000/svg'>

                                    <title>SVG Table</title>

                                    <g id='columnGroup'>
                                        <rect x='65' y='10' width='75' height='80' fill='gainsboro'/>
                                        <rect x='265' y='10' width='75' height='80' fill='gainsboro'/>

                                        <text x='30' y='30' font-size='18px' font-weight='bold' fill='crimson'>
                                            <tspan x='30' dy='1.5em'>Q1</tspan>
                                            <tspan x='30' dy='1em'>Q2</tspan>
                                        </text>

                                        <text x='100' y='30' font-size='18px' text-anchor='middle'>
                                            <tspan x='100' font-weight='bold' fill='crimson'>Sales</tspan>
                                            <tspan x='100' dy='1.5em'>$ 223</tspan>
                                            <tspan x='100' dy='1em'>$ 183</tspan>
                                        </text>

                                        <text x='200' y='30' font-size='18px' text-anchor='middle'>
                                            <tspan x='200' font-weight='bold' fill='crimson'>Expenses</tspan>
                                            <tspan x='200' dy='1.5em'>$ 195</tspan>
                                            <tspan x='200' dy='1em'>$ 70</tspan>
                                        </text>

                                        <text x='300' y='30' font-size='18px' text-anchor='middle'>
                                            <tspan x='300' font-weight='bold' fill='crimson'>Net</tspan>
                                            <tspan x='300' dy='1.5em'>$ 28</tspan>
                                            <tspan x='300' dy='1em'>$ 113</tspan>
                                        </text>
                                    </g>

                                </svg>
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
                                <a href="#"><span class="red">10</span>  Review(s)</a>   /
                                <a href="#" @click.prevent="checkUserAbilityToReview">Add Your Review</a>
                            </div>
                        </div><!--/.row-->

                        <div class="modal fade login-model" id="addReview" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content rounded-0">
                                    <div class="modal-header">Add Your Review
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
                                                <label for="nickname">Nickname</label>
                                                <input type="text" class="form-control" id="nickname" aria-describedby="emailHelp" placeholder="Enter your nickname" v-model="reviewNickname">
                                            </div>
                                            <div class="form-group mt-10 mb-10 fullwidth">
                                                <label >Review Details</label>
                                                <textarea class="form-control" name="review" v-model="reviewText"></textarea>
                                            </div>
                                            <br>
                                            <button type="submit" class="btn btn-danger rounded-0"  @click.prevent="submitReview">Submit</button>
                                        </form>
                                    </div><!--/.modal-body-->
                                </div>
                            </div>
                        </div>
                        <div v-if="isAuth && selected_attribute.stock > 0">
                            <ul class="file-upload">
                                <li class="row quantity">
                                    <div class="col-sm-3">Uploads -</div>
                                    <div class="col-sm-9">
                                        <div class="form-group user-register">
                                            <input id="uploadFile" class="normal-text-box" placeholder="CLICK TO UPLOAD IMAGE(JPG OR PNG)" disabled="disabled" :value="file.name">
                                            <div class="fileUpload">
                                                <span>Browse</span>
                                                <input class="upload" type="file" id="file" ref="file" @change="handleFileUpload($event)"/>
                                            </div>
                                        </div>
                                    </div>
                                </li><!--/li-->
                            </ul>
                            <ul class="color-load">
                                <li class="row quantity" v-for="(colorInput, index) in colorInputsCount">
                                    <div class="col-sm-3">
                                        <select class="js-example-basic-single color-select form-control"
                                                name="colorSelectedByIds[]"
                                                v-model="colorInputs[index]"
                                                @change="validateInput($event)">
                                            <option value="null">Choose Color</option>
                                            <option
                                                v-for="(color, index) in product.colors"
                                                :value="index"
                                            > {{color.name}}  </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control rounded-0" name="qtySelectedWithColors[]" v-model="qtyInputs[index]">
                                    </div>
                                </li><!--/li-->
                            </ul>
                            <button class="more add" @click="addColorInput">Add More Colors</button>

                            <div class="row">
                                <div class="col-sm-6"><button class="btn-lg btn-success full-width" @click="submitCart()">ADD TO CART</button></div>
                                <div class="col-sm-6"><button class="btn-lg btn-primary full-width">ADD TO WISHLIST</button></div>
                            </div>
                        </div>
                        <span class="out-stock" v-if="selected_attribute.id && selected_attribute.stock == 0"></span>
                    </div><!--/.col-sm-6-->
                </div><!--/.row-->

                <div class="tab-cvr">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class=""><a href="http://www.mawaqaa.com/clients/demos/itc/html3/product-details.html#Details" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="false">Details</a></li>
                        <li role="presentation" class=""><a href="http://www.mawaqaa.com/clients/demos/itc/html3/product-details.html#Info" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">More Information</a></li>
                        <li role="presentation" class="active"><a href="http://www.mawaqaa.com/clients/demos/itc/html3/product-details.html#Reviews" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="true">Reviews (6)</a></li>
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
                            <div class="row">
                                <div class="col-sm-6 col-md-7">
                                    <h4>Cheri of Goleta,&amp;sp CA</h4>
                                </div>
                                <div class="col-sm-6 col-md-5">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-5">
                                            <div class="rate">
                                                <star-rating active-color="#e01b22" :show-rating="false" :rating=2 :item-size=20 border-color="#fff" read-only></star-rating>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-7">
                                            <p class="date-rate">12 Jan 2018 ( 10 days ago )</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <p>I ordered a costume in children's small and was sent an extra small. I asked for a refund and was sent another extra small costume.<br>ShopDisney has me dealing with UPS returns over and over and no refund...</p>
                                </div>
                            </div><!--/.row-->
                            <hr>
                            <div class="row">
                                <div class="col-sm-6 col-md-7">
                                    <h4>Cheri of Goleta,&amp;sp CA</h4>
                                </div>
                                <div class="col-sm-6 col-md-5">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-5">
                                            <div class="rate">
                                                <star-rating active-color="#e01b22" :show-rating="false" :rating=2 :item-size=20 border-color="#fff" read-only></star-rating>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-7">
                                            <p class="date-rate">12 Jan 2018 ( 10 days ago )</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <p>I ordered a costume in children's small and was sent an extra small. I asked for a refund and was sent another extra small costume.<br>ShopDisney has me dealing with UPS returns over and over and no refund...</p>
                                </div>
                            </div><!--/.row-->
                        </div>
                    </div>
                </div>
            </div><!--/.product-details-->
        </div><!--/.innr-cont-area-->

        <div class="related-products">
            <div class="container">
                <h2>Related <span>Products</span></h2>
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

                    this.addToCart(colorObjectInput, key);
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
                    formData.append('product_price', '0');
                    formData.append('total', '0');
                    /*
                      Make the request to the POST /single-file URL
                    */
                    let  _this = this;

                    axios.post('/api/v1/cart/item',
                        formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
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
                        //delete file from input
                        _this.$refs.file.value = null;
                    })
                    .catch(() => {
                        console.log('There was a problem creating your cart')
                    });
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
                // this.colorInputs.push({ id: '', qty: 0 });
                this.colorInputsCount += 1;
            },
            validateInput(event){

                // @ToDo when add delete elements will fix delete redundancy
                // let colorId = event.target.value;
                // console.log(this.colorInputs);
                // console.log(this.qtyInputs);
                // // if color input is already added
                // let checkColorAdded = this.colorInputs.filter(function(value){
                //     return value === colorId;
                // });
                //
                // if(checkColorAdded.length > 1){
                //     this.$swal({
                //         icon: 'error',
                //         title: 'Oops...',
                //         text: 'Color is already added!',
                //     });
                //
                //     let indexToRemove = this.colorInputs.length - 1;
                //     console.log(indexToRemove);
                //     delete this.colorInputs[indexToRemove];
                //     delete this.qtyInputs[indexToRemove];
                //
                //     console.log(this.colorInputs);
                //     console.log(this.qtyInputs);
                //
                //     return;
                // }

                this.loadColorImages(null, event.target.value );
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

            }

        },
        updated: function () {
            this.$nextTick(function () {
                // Code that will run only after the
                // entire view has been re-rendered
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
