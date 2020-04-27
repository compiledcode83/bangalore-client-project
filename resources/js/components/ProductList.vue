<template>
    <div>
        <div v-if="loading">
            <vue-content-loading :width="300" :height="100">
                <rect x="75" y="13" rx="0" ry="0" width="150" height="2" />
                <rect x="75" y="17" rx="0" ry="0" width="150" height="2" />
                <rect x="75" y="21" rx="0" ry="0" width="150" height="2" />
                <rect x="75" y="25" rx="0" ry="0" width="150" height="2" />
                <rect x="75" y="29" rx="0" ry="0" width="150" height="2" />
                <rect x="75" y="34" rx="0" ry="0" width="150" height="2" />
                <rect x="75" y="38" rx="0" ry="0" width="150" height="2" />
                <rect x="75" y="42" rx="0" ry="0" width="150" height="2" />
            </vue-content-loading>
        </div>
        <div v-else>
            <div class="innr-banner fullwidth">
            <img :src="'/uploads/'+category.banner"
                 @error="onImageLoadFailure($event, '1400x250')"
                 style="max-height: 315px;" />
            <div class="heading">
                <h2>{{category.name_en}}</h2>
                <ul class="breadcrumb">
                    <li><router-link to="/" exact>{{$t('pages.home')}}</router-link></li>
                    <li class="active">{{category.name_en}}</li>
                </ul>
            </div>
        </div><!--/.banner-->

            <div class="container innr-cont-area">
                <div class="input-group big-searchbox">
                    <input type="text" class="form-control"  placeholder="Keyword Search"  v-model="filterSearchTerm">
                    <span class="input-group-addon rounded-0">
              <button type="submit" class="btn btn-success rounded-0" @click.prevent="loadProducts" >
                  <span class="glyphicon glyphicon-search"></span>
                  {{$t('pages.search')}}
              </button>
          </span>
                </div><!--/.big-searchbox-->

                <div class="row">

                    <ProductFilter
                        :singleCategories="filterCategoriesList.singleCategories"
                        :multipleCategories="filterCategoriesList.multipleCategories"
                        :colors="productsFilterAttributes.colors"
                        :minPrice="productsFilterAttributes.prices.min"
                        :maxPrice="productsFilterAttributes.prices.max"
                        :discounts="productsFilterAttributes.discounts.filter"
                    ></ProductFilter>

                    <div class="col-sm-9 product-listing">
                        <div class="row">
                            <div class="col-sm-12 filtering">
                                <div class="pull-left" v-if="pagination">
                                    {{pagination.total}} {{$t('pages.items')}}
                                </div>

                                <div class="pull-right">
                                    <span> {{$t('pages.sortBy')}} : </span>
                                    <select v-model="filterSort" @change="loadProducts">
                                        <option></option>
                                        <option value="price_asc" v-if="isAuthenticated">{{$t('pages.price')}} - {{$t('pages.lowToHigh')}}</option>
                                        <option value="price_desc" v-if="isAuthenticated">{{$t('pages.price')}} - {{$t('pages.highToLow')}}</option>
                                        <option value="asc">{{$t('pages.alphabetic')}} - {{$t('pages.aToZ')}}</option>
                                        <option value="desc">{{$t('pages.alphabetic')}} - {{$t('pages.zToA')}}</option>
                                    </select>
                                </div>
                            </div><!--/.filtering-->
                        </div><!--/.row-->
                        <div class="row" v-for="chunk in productChunks">
                            <div class="col-sm-4" v-for="product in chunk">
                                <ProductBox v-bind:product="product"></ProductBox>
                                <!--/.prod-bx-->
                            </div>
                            <!--/.col-sm-4-->
                        </div>
                        <!--/.row-->
                        <div class="text-center d-block" v-if="pagination.total >= 9 && pagination.last_page > pagination.current_page">
                            <a class="viewmore" href="#" @click.prevent="loadMoreProducts()" >{{$t('pages.viewMore')}}</a>
                        </div>
                    </div><!--/.col-sm-9-->
                </div>

            </div><!--/.innr-cont-area-->

        </div>

    </div>
</template>

