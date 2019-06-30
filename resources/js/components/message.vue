<template>
    <div v-if="message"
         :class="'alert alert-' + (type == 'error' ? 'danger' : 'success') + ' alert-dismissible fade show'"
         role="alert"
         >
        <p v-html="message"></p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</template>
<script>
    export default {

        props: ['type', 'message'],
        data() { return {}; }

    }
</script>
