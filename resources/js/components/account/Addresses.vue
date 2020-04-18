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
                        <div class="col-sm-6" v-if="user.defaultBilling">
                            <div class="box">
                                <h5> {{$t('pages.defaultBillingAddress')}} </h5>
                                <a class="edit" href="#" @click.prevent="editAddress(user.defaultBilling)">{{$t('pages.edit')}}</a>
                                <a class="edit" href="#" style="top: 50px;" @click.prevent="deleteAddress(user.defaultBilling.id)">{{$t('pages.delete')}}</a>
                                <span v-if="user.user_type == '1'">
                                  {{$t('pages.governotate')}}: {{user.defaultBilling.governorateName}}<br>
                                  {{$t('pages.area')}}: {{user.defaultBilling.areaName}}<br>
                                  {{$t('pages.blockNumber')}}: {{user.defaultBilling.block}}<br>
                                  {{$t('pages.street')}}: {{user.defaultBilling.street}}<br>
                                  {{$t('pages.buildingNumber')}}: {{user.defaultBilling.building}}<br>
                                  {{$t('pages.floorNumber')}}: {{user.defaultBilling.floor}}<br>
                                  {{$t('pages.houseNumber')}}: {{user.defaultBilling.house_number}}<br>
                                </span>
                                <span v-if="user.user_type == '2'">
                                  {{$t('pages.governotate')}}: {{user.defaultBilling.governorateName}}<br>
                                  {{$t('pages.area')}}: {{user.defaultBilling.areaName}}<br>
                                  {{$t('pages.blockNumber')}}: {{user.defaultBilling.block}}<br>
                                  {{$t('pages.street')}}: {{user.defaultBilling.street}}<br>
                                  {{$t('pages.buildingNumber')}}: {{user.defaultBilling.building}}<br>
                                  {{$t('pages.floorNumber')}}: {{user.defaultBilling.floor}}<br>
                                  {{$t('pages.officeAddress')}}: {{user.defaultBilling.office_address}}<br>
                                  {{$t('pages.officeNumber')}}: {{user.defaultBilling.office_number}}<br>
                                </span>
                            </div>
                        </div><!--/.col-sm-6-->
                        <div class="col-sm-6" v-if="user.defaultShipping">
                            <div class="box">
                                <h5> {{$t('pages.defaultShippingAddress')}} </h5>
                                <a class="edit" href="#" @click.prevent="editAddress(user.defaultShipping)">{{$t('pages.edit')}}</a>
                                <a class="edit" href="#" style="top: 50px;" @click.prevent="deleteAddress(user.defaultShipping.id)">{{$t('pages.delete')}}</a>
                                <span v-if="user.user_type == '1'">
                                  {{$t('pages.governotate')}}: {{user.defaultShipping.governorateName}}<br>
                                  {{$t('pages.area')}}: {{user.defaultShipping.areaName}}<br>
                                  {{$t('pages.blockNumber')}}: {{user.defaultShipping.block}}<br>
                                  {{$t('pages.street')}}: {{user.defaultShipping.street}}<br>
                                  {{$t('pages.buildingNumber')}}: {{user.defaultShipping.building}}<br>
                                  {{$t('pages.floorNumber')}}: {{user.defaultShipping.floor}}<br>
                                  {{$t('pages.houseNumber')}}: {{user.defaultShipping.house_number}}<br>
                                </span>
                                <span v-if="user.user_type == '2'">
                                  {{$t('pages.governotate')}}: {{user.defaultShipping.governorateName}}<br>
                                  {{$t('pages.area')}}: {{user.defaultShipping.areaName}}<br>
                                  {{$t('pages.blockNumber')}}: {{user.defaultShipping.block}}<br>
                                  {{$t('pages.street')}}: {{user.defaultShipping.street}}<br>
                                  {{$t('pages.buildingNumber')}}: {{user.defaultShipping.building}}<br>
                                  {{$t('pages.floorNumber')}}: {{user.defaultShipping.floor}}<br>
                                  {{$t('pages.officeAddress')}}: {{user.defaultShipping.office_address}}<br>
                                  {{$t('pages.officeNumber')}}: {{user.defaultShipping.office_number}}<br>
                                </span>
                            </div>
                        </div><!--/.col-sm-6-->
                        <div class="col-sm-6" v-for="address in user.addresses">
                            <div class="box">
                                <div style="padding: 27px;"></div>
                                <a class="edit" href="#" @click.prevent="editAddress(address)">{{$t('pages.edit')}}</a>
                                <a class="edit" href="#" style="top: 50px;" @click.prevent="deleteAddress(address.id)">{{$t('pages.delete')}}</a>
                                <span v-if="user.user_type == '1'">
                                  {{$t('pages.governotate')}}: {{address.governorateName}}<br>
                                  {{$t('pages.area')}}: {{address.areaName}}<br>
                                  {{$t('pages.blockNumber')}}: {{address.block}}<br>
                                  {{$t('pages.street')}}: {{address.street}}<br>
                                  {{$t('pages.buildingNumber')}}: {{address.building}}<br>
                                  {{$t('pages.floorNumber')}}: {{address.floor}}<br>
                                  {{$t('pages.houseNumber')}}: {{address.house_number}}<br>
                                </span>
                                <span v-if="user.user_type == '2'">
                                  {{$t('pages.governotate')}}: {{address.governorateName}}<br>
                                  {{$t('pages.area')}}: {{address.areaName}}<br>
                                  {{$t('pages.blockNumber')}}: {{address.block}}<br>
                                  {{$t('pages.street')}}: {{address.street}}<br>
                                  {{$t('pages.buildingNumber')}}: {{address.building}}<br>
                                  {{$t('pages.floorNumber')}}: {{address.floor}}<br>
                                  {{$t('pages.officeAddress')}}: {{address.office_address}}<br>
                                  {{$t('pages.officeNumber')}}: {{address.office_number}}<br>
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
                                    <option value="0" disabled> {{$t('pages.selectGovernorate')}} </option>
                                    <option v-for="governorate in user.governorates" :value="governorate.id">{{governorate.name_en}}</option>
                                </select>
                            </div><!--/.col-sm-6-->
                            <div class="col-sm-6">
                                <select class="form-control" v-model="address.area">
                                    <option value="0" disabled> {{$t('pages.selectArea')}}</option>
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
                address: {
                    governorate: 0,
                    area: 0
                },
                selectedAreas: {},
                validationErrors: {}
            }
        },
        mounted() {
            this.loadAddresses();
        },
        watch: {
            'address.governorate' : function(value){
                this.updateArea(value);
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
            updateArea(value){
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
                            this.address = {
                                governorate: 0,
                                area: 0
                            };
                            this.validationErrors = {};
                            this.loadAddresses();
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
            },
            loadAddresses(){
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
                        console.log(this.user);
                    });
                }else{
                    console.log('No authorization');
                }
            },
            editAddress(addressToBeUpdated){
                console.log('clicked');
                console.log(addressToBeUpdated);
                this.address.governorate = addressToBeUpdated.governorate;
                this.address.area = addressToBeUpdated.area;
                this.address.block = addressToBeUpdated.block;
                this.address.street = addressToBeUpdated.street;
                this.address.building = addressToBeUpdated.building;
                this.address.floorNo = addressToBeUpdated.floor;
                this.address.house = addressToBeUpdated.house_number;
                this.address.officeAddress = addressToBeUpdated.office_address;
                this.address.officeNo = addressToBeUpdated.office_number;
                this.address.defaultBilling = addressToBeUpdated.is_default_billing;
                this.address.defaultShipping = addressToBeUpdated.is_default_shipping;
                this.address.id = addressToBeUpdated.id;
            },
            deleteAddress(addressId){
                this.$swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        //delete item
                        axios.post(
                            '/api/v1/account/addresses/delete',
                            {id: addressId},
                            {
                                headers: {
                                    "Authorization" : `Bearer ${this.$store.state.authModule.accessToken}`
                                }
                            }
                        ).then((response) => {
                            if(response.data){
                                this.$swal({
                                    title: 'success!',
                                    text: "Your Address has been deleted successfully!",
                                    icon: 'success'
                                });
                                this.address = {};
                                this.validationErrors = {};
                                this.loadAddresses();
                            }else{
                                this.$swal({
                                    title: 'error!',
                                    text: "Server error ... couldn't delete your address, please try again later!",
                                    icon: 'error'
                                });
                            }
                        }).catch(() => {
                            console.log('There was a problem removing from your cart')
                        });

                    }
                });
            }
        }
    }
</script>
