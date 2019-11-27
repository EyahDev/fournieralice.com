<template>
  <div>
      <input type="text" v-model="news.title">
      <editor
              api-key="no-api-key"
              :initialValue=description
              v-model="news.description"
              :init="{
       height: 500,
       menubar: false,
       plugins: [
         'advlist autolink lists link image charmap print preview anchor',
         'searchreplace visualblocks code fullscreen',
         'insertdatetime media table paste code help wordcount'
       ],
       toolbar:
         'undo redo | formatselect | bold italic backcolor | \
         alignleft aligncenter alignright alignjustify | \
         bullist numlist outdent indent | removeformat | help'
     }"
      ></editor>
      <button @click="save">Sauvegarder</button>
  </div>
</template>

<script>
    export default {
        name: 'news-edit',
        props: ['news_id', 'title', 'description'],
        data: function () {
            return {
                api: this.news_id ? "api_news_update" : "api_news_create",
                params: this.news_id ? {id: this.news_id } : {},
                news: {
                    'id': this.news_id,
                    'title': this.title,
                    'description': this.description
                }
            }
        },
        methods: {
            save() {
                $http.post(Routing.generate(this.api, this.params), this.news)
                    .then(response => {
                        //Make some toast printing to the user
                    }).catch(e => {
                    //Handle error
                });
            }
        }
    }
</script>
