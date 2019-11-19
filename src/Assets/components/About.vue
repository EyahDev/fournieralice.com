<template>
    <div>
        <div v-if="about">
            <section v-html="about"></section>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'about-section',
        data: function () {
            return {
                about: null,
            }
        },
        mounted() {
            $http.get(Routing.generate('api_about_index')).then(response => {
                this.about = response.data.content;
            });
        }
    }
</script>