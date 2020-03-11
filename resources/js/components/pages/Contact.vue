<template>
    <div>
        <div class="innr-banner fullwidth">
            <img :src="'/uploads/'+responseData.informations[0].contact_img">
            <div class="heading">
                <h2>{{$t('pages.contactUs')}}</h2>
                <ul class="breadcrumb">
                    <li><a href="/">{{$t('pages.home')}}</a></li>
                    <li class="active">{{$t('pages.contactUs')}}</li>
                </ul>
            </div>
        </div><!--/.banner-->
        <div class="container innr-cont-area">
            <div class="contact-us clearfix">
                <div class="col-sm-6 pin-bg">
                    <div class="address">
                        <h3>{{$t('pages.ourOfficeIn')}} <span>{{ responseData.informations[0].cantry_en }}</span></h3>
                        <span class="data">
                        {{ responseData.informations[0].building_en }}<br>
                        {{ responseData.informations[0].street_en }}, {{ responseData.informations[0].area_en }}<br>
                        {{ responseData.informations[0].city_en }}
                        </span>
                        <div class="contact">
                        <span><i><img src="images/call2.png"></i> {{ responseData.informations[0].tel }}</span>
                        <span><i><img src="images/fax.png"></i> {{ responseData.informations[0].fax }}</span>
                        <span><i><img src="images/mail.png"></i>  {{ responseData.informations[0].email }}</span>
                        </div>
                    </div>
                </div><!--/.col-sm-6-->
                <div class="col-sm-6 map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3477.004354557728!2d47.992079047395784!3d29.37016170970213!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3fcf9d854630584f%3A0xfcfb424db6341d76!2sITC+Promotions!5e0!3m2!1sen!2sin!4v1548394345199" width="100%" height="420" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
            </div>

            <div class="get-touch">
                <h3>{{$t('pages.getInnTouch')}}</h3>
                <p>{{$t('pages.contact_pleaseFillOutForm')}}</p>
                <div class="row">
                    <div v-if="validationErrors">
                        <Validation :errors="validationErrors"></Validation>
                    </div>
                    <form class="row">
                        <div class="col-sm-6 mt-10 mb-10">
                            <span v-if="responseData.errors">{{$t('pages.errors')}}</span>
                            <input type="text" class="form-control" :placeholder="$t('pages.name')" name="name" v-model="name">
                        </div>
                        <div class="col-sm-6 mt-10 mb-10">
                            <input type="email" class="form-control" :placeholder="$t('pages.email')" name="email" v-model="email">
                        </div>
                        <div class="col-sm-6 mt-10 mb-10">
                            <input type="text" class="form-control" :placeholder="$t('pages.phone')" name="mobile" v-model="mobile">
                        </div>
                        <div class="col-sm-6 mt-10 mb-10">
                            <input type="text" class="form-control" :placeholder="$t('pages.subject')" name="subject" v-model="subject">
                        </div>
                        <div class="col-sm-12 mt-10 mb-10">
                            <textarea class="form-control" :placeholder="$t('pages.message')" name="message" v-model="message"></textarea>
                        </div>
                        <div class="col-sm-12 mt-30 text-center">
                            <button class="btn-lg btn-primary rounded-0" @click.prevent="sentEmail" :disabled="hasSubmitted">{{$t('pages.submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!--/.innr-cont-area-->

    </div>
</template>

<script>
    import Validation  from "../partials/Validation";

    export default {
        components: {Validation},
        data(){
            return {
                validationErrors: {},
                hasSubmitted: false,
                responseData: {
                    informations: [0]
                },
                name : '',
                email : '',
                mobile : '',
                subject : '',
                message : ''

            }
        },
        mounted() {
            axios.get(
                '/api/v1/static/contact'
            ).then((response) => {
                console.log(response.data);
                this.responseData = response.data;
            });
        },
        methods: {
            sentEmail(){
                //Initialize the form data
                let formData = new FormData();

                formData.append('name', this.name);
                formData.append('email', this.email);
                formData.append('mobile', this.mobile);
                formData.append('subject', this.subject);
                formData.append('message', this.message);

                this.hasSubmitted = true;
                /*
                  Make the request to the POST /single-file URL
                */
                let  _this = this;

                axios.post('/api/v1/static/contact',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(function (response) {
                    if(response.data.message) {
                        _this.$swal({
                            icon: 'success',
                            title: 'E-mail Sent!',
                            text: 'thank you, Your email sent successfully',
                        });

                        _this.hasSubmitted = false;
                        _this.validationErrors = '';
                        _this.name       = '';
                        _this.email      = '';
                        _this.mobile     = '';
                        _this.subject    = '';
                        _this.message    = '';
                    }
                }).catch(function (errors) {
                    _this.hasSubmitted = false;
                    if (errors.response.status == 422){
                        _this.validationErrors = errors.response.data.errors;
                        console.log(_this.validationErrors);
                    }
                });
            }
        }
    }
</script>
