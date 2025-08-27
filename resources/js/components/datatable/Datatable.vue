<!-- src/components/tables/DataTable.vue -->
<script setup lang="ts">
import { ref } from "vue"
import {
  useVueTable,
  getCoreRowModel,
  getSortedRowModel,
  getFilteredRowModel,
  getPaginationRowModel,
  FlexRender,
  SortingState,
  ColumnFiltersState,
} from "@tanstack/vue-table"

import { 
  Table, TableHeader, TableRow, TableHead, TableBody, TableCell 
} from "@/components/ui/table"

import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"

interface Props<T> {
  columns: any[]
  data: T[]
}

const props = defineProps<Props<any>>()

// Sorting + filtering state
const sorting = ref<SortingState>([])
const columnFilters = ref<ColumnFiltersState>([])
const globalFilter = ref("")

const table = useVueTable({
  data: props.data,
  columns: props.columns,
  state: {
    sorting,
    columnFilters,
    globalFilter,
  },
  onSortingChange: updater => (sorting.value = updater),
  onColumnFiltersChange: updater => (columnFilters.value = updater),
  onGlobalFilterChange: updater => (globalFilter.value = updater),
  getCoreRowModel: getCoreRowModel(),
  getSortedRowModel: getSortedRowModel(),
  getFilteredRowModel: getFilteredRowModel(),
  getPaginationRowModel: getPaginationRowModel(),
})
</script>

<template>
  <div class="space-y-4">
    <!-- 🔍 Global Search -->
    <div class="flex justify-between items-center">
      <Input
        v-model="globalFilter"
        placeholder="Search..."
        class="w-64"
      />
    </div>

    <!-- 📊 Table -->
    <div class="rounded-xl border bg-white dark:bg-gray-900 shadow-sm overflow-hidden">
      <Table>
        <TableHeader>
          <TableRow>
            <template v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
              <template v-for="header in headerGroup.headers" :key="header.id">
                <TableHead
                  class="cursor-pointer select-none"
                  @click="header.column.getToggleSortingHandler()?.($event)"
                >
                  <span v-if="!header.isPlaceholder">
                    <FlexRender :render="header.column.columnDef.header" :props="header.getContext()"/>
                  </span>
                  <span v-if="header.column.getIsSorted() === 'asc'">⬆️</span>
                  <span v-else-if="header.column.getIsSorted() === 'desc'">⬇️</span>
                </TableHead>
              </template>
            </template>
          </TableRow>
        </TableHeader>

        <TableBody>
          <template v-for="row in table.getRowModel().rows" :key="row.id">
            <TableRow>
              <template v-for="cell in row.getVisibleCells()" :key="cell.id">
                <TableCell>
                   <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()"/>
                </TableCell>
              </template>
            </TableRow>
          </template>

          <!-- Empty state -->
          <tr v-if="table.getRowModel().rows.length === 0">
            <td colspan="100%" class="text-center py-4 text-gray-500">
              No results.
            </td>
          </tr>
        </TableBody>
      </Table>
    </div>

    <!-- 📑 Pagination Controls -->
    <div class="flex justify-between items-center">
      <div class="space-x-2">
        <Button
          variant="outline"
          size="sm"
          :disabled="!table.getCanPreviousPage()"
          @click="table.previousPage()"
        >
          Prev
        </Button>
        <Button
          variant="outline"
          size="sm"
          :disabled="!table.getCanNextPage()"
          @click="table.nextPage()"
        >
          Next
        </Button>
      </div>
      <div>
        Page {{ table.getState().pagination.pageIndex + 1 }} of
        {{ table.getPageCount() }}
      </div>
    </div>
  </div>
</template>
