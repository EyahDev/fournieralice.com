<template>
    <div>
        <editor
                api-key="no-api-key"
                :initialValue=about
                v-model="about"
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
        name: 'about-edit',
        data: function () {
            return {
                about: null,
            }
        },
        mounted() {
            $http.get(Routing.generate('api_about_index')).then(response => {
                this.about = response.data.content;
            });
        },
        methods: {
            save() {
                $http.post(Routing.generate('api_about_update'), {'content': this.about})
                    .then(response => {
                        //Make some toast printing to the user
                    }).catch(e => {
                    //Handle error
                });
            }
        }
    }
</script>