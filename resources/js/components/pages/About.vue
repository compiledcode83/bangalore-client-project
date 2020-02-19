<template>
    <div>
        <div class="innr-banner fullwidth">
            <img :src="'/uploads/'+responseData.informations[0].about_img">
            <div class="heading">
            <h2>About Us</h2>
            <ul class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li class="active">About Us</li>
            </ul>
            </div>
        </div><!--/.banner-->

        <div class="container innr-cont-area">
            <div class="row">
                <div class="col-sm-12 about-us">
                   <div v-html='responseData.informations[0].about_description_en'></div>
                    <br>
                    <h4>SUBSIDIARIES</h4>
                    <div class="subsidiaries-cvr">
                        <ul class="subsi-slides">
                            <li class="slide" v-for="subsidiarie in responseData.subsidiaries">
                                <div class="box">
                                    <img :src="'/uploads/'+subsidiarie.logo">
                                    <p>
                                        {{subsidiarie.description_en}}
                                        <br>
                                        Visit <a :href="subsidiarie.url" target="blank">{{subsidiarie.url}}</a> for more info.
                                    </p>
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

        data(){
            return {
                responseData: {
                    informations: [0]
                }
            }
        },
        mounted() {
            axios.get(
                '/api/v1/static/about'
            ).then((response) => {
                this.responseData = response.data;
            });
        },
        methods: {
        }
    }
</script>
