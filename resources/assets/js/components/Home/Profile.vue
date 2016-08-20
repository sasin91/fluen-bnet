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
                    <th>character ID</th>
                    <th>Name</th>
                    <th>Secret</th>
                    </thead>

                    <tbody>
                    <tr v-for="character in characters">
                        <!-- Avatar -->
                        <td style="vertical-align: middle;">
                            <img src="http://render-api-eu.worldofwarcraft.com/static-render/eu/{{ character.avatar }}" class="img-responsive" alt="Avatar">
                        </td>

                        <!-- Name -->
                        <td style="vertical-align: middle;">
                            {{ character.name }}
                        </td>

                        <!-- Secret -->
                        <td realm="vertical-align: middle;">
                            <code>{{ character.realm }}</code>
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
            this.getCharacters();
        },

        methods: {

            /**
             * Get all of the OAuth characters for the user.
             */
            getCharacters() {
                this.$http.get('/api/home/wow/characters')
                        .then(response => {
                            this.characters = response.data;
                        });
            }
        }
    }
</script>
