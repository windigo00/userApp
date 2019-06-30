<template>
    <!-- Modal -->
    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ "user.User edit" | translate }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <article class="card-body mx-auto" style="max-width: 400px;">
                        <slot></slot>
                        <form class="form-signin" v-on:submit.prevent="save">
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <font-awesome-icon icon="user"/> </span>
                                </div>
                                <input v-model="usr.name" class="form-control" :placeholder="$options.filters.translate('user.Full name')" type="text" required autofocus>
                            </div> <!-- form-group// -->

                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <font-awesome-icon icon="building"/> </span>
                                </div>
                                <select class="form-control" v-model="usr.is_admin" required>
                                    <option value=""> {{ 'user.Select job type' | translate }}</option>
                                    <option value="0">{{ 'auth.User' | translate }}</option>
                                    <option value="1">{{ 'auth.Admin' | translate }}</option>
                                </select>
                            </div> <!-- form-group end.// -->

                        </form>
                    </article>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="$el.querySelector('form').reportValidity() ? save() : ''">{{ "default.Save" | translate }}</button>
                    <button id="bclose" type="button" class="btn btn-secondary" data-dismiss="modal">{{ "default.Close" | translate }}</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    export default {

        props: ['user'],

        data()
        {
            return {
                usr : Object.assign({}, this.user)
            };
        },

        watch: {
            user(newValue)
            {
                this.usr = Object.assign({}, newValue);
            }
        },

        methods: {
            save()
            {
                this.$el.querySelector('#bclose').click();
                this.$emit('save', {
                    id       : this.usr.id,
                    name     : this.usr.name,
                    is_admin : this.usr.is_admin,
                });
            }
        }

    }
</script>