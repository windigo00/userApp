<template>
    <article class="card-body mx-auto" style="max-width: 400px;">
        <h4 class="card-title mt-3 text-center">{{ 'user.Create Account' | translate }}</h4>
        <p class="text-center">{{ 'user.Get started with your free account' | translate }}</p>
        <p class="text-center">{{ 'user.Have an account?' | translate }} <a href="#" @click.prevent="$emit('page-change', 'login')">{{ 'user.Log In' | translate }}</a> </p>
        <slot></slot>
        <form v-on:input="validateAction" class="form-signin">
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <font-awesome-icon icon="user"/> </span>
                </div>
                <input v-model="name" class="form-control" :placeholder="$options.filters.translate('user.Full name')" type="text" required autofocus>
            </div> <!-- form-group// -->

            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <font-awesome-icon icon="envelope"/> </span>
                </div>
                <input v-model="email" class="form-control" :placeholder="$options.filters.translate('user.Email address')" type="email" required>
            </div> <!-- form-group// -->

            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <font-awesome-icon icon="building"/> </span>
                </div>
                <select class="form-control" v-model="isAdmin" required>
                    <option value=""> {{ 'user.Select job type' | translate }}</option>
                    <option value="0">{{ 'auth.User' | translate }}</option>
                    <option value="1">{{ 'auth.Admin' | translate }}</option>
                </select>
            </div> <!-- form-group end.// -->

            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <font-awesome-icon icon="lock"/> </span>
                </div>
                <input class="form-control"
                       id="inputPassword"
                       v-model="password"
                       :placeholder="$options.filters.translate('user.Create password')"
                       type="password"
                       required
                       autocomplete="user detail password">
            </div> <!-- form-group// -->

            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <font-awesome-icon icon="lock"/> </span>
                </div>
                <input class="form-control"
                       id="inputPassword2"
                       v-model="password2"
                       :placeholder="$options.filters.translate('user.Repeat password')"
                       type="password"
                       required autocomplete="user detail password"
                       data-match="#inputPassword">
            </div> <!-- form-group// -->

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block"> {{ 'user.Create Account' | translate }}  </button>
            </div> <!-- form-group// -->

        </form>
    </article>
</template>

<script>

    import FormBase from './_form.vue'; //base functionality
    /**
     *
     * @source: template taken from https://bootsnipp.com/snippets/z8699
     *
     */
    export default {

        extends: FormBase,

        data()
        {
            return {
                name: '',
                email: '',
                password: '',
                password2: '',
                isAdmin: '',
            };
        },

        methods: {
            validateAction()
            {
                if (this.password !== '' && this.password2 !== '') {
                    if (this.password !== this.password2) { //check password confirmation
                        this.$el.querySelector('#inputPassword2').setCustomValidity("Passwords do not match.");
                        return false;
                    } else {
                        this.$el.querySelector('#inputPassword2').setCustomValidity("");
                        return true;
                    }
                }
            },

            /**
             * Sign user in
             *
             * @returns {void}
             */
            submitAction()
            {

                this.$emit('rergistration', {
                    email: this.email,
                    name: this.name,
                    is_admin: this.isAdmin,
                    password: this.password,
                    password_confirmation: this.password2,
                });
            }
        }
    }
</script>
