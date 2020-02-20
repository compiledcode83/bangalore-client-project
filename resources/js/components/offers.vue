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
<!--            <div class="innr-banner fullwidth">-->
<!--            <img :src="'/uploads/'+category.banner"-->
<!--                 @error="onImageLoadFailure($event, '1400x250')"-->
<!--                 style="max-height: 315px;" />-->
<!--            <div class="heading">-->
<!--                <h2>{{category.name_en}}</h2>-->
<!--                <ul class="breadcrumb">-->
<!--                    <li><router-link to="/" exact>Home</router-link></li>-->
<!--                    <li class="active">{{category.name_en}}</li>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </div>&lt;!&ndash;/.banner&ndash;&gt;-->

            <div class="container innr-cont-area">
                <div class="input-group big-searchbox">
                    <input type="text" class="form-control" v-model="term"  placeholder="Keyword Search" >
                    <span class="input-group-addon rounded-0">
              <button type="submit" class="btn btn-success rounded-0" >
                  <span class="glyphicon glyphicon-search"></span>
                  SEARCH
              </button>
          </span>
                </div><!--/.big-searchbox-->

                <div class="row">

<!--                    <ProductFilter-->
<!--                        :singleCategories="filterCategoriesList.singleCategories"-->
<!--                        :multipleCategories="filterCategoriesList.multipleCategories"-->
<!--                        :colors="filterColorsList"-->
<!--                    ></ProductFilter>-->

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
                                <ProductBox v-bind:product="product"></ProductBox>
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

    </div>
</template>

<script>
    import _ from 'lodash';
    import ProductBox from "./Product-box";
    import VueContentLoading from 'vue-content-loading';
    import ProductFilter from "./ProductFilter";

    export default {
        components: {ProductFilter, ProductBox, VueContentLoading},
        data: function () {
            return {
                loading: true,
                slug: null,
                filterCategoriesList: {},
                filterColorsList: {},
                current_page: 0,
                category: {},
                pagination: {}
            }
        },
        mounted() {
            this.loadOffers();
            this.loading = false;
            // this.slug = this.$route.params.slug;
            // this.loadFilterCategoriesList();
            // this.loadFilterColorsList();
        },
        watch: {
            // '$route' (to, from) {
            //     this.slug = to.params.slug;
            //     this.loadFilterCategoriesList();
            //     this.loadFilterColorsList();
            //     this.loadProducts();
            // }
        },
        computed: {
            productChunks(){
                return _.chunk(Object.values(this.products), 3);
            }
        },
        methods: {
            loadOffers(){

                let filterQueryString = '';
                if(this.filterCategories && this.filterCategories.length >= 1){
                    if(filterQueryString !== ''){
                        filterQueryString = '?'+filterQueryString;
                    }
                    filterQueryString = 'cat='+this.filterCategories;
                }
                if(this.filterColor && this.filterColor.length >= 1){
                    if(filterQueryString !== ''){
                        filterQueryString += '&';
                    }
                    filterQueryString += 'color='+this.filterColor
                }
                if(filterQueryString !== ''){
                    filterQueryString = '?'+filterQueryString;
                }

                this.products = [];
                axios.all([
                    axios.get('/api/v1/category-products/'+this.slug+filterQueryString)
                ]).then(axios.spread((categoryResponse) => {
                    this.products = categoryResponse.data.products.data;
                    this.pagination = categoryResponse.data.products;
                    this.category   = categoryResponse.data.category;
                })).then(() => {
                    this.loading = false;
                });
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
            }

        }
    }
</script>
