<template xmlns="http://www.w3.org/1999/html">
    <!-- Modal For Register-->
    <div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header">{{$t('pages.register')}}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <img src="/images/close.png">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4 mt-10 mb-10">
                            <strong>{{$t('pages.registerAs')}}</strong>
                        </div>
                        <div class="col-sm-8 mt-10 mb-10">
                            <ul class="nav nav-tabs row" id="myTab">
                                <li class="active col-sm-5 col-xs-6" v-if="userRegisterEnabled">
                                    <a href="#individual">
                                        <label class="checkbox">{{$t('pages.individual')}}
                                            <input type="checkbox" :checked="userRegister" @click="showIndividual">
                                            <span class="checkmark"></span>
                                        </label>
                                    </a>
                                </li>
                                <li class="col-sm-5 col-xs-6">
                                    <a href="#corporate">
                                        <label class="checkbox">{{$t('pages.corporate')}}
                                            <input type="checkbox" :checked="corporateRegister" @click="showCorporate">
                                            <span class="checkmark"></span>
                                        </label>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div id='content' class="tab-content">
                        <div v-if="userErrors && userRegister" style="text-align: left;padding-top: 5%;">
                            <b>{{$t('pages.correctFollowingErrors')}}:</b>
                            <span style="color: red;">{{ userErrors }}</span>
                        </div>
                        <div :class="individualRegisterClass" id="individual" v-if="userRegister">
                            <form class="row" @submit.prevent="registerUserForm">
                                <div class="col-sm-6 mt-10 mb-10">
                                    <input type="text" class="form-control" :placeholder="$t('pages.firstName')" v-model="userData.first_name" style="text-transform: none;">
                                </div><!--/.col-sm-6-->
                                <div class="col-sm-6 mt-10 mb-10">
                                    <input type="text" class="form-control" :placeholder="$t('pages.lastName')" v-model="userData.last_name" style="text-transform: none;">
                                </div><!--/.col-sm-6-->
                                <div class="col-sm-6 mt-10 mb-10">
                                    <input type="password" class="form-control" :placeholder="$t('pages.password')" v-model="userData.password" style="text-transform: none;">
                                </div><!--/.col-sm-6-->
                                <div class="col-sm-6 mt-10 mb-10">
                                    <input type="password" class="form-control" :placeholder="$t('pages.confirmPassword')" v-model="userData.password_confirmation" style="text-transform: none;">
                                </div><!--/.col-sm-6-->
                                <div class="col-sm-6 mt-10 mb-10">
                                    <input type="email" class="form-control" :placeholder="$t('pages.emailId')" v-model="userData.email" style="text-transform: none;">
                                </div><!--/.col-sm-6-->
                                <div class="col-sm-6 mt-10 mb-10">
                                    <input type="number" class="form-control" :placeholder="$t('pages.phone')" v-model="userData.phone" style="text-transform: none;">
                                </div><!--/.col-sm-6-->
                                <div class="col-sm-12 mt-10">
                                    <br>
                                    <label class="checkbox-sml">{{$t('pages.agreeForTermsAndConditions')}}
                                        <input type="checkbox" value="" v-model="userData.agree_terms">
                                        <span class="checkmark"></span>
                                    </label>
                                </div><!--/.col-sm-12-->
                                <div class="col-sm-12">
                                    <label class="checkbox-sml">{{$t('pages.subscribeToOurNewsLetter')}}
                                        <input type="checkbox" value="" v-model="userData.newsLetter">
                                        <span class="checkmark"></span>
                                    </label>
                                </div><!--/.col-sm-12-->
                                <div class="col-sm-12 text-center mt-10">
                                    <br>
                                    <button type="submit" class="btn btn-danger rounded-0" >{{$t('pages.register')}}</button>
                                </div>
                            </form><!--/form-->
                        </div><!--/.tab-pane-->
                        <div :class="corporateRegisterClass" id="corporate">
