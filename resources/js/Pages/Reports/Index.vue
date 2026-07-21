<template>
  <AppLayout>
    <div class="space-y-6">
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Reports</h1>

      <!-- Summary Cards -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-4">
          <span class="text-xs text-gray-500 dark:text-gray-400">Total Employees</span>
          <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ data.total_employees }}</p>
          <p class="text-xs text-green-600 mt-1">{{ data.active_employees }} active</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-4">
          <span class="text-xs text-gray-500 dark:text-gray-400">Attendance Today</span>
          <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ data.attendance_today }}</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-4">
          <span class="text-xs text-gray-500 dark:text-gray-400">Pending Leave</span>
          <p class="text-2xl font-bold text-yellow-600">{{ data.pending_leave }}</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-4">
          <span class="text-xs text-gray-500 dark:text-gray-400">Completed Reviews</span>
          <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ data.completed_reviews }}</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-4">
          <span class="text-xs text-gray-500 dark:text-gray-400">Open Positions</span>
          <p class="text-2xl font-bold text-blue-600">{{ data.open_jobs }}</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-4">
          <span class="text-xs text-gray-500 dark:text-gray-400">New Hires (This Month)</span>
          <p class="text-2xl font-bold text-green-600">{{ data.new_hires }}</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-4">
          <span class="text-xs text-gray-500 dark:text-gray-400">Pinned Announcements</span>
          <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ data.pinned_announcements }}</p>
        </div>
      </div>

      <!-- Charts -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Leave Status -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
          <h2 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Leave by Status</h2>
          <div class="space-y-3">
            <div v-for="(count, status) in chart.leave_by_status" :key="status">
              <div class="flex items-center justify-between text-sm mb-1">
                <span class="text-gray-700 dark:text-gray-300 capitalize">{{ status }}</span>
                <span class="text-gray-900 dark:text-white font-medium">{{ count }}</span>
              </div>
              <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                <div class="h-full rounded-full" :style="{ width: barWidth(count, chart.leave_by_status), backgroundColor: barColor(status) }"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Employee Status -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
          <h2 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Employee by Status</h2>
          <div class="space-y-3">
            <div v-for="(count, status) in chart.employee_by_status" :key="status">
              <div class="flex items-center justify-between text-sm mb-1">
                <span class="text-gray-700 dark:text-gray-300 capitalize">{{ status }}</span>
                <span class="text-gray-900 dark:text-white font-medium">{{ count }}</span>
              </div>
              <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                <div class="h-full rounded-full" :style="{ width: barWidth(count, chart.employee_by_status), backgroundColor: barColor(status) }"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  data: { type: Object, required: true },
  chart: { type: Object, required: true },
})

function barWidth(count, total) {
  const max = Math.max(...Object.values(total), 1)
  return (count / max * 100) + '%'
}

function barColor(key) {
  const colors = {
    pending: '#f59e0b',
    approved: '#22c55e',
    rejected: '#ef4444',
    active: '#22c55e',
    inactive: '#6b7280',
    terminated: '#ef4444',
    resigned: '#f59e0b',
  }
  return colors[key] || '#3b82f6'
}
</script>
