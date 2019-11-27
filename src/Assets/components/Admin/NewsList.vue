<template>
<div>
  <h1>News</h1>
  <div v-if="!create">
    <div v-bind:key="news.id" v-for="news in newsList">
      <p><strong>#{{ news.id }}</strong> </p>
      <p><strong>Titre:</strong> {{ news.title }}</p>
      <p><strong>Description:</strong> {{ news.description }}</p>
      <p><strong>Publié le:</strong> {{ news.publicationDate | standardDate }} </p>
      <p v-if="news.lastEditDate"><strong>Modifié le:</strong> {{ news.lastEditDate | standardDate }} </p>
      <p><strong>Ajouté par:</strong> {{ news.author.firstname }} {{ news.author.lastname }}</p>
      <p><strong>Archivé:</strong> {{ news.archived ? "Oui" : "Non" }} </p>
      <a v-bind:href="'news/' + news.id + ''">Editer</a>
      <button @click="deleteNews(news.id)">Supprimer</button>
      <button @click="archive(news)">{{ news.archived ? "Toujours afficher" : "Archiver" }}</button>
    </div>
    <div>
      <button @click="create = true">Créer une news</button>
    </div>
  </div>
  <news-edit v-if="create"></news-edit>
</div>
</template>

<script>
    export default {
        name: 'news-list',
        data: function () {
            return {
                newsList: null,
                create: false
            }
        },
        mounted() {
            $http.get(Routing.generate('api_news_index')).then(response => {
                this.newsList = response.data;
            });
        },
        methods: {
            deleteNews(news_id) {
                $http.delete(Routing.generate('api_news_delete', { id: news_id }))
                .then(response => {
                    //Make some toast printing to the user
                    this.newsList = this.newsList.filter(news => news.id != news_id);
                }).catch(e => {
                //Handle error
                });
            },
            archive(news) {
                news.archived = !news.archived;
                $http.post(Routing.generate('api_news_update', { id: news.id }), news)
                .then(response => {
                    //Make some toast printing to the user

                }).catch(e => {
                //Handle error
                });
            }
        }
    }
</script>
