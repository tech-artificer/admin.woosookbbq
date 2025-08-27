<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { columns } from '@/components/users/components/columns';
import UserTable from '@/components/users/Index.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users',
        href: '/users',
    },
];

defineProps<{
    title: string;
    description: string;
    users: any[],
}>()    

</script>

<template>
    <Head :title="title" :description="description" />

    <AppLayout :breadcrumbs="breadcrumbs">        
        <UserTable :rows="users" :columns="columns" />
    </AppLayout>
</template>
