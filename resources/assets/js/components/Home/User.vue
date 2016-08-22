<template>

                        <!-- Form Errors -->
                        <div class="alert alert-danger" v-if="userForm.errors.length > 0">
                            <p><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li v-for="error in userForm.errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Finalize user Form -->
                        <form id="userForm" class="form-horizontal" role="form">
                            <!-- Name -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>

                                <div class="col-md-7">
                                    <input id="edit-user-name" type="text" class="form-control"
                                           @keyup.enter="store" v-model="userForm.name">

                                    <span class="help-block">
                                        Your name.
                                    </span>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Email</label>

                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="email"
                                           @keyup.enter="store" v-model="userForm.email">

                                    <span class="help-block">
                                        Your email.
                                    </span>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Password</label>

                                <div class="col-md-7">
                                    <input type="password" class="form-control" name="password"
                                           @keyup.enter="store" v-model="userForm.password">

                                    <span class="help-block">
                                        Password
                                    </span>
                                </div>
                            </div>

                            <!-- Password Confirmation -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Password Confirmation</label>

                                <div class="col-md-7">
                                    <input type="password" class="form-control" name="password_confirmation"
                                           @keyup.enter="store" v-model="userForm.password_confirmation">

                                    <span class="help-block">
                                        Password
                                    </span>
                                </div>
                            </div>
                        </form>
</template>

<script>
    export default {
        /*
         * The component's data.
         */
        data() {
            return {
                userForm: {
                    uid: "",
                    battleTag: "",
                    email: "",
                    name: "",
                    password: "",
                    password_confirmation: "",
                    created_at: "",
                    updated_at: "",
                    errors: {}
                },
                user: {}
            };
        },

        /**
         * Prepare the component.
         */
        ready() {
            this.getUser();
        },

        methods: {

            /**
             * Get the current user
             */
            getUser() {
                this.$http.get('/api/user')
                        .then(response => {
                            this.user = JSON.parse(response.data);
                        });
            },
           
            /**
             * Update the user being edited.
             */
            store() {
                this.userForm.uid = this.user.uid;
                this.userForm.battleTag = this.user.battleTag;
                this.persistUser(
                        'patch', '/api/user/'+this.user.id,
                        this.userForm
                );
            },

            /**
             * Persist the user to storage using the given form.
             */
            persistUser(method, uri, form) {
                form.errors = [];

                this.$http[method](uri, form)
                        .then(response => {
                            setTimeout(function () {
                                swal(
                                    "Done!",
                                    "Hang on tight while you fetch you a transport shuttle and sent you into your new Home ;)",
                                    "success"
                                );
                            }, 2500 );

                            location.reload();
                        })
                        .catch(response => {
                            if (typeof response.data === 'object') {
                                form.errors = _.flatten(_.toArray(response.data));
                            } else if(typeof response.data === 'string') {
                                form.errors = _.flatten(_.toArray(JSON.parse(response.data)));
                            } else {
                                console.log(typeof response.data);
                                form.errors = ['Something went wrong. Please try again.'];
                            }
                        });
            },
        }
    }
</script>
