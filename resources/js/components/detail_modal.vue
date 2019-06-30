<template>
    <!-- Modal -->
    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ "user.User detail" | translate }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <detail v-if="user" :user="user"></detail>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ "default.Close" | translate }}</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Detail from './detail.vue';

    export default {

        props: ['user'],

        components: {
            Detail
        },

        data()
        {
            return {};
        }
    }
</script>