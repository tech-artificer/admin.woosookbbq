<!-- src/components/tables/ReportTable.vue -->
<script setup lang="ts">
// import DataTable from "@/components/datatable/DataTable.vue"
import useReportColumns from "@/composables/useReportColumns"

interface Props {
  type: string
  data: any[]
}

const props = defineProps<Props>()

const { getColumns } = useReportColumns()
const columns = getColumns(props.type)
</script>

<template>
  <!-- <DataTable :columns="columns" :data="props.data" /> -->
</template>
