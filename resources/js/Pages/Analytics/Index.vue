<template>
  <AppLayout>
    <div class="space-y-6">
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Analytics</h1>

      <!-- Summary Cards -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-4">
          <span class="text-xs text-gray-500 dark:text-gray-400">Attendance Rate</span>
          <p class="text-2xl font-bold text-blue-600">{{ attendanceRate }}%</p>
          <p class="text-xs text-gray-500 mt-1">this month</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-4">
          <span class="text-xs text-gray-500 dark:text-gray-400">Performance Reviews</span>
          <p class="text-2xl font-bold text-green-600">{{ completedReviews }} / {{ totalReviews }}</p>
          <p class="text-xs text-gray-500 mt-1">completed</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-4">
          <span class="text-xs text-gray-500 dark:text-gray-400">Total Applicants</span>
          <p class="text-2xl font-bold text-purple-600">{{ pipelineTotal }}</p>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Headcount Trend -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
          <h2 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Monthly Headcount ({{ year }})</h2>
          <div class="flex items-end gap-2 h-32">
            <div v-for="(count, month) in headcount" :key="month"
              class="flex-1 bg-blue-500 dark:bg-blue-400 rounded-t transition-all duration-300"
              :style="{ height: barHeight(count, headcountMax) }" :title="month + ': ' + count">
            </div>
          </div>
          <div class="flex justify-between mt-2">
            <span v-for="(_, month) in headcount" :key="month" class="text-xs text-gray-500 dark:text-gray-400">{{ month.slice(-2) }}</span>
          </div>
        </div>

        <!-- Employees by Department -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
          <h2 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Employees by Department</h2>
          <div class="space-y-3">
            <div v-for="dept in byDepartment" :key="dept.name">
              <div class="flex justify-between text-sm mb-1">
                <span class="text-gray-700 dark:text-gray-300">{{ dept.name }}</span>
                <span class="text-gray-900 dark:text-white font-medium">{{ dept.count }}</span>
              </div>
              <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                <div class="h-full rounded-full bg-emerald-500" :style="{ width: barWidth(dept.count, byDepartmentMax) }"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Leave Usage -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
          <h2 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Leave Usage</h2>
          <div class="space-y-3">
            <div v-for="item in leaveUsage" :key="item.name">
              <div class="flex justify-between text-sm mb-1">
                <span class="text-gray-700 dark:text-gray-300">{{ item.name }}</span>
                <span class="text-gray-900 dark:text-white font-medium">{{ item.days }} days</span>
              </div>
              <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                <div class="h-full rounded-full" :style="{ width: barWidth(item.days, leaveMax), backgroundColor: '#f59e0b' }"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Recruitment Pipeline -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
          <h2 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Recruitment Pipeline</h2>
          <div class="space-y-3">
            <div v-for="(count, stage) in pipeline" :key="stage">
              <div class="flex justify-between text-sm mb-1">
                <span class="text-gray-700 dark:text-gray-300 capitalize">{{ stage }}</span>
                <span class="text-gray-900 dark:text-white font-medium">{{ count }}</span>
              </div>
              <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                <div class="h-full rounded-full" :style="{ width: barWidth(count, pipelineMax), backgroundColor: stageColor(stage) }"></div>
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
  headcount: { type: Object, required: true },
  byDepartment: { type: Array, required: true },
  attendanceRate: { type: Number, required: true },
  leaveUsage: { type: Array, required: true },
  pipeline: { type: Object, required: true },
  totalReviews: { type: Number, required: true },
  completedReviews: { type: Number, required: true },
})

const year = new Date().getFullYear()

const headcountMax = Math.max(...Object.values(props.headcount), 1)
const byDepartmentMax = Math.max(...props.byDepartment.map(d => d.count), 1)
const leaveMax = Math.max(...props.leaveUsage.map(d => d.days), 1)
const pipelineMax = Math.max(...Object.values(props.pipeline), 1)
const pipelineTotal = Object.values(props.pipeline).reduce((a, b) => a + b, 0)

function barHeight(val, max) {
  return (val / max * 100) + '%'
}

function barWidth(val, max) {
  return (val / max * 100) + '%'
}

function stageColor(stage) {
  const colors = {
    applied: '#6b7280',
    screening: '#3b82f6',
    interview: '#f59e0b',
    offer: '#22c55e',
    hired: '#16a34a',
    rejected: '#ef4444',
  }
  return colors[stage] || '#3b82f6'
}
</script>
