<template>
    <div>

    </div>
</template>

<script>

    export default {

        data(){
            return {
                responseData: {}
            }
        },
        mounted() {
            axios.get(
                '/api/v1/account/info'
            ).then((response) => {
                this.responseData = response.data;
            });
        },
        methods: {
        }
    }
</script>
