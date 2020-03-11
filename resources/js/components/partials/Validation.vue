<template>
    <div v-if="errorsFound">
        <ul class="alert alert-danger">
            <li v-for="(errorValue, key, index) in errors" v-text="errorValue[0]"> </li>
        </ul>
    </div>
</template>

<script>

    export default {
        name: 'validation',
        props: ['errors'],
        computed: {
            validationErrors() {
                let errors = Object.values(this.errors);
                errors = errors.flat();
                return errors;
            },
            errorsFound(){
                let count = Object.values(this.errors);
                if(count.length > 0){
                    return 1;
                }else{
                    return 0;
                }
            }
        }
    }
</script>