<script>
    import _ from 'lodash';
    import ProductBox from "./Product-box";
    import VueContentLoading from 'vue-content-loading';
    import ProductFilter from "./ProductFilter";
    import {mapGetters} from "vuex";

    export default {
        components: {ProductFilter, ProductBox, VueContentLoading},
        props: ['filterCategories', 'filterColor', 'filterMinPrice', 'filterMaxPrice', 'filterDiscounts'],
        mounted() {
            this.slug = this.$route.params.slug;
            this.loadFilterCategoriesList();
            this.loadFilterColorsList();
            this.loadProducts();
        },
        watch: {
            '$route.query' (to, from) {

                this.slug = this.$route.params.slug;
                this.loadFilterCategoriesList();
                this.loadFilterColorsList();

                // if(this.currentFullPath != null && this.currentFullPath !== this.$route.fullPath)
                // {
                    this.loadProducts();
                // }

                this.currentFullPath = this.$route.fullPath;
            }
        },
        computed: {
            productChunks(){
                return _.chunk(Object.values(this.products), 3);
            },
            ...mapGetters('authModule', [
                'isAuthenticated',
            ])
        },
        methods: {
            getFilterData(){
                let filterQueryString = '';
                if(this.filterCategories && this.filterCategories.length >= 1){
                    if(filterQueryString !== ''){
                        filterQueryString = '?'+filterQueryString;
                    }
                    filterQueryString = 'cat='+this.filterCategories;
                }
                if(this.filterSearchTerm){
                    if(filterQueryString !== ''){
                        filterQueryString += '&';
                    }
                    filterQueryString += 'term='+this.filterSearchTerm
                }
                if(this.filterSort){
                    if(filterQueryString !== ''){
                        filterQueryString += '&';
                    }
                    if(this.filterSort == 'price_asc'){
                        filterQueryString += 'sort_by_price=asc';
                    }else if(this.filterSort == 'price_desc'){{
                        filterQueryString += 'sort_by_price=desc';
                    }
                    }else{
                        filterQueryString += 'sort='+this.filterSort
                    }
                }
                if(this.filterColor && this.filterColor.length >= 1){
                    if(filterQueryString !== ''){
                        filterQueryString += '&';
                    }
                    filterQueryString += 'color='+this.filterColor
                }
                if(this.filterMinPrice){
                    if(filterQueryString !== ''){
                        filterQueryString += '&';
                    }
                    filterQueryString += 'min='+this.filterMinPrice;
                }
                if(this.filterMaxPrice){
                    if(filterQueryString !== ''){
                        filterQueryString += '&';
                    }
                    filterQueryString += 'max='+this.filterMaxPrice;
                }
                if(this.filterDiscounts && this.filterDiscounts.length >= 1){
                    if(filterQueryString !== ''){
                        filterQueryString += '&';
                    }
                    if(!Array.isArray(this.filterDiscounts)){
                        filterQueryString += 'discount[]='+this.filterDiscounts+'&';
                    }else{
                        this.filterDiscounts.forEach(function(item){
                            filterQueryString += 'discount[]='+item+'&';
                        });
                    }

                }
                if(filterQueryString !== ''){
                    filterQueryString = '?'+filterQueryString;
                }

                return filterQueryString;
            },
            loadProducts(){
                let filterQueryString = this.getFilterData();


                this.products = [];
                axios.all([
                    axios.get('/api/v1/category-products/' + this.slug + filterQueryString,
                        {
                            headers: {
                                "Authorization": `Bearer ${this.$store.state.authModule.accessToken}`
                            }
                        })
                ]).then(axios.spread((categoryResponse) => {
                    this.products = categoryResponse.data.products.data;
                    console.log(categoryResponse.data.products.data);
                    this.pagination = categoryResponse.data.products;
                    this.category = categoryResponse.data.category;
                    if (categoryResponse.data.filterAttributes) {
                        this.productsFilterAttributes = categoryResponse.data.filterAttributes;
                    }
                })).then(() => {
                    this.loading = false;
                });
            },
            loadMoreProducts(){
                let filterQueryString = this.getFilterData();
                let next_page = this.pagination.current_page + 1;
                let operatorQuery = '?';
                if (filterQueryString){
                    operatorQuery = '&';
                }
                axios.all([
                    axios.get('/api/v1/category-products/'+this.slug + filterQueryString + operatorQuery + 'page='+ next_page,{
                        headers: {
                            "Authorization": `Bearer ${this.$store.state.authModule.accessToken}`
                        }
                    })
                ]).then(axios.spread((categoryResponse) => {
                    console.log(categoryResponse.data.products.data);
                    if(Array.isArray(categoryResponse.data.products.data)){

                        this.products.push(...categoryResponse.data.products.data);
                    }else{

                        this.products.push(...Object.values(categoryResponse.data.products.data));
                    }
                    this.pagination = categoryResponse.data.products;
                    this.category   = categoryResponse.data.category;
                }));
            },
            onImageLoadFailure (event, size) {
                event.target.src = 'https://via.placeholder.com/'+size;
            },
            loadFilterCategoriesList(){
                this.filterCategoriesList = {};
                axios.get('/api/v1/filter-categories/'+this.slug)
                    .then((response) => {
                        this.filterCategoriesList = response.data;
                    });
            },
            loadFilterColorsList(){
                this.filterColorsList = {};
                axios.get('/api/v1/filter-colors')
                    .then((response) => {
                        this.filterColorsList = response.data;
                    });
            },
            resetColorFilter(colorFromQuery){
                this.filterColor = colorFromQuery;
            }

        },

        data: function () {
            return {
                loading: true,
                slug: null,
                filterSearchTerm: null,
                filterSort: null,
                filterCategoriesList: {},
                filterColorsList: {},
                current_page: 0,
                category: {},
                products: [],
                productsFilterAttributes: [],
                pagination: {},
                currentFullPath: null,
            }
        }
    }
</script>
