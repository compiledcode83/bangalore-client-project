<template>
    <div>
        <div class="innr-banner fullwidth">
            <img src="images/wishlist-banner.jpg">
            <div class="heading">
                <h2>About Us</h2>
                <ul class="breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li class="active">About Us</li>
                </ul>
            </div>
        </div><!--/.banner-->

        <div class="container innr-cont-area">
            <div class="row">
                <div class="col-sm-12 about-us">
                    <h4>WHO WE ARE</h4>
                    <p>Simply put, we are a leading promotional gift supplier, one-stop source for all Promotional Products such as Corporate Gifts, Licensed Properties (Branded), Giveaways, Merchandises, Premium Gifts and VIP Gifts. For promotional products, we offer the entire spectrum of services starting with the concept design/ promotional Ideas, development, sourcing, marketing and distribution of those  goods. we are specialize in creating promotional ideas for products such as Pens, USBs, Bags, Toys etc. that suits best for your company requirements.</p>
                    <br>
                    <h4>ACHIEVEMENTS</h4>
                    <p>Since it's established in the early 1990's, ITC Promotions has become:</p>
                    <ul class="listing">
                        <li>A proud member of the Kuwaiti business community</li>
                        <li>A fully fledged supplier for corporate gifts, premiums and merchandise</li>
                        <li>An experienced operator in logistics and skilled facilitator of goods on real-time basis</li>
                        <li>A long-time member of many specialized organizations for gifts and premiums</li>
                        <li>An exemplary partner with regional and international licensors</li>
                    </ul>
                    <br>
                    <h4>Quality</h4>
                    <p>We source our coffee mugs, tee shirts, and all other items from the same suppliers as do other reputable promotional products companies. Our prices are lower, but the products are the same. We provide free samples of everything we sell, so you can test the quality for yourself.</p>
                    <br>
                    <h4>SUBSIDIARIES</h4>
                    <div class="subsidiaries-cvr">
                        <ul class="subsi-slides">
                            <li class="slide">
                                <div class="box">
                                    <img src="images/imperial.jpg">
                                    <p>A Leading supplier of unique souvenirs and luxurious gifts, reflecting rich heritage of the Kuwait’s culture. Each collection is a combination of the latest technological techniques and design elements coming from traditional life of beautiful ornaments and decoration elements, the ancient and modern architecture of Kuwait. <br>Visit <a href="http://www.imperial-collection.co/" target="blank">www.imperial-collection.co</a> for more info.</p>
                                </div>
                            </li><!--/li-->
                            <li class="slide">
                                <div class="box">
                                    <img class="mania" src="images/evnt-mania.jpg">
                                    <p>EVENTmania It’s role is to deliver creative and exciting sponsorship events that are customized to be both highly efficient and cost-effective. Our passion for brand building, energetic product visibility and sizzling creativity through social engagement is essential in propelling events to new heights and turning positive consumer experiences into promotional connections between brands and customers. Visit <a href="http://www.eventmania.co/" target="blank">www.eventmania.co</a>  for more info.</p>
                                </div>
                            </li><!--/li-->
                            <li class="slide">
                                <div class="box">
                                    <img src="images/imperial.jpg">
                                    <p>A Leading supplier of unique souvenirs and luxurious gifts, reflecting rich heritage of the Kuwait’s culture. Each collection is a combination of the latest technological techniques and design elements coming from traditional life of beautiful ornaments and decoration elements, the ancient and modern architecture of Kuwait. <br>Visit <a href="http://www.imperial-collection.co/" target="blank">www.imperial-collection.co</a> for more info.</p>
                                </div>
                            </li><!--/li-->
                            <li class="slide">
                                <div class="box">
                                    <img class="mania" src="images/evnt-mania.jpg">
                                    <p>EVENTmania It’s role is to deliver creative and exciting sponsorship events that are customized to be both highly efficient and cost-effective. Our passion for brand building, energetic product visibility and sizzling creativity through social engagement is essential in propelling events to new heights and turning positive consumer experiences into promotional connections between brands and customers. Visit <a href="http://www.eventmania.co/" target="blank">www.eventmania.co</a>  for more info.</p>
                                </div>
                            </li><!--/li-->
                        </ul><!--/ul-->
                    </div>
                </div><!--/.col-sm-12-->
            </div>

        </div><!--/.innr-cont-area-->
    </div>
</template>

<script>
    export default {
        mounted() {
            $(".subsi-slides").slick({
                dots: false,
                autoplay: false,
                infinite: true,
                slidesToShow: 2,
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
        }
    }
</script>
