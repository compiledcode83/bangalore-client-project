<template>

</template>

<script>
    export default {
        name: 'layout',
        mounted() {
            let currentLang = this.$i18n.locale;
            if(currentLang == 'ar'){
                $('link[rel="stylesheet"]').each(function () {
                    if (this.href.indexOf('style.css')>=0) {
                        this.href = this.href.replace('style.css', 'style-rtl.css');
                    }
                    if (this.href.indexOf('bootstrap.css')>=0) {
                        this.href = this.href.replace('bootstrap.css', 'bootstrap-rtl.css');
                    }
                });
            }else{
                $('link[rel="stylesheet"]').each(function () {
                    if (this.href.indexOf('style-rtl.css')>=0) {
                        this.href = this.href.replace('style-rtl.css', 'style.css');
                    }
                    if (this.href.indexOf('bootstrap-rtl.css')>=0) {
                        this.href = this.href.replace('bootstrap-rtl.css', 'bootstrap.css');
                    }
                });
            }

            //change i18n default lang to load dictionary
        }
    }
</script>
