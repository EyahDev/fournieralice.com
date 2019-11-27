<template>
    <div>
      <div v-bind:key="news.id" v-for="news in newsList" @click="windows.location = 'news/' + news.id">
        <p><strong>{{ news.title }}</strong> </p>
        <p>{ news.description }}</p>
        <p><strong>Publié le:</strong> {{ news.publicationDate | standardDate }} </p>
        <p v-if="news.lastEditDate"><strong>Modifié le:</strong> {{ news.lastEditDate | standardDate }} </p>
        <p><strong>Ajouté par:</strong> {{ news.author.firstname }} {{ news.author.lastname }}</p>
      </div>
    </div>
</template>

<script>
    export default {
        name: 'news',
        data: function () {
            return {
                newsList: null,
            }
        },
        mounted() {
            $http.get("/news").then(response => {
                this.newsList = response.data;
            });
        },
        methods: {

        }
    }
</script>
