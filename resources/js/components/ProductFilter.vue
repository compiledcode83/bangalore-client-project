<template>
    <div class="col-sm-3 side-filtering">
        <div class="panel panel-default">
            <button id="filter_btn" class="btn-lg btn-primary full-width hidden-md hidden-sm hidden-lg"><span class="glyphicon glyphicon-filter"></span>
                  Filter
              </button>
            <ul class="nav nav-pills nav-stacked hidden-xs" id="stacked-menu">
                <!-- Category collapsed menu -->
                <li class="main-cat" v-if="(singleCategories && singleCategories.length >= 1) || (multipleCategories && multipleCategories.length >= 1)">
                    <a class="nav-container" data-toggle="collapse" data-parent="#stacked-menu" href="#categories">{{$t('pages.categories')}}</a>
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
                    <a class="nav-container" data-toggle="collapse" data-parent="#stacked-menu" href="#Color">{{$t('pages.color')}}</a>
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
                <li class="main-cat" v-if="isAuth">
                    <a class="nav-container" data-toggle="collapse" data-parent="#stacked-menu" href="#price">{{$t('pages.price')}}</a>
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
                                :formatter="formatter"
                                :lazy=true
                                @slide-end="toggleQueryString('price',0)">
                            </vue-range-slider>

                            <input class="rangedprice pull-left" type="text" id="amountfrm" readonly style="text-align:left;">
                            <input class="rangedprice pull-right" type="text" id="amountto" readonly >
                        </li>
                    </ul>
                </li>

                <!-- Size collapsed menu -->
                <li class="main-cat" v-if="isAuth">
                    <a class="nav-container" data-toggle="collapse" data-parent="#stacked-menu" href="#Discount">{{$t('pages.discount')}}</a>
                    <ul class="nav nav-pills nav-stacked collapse in hide-mob" id="Discount">
                        <li v-if="discounts.upTo30">
                            <label class="discount-chk">Up to 30%
                                <input type="checkbox" id="upTo30" value="upTo30" v-model="filterBoxes" :disabled="disabledBoxes"
                                       :checked="toggleQueryString('discount','upTo30')">
                                <span class="checkmark"></span>
                            </label>
                        </li>
                        <li v-if="discounts.upTo50">
                            <label class="discount-chk">30% - 50%
                                <input type="checkbox" id="upTo50" value="upTo50" v-model="filterBoxes" :disabled="disabledBoxes"
                                       :checked="toggleQueryString('discount','upTo50')">
                                <span class="checkmark"></span>
                            </label>
                        </li>
                        <li v-if="discounts.upTo60">
                            <label class="discount-chk">50% - 60%
                                <input type="checkbox" id="upTo60" value="upTo60" v-model="filterBoxes" :disabled="disabledBoxes"
                                       :checked="toggleQueryString('discount','upTo60')">
                                <span class="checkmark"></span>
                            </label>
                        </li>
                        <li v-if="discounts.moreThan60">
                            <label class="discount-chk">+ 60%
                                <input type="checkbox" id="moreThan60" value="moreThan60" v-model="filterBoxes" :disabled="disabledBoxes"
                                       :checked="toggleQueryString('discount','moreThan60')">
                                <span class="checkmark"></span>
                            </label>
                        </li>
<!--                        <li>-->
<!--                            <label class="discount-chk">{{$t('pages.fullPrice')}}-->
<!--                                <input type="checkbox"  v-model="fullPrice"-->
<!--                                       :checked="toggleQueryString('discount','0')">-->
<!--                                <span class="checkmark"></span>-->
<!--                            </label>-->
<!--                        </li>-->
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
                fullPrice: null,
                disabledBoxes: false,
                filterBoxes: [],
                filterCategory: [],
                filterColor: [],
                filterPrice: [],
                sliderPriceMin: parseInt(this.minPrice),
                sliderPriceMax: parseInt(this.maxPrice),
                priceSliderValue: [parseInt(this.minPrice),parseInt(this.maxPrice)]
            }
        },
        watch: {
            fullPrice : function(value){
                if(value){
                    this.filterBoxes = [];
                    this.disabledBoxes = true;
                }else{
                    this.disabledBoxes = false;
                }
            }
        },
        created() {
            /* price slider */
            // this.sliderPriceMin = parseInt(this.minPrice);
            // this.sliderPriceMax = parseInt(this.maxPrice);
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
            this.formatter = value => `${value} KD`
            /* End price slider */
        },
        computed: {
            isAuth() {
                return this.$store.getters['authModule/isAuthenticated'];
            },
            // sliderPriceMin(){
            //     return parseInt(this.minPrice);
            // },
            // sliderPriceMax(){
            //     return parseInt(this.maxPrice);
            // },
            // priceSliderValue:{
            //     get(){
            //         return [parseInt(this.minPrice),parseInt(this.maxPrice)];
            //     },
            //     set(minPrice, maxPrices){
            //         return [parseInt(minPrice),parseInt(maxPrices)];
            //     }
            // }
        },
        methods: {

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
                                    color: this.filterColor,
                                    min: this.filterPrice.min,
                                    max: this.filterPrice.max
                                }
                            });
                        }
                        //rebuild query string
                        return this.$router.push({ name: 'productList', query: {
                                color: this.filterColor,
                                cat: this.filterCategory,
                                min: this.filterPrice.min,
                                max: this.filterPrice.max
                            }});
                    }
                }

                if(filterType === 'price') {
                    let queryStringPrice = "min="+this.priceSliderValue[0]+"&max="+this.priceSliderValue[1];
                    this.filterPrice.min = this.priceSliderValue[0];
                    this.filterPrice.max = this.priceSliderValue[1];

                    return this.$router.push({ name: 'productList', query: {
                            color: this.filterColor,
                            cat: this.filterCategory,
                            min: this.filterPrice.min,
                            max: this.filterPrice.max
                        }});
                }

                if( filterType === 'discount' ){

                    return this.$router.push({ name: 'productList', query: {
                            color: this.filterColor,
                            cat: this.filterCategory,
                            min: this.filterPrice.min,
                            max: this.filterPrice.max,
                            discount: this.filterBoxes
                        }}).catch(err => {});
                }
            }
        }
    }
</script>
