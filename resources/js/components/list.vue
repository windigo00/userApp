<template>
    <div>
        <div class="table-responsive-md">
            <slot></slot>
            <table class="bg-white table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col" class="w-10">#</th>
                        <th scope="col" class="w-10"></th>
                        <th scope="col">{{ 'user.Name'    | translate }}</th>
                        <th scope="col">{{ 'user.E-mail'  | translate }}</th>
                        <th scope="col">{{ 'user.Role'    | translate }}</th>
                        <th scope="col">{{ 'user.Created' | translate }}</th>
                        <th scope="col">{{ 'user.Updated' | translate }}</th>
                        <th scope="col">{{ 'user.Verified'| translate }}</th>
                    </tr>
                </thead>
                <tbody>
                    <component
                        is="tr"
                        v-for="(usr, idx) in users"
                        :key="idx">
                        <th scope="row"  class="text-right">{{ usr.id }}</th>
                        <th scope="row"  class="text-center">
                            <span class="btn btn-light"
                                  :title="$options.filters.translate('user.Edit')"
                                  data-toggle="modal"
                                  data-target="#editModal"
                                  @click="mode='edit'; user = usr">
                                <font-awesome-icon icon="wrench" class="text-primary"/></span>
                            <span class="btn btn-light"
                                  v-if="$parent.user.id !== usr.id"
                                  @click="deleteUser(usr)"
                                  :title="$options.filters.translate('user.User delete')">
                                <font-awesome-icon icon="trash" class="text-danger del"/></span>
                        </th>
                        <td>
                            <a class="view"
                               data-toggle="modal"
                               data-target="#detailModal"
                               @click="mode=''; user = usr">
                                {{ usr.name }}
                            </a>
                        </td>
                        <td>
                            <a class="view"
                               data-toggle="modal"
                               data-target="#detailModal"
                               @click="mode=''; user = usr">
                            {{ usr.email }}
                            </a>
                        </td>
                        <th scope="row" class="text-center">
                            <font-awesome-icon
                                :title="$options.filters.translate(usr.is_admin ? 'auth.Admin' : 'auth.User')"
                                :icon="usr.is_admin ? 'user-shield' : 'user'"/>
                        </th>
                        <td>{{ usr.created_at }}</td>
                        <td>{{ usr.updated_at }}</td>
                        <th scope="row" class="text-center">
                            <font-awesome-icon
                                :title="$options.filters.translate(usr.email_verified_at ? 'user.Verified at :date' : 'user.Not verified', { date : usr.email_verified_at})"
                                :icon="usr.email_verified_at ? 'check' : 'times'"/>
                        </th>
                    </component>
                </tbody>
            </table>
            <simple-paging ref="paging"
                :page="pagingConfig.currentPage"
                :per-page="pagingConfig.perPage"
                :pages="pagingConfig.pages"
                v-on:change="updatePaging"></simple-paging>
        </div>
        <detail id="detailModal" :user="user" v-if="mode!=='edit'"></detail>
        <edit id="editModal" :user="user" ref="edit" v-if="mode==='edit'" v-on:save="$emit('save', $event)"></edit>
    </div>
</template>

<script>

    import Axios from 'axios';
    import SimplePaging from './SimplePaging.vue';
    import Detail from './detail_modal.vue';
    import Edit from './edit_modal.vue';

    /**
     * Main controling app
     */
    export default {

        props: ['page'],

        components: {
            SimplePaging,
            Detail,
            Edit
        },

        data()
        {
            return {
                users : [], //result of paging
                user : null,
                mode : '',
                pagingConfig : {
                    currentPage : 1,
                    perPage : 5,
                    pages : -1
                }
            };
        },

        watch : {
            page(newVal)
            {
                this.users = newVal.data;
                this.pagingConfig.currentPage = newVal.current_page -1;
                this.pagingConfig.perPage = newVal.per_page;
                this.pagingConfig.pages = newVal.last_page;
            }

        },

        methods: {

            updatePaging(data)
            {
                if (!data) {
                    data = this.$refs.paging.getEventData();
                }
                this.$emit('update', data);
            },

            deleteUser(user)
            {
                if (this.$parent.user.id !== user.id) {
                    if (window.confirm(this.$options.filters.translate('default.Are you sure?'))) {
                        this.$emit('delete', user.id);
                    }
                }
            }
        },

        mounted()
        {
            this.updatePaging();
        }
    }
</script>

<style>
    .page-link .dropdown-menu.show {
        top: 8px !important;
        left: -16px !important;
    }

    tbody .view {
        cursor: pointer;
    }

    .del {
        margin-left: 5px;
    }
</style>