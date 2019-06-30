<template>
    <nav class="nav nav-tabs">
        <li class="nav-item primary">
            <a class="nav-link active bg-primary text-white" @click.prevent="$emit('logout')" href="#"><font-awesome-icon icon="sign-out-alt"/>{{ 'auth.Logout' | translate }}</a>
        </li>
    </nav>
</template>
<script>
    export default {
        data()
        {
            return {};
        }
    }
</script>
