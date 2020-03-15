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
            <img :src="'/uploads/'"
                 @error="onImageLoadFailure($event, '1400x250')"
                 style="max-height: 315px;" />
            <div class="heading">
                <h2> {{$t('pages.bestSellers')}} </h2>
                <ul class="breadcrumb">
                    <li><router-link to="/" exact>{{$t('pages.home')}}</router-link></li>
                    <li class="active"> {{$t('pages.bestSellers')}}</li>
                </ul>
            </div>
        </div><!--/.banner-->
            <div class="container innr-cont-area">
            <div class="input-group big-searchbox">
                <input type="text" class="form-control"  placeholder="Keyword Search" >
                <span class="input-group-addon rounded-0">
              <button type="submit" class="btn btn-success rounded-0">
                  <span class="glyphicon glyphicon-search"></span>
                  {{$t('pages.search')}}
              </button>
          </span>
            </div><!--/.big-searchbox-->

            <div class="row">
                <div class="col-sm-12 product-listing">
                    <div class="row">
                        <div class="col-sm-12 filtering">
                            <div class="pull-left" v-if="products">
                                {{products.length}} items
                            </div>

                            <div class="pull-right">
                                <span> SORT BY : </span>
                                <select>
                                    <option value="asc">{{$t('pages.alphabetic')}} - {{$t('pages.aToZ')}}</option>
                                    <option value="desc">{{$t('pages.alphabetic')}} - {{$t('pages.zToA')}}</option>
                                </select>
                            </div>
                        </div><!--/.filtering-->
                    </div><!--/.row-->
                    <div class="row" v-for="chunk in productChunks">
                        <div class="col-sm-3" v-for="product in chunk">
                            <ProductBox v-bind:product="product"></ProductBox>
                            <!--/.prod-bx-->
                        </div>
                        <!--/.col-sm-4-->
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

    export default {
        components: {ProductBox, VueContentLoading},
        mounted() {
            this.loadProducts();
        },
        beforeRouteUpdate(to, from, next) {
            this.loadProducts();
            next();
        },
        computed: {
            productChunks(){
                return _.chunk(Object.values(this.products), 4);
            }
        },
        methods: {
            loadProducts(){
                axios.all([
                    axios.get('/api/v1/products-best-list/')
                ]).then(axios.spread((productResponse) => {
                    this.products = productResponse.data;
                })).then(() => {
                    this.loading = false;
                });
            },
            onImageLoadFailure (event, size) {
                event.target.src = 'https://via.placeholder.com/'+size;
            }

        },

        data: function () {
            return {
                loading: true,
                products: []
            }
        }
    }
</script>
