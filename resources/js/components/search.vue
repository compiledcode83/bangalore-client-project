<template>
    <div id="search">
        <button type="button" class="close">×</button>
        <form>
            <input type="search" value="" placeholder="Type Your Keywords" v-model="term" required/>
            <button type="submit" class="btn btnlg" @click.prevent="loadProducts">{{$t('pages.search')}}</button>
        </form>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                term: ''
            }
        },
        mounted() {
            // console.log(this.$route);
            if(this.$route.path === '/search'){
                // this.term = this.$route.query.term;
                // this.loadProducts();
                return this.$router.push({ name: 'home'});
            }
        },
        methods: {
            loadProducts(){

                if(this.term === '') {
                    this.$swal({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please add some text ...',
                    });
                    return;
                }
                axios.get('/api/v1/search/'+this.term)
                    .then((responseProducts) => {
                        $('#search').removeClass('open');
                        return this.$router.push({ name: 'searchProducts', query: {
                                term: this.term
                            },params: { products: responseProducts.data, term: this.term }
                        });
                    });
            }
        }
    }
</script>
