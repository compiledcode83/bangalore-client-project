<template></template>
<script>
    export default {
        name: 'ProductDetailsCheck',
        beforeCreate() {
            return this.$router.push({path: '/products/' + this.$route.params.slug});
        }
    }
</script>

