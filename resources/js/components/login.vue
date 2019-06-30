<template>
    <div class="text-center">
        <form class="form-signin">
            <slot></slot>
            <h1 class="h3 mb-3 font-weight-normal">{{ 'user.Please sign in' | translate }}</h1>

            <label for="inputEmail" class="sr-only">{{ 'user.Email address' | translate }}</label>
            <input type="email"
                   id="inputEmail"
                   v-model="email"
                   class="form-control first"
                   :placeholder="$options.filters.translate('user.Email address')"
                   required autofocus>

            <label for="inputPassword" class="sr-only">{{ 'user.Password' | translate }}</label>
            <input type="password"
                   id="inputPassword"
                   v-model="password"
                   class="form-control last"
                   :placeholder="$options.filters.translate('user.Password')"
                   required autocomplete="user detail password">

            <label v-show="false" v-on:click="remember = !remember">
                <font-awesome-icon class="" :icon="remember ? 'check-square' : 'times'"/>&nbsp;
                {{ 'user.Remember me' | translate }}
                <input type="hidden" name="remember" v-model="remember">
            </label>

            <button class="btn btn-lg btn-primary btn-block" type="submit">
                <font-awesome-icon icon="sign-in-alt" pull="right"/> {{ 'user.Sign in' | translate }}
            </button>
            <p class="divider-text">
                <span style="background-color: #f5f5f5;">{{ 'default.OR' | translate }}</span>
            </p>
            <button class="btn btn-lg btn-warning btn-block" @click="$emit('page-change', 'registration')">
                <font-awesome-icon pull="right" icon="user-plus"/> {{ 'user.Sign up' | translate }}
            </button>
        </form>
    </div>
</template>

<script>

    import FormBase from './_form.vue'; //base functionality
    /**
     *
     * @source: template taken from https://getbootstrap.com/docs/4.3/examples/sign-in/
     */
    export default {

        extends: FormBase,

        data()
        {
            return {
                email    : '',
                password : '',
                remember : false
            };
        },

        methods: {
            /**
             * Sign user in
             *
             * @returns {void}
             */
            submitAction()
            {
                this.$emit('login', {
                    email    : this.email,
                    password : this.password
                });
            }
        }
    }
</script>
