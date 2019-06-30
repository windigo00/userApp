<template>
    <div class="form-signin">
        <slot></slot>
        <detail :user="user"></detail>
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
<style>
    .card-img-top {
        padding: 5px;
    }
</style>