<!--                        <div :class="'tab-pane ' + { active: userRegister }" id="Corporate">-->
                            <div v-if="corporateErrors" style="text-align: left;padding-top: 5%;">
                                <b>{{$t('pages.correctFollowingErrors')}}:</b>
                                <span style="color: red;">{{ corporateErrors }}</span>
                            </div>
                            <form class="row" @submit.prevent="registerCorporateForm">
                                <div class="col-sm-6 mt-10 mb-10">
                                    <input type="text" class="form-control" :placeholder="$t('pages.company')" style="text-transform: none;" v-model="corporateData.company">
                                </div><!--/.col-sm-6-->
                                <div class="col-sm-6 mt-10 mb-10">
                                    <input type="email" class="form-control" :placeholder="$t('pages.email')" style="text-transform: none;" v-model="corporateData.email">
                                </div><!--/.col-sm-6-->
                                <div class="col-sm-6 mt-10 mb-10">
                                    <input type="password" class="form-control" :placeholder="$t('pages.password')" style="text-transform: none;" v-model="corporateData.password">
                                </div><!--/.col-sm-6-->
                                <div class="col-sm-6 mt-10 mb-10">
                                    <input type="password" class="form-control" :placeholder="$t('pages.confirmPassword')" style="text-transform: none;" v-model="corporateData.password_confirmation">
                                </div><!--/.col-sm-6-->
                                <div class="col-sm-6 mt-10 mb-10">
                                    <input type="text" class="form-control" :placeholder="$t('pages.contactPerson')" style="text-transform: none;" v-model="corporateData.contact">
                                </div><!--/.col-sm-6-->
                                <div class="col-sm-6 mt-10 mb-10">
                                    <input type="text" class="form-control" :placeholder="$t('pages.jobTitle')" style="text-transform: none;" v-model="corporateData.job_title">
                                </div><!--/.col-sm-6-->
                                <div class="col-sm-6 mt-10 mb-10">
                                    <input type="number" class="form-control" :placeholder="$t('pages.mobileNumber')" style="text-transform: none;" v-model="corporateData.phone">
                                </div><!--/.col-sm-6-->
                                <div class="col-sm-6 mt-10 mb-10">
                                    <div class="input-group">
                                        <input id="uploadFile" class="form-control" :placeholder="$t('pages.companyLicense')" disabled :value="this.corporateData.company_license.name">
                                        <div class="input-group-btn">
                                            <div class="fileUpload btn btn-warning rounded-0">
                                                <span>{{$t('pages.browse')}}</span>
                                                <input class="upload" type="file" id="file" ref="file" @change="handleFileUpload($event)"/>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--/.col-sm-6-->
                                <div class="col-sm-12 mt-10">
                                    <br>
                                    <label class="checkbox-sml">{{$t('pages.agreeForTermsAndConditions')}}
                                        <input type="checkbox" value="" v-model="corporateData.agree_terms">
                                        <span class="checkmark"></span>
                                    </label>
                                </div><!--/.col-sm-12-->
                                <div class="col-sm-12">
                                    <label class="checkbox-sml">{{$t('pages.subscribeToOurNewsLetter')}}
                                        <input type="checkbox" value="" v-model="corporateData.newsLetter">
                                        <span class="checkmark"></span>
                                    </label>
                                </div><!--/.col-sm-12-->
                                <div class="col-sm-12 text-center mt-10">
                                    <br>
                                    <button type="submit" class="btn btn-danger rounded-0">{{$t('pages.register')}}</button>
                                </div>
                            </form><!--/form-->
                        </div><!--/.tab-pane-->
                    </div><!--/.tab-content-->
                </div><!--/.modal-body-->
            </div>
        </div>
    </div>
</template>

<script>
    import { mapActions } from 'vuex';
    export default {
        name: 'registerModal',
        data() {
            return {
                userData: {
                    email: '',
                    password: '',
                    password_confirmation: '',
                    first_name: '',
                    last_name: '',
                    phone: '',
                    agree_terms: null,
                    newsLetter: 0
                },
                corporateData: {
                    email: '',
                    password: '',
                    password_confirmation: '',
                    company: '',
                    job_title: '',
                    contact: '',
                    company_license: '',
                    phone: '',
                    agree_terms: null,
                    newsLetter: 0
                },
                userErrors: null,
                corporateErrors: null,
                userRegister: 0,
                userRegisterEnabled: 0,
                corporateRegister: 1,
                corporateRegisterClass: '',
                individualRegisterClass: ''
            };
        },
        mounted() {
            axios.get(
                '/api/v1/settings'
            ).then((response) => {
                if(response.data.individual_can_register){
                    this.userRegister = 1;
                    this.userRegisterEnabled = 1;
                    this.corporateRegister = 0;
                }

                this.loadRegister();
            });

        },
        methods:  {
            ...mapActions('authModule', [
                'registerUser', 'registerCorporate'
            ]),
            loadRegister(){
                if(!this.userRegister){
                    this.corporateRegisterClass = 'tab-pane active';
                    this.individualRegisterClass = 'tab-pane';
                }else{
                    this.corporateRegisterClass = 'tab-pane';
                    this.individualRegisterClass = 'tab-pane active';
                }
            },
            showIndividual(){
                this.userRegister = 1;
                this.corporateRegister = 0;
                this.corporateRegisterClass = 'tab-pane';
                this.individualRegisterClass = 'tab-pane active';
            },
            showCorporate(){
                this.userRegister = 0;
                this.corporateRegister = 1;
                this.corporateRegisterClass = 'tab-pane active';
                this.individualRegisterClass = 'tab-pane';

            },
            registerUserForm() {
                if(!this.userData.agree_terms){
                    this.userErrors = this.$t("accept_terms_conditions");
                    return;
                }
                this.registerUser({ ...this.userData })
                    .then(() => {
                        this.hideModal();
                        if(this.$router.currentRoute.name !== 'home'){
                            this.$router.push({name: 'home'});
                        }
                    })
                    .catch((errors) => {
                        // Handle Errors
                        this.userErrors = errors.data.message;
                    });
            },
            registerCorporateForm() {
                if(!this.corporateData.agree_terms){
                    this.corporateErrors = this.$t("accept_terms_conditions");
                    return;
                }
                this.registerCorporate({ ...this.corporateData })
                    .then(() => {
                        this.hideModal();
                        this.$swal({
                            icon: 'success',
                            title: 'You registered successfully!',
                            text: 'Thank for registration in ITC Promotions website. Your request is under processing. We will inform you by email once it is approved',
                        });
                    })
                    .catch((errors) => {
                        // Handle Errors
                        this.corporateErrors = errors.data.message;
                    });
            },
            hideModal(){
                $('#register').modal('hide');
            },
            handleFileUpload(event){
                if(this.validateFile()) {
                    this.corporateData.company_license = this.$refs.file.files[0];
                }

            },
            validateFile(e){
                if (this.$refs.file.files[0] && this.$refs.file.files[0].size > 1024 * 1024) {
                    this.$swal({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'File too big (> 1MB)!',
                    });
                    //delete file from input
                    this.$refs.file.value = null;
                    return false;
                }
                if(this.$refs.file.files[0] && (this.$refs.file.files[0].type === "application/pdf")){
                    return true;
                }else{
                    this.$swal({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Only Pdf is allowed!',
                    });
                    //delete file from input
                    this.$refs.file.value = null;
                    return false;
                }
            },
        }
    }
</script>
