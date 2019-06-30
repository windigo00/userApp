<template>
    <div class="card">
        <div class="card-img-top text-center">
            <font-awesome-icon :icon="'user-graduate'" size="10x"/>
        </div>
        <h3 class="card-title text-center">{{ user.name }}</h3>

        <ul class="list-group list-group-flush">
            <li class="list-group-item"><font-awesome-icon icon="envelope"/> {{ user.email }}</li>
            <li class="list-group-item"><font-awesome-icon :icon="'user'+(user.is_admin?'-shield':'')"/> {{ user.is_admin ? 'user.Admin role' : 'user.User role' | translate }}</li>
        </ul>
    </div>
</template>
<script>
    export default {
        props: ['user'],

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