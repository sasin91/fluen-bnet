<style scoped>
    .action-link {
        cursor: pointer;
    }

    .m-b-none {
        margin-bottom: 0;
    }
</style>

<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>Characters</h1>
            </div>

            <div class="panel-body">
                <!-- Current characters -->
                <p class="m-b-none" v-if="characters.length === 0">
                    You have not created any characters.
                </p>

                <table class="table table-borderless m-b-none" v-if="characters.length > 0">
                    <thead>
                    <th>Avatar</th>
                    <th>Name</th>
                    <th>Realm</th>
                    <th>Level</th>
                    <th>Guild</th>
                    </thead>

                    <tbody>
                    <tr v-for="character in characters">
                        <!-- Avatar -->
                        <td style="vertical-align: middle;">
                            <img src="http://render-api-eu.worldofwarcraft.com/static-render/eu/{{ character.thumbnail }}" class="img-responsive" alt="Avatar">
                        </td>

                        <!-- Name -->
                        <td style="vertical-align: middle;">
                            {{ character.name }}
                        </td>

                        <!-- Realm -->
                        <td style="vertical-align: middle;">
                            {{ character.realm }}
                        </td>

                        <!-- Level -->
                        <td style="vertical-align: middle;">
                            {{ character.level }}
                        </td>

                        <!-- Guild -->
                        <td style="vertical-align: middle;">
                            {{ character.guild }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        /*
         * The component's data.
         */
        data() {
            return {
                characters: []
            };
        },

        /**
         * Prepare the component.
         */
        ready() {
            this.getAccessToken();

            Vue.http.interceptors.push(function(request, next){
                var token;

                token = localStorage.getItem('access_token');
                if ( token !== null && token !== 'undefined') {
                    Vue.http.headers.common['Authorization'] = token;
                }

                next(function (response) {
                    if (response.status && response.status.code == 401) {
                        localStorage.removeItem('access_token');
                    }
                    if (response.headers && response.headers.Authorization) {
                        localStorage.setItem('access_token', response.headers.Authorization)
                    }
                    if (response.data && response.data.token && response.data.token.length > 10) {
                        localStorage.setItem('access_token', 'Bearer ' + response.data.token);
                    }
                })
            });

            this.getCharacters();
        },

        methods: {

            getAccessToken() {
              this.$http.get('/auth/battleNet/token')
                      .then(response => {
                          localStorage.setItem('access_token', response.data);
                      });
            },

            /**
             * Get all of the OAuth characters for the user.
             */
            getCharacters() {
                this.$http.get('https://eu.api.battle.net/wow/user/characters', {params: { access_token: localStorage.getItem('access_token') }})
                        .then(response => {
                            this.characters = response.data.characters;
                        });
            }
        }
    }
</script>
