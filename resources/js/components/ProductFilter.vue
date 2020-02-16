<template>
    <div class="col-sm-3 side-filtering">
        <div class="panel panel-default">
            <ul class="nav nav-pills nav-stacked" id="stacked-menu">
                <!-- Category collapsed menu -->
                <li class="main-cat" v-if="(singleCategories && singleCategories.length >= 1) || (multipleCategories && multipleCategories.length >= 1)">
                    <a class="nav-container" data-toggle="collapse" data-parent="#stacked-menu" href="#categories">Categories</a>
                    <ul class="nav nav-pills nav-stacked collapse in hide-mob" id="categories">
                        <!-- Home Link -->

                        <li v-for="category in singleCategories" >
                            <a
                                :class="'single-category ' + categoryActive(category.slug)"
                                @click.prevent="toggleQueryString('cat', category.slug)">
                                {{category.name_en}}
                            </a>
                        </li>

                        <!-- Technologies Link -->
                        <div v-for="category in multipleCategories">
                            <li class="nav-sub-container" data-toggle="collapse" :data-parent="'#'+category.slug" :href="'#'+category.slug">
                                <a>{{category.name_en}}</a>
                            </li>
                            <ul class="nav nav-pills nav-stacked collapse in" :id="'#'+category.slug">
                                <li v-for="subCategory in category.subCategories">
                                    <router-link :to="{ name: 'productList', query: { cat: subCategory.slug }}">
                                        {{subCategory.name_en}}
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </ul><!--/nav-->
                </li><!--/.main-cat-->

                <!-- Color collapsed menu -->
                <li class="main-cat">
                    <a class="nav-container" data-toggle="collapse" data-parent="#stacked-menu" href="#Color">Color</a>
                    <ul class="nav nav-pills nav-stacked collapse in hide-mob" id="Color">
                        <div class="btn-group" data-toggle="buttons">

                            <label
                                v-for="color in colors"
                                :class="'btn selct-clr ' +  colorActive(color.id)"
                                :style="{background: color.other_value}"
                                @click.prevent="toggleQueryString('color', color.id)">

                                <input
                                    type="radio"
                                    name="options"
                                    autocomplete="off">

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

                            <vue-range-slider
                                v-model="priceSliderValue"
                                :bg-style="bgStyle"
                                :min="sliderPriceMin" :max="sliderPriceMax"
                                :enable-cross="enableCross"
                                :tooltip-style="tooltipStyle"
                                :process-style="processStyle"
                                @drag-end="priceChanged">
                            </vue-range-slider>

                            <input class="rangedprice pull-left" type="text"id="amountfrm" readonly style="text-align:left;">
                            <input class="rangedprice pull-right" type="text"id="amountto" readonly >
                        </li>
                    </ul>
                </li>

                <!-- Size collapsed menu -->
                <li class="main-cat">
                    <a class="nav-container" data-toggle="collapse" data-parent="#stacked-menu" href="#Discount">Discount</a>
                    <ul class="nav nav-pills nav-stacked collapse in hide-mob" id="Discount">
                        <li v-if="discounts.upTo30">
                            <label class="discount-chk">Up to 30%
                                <input type="checkbox" checked="checked">
                                <span class="checkmark"></span>
                            </label>
                        </li>
                        <li v-if="discounts.upTo50">
                            <label class="discount-chk">30% - 50%
                                <input type="checkbox">
                                <span class="checkmark"></span>
                            </label>
                        </li>
                        <li v-if="discounts.upTo60">
                            <label class="discount-chk">50% - 60%
                                <input type="checkbox">
                                <span class="checkmark"></span>
                            </label>
                        </li>
                        <li v-if="discounts.moreThan60">
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
</template>

<script>

    import 'vue-range-component/dist/vue-range-slider.css'
    import VueRangeSlider from 'vue-range-component'

    export default {

        name: 'productFilter',
        props: ['singleCategories', 'multipleCategories', 'colors', 'minPrice', 'maxPrice', 'discounts'],
        components: {VueRangeSlider},
        data: function () {
            return {
                filterCategory: [],
                filterColor: [],
                priceSliderValue: [parseInt(this.minPrice),parseInt(this.maxPrice)]
            }
        },
        created() {
            this.sliderPriceMin = parseInt(this.minPrice);
            this.sliderPriceMax = parseInt(this.maxPrice);
            this.enableCross = false;
            this.bgStyle = {
                backgroundColor: '#fff',
                boxShadow: 'inset 0.5px 0.5px 3px 1px rgba(0,0,0,.36)'
            };
            this.tooltipStyle = {
                backgroundColor: '#be1522',
                borderColor: '#be1522'
            };
            this.processStyle = {
                backgroundColor: '#be1522'
            };
        },
        methods: {
            priceChanged(){
                console.log(this.priceSliderValue);
            },
            colorActive(id){
                if(this.filterColor == id){
                    return 'active';
                }else{
                    return "";
                }
            },
            categoryActive(slug){
                if(this.filterCategory == slug){
                    return 'active';
                }else{
                    return "";
                }
            },
            toggleQueryString(filterType, filterValue){
                let query = Object.assign({}, this.$route.query);

                if(filterType === 'cat') {

                    if(this.filterCategory.includes(filterValue))
                    {
                        //delete this element
                        this.filterCategory = [];

                        return this.$router.push({ name: 'productList', query: {
                                cat: this.filterCategory,
                                color: this.filterColor
                            }});
                    }else{

                        if(this.filterCategory !== filterValue){
                            this.filterCategory = filterValue;
                        }else{
                            this.filterCategory = [];

                            return this.$router.push({ name: 'productList', query: {
                                    cat: this.filterCategory,
                                    color: this.filterColor
                                }});
                        }

                        return this.$router.push({ name: 'productList', query: {
                                cat: this.filterCategory,
                                color: this.filterColor
                            }});
                    }
                }

                if(filterType === 'color') {

                    if(this.filterColor.includes(filterValue))
                    {
                        //delete this element
                        this.filterColor = [];

                        return this.$router.push({ name: 'productList', query: {
                                color: this.filterColor,
                                cat: this.filterCategory
                            }});
                    }else{
                        //add this element to  array
                        if(this.filterColor[0] !== filterValue){
                            this.filterColor[0] = filterValue;
                        }else {
                            this.filterColor = [];

                            return this.$router.push({
                                name: 'productList', query: {
                                    cat: this.filterCategory,
                                    color: this.filterColor
                                }
                            });
                        }
                        //rebuild query string
                        return this.$router.push({ name: 'productList', query: {
                                color: this.filterColor,
                                cat: this.filterCategory
                            }});
                    }
                }
            }
        }
    }
</script>
