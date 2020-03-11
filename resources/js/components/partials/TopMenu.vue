<template>
    <div class="full-width">
        <div class="container">
            <div class="row nav-section">
                <div class="col-lg-1 col-md-2 col-sm-2 navbrand">
                    <router-link to="/" exact>
                        <img src="/images/logo.png" style="max-width: none;" alt="logo" class="mCS_img_loaded" />
                    </router-link><!-- /.logo -->
                </div><!-- /.col-lg-10 -->
                <div class="col-lg-11 col-md-10 col-sm-10">
                    <div class="navigation full-width">
                        <nav class="navbar navbar-default">
                            <div class="navbar-header">
                                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                            <div class="collapse navbar-collapse js-navbar-collapse">
                                <ul class="nav navbar-nav">
                                    <li v-for="category in categories">
                                        <router-link :to="'/categories/'+category.slug"> {{category.name}} </router-link>
                                    </li>
                                </ul>
                            </div>
                            <!-- /.nav-collapse -->
                            <!-- /.search_box_cover -->
                        </nav>
                        <!-- /.navigation -->
                    </div>
                    <!-- /.col-lg-10 -->
                </div><!-- /.col-lg-11 -->
            </div><!-- /.row -->
        </div><!--/.container-->
    </div>
</template>

<script>

    export default {
        name: 'TopMenu',
        data() {
            return {
                categories: null
            }
        },
        created() {
            this.loadCategories();
            this.$Progress.finish();

            let _this = this;
            this.$root.$on('lang_changed', function(currentLang) {
                //reload the component
                axios.get('/api/v1/home-categories', {
                    headers: {
                        'xLocalization' : currentLang
                    }
                }).then(response => _this.categories = response.data);
            })

        },
        methods: {
            loadCategories(){
                axios.get('/api/v1/home-categories', {
                    headers: {
                        'xLocalization' : this.$store.state.langModule.lang
                    }
                }).then(response => this.categories = response.data);
            }
        }
    }
</script>
