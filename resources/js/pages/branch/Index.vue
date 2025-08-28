<script setup lang="ts">
import { onMounted } from 'vue'
import {
  Card, CardContent, CardHeader, CardTitle, CardDescription
} from '@/components/ui/card';
import { getBranchColumns } from './branch-columns';
import BranchTable from './components/BranchTable.vue';
import { Branch } from '@/types/models';

const columns = getBranchColumns();

const props = defineProps<{
    rows: Branch[], 
}>()

onMounted(() => {
    
})

</script>

<template>
    <!--  -->
      <Card class="border-0">
      <CardHeader class="text-center6 border-b border-gray-200 dark:border-gray-700">
        <CardTitle class="text-2xl font-body font-semibold border-0">
          Branches
        </CardTitle>
        <CardDescription class="text-muted-foreground">
          Manage what each role can access across the system.
        </CardDescription>
      </CardHeader>
      <!-- Content -->
      <CardContent class="space-y-8 pt-3">
        <!-- Role Selection -->
        <BranchTable :rows="props.rows" :columns="columns" />
      </CardContent>
    </Card>
</template>