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
        <button v-if="!user.name || !user.email" type="button" @click="edit" class="btn btn-default">Finalize User</button>
        <!-- Edit user Modal -->
        <div class="modal fade" id="modal-edit-user" tabindex="-1" role="dialog" transition="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            Finalize User
                        </h4>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div class="alert alert-danger" v-if="editForm.errors.length > 0">
                            <p><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li v-for="error in editForm.errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Edit user Form -->
                        <form class="form-horizontal" role="form">
                            <!-- Name -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>

                                <div class="col-md-7">
                                    <input id="edit-user-name" type="text" class="form-control"
                                           @keyup.enter="edit" v-model="editForm.name">

                                    <span class="help-block">
                                        Your name, this can of course be a nickname if preferred. 
                                    </span>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Email</label>

                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="email"
                                           @keyup.enter="edit" v-model="editForm.email">

                                    <span class="help-block">
                                        Your email.
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-primary" @click="update">
                            Save Changes
                        </button>
                    </div>
                </div>
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
                user: {
                    id: "",
                    uid: "",
                    battleTag: "",
                    email: "",
                    name: "",
                    created_at: "",
                    updated_at: "",
                },

                editForm: {
                    errors: [],
                    name: '',
                    email: ''
                },
            };
        },

        /**
         * Prepare the component.
         */
        ready() {
            this.getUser();


            $('#modal-edit-user').on('shown.bs.modal', () => {
                $('#edit-user-name').focus();
            });
        },

        methods: {
            getUser() {
              this.$http.get('/api/user')
                      .then(response => {
                          this.user = JSON.parse(response.data);
                      });
            },
            
            /**
             * Edit the given user.
             */
            edit() {
                this.editForm.name = this.user.name;
                this.editForm.email = this.user.email;

                $('#modal-edit-user').modal('show');
            },

            /**
             * Update the user being edited.
             */
            update() {
                this.persistUser(
                        'put', '/api/user',
                        this.editForm, '#modal-edit-user'
                );
            },

            /**
             * Persist the user to storage using the given form.
             */
            persistUser(method, uri, form, modal) {
                form.errors = [];

                this.$http[method](uri, form)
                        .then(response => {
                            this.getCharacters();

                            form.name = '';
                            form.email = '';
                            form.errors = [];

                            $(modal).modal('hide');
                        })
                        .catch(response => {
                            if (typeof response.data === 'object') {
                                form.errors = _.flatten(_.toArray(response.data));
                            } else {
                                form.errors = ['Something went wrong. Please try again.'];
                            }
                        });
            },

            /**
             * Destroy the given user.
             */
            destroy(user) {
                this.$http.delete('/api/user');
            }
        }
    }
</script>
