<template>
    <div>
        <div class="innr-banner fullwidth">
            <img :src="'/uploads/'+category.banner"
                 @error="onImageLoadFailure($event, '1400x250')"
                 style="max-height: 315px;" />
            <div class="heading">
                <h2>{{category.name_en}}</h2>
                <ul class="breadcrumb">
                    <li><router-link to="/" exact>Home</router-link></li>
                    <li class="active">{{category.name_en}}</li>
                </ul>
            </div>
        </div><!--/.banner-->

        <div class="container innr-cont-area">
            <div class="input-group big-searchbox">
                <input type="text" class="form-control"  placeholder="Keyword Search" >
                <span class="input-group-addon rounded-0">
              <button type="submit" class="btn btn-success rounded-0">
                  <span class="glyphicon glyphicon-search"></span>
                  SEARCH
              </button>
          </span>
            </div><!--/.big-searchbox-->

            <div class="row">
                <div class="col-sm-3 side-filtering">
                    <div class="panel panel-default">
                        <ul class="nav nav-pills nav-stacked" id="stacked-menu">
                            <!-- Category collapsed menu -->
                            <li class="main-cat">
                                <a class="nav-container" data-toggle="collapse" data-parent="#stacked-menu" href="#categories">Categories</a>
                                <ul class="nav nav-pills nav-stacked collapse in hide-mob" id="categories">
                                    <!-- Home Link -->
                                    <li>
                                        <a class="single-category">Home </a>
                                    </li>
                                    <!-- Technologies Link -->
                                    <li class="nav-sub-container" data-toggle="collapse" data-parent="#p1" href="#Tech">
                                        <a>Technologies</a>
                                    </li>
                                    <ul class="nav nav-pills nav-stacked collapse in" id="Tech">
                                        <li><a href="#">Technologies Sub Cat1</a></li>
                                        <li><a href="#">Technologies Sub Cat2</a></li>
                                    </ul>
                                    <!-- Leisure Link -->
                                    <li class="nav-sub-container" data-toggle="collapse" data-parent="#p1" href="#Leisure">
                                        <a>Leisure</a>
                                    </li>
                                    <ul class="nav nav-pills nav-stacked collapse" id="Leisure">
                                        <li><a href="#">Leisure Sub Cat1</a></li>
                                        <li><a href="#">Leisure Sub Cat2</a></li>

                                    </ul>
                                    <!-- Drinkware Link -->
                                    <li class="nav-sub-container" data-toggle="collapse" data-parent="#p1" href="#Drinkware">
                                        <a>Drinkware</a>
                                    </li>
                                    <ul class="nav nav-pills nav-stacked collapse" id="Drinkware">
                                        <li><a href="#">Drinkware Sub Cat1</a></li>
                                        <li><a href="#">Drinkware Sub Cat2</a></li>
                                    </ul>
                                    <!-- Kids Link -->
                                    <li class="nav-sub-container" data-toggle="collapse" data-parent="#p1" href="#Kids">
                                        <a>Kids</a>
                                    </li>
                                    <ul class="nav nav-pills nav-stacked collapse" id="Kids">
                                        <li><a href="#">Kids Sub Cat1</a></li>
                                        <li><a href="#">Kids Sub Cat2</a></li>
                                    </ul>
                                    <!-- Stationary Link -->
                                    <li class="nav-sub-container" data-toggle="collapse" data-parent="#p1" href="#Stationary">
                                        <a>Stationary</a>
                                    </li>
                                    <ul class="nav nav-pills nav-stacked collapse" id="Stationary">
                                        <li><a href="#">Stationary Sub Cat1</a></li>
                                        <li><a href="#">Stationary Sub Cat2</a></li>
                                    </ul>
                                    <!-- Premiums Link -->
                                    <li class="nav-sub-container" data-toggle="collapse" data-parent="#p1" href="#Premiums">
                                        <a>Premiums</a>
                                    </li>
                                    <ul class="nav nav-pills nav-stacked collapse" id="Premiums">
                                        <li><a href="#">Premiums Sub Cat1</a></li>
                                        <li><a href="#">Premiums Sub Cat2</a></li>
                                    </ul>
                                    <!-- Care Link -->
                                    <li class="nav-sub-container" data-toggle="collapse" data-parent="#p1" href="#Care">
                                        <a>Care</a>
                                    </li>
                                    <ul class="nav nav-pills nav-stacked collapse" id="Care">
                                        <li><a href="#">Care Sub Cat1</a></li>
                                        <li><a href="#">Care Sub Cat2</a></li>
                                    </ul>
                                    <!-- Apparel Link -->
                                    <li class="nav-sub-container" data-toggle="collapse" data-parent="#p1" href="#Apparel">
                                        <a>Apparel</a>
                                    </li>
                                    <ul class="nav nav-pills nav-stacked collapse" id="Apparel">
                                        <li><a href="#">Apparel Sub Cat1</a></li>
                                        <li><a href="#">Apparel Sub Cat2</a></li>
                                    </ul>
                                    <!-- Themes Link -->
                                    <li class="nav-sub-container" data-toggle="collapse" data-parent="#p1" href="#Themes">
                                        <a>Themes</a>
                                    </li>
                                    <ul class="nav nav-pills nav-stacked collapse" id="Themes">
                                        <li><a href="#">Themes Sub Cat1</a></li>
                                        <li><a href="#">Themes Sub Cat2</a></li>
                                    </ul>
                                    <!-- Factory Link -->
                                    <li class="nav-sub-container" data-toggle="collapse" data-parent="#p1" href="#Factory">
                                        <a>Factory</a>
                                    </li>
                                    <ul class="nav nav-pills nav-stacked collapse" id="Factory">
                                        <li><a href="#">Factory Sub Cat1</a></li>
                                        <li><a href="#">Factory Sub Cat2</a></li>
                                    </ul>
                                </ul><!--/nav-->
                            </li><!--/.main-cat-->

                            <!-- Color collapsed menu -->
                            <li class="main-cat">
                                <a class="nav-container" data-toggle="collapse" data-parent="#stacked-menu" href="#Color">Color</a>
                                <ul class="nav nav-pills nav-stacked collapse in hide-mob" id="Color">
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn active selct-clr" style="background: #d1bda1;">
                                            <input type="radio" name="options" id="option2" autocomplete="off" chacked="">
                                        </label>
                                        <label class="btn selct-clr" style="background: #232323;">
                                            <input type="radio" name="options" id="option1" autocomplete="off">
                                        </label>
                                        <label class="btn selct-clr" style="background: #506cbb;">
                                            <input type="radio" name="options" id="option2" autocomplete="off">
                                        </label>
                                        <label class="btn selct-clr" style="background: #b5b5b5;">
                                            <input type="radio" name="options" id="option2" autocomplete="off">
                                        </label>
                                        <label class="btn selct-clr" style="background: #00b37d;">
                                            <input type="radio" name="options" id="option2" autocomplete="off">
                                        </label>
                                        <label class="btn selct-clr" style="background: #eeeeee;">
                                            <input type="radio" name="options" id="option2" autocomplete="off">
                                        </label>
                                        <label class="btn selct-clr" style="background: #fdfa8f;">
                                            <input type="radio" name="options" id="option2" autocomplete="off">
                                        </label>
                                    </div>
                                </ul>
                            </li>

                            <!-- Price collapsed menu -->
                            <li class="main-cat">
                                <a class="nav-container" data-toggle="collapse" data-parent="#stacked-menu" href="#price">Price</a>
                                <ul class="nav nav-pills nav-stacked collapse in hide-mob" id="price">
                                    <li class="pad-15">
                                        <div id="slider-range"></div>
                                        <input class="rangedprice pull-left" type="text"id="amountfrm" readonly style="text-align:left;">
                                        <input class="rangedprice pull-right" type="text"id="amountto" readonly >
                                    </li>
                                </ul>
                            </li>

                            <!-- Size collapsed menu -->
                            <li class="main-cat">
                                <a class="nav-container" data-toggle="collapse" data-parent="#stacked-menu" href="#Discount">Discount</a>
                                <ul class="nav nav-pills nav-stacked collapse in hide-mob" id="Discount">
                                    <li>
                                        <label class="discount-chk">Up to 30%
                                            <input type="checkbox" checked="checked">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="discount-chk">30% - 50%
                                            <input type="checkbox">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="discount-chk">50% - 60%
                                            <input type="checkbox">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="discount-chk">+ 60%
                                            <input type="checkbox">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="discount-chk">Full Price
                                            <input type="checkbox">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div><!--/.col-sm-3-->
                <div class="col-sm-9 product-listing">
                    <div class="row">
                        <div class="col-sm-12 filtering">
                            <div class="pull-left" v-if="pagination">
                                {{pagination.total}} items
                            </div>

                            <div class="pull-right">
                                <span> SORT BY : </span>
                                <select>
                                    <option>PRICE - HIGH TO LOW</option>
                                </select>
                            </div>
                        </div><!--/.filtering-->
                    </div><!--/.row-->
                    <div class="row" v-for="chunk in productChunks">
                        <div class="col-sm-4" v-for="product in chunk">
                            <div class="prod-bx">
                                <div class="img">
                                    <router-link :to="'/products/'+product.id">
