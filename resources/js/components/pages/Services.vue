<template>
    <div>
        <div class="innr-banner fullwidth">
            <img :src="'/uploads/'+responseData.informations[0].services_banner">
            <div class="heading">
                <h2>Serices</h2>
                <ul class="breadcrumb">
                    <li><a href="/">Home</a></li>
                    <li class="active">Services</li>
                </ul>
            </div>
        </div><!--/.banner-->

        <div class="container innr-cont-area">
            <div class="row">
                <div class="col-sm-12 services">
                    <section v-for="service in responseData.services">
                        <div class="row">
                        <div class="col-sm-3">
                            <img :src="'/uploads/'+service.image">
                        </div>
                        <div class="col-sm-9">
                            <h4>{{ service.title_en }}</h4>
                            <p v-html='service.short_description_en'>{{ service.short_description_en }}</p>

                            <a :href="'services-details/'+service.id">View More</a>
                        </div>
                        </div>
                    </section><!--/section-->
                    <div class="text-center d-block">
                        <a class="viewmore-spl" href="#">View More</a>
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
                    informations: [0],
                    services : []
                }
            }
        },
        mounted() {
            axios.get(
                '/api/v1/static/service'
            ).then((response) => {
                this.responseData = response.data;
            });
        },
        methods: {
        }
    }
</script>
