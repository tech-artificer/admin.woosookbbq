<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { columns } from '@/components/users/components/columns';
import UserTable from '@/components/users/Index.vue';
import { User } from '@/types/models';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'User Management',
        href: route('users.index'),
    },
];

defineProps<{
    title: string;
    description: string;
    users: User[],
}>()    

</script>

<template>
    <Head :title="title" :description="description" />

    <AppLayout :breadcrumbs="breadcrumbs">        
        <UserTable :rows="users" :columns="columns" />
    </AppLayout>
</template>
