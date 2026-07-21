<template>
  <AppLayout>
    <div class="space-y-6">
      <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Leave</h1>
        <Link :href="route('leave.create')"
          class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
          <PlusIcon class="w-4 h-4" />
          Apply Leave
        </Link>
      </div>

      <!-- Balance Cards -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div v-for="balance in balances" :key="balance.id"
          class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-4">
          <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ balance.leave_type?.name }}</span>
            <span class="w-3 h-3 rounded-full" :style="{ backgroundColor: balance.leave_type?.color || '#3B82F6' }"></span>
          </div>
          <div class="flex items-baseline gap-2">
            <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ balance.remaining_days }}</span>
            <span class="text-xs text-gray-500 dark:text-gray-400">/ {{ balance.total_days }} days</span>
          </div>
          <div class="mt-2 flex gap-3 text-xs text-gray-500 dark:text-gray-400">
            <span>{{ balance.used_days }} used</span>
            <span v-if="balance.pending_days">{{ balance.pending_days }} pending</span>
          </div>
        </div>
      </div>

      <!-- History -->
      <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-800">
          <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Leave History</h2>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="border-b border-gray-200 dark:border-gray-800">
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Request No</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Type</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Dates</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Days</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Status</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Applied</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
              <tr v-for="lr in leaveRequests.data" :key="lr.id" class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ lr.leave_request_no }}</td>
                <td class="px-4 py-3">
                  <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full" :style="{ backgroundColor: lr.leave_type?.color || '#3B82F6' }"></span>
                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ lr.leave_type?.name }}</span>
                  </div>
                </td>
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ formatDate(lr.start_date) }} - {{ formatDate(lr.end_date) }}</td>
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ lr.total_days }}</td>
                <td class="px-4 py-3">
                  <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full" :class="statusClass(lr.status)">
                    {{ lr.status }}
                  </span>
                </td>
                <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ formatDate(lr.applied_on) }}</td>
              </tr>
              <tr v-if="!leaveRequests.data?.length">
                <td colspan="6" class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">No leave requests</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import { formatDate } from '@/utils/date'
import { PlusIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  leaveRequests: { type: Object, default: () => ({ data: [] }) },
  balances: { type: Array, default: () => [] },
  leaveTypes: { type: Array, default: () => [] },
})

function statusClass(status) {
  const map = {
    pending: 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400',
    approved: 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
    rejected: 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
    cancelled: 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-400',
  }
  return map[status] || 'bg-gray-100 text-gray-700'
}
</script>
