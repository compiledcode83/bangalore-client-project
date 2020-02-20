<template>
    <div id="search">
        <button type="button" class="close">×</button>
        <form>
            <input type="search" value="" placeholder="Type Your Keywords" v-model="term" />
            <button type="submit" class="btn btnlg" @click.prevent="loadProducts">Search</button>
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
        methods: {
            loadProducts(){

                axios.get('/api/v1/search/'+this.term)
                    .then((responseProducts) => {
                        console.log(responseProducts.data);
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