<!--                                    <a href="product-details.html">-->
                                        <img :src="'/uploads/' + product.main_image"
                                             @error="onImageLoadFailure($event, '250x250')" style="min-height: 250px">
<!--                                    </a>-->
                                    </router-link>
                                    <div class="hover">
                                        <a href="#"><img src="/images/favourite.png"></a>
<!--                                        <a href="#"><img src="/images/cart1.png"></a>-->
                                    </div>
                                </div>
                                <div class="data clearfix">
                                    <h4>{{product.name_en}}</h4>
                                    <div class="price">
                                        Login to check price
<!--                                        24.00 KD <span>30.00 KD</span>-->
                                    </div>
                                    <div class="rate-cvr clearfix">
                                        <div class="rate">
                                            <input type="radio" value="5" :checked="product.rating == 5" disabled>
                                            <label title="text">5 stars</label>
                                            <input type="radio"  value="4" :checked="product.rating == 4" disabled>
                                            <label title="text">4 stars</label>
                                            <input type="radio" value="3" :checked="product.rating == 3" disabled>
                                            <label title="text">3 stars</label>
                                            <input type="radio" value="2" :checked="product.rating == 2" disabled>
                                            <label title="text">2 stars</label>
                                            <input type="radio" value="1" :checked="product.rating == 1" disabled>
                                            <label title="text">1 star</label>
                                        </div>

                                    </div>
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn active selct-clr" style="background: #d1bda1;">
                                            <input type="radio" name="options" id="option2" autocomplete="off" chacked="">
                                        </label>
                                        <label class="btn selct-clr" style="background: #232323;">
                                            <input type="radio" name="options" id="option1" autocomplete="off">
                                        </label>
                                        <label class="btn selct-clr" style="background: #506cbb;">
                                            <input type="radio" name="options" id="option2" autocomplete="off">
                                        </label>
                                    </div>
                                </div>
                                <!--/.data-->
                            </div>
                            <!--/.prod-bx-->
                        </div>
                        <!--/.col-sm-4-->
                    </div>
                    <!--/.row-->
                    <div class="text-center d-block" v-if="pagination.total >= 9 && pagination.last_page > pagination.current_page">
                        <a class="viewmore" href="#" @click.prevent="loadMoreProducts()" >View More</a>
                    </div>
                </div><!--/.col-sm-9-->
            </div>

        </div><!--/.innr-cont-area-->

    </div>
