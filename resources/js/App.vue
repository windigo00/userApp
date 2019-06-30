<template>
    <div class="container">
        <h1 class="text-center" v-if="page == 'login' || page == 'registration'">{{'default.Welcome' | translate }}</h1>
        <login-page
            v-if="page == 'login' && $root.loc.loaded"
            v-on:page-change="changePage($event)"
            v-on:login="login($event)">
            <message :type="type" :message="message"></message>
        </login-page>

        <reg-page
            v-if="page == 'registration' && $root.loc.loaded"
            v-on:page-change="changePage($event)"
            v-on:rergistration="register($event)">
            <message :type="type" :message="message"></message>
        </reg-page>

        <list-page
            v-if="page == 'list' && $root.loc.loaded"
            v-on:update="getUserList($event)"
            v-on:save="saveUser($event)"
            v-on:delete="deleteUser($event)"
            ref="list"
            :page="users">
            <nav-component v-on:logout="logout" :user="user"></nav-component>
            <message :type="type" :message="message"></message>
        </list-page>

        <detail-page
            v-if="page == 'detail' && $root.loc.loaded"
            :user="user">
            <nav-component v-on:logout="logout" :user="user"></nav-component>
            <message :type="type" :message="message"></message>
        </detail-page>

        <div class="text-center" v-if="page == '' || !$root.loc.loaded">
            <font-awesome-icon :icon="'cog'" spin size="6x"/>
        </div>
    </div>
</template>

<script>

    import Axios from 'axios';

    import LoginPage from './components/login.vue';
    import RegPage   from './components/registration.vue';
    import ListPage  from './components/list.vue';
    import DetailPage from './components/detail_page.vue';
    import NavComponent from './components/nav.vue';
    import Message   from './components/message.vue';

    /**
     * Main controling app
     */
    export default {

        components: {
            LoginPage,
            RegPage,
            DetailPage,
            ListPage,
            NavComponent,
            Message
        },

        data()
        {
            return {
                page    : '',   //current page
                user    : null, //current user
                users   : [],   //list for grid
                loc     : null, //locales
                message : '',
                type    : ''
            };
        },

        methods: {
            /**
             * Change current page
             *
             * @param {type} value
             * @returns {void}
             */
            changePage(value)
            {
                this.message = '';
                this.page = value;
            },

            /**
             * Perform login action and set api key on success or display error
             *
             * @param {type} data
             * @returns {undefined}
             */
            login(data)
            {
                Axios.post(this.$parent.routes.login, data)
                .then(function (response) {
                    if (response.data) {
                        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = response.data.token;
                        this.isAuthenticated(this.checkAuth.bind(this));
                        this.showMessage('success', response.data.message);
                    } else {
                        this.showMessage('error', response.data.message);
                    }
                }.bind(this))
                .catch(this.handleError.bind(this));
            },

            /**
             * Perform reg action and redir to login on success or display error
             *
             * @param {Object} data
             * @returns {undefined}
             */
            register(data)
            {
                Axios.post(this.$parent.routes.register, data)
                .then(function (response) {
                    this.isAuthenticated(this.checkAuth.bind(this));
                }.bind(this))
                .catch(this.handleError.bind(this));
            },
            /**
             * Perform logout ajax call
             * @returns {undefined}
             */
            logout()
            {
                Axios.post(this.$parent.routes.logout)
                .then(function (response) {
                    if (response.data) {
                        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = response.data.token;
                        this.changePage('login');
                        this.showMessage('', response.data.message);

                    } else {
                        this.showMessage('error', response.data.message);
                    }
                }.bind(this))
                .catch(this.handleError.bind(this));
            },
            /**
             * Perform auth check ajax call
             * @returns {undefined}
             */
            isAuthenticated(successCallback)
            {
                Axios.post(this.$parent.routes.check)
                .then((response) => {
                    successCallback(response.data);
                })
                .catch(this.handleError.bind(this));
            },

            /**
             * Perform logout ajax call
             * @returns {undefined}
             */
            getUserList(data)
            {
                Axios.post(this.$parent.routes.user_grid, data)
                .then(function (response) {
                    if (response.data) {
                        this.users = response.data.page;
                    } else {
                        this.showMessage('error', response.data.message);
                    }
                }.bind(this))
                .catch(this.handleError.bind(this));
            },

            saveUser(data)
            {
                Axios.put(this.$parent.routes.user_edit.replace('?', data.id), data)
                .then(function (response) {
                    if (response.data.success) {
                        this.showMessage('', response.data.message);
                        this.$refs.list.updatePaging();//update grid
                    } else {
                        this.showMessage('error', response.data.message);
                    }
                }.bind(this))
                .catch(this.handleError.bind(this));
            },

            deleteUser(userId)
            {
                Axios.delete(this.$parent.routes.user_delete.replace('?', userId))
                .then(function (response) {
                    if (response.data.success) {
                        this.showMessage('', response.data.message);
                        this.$refs.list.updatePaging();//update grid
                    } else {
                        this.showMessage('error', response.data.message);
                    }
                }.bind(this))
                .catch(this.handleError.bind(this));
            },

            /**
             * Auth check callback method
             *
             * @param {object} result Data from request
             * @returns {undefined}
             */
            checkAuth(result)
            {
                if (result !== false) {
                    if (result.admin) {
                        this.page = 'list';
                    } else {
                        this.page = 'detail';
                    }
                    this.user = result;
                } else {
                    this.page = 'login';
                }
            },

            /**
             * Set data for info message
             * @param {type} type
             * @param {type} message
             * @returns {undefined}
             */
            showMessage(type, message)
            {
                this.type = type;
                this.message = message;
            },

            /**
             * Handle request exceptions
             * @param {type} error
             * @returns {undefined}
             */
            handleError(error)
            {

                if (error.response.data) {
                    if (error.response.data.errors) {
                        var msg = [],
                            err;
                        for(var e in error.response.data.errors) {
                            err = error.response.data.errors[e];
                            for(var i in err) {
                                msg.push(err[i]);
                            }
                        }
                        this.showMessage('error', msg.join('<br>'));
                    }
                    else if (error.response.data.message) {
                        this.showMessage('error', error.response.data.message);
                    }
                } else {
                    this.showMessage('error', error);
                }
            }
        },

        beforeMount()
        {
            this.isAuthenticated(this.checkAuth.bind(this));
        }
    }
</script>
