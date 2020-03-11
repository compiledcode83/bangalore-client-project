<template>
    <div>
        <my-account-banner
            :bannerTitle="$t('pages.addressBook')"
        ></my-account-banner>

        <div class="container innr-cont-area">
            <div class="row">
                <my-account-sidebar></my-account-sidebar>

                <!--/ Content Here-->
                <div class="col-sm-9 right-sec addrss-book">
                    <h4>{{$t('pages.addressBook')}}</h4>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="box">
                                <h5> {{$t('pages.defaultBillingAddress')}} </h5>
                                <a class="edit" href="address-edit.html">{{$t('pages.edit')}}</a>
                                <span>
                                  AL SALEM STREET<br>
                                  BLOCK #12<br>
                                  BUILDING NO. 23<br>
                                  SALMIYA
                                </span>
                            </div>
                        </div><!--/.col-sm-6-->
                        <div class="col-sm-6">
                            <div class="box">
                                <h5> {{$t('pages.defaultShippingAddress')}} </h5>
                                <a class="edit" href="address-edit.html">{{$t('pages.edit')}}</a>
                                <span>
                                  <br>
                                  BLOCK #12<br>
                                  BUILDING NO. 23<br>
                                  SALMIYA
                                </span>
                            </div>
                        </div><!--/.col-sm-6-->
                    </div><!--/.row-->
                    <br>
                    <h4>{{$t('pages.addNewAddress')}}</h4>
                    <div class="add-newaddrss">

                        <div v-if="validationErrors">
                            <Validation :errors="validationErrors"></Validation>
                        </div>
                        <form class="row">
                            <div class="col-sm-6">
<!--                                <span class="alert alert-danger" >@{{ value }}</span>-->
                                <select class="form-control" v-model="address.governorate" @change="updateAreas($event)">
                                    <option> {{$t('pages.selectGovernotate')}}</option>
                                    <option v-for="governorate in user.governorates" :value="governorate.id">{{governorate.name_en}}</option>
                                </select>
                            </div><!--/.col-sm-6-->
                            <div class="col-sm-6">
                                <select class="form-control" v-model="address.area">
                                    <option> {{$t('pages.selectArea')}}</option>
                                    <option v-for="area in selectedAreas" :value="area.id"> {{area.name_en}}</option>

                                </select>
                            </div><!--/.col-sm-6-->
                            <div class="col-sm-6">
                                <input type="text" class="form-control rounded-0" :placeholder="$t('pages.blockNumber')" v-model="address.block">
                            </div><!--/.col-sm-6-->
                            <div class="col-sm-6">
                                <input type="text" class="form-control rounded-0" :placeholder="$t('pages.street')" v-model="address.street">
                            </div><!--/.col-sm-6-->
                            <div class="col-sm-6">
                                <input type="text" class="form-control rounded-0" :placeholder="$t('pages.buildingNumber')" v-model="address.building">
                            </div><!--/.col-sm-6-->
                            <div class="col-sm-6">
                                <input type="text" class="form-control rounded-0" :placeholder="$t('pages.floorNumber')" v-model="address.floorNo">
                            </div><!--/.col-sm-6-->
                            <div v-if="user.user_type == 1">
                                <div class="col-sm-6">
                                    <input type="text" class="form-control rounded-0" :placeholder="$t('pages.flatNumber')" v-model="address.house">
                                </div><!--/.col-sm-6-->
                                <div class="col-sm-6">
                                    <input type="text" class="form-control rounded-0" :placeholder="$t('pages.houseNumber')" v-model="address.house">
                                </div><!--/.col-sm-6-->
                            </div>
                            <div v-else>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control rounded-0" :placeholder="$t('pages.officeAddress')" v-model="address.officeAddress">
                                </div><!--/.col-sm-6-->
                                <div class="col-sm-6">
                                    <input type="text" class="form-control rounded-0" :placeholder="$t('pages.officeNumber')" v-model="address.officeNo">
                                </div><!--/.col-sm-6-->
                            </div>

                            <div class="col-sm-6">
                                <label class="checkbox-sml mt-20"> {{$t('pages.useAsDefaultBilling')}}
                                    <input type="checkbox" v-model="address.defaultBilling">
                                    <span class="checkmark"></span>
                                </label>
                            </div><!--/.col-sm-6-->
                            <div class="col-sm-6">
                                <label class="checkbox-sml mt-20"> {{$t('pages.useAsDefaultShipping')}}
                                    <input type="checkbox" v-model="address.defaultShipping">
                                    <span class="checkmark"></span>
                                </label>
                            </div><!--/.col-sm-6-->
                            <div class="col-sm-12 mt-30">
                                <button class="btn-lg btn-success rounded-0" @click.prevent="saveAddress">{{$t('pages.saveAddress')}}</button>
                            </div><!--/.col-sm-12-->
                        </form>
                    </div><!--/.row-->
                </div><!--/.col-sm-9-->
                <!--/.col-sm-9-->
            </div>
        </div><!--/.innr-cont-area-->
    </div>
</template>

<script>
    import myAccountSidebar from "./partials/TheSidebar";
    import myAccountBanner from "./partials/TheBanner";
    import Validation  from "../partials/Validation";
    export default {
        components: {Validation, myAccountSidebar, myAccountBanner},
        data(){
            return {
                user: {},
                address: {},
                selectedAreas: {},
                validationErrors: {}
            }
        },
        mounted() {
            if (this.$store.getters['authModule/isAuthenticated']) {

                axios.get(
                    '/api/v1/account/addresses',
                    {
                        headers: {
                            "Authorization" : `Bearer ${this.$store.state.authModule.accessToken}`
                        }
                    }
                ).then((response) => {
                    this.user = response.data;
                });
            }else{
                console.log('No authorization');
            }
        },
        methods: {
            updateAreas(event){
                let value = event.target.value;
                let currentGov = {};
                this.user.governorates.forEach(function(gov){
                    if(gov.id == value){
                        currentGov = gov;
                    }
                });
                this.selectedAreas = currentGov.areas;
            },
            saveAddress(){
                let _this = this;
                if (this.$store.getters['authModule/isAuthenticated']) {

                    axios.post(
                        '/api/v1/account/addresses/new',
                        this.address,
                        {
                            headers: {
                                "Authorization" : `Bearer ${this.$store.state.authModule.accessToken}`
                            }
                        }
                    ).then((response) => {
                        if(response.data){
                            this.$swal({
                                title: 'success!',
                                text: "Your Address has been saved successfully!",
                                icon: 'success'
                            });
                            this.address = {};
                            this.validationErrors = {};
                        }else{
                            this.$swal({
                                title: 'error!',
                                text: "Server error ... couldn't save your address, please try again later!",
                                icon: 'error'
                            });
                        }
                    }).catch(function (errors) {
                        if (errors.response.status == 422){
                            _this.validationErrors = errors.response.data.errors;
                            console.log(_this.validationErrors);
                        }
                    });
                }else{
                    console.log('No authorization');
                }
            }
        }
    }
</script>
