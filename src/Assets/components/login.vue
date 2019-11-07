<template>
    <div>
        <div>
            <button @click="changeLang()">Changer de langue</button>
            <p>ceci est du vue.js</p>
            <p>{{ "welcome.name"|trans({'%name%': pseudo}, "workend") }}</p>
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
    }
</script>

<style scoped>

</style>