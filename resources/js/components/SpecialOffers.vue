<template>
   <div>
       <div class="innr-banner fullwidth">
           <img :src="'/uploads/'+settings.special_offers_banner">
           <div class="heading">
               <h2>{{$t('pages.specialOffers')}}</h2>
               <ul class="breadcrumb">
                   <li><a href="/">{{$t('pages.home')}}</a></li>
                   <li class="active">{{$t('pages.specialOffers')}}</li>
               </ul>
           </div>
       </div><!--/.banner-->

       <div class="container innr-cont-area" v-if="token">
           <div class="input-group big-searchbox">
               <input type="text" class="form-control"  placeholder="Keyword Search" v-model="filterSearchTerm">
               <span class="input-group-addon rounded-0">
              <button type="submit" class="btn btn-success rounded-0" @click.prevent="loadOnlyOffers" >
                  <span class="glyphicon glyphicon-search"></span>
                  {{$t('pages.search')}}
              </button>
          </span>
           </div><!--/.big-searchbox-->

           <div class="row">
               <div class="col-sm-12 product-listing">
                   <div class="row">
                       <div class="col-sm-12 filtering">
                           <div class="pull-left" v-if="pagination">
                               {{pagination.total}} {{$t('pages.items')}}
                           </div>

                           <div class="pull-right">
                               <span> {{$t('pages.sortBy')}} : </span>
                               <select v-model="filterSort" @change="loadOnlyOffers">
                                   <option value="asc">{{$t('pages.alphabetic')}} - {{$t('pages.aToZ')}}</option>
                                   <option value="desc">{{$t('pages.alphabetic')}} - {{$t('pages.zToA')}}</option>
                               </select>
                           </div>
                       </div><!--/.filtering-->
                   </div><!--/.row-->
                   <div class="row" v-for="chunk in productChunks">
                       <div class="col-sm-3" v-for="product in chunk">

                           <div class="prod-bx">
                               <div class="img">
                                   <router-link :to="'/products/'+product.slug">
                                       <!--                                    <a href="product-details.html">-->
                                       <img :src="'/uploads/' + product.main_image"
                                            @error="onImageLoadFailure($event, '250x250')" style="min-height: 250px">
                                       <!--                                    </a>-->
                                   </router-link>
                                   <span class="disc">~{{product.discount}}%</span>
                                   <div class="hover" :style="'opacity:'+ product.whishlisted">
                                       <img src="/images/favourite.png" style="cursor: pointer;">
                                   </div>
                               </div>
                               <div class="data clearfix">
                                   <h4>{{product.name_en}}</h4>
                                   <div class="rate-cvr clearfix">
                                       <div class="rate">
                                           <star-rating
                                               active-color="#e01b22"
                                               :show-rating="false"
                                               :rating="product.rating"
                                               :item-size=20
                                               border-color="#f4f4f4"
                                               read-only>
                                           </star-rating>
                                       </div>
                                   </div>
                                   <div class="btn-group" data-toggle="buttons" v-if="product.colors">
                                       <label class="btn selct-clr" v-for="color in product.colors" :style="'background:' + color">
                                           <input type="radio" name="options" autocomplete="off" chacked="">
                                       </label>
                                   </div>
                               </div>
                               <!--/.data-->
                           </div>

                       </div><!--/.col-sm-3-->
                   </div><!--/.row-->
                   <div class="text-center d-block">
                       <div class="text-center d-block" v-if="pagination.total >= 12 && pagination.last_page > pagination.current_page">
                           <a class="viewmore" href="#" @click.prevent="loadMoreProducts()" >{{$t('pages.viewMore')}}</a>
                       </div>
                   </div>
               </div><!--/.col-sm-9-->
           </div>

       </div><!--/.innr-cont-area-->
       <div class="container innr-cont-area" v-else>
           <p style="text-align: center;font-size: 19px;font-weight: bold;"> Please login to see content of this page ... </p>
       </div>
   </div>
</template>

<script>
    import _ from 'lodash';
    import VueContentLoading from 'vue-content-loading';
    import {StarRating} from 'vue-rate-it';

    export default {
        components: {VueContentLoading, StarRating},
        mounted() {
            this.slug = this.$route.params.slug;
            this.loadOnlyOffers();
        },
        beforeCreate(){
            axios.get('/api/v1/settings/')
                .then((response) =>{
                    if(!response.data.enable_offers_page){
                        return this.$router.push({ name: 'home'});
                    }
                    this.settings = response.data;
                });
        },
        watch: {
            '$route' (to, from) {
                this.slug = to.params.slug;
                this.loadOnlyOffers();
            }
        },
        computed: {
            productChunks(){
                return _.chunk(Object.values(this.products), 4);
            }
        },
        methods: {
            loadOnlyOffers(){
                let filterQueryString = '';

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
                    filterQueryString += 'sort='+this.filterSort
                }

                if(filterQueryString !== ''){
                    filterQueryString = '?'+filterQueryString;
                }


                this.products = [];
                axios.all([
                    axios.get('/api/v1/offers/'+filterQueryString,
                        {headers: {
                                "Authorization" : `Bearer ${this.$store.state.authModule.accessToken}`
                            }
                        })
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
                let filterQueryString = '';

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
                    filterQueryString += 'sort='+this.filterSort
                }

                axios.all([
                    axios.get('/api/v1/offers?page='+ next_page + filterQueryString)
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
                loading: true,
                slug: null,
                current_page: 0,
                filterSearchTerm: '',
                filterSort: null,
                category: {},
                products: [],
                settings: {},
                productsFilterAttributes: [],
                pagination: {},
                token: this.$store.state.authModule.accessToken
            }
        }
    }
</script>
