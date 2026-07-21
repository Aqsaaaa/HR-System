<template>
  <AppLayout>
    <div class="space-y-6">
      <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ myAttendance ? 'Clocked in at ' + myAttendance.clock_in : '' }}</p>
      </div>

      <!-- My Status -->
      <div v-if="myLeaveBalances" class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
        <h2 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">My Leave Balances</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div v-for="bal in myLeaveBalances" :key="bal.id">
            <span class="text-xs text-gray-500 dark:text-gray-400">{{ bal.leave_type?.name }}</span>
            <p class="text-lg font-bold" :class="bal.remaining_days > 0 ? 'text-gray-900 dark:text-white' : 'text-red-600'">
              {{ bal.remaining_days }} <span class="text-xs font-normal text-gray-500">/ {{ bal.total_days }}</span>
            </p>
          </div>
        </div>
      </div>

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
          <p v-if="myPendingLeave" class="text-xs text-yellow-600 mt-1">{{ myPendingLeave }} yours</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-4">
          <span class="text-xs text-gray-500 dark:text-gray-400">Latest Payroll</span>
          <p class="text-2xl font-bold text-green-600">{{ data.latest_payroll ? formatCurrency(data.latest_payroll.total_net) : '-' }}</p>
        </div>
      </div>

      <!-- Pinned Announcements -->
      <div v-if="data.pinned_announcements?.length" class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
        <h2 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Announcements</h2>
        <div v-for="item in data.pinned_announcements" :key="item.id" class="mb-3 last:mb-0">
          <h3 class="text-sm font-medium text-gray-900 dark:text-white">{{ item.title }}</h3>
          <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ item.content?.substring(0, 120) }}{{ item.content?.length > 120 ? '...' : '' }}</p>
        </div>
      </div>

      <!-- Recent Employees -->
      <div v-if="data.recent_employees?.length" class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
        <h2 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Recent Employees</h2>
        <div class="space-y-2">
          <div v-for="emp in data.recent_employees" :key="emp.id" class="flex items-center justify-between text-sm">
            <span class="text-gray-900 dark:text-white">{{ emp.first_name }} {{ emp.last_name }}</span>
            <span class="text-gray-500 dark:text-gray-400">{{ emp.employee_id }}</span>
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
})

const myAttendance = props.data.my_attendance || null
const myLeaveBalances = props.data.my_leave_balances || null
const myPendingLeave = props.data.my_pending_leave || 0

function formatCurrency(val) {
  if (!val && val !== 0) return '-'
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(val)
}
</script>