</template>

<script>
    import _ from 'lodash';

    export default {

        mounted() {
            this.slug = this.$route.params.slug;
            this.loadProducts();
        },
        beforeRouteUpdate(to, from, next) {
            this.slug = to.params.slug;
            this.loadProducts();
            next();
        },
        computed: {
            productChunks(){
                return _.chunk(Object.values(this.products), 3);
            }
        },
        methods: {
            loadProducts(){
                axios.all([
                    axios.get('/api/v1/category-products/'+this.slug)
                ]).then(axios.spread((categoryResponse) => {
                    this.products = categoryResponse.data.products.data;
                    this.pagination = categoryResponse.data.products;
                    this.category   = categoryResponse.data.category;
                }));
            },
            loadMoreProducts(){
                let next_page = this.pagination.current_page + 1;
                axios.all([
                    axios.get('/api/v1/category-products/'+this.slug+'?page='+ next_page)
                ]).then(axios.spread((categoryResponse) => {
                    this.products.push(...categoryResponse.data.products.data);
                    this.pagination = categoryResponse.data.products;
                    this.category   = categoryResponse.data.category;
                }));
            },
            onImageLoadFailure (event, size) {
                event.target.src = 'https://via.placeholder.com/'+size;
            }

        },

        data: function () {
            return {
                slug: null,
                current_page: 0,
                category: {},
                products: [],
                pagination: {}
            }
        }
    }
</script>
