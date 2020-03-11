<template>
    <div class="social-cvr">
        <h2>{{$t('pages.socialMedia_social')}} <span>{{$t('pages.socialMedia_media')}}</span></h2>
        <p class="text-md">{{$t('pages.socialMedia_description')}}</p>
        <ul class="social">
            <li v-for="social in responseData">
                <a :href="social.link">
                    <img :src="'/'+social.icon">
                </a>
            </li>
        </ul>
    </div>
</template>

<script>

    export default {
        name: 'Social',
        data(){
            return {
                responseData: {}
            }
        },
        mounted() {
            axios.get(
                '/api/v1/social'
            ).then((response) => {
                this.responseData = response.data;
            });
        },
        methods: {
        }
    }
</script>
