<template>
    <div>
        <div>
            <button @click="changeLang">Changer de langue</button>
            <p>ceci est du vue.js</p>
            <p>{{ 'messages.welcome' | trans({'pseudo': pseudo}) }}</p>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'login',
        data: function () {
            return {
                pseudo: 'Bad_Dev'
            }
        },
        methods: {
            changeLang(){
                if(this.translation.getLocale() === 'fr'){
                    this.translation.setLocale('en');
                }else{
                    this.translation.setLocale('fr');
                }
            }
        },
    }
</script>

<style scoped>

</style>