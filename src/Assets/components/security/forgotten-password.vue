<template>
    <div>
        <div id="modal-forgotten-password" class="uk-flex-top" uk-modal>
            <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

                <button class="uk-modal-close-default" type="button" uk-close></button>
                <h3 class="uk-card-title">Mot de passe oublié</h3>
                <p>Un mail avec la procédure de la reinitilisation de votre mot de passe va vous être envoyé. Pour cela,
                    saisissez votre adrese mail de votre compte</p>

                <form action="">
                    <div class="uk-margin">
                        <div class="uk-inline uk-width-1">
                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: mail"></span>
                            <input class="uk-input" type="text" id="username_forgotten" name="_username"
                                   placeholder="Adresse email">
                        </div>
                    </div>

                    <button class="uk-button uk-align-right uk-button-primary uk-margin-small-bottom" type="submit">
                        Réinitialisation
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "forgotten-password",
        data: function () {
        }
    }
</script>

<style scoped>

</style>