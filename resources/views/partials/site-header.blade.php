<header class="clearfix">
    <div class="top-sec full-width">
        <div class="container">
            <div class="row position-rel">
                <div class="col-xs-2 col-sm-4">
                    <div class="dropdown language">
                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Choose Language
                        </button>
                        <div class="dropdown-menu rounded-0" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">English</a>
                            <a class="dropdown-item" href="#">Arabic</a>
                        </div>
                    </div>
                </div><!--/.col-sm-4-->

                <account-menu></account-menu>
                <!--/.col-sm-8-->
            </div><!--/.row-->
        </div><!--/.container-->
    </div><!--/.top-sec-->

    <!--Seaarch Pop up-->
    <search></search>


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
                                        <router-link :to="'/categories/'+category.slug"> @{{category.name_en}} </router-link>
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
</header><!--/header-->

