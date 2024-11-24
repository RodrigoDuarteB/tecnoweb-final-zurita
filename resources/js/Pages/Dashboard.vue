<script setup>
import ManagmentLayout from '@/Layouts/ManagmentLayout.vue';
</script>

<template>
    <ManagmentLayout :title="`Bienvenido ${$page.props.auth.user.name}`">
        <div>
            <span></span>
        </div>
    </ManagmentLayout>
</template>
