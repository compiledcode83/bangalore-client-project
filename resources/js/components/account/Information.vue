<template>
    <div>
        <my-account-banner></my-account-banner>

        <div class="container innr-cont-area">
            <div class="row">
                <my-account-sidebar></my-account-sidebar>

                <!--/ Content Here-->
                <div class="col-sm-9 right-sec addrss-book">

                    <h4>Edit Account Information</h4>
                    <div class="add-newaddrss">
                        <form class="row">
                            <div v-if="account.type == '1'">
                                <div class="col-sm-6">
                                    <div> First Name</div>
                                    <input type="text" class="form-control rounded-0" placeholder="First Name" name="first_name" v-model="account.first_name">
                                </div><!--/.col-sm-6-->
                                <div class="col-sm-6">
                                    <div> Last Name</div>
                                    <input type="text" class="form-control rounded-0" placeholder="Last Name" name="last_name" v-model="account.last_name">
                                </div><!--/.col-sm-6-->
                            </div>
                            <div v-else>
                                <div class="col-sm-6">
                                    <div> Company</div>
                                    <input type="text" class="form-control rounded-0" placeholder="Company Name" name="company"v-model="account.company">
                                </div><!--/.col-sm-6-->
                                <div class="col-sm-6">
                                    <div> Contact Person</div>
                                    <input type="text" class="form-control rounded-0" placeholder="Contact Person" name="contact_person" v-model="account.contact_person">
                                </div><!--/.col-sm-6-->
                                <div class="col-sm-6">
                                    <div> Job Title</div>
                                    <input type="text" class="form-control rounded-0" placeholder="Job Title" name="job_title" v-model="account.job_title">
                                </div><!--/.col-sm-6-->
                                <div class="col-sm-6">
                                    <div> Company License</div>
                                    <a :href="'/'+account.company_license" target="_blank" v-if="account.company_license"> View File </a>
                                    <input type="file" class="form-control rounded-0" name="file" ref="file" @change="handleFileUpload($event)">
                                </div><!--/.col-sm-6-->
                            </div>
                            <div class="col-sm-6">
                                <div> E-mail Address</div>
                                <input type="text" class="form-control rounded-0" placeholder="Email Address" name="email" v-model="account.email">
                            </div><!--/.col-sm-6-->
                            <div class="col-sm-6 ">
                                <div> Telephone</div>
                                <div class="phonewithcontry">
                                    <select class="form-control contry">
                                        <option>+965</option>
                                    </select>
                                    <input type="number" class="form-control rounded-0 phone" placeholder="Phone Number" name="phone" v-model="account.phone">
                                </div>
                            </div><!--/.col-sm-6-->


                            <div class="col-sm-12 mt-30">
                                <button class="btn-lg btn-success rounded-0" @click.prevent="updateAccount">Update Account Info</button>
                            </div><!--/.col-sm-12-->
                        </form>
                    </div><!--/.row-->
                </div><!--/.col-sm-9-->
            </div>
        </div><!--/.innr-cont-area-->
    </div>
</template>

<script>
    import myAccountSidebar from "./partials/TheSidebar";
    import myAccountBanner from "./partials/TheBanner";
    export default {
        components: {myAccountSidebar, myAccountBanner},
        data(){
            return {
                account: {
                    file: ''
                }
            }
        },
        mounted() {
            if (this.$store.getters['authModule/isAuthenticated']) {
                console.log('sending authorization while  browser refresh');

                axios.get(
                    '/api/v1/account/info',
                    {headers: {
                            "Authorization" : `Bearer ${this.$store.state.authModule.accessToken}`
                        }
                    }
                ).then((response) => {
                        this.account = response.data;
                    });
            }else{
                console.log('No authorization');
            }

        },
        methods: {
            handleFileUpload(event){
                this.account.file = this.$refs.file.files[0];
            },
            updateAccount(){

                //Initialize the form data
                let formData = new FormData();
                // upload file
                formData.append('file', this.account.file);
                formData.append('first_name', this.account.first_name);
                formData.append('last_name', this.account.last_name);
                formData.append('company', this.account.company);
                formData.append('contact_person', this.account.contact_person);
                formData.append('job_title', this.account.job_title);
                formData.append('phone', this.account.phone);
                formData.append('email', this.account.email);
                /*
                  Make the request to the POST /single-file URL
                */
                let  _this = this;

                axios.post('/api/v1/account/info',
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
                            title: 'Account Updated!',
                            text: 'Your account information updated successfully',
                        });
                    }else{
                        _this.$swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Server error 889 ...',
                        });
                    }
                }).catch(function (errors) {
                    // console.log(errors);
                });
            }
        }
    }
</script>
