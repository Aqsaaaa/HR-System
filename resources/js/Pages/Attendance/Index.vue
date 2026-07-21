<template>
  <AppLayout>
    <div class="space-y-6">
      <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Attendance</h1>
      </div>

      <!-- Today's Status -->
      <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
        <div class="flex items-center justify-between">
          <div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Today</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ currentDate }}</p>
          </div>
          <div class="flex items-center gap-4">
            <div v-if="today && today.clock_in && !today.clock_out" class="text-right">
              <p class="text-sm text-gray-500 dark:text-gray-400">Clocked in at</p>
              <p class="text-lg font-semibold text-green-600 dark:text-green-400">{{ formatTime(today.clock_in) }}</p>
            </div>
            <div v-if="today && today.clock_out" class="text-right">
              <p class="text-sm text-gray-500 dark:text-gray-400">Total hours</p>
              <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ today.total_hours }}h</p>
            </div>
            <div class="flex gap-3">
              <button v-if="!today?.clock_in" @click="clockIn"
                :disabled="clockingIn"
                class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors disabled:opacity-50">
                <ArrowRightOnRectangleIcon class="w-5 h-5" />
                {{ clockingIn ? 'Clocking in...' : 'Clock In' }}
              </button>
              <button v-if="today?.clock_in && !today?.clock_out" @click="clockOut"
                :disabled="clockingOut"
                class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors disabled:opacity-50">
                <ArrowLeftOnRectangleIcon class="w-5 h-5" />
                {{ clockingOut ? 'Clocking out...' : 'Clock Out' }}
              </button>
            </div>
          </div>
        </div>
        <div v-if="today" class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-800">
          <div class="flex items-center gap-4 text-sm">
            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full"
              :class="today.status === 'present' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' : 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400'">
              <CheckCircleIcon v-if="today.status === 'present'" class="w-4 h-4" />
              <ExclamationCircleIcon v-else class="w-4 h-4" />
              {{ today.status }}
            </span>
            <span class="text-gray-500 dark:text-gray-400">{{ today.type }}</span>
            <span v-if="today.clock_in" class="text-gray-500 dark:text-gray-400">In: {{ formatTime(today.clock_in) }}</span>
            <span v-if="today.clock_out" class="text-gray-500 dark:text-gray-400">Out: {{ formatTime(today.clock_out) }}</span>
          </div>
        </div>
        <div v-else class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-800">
          <p class="text-sm text-gray-500 dark:text-gray-400">No attendance record for today. Click "Clock In" to start.</p>
        </div>
      </div>

      <!-- History -->
      <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-800">
          <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Attendance History</h2>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="border-b border-gray-200 dark:border-gray-800">
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Date</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Clock In</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Clock Out</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Hours</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Status</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Type</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
              <tr v-for="att in attendances.data" :key="att.id" class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ att.date }}</td>
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ formatTime(att.clock_in) || '-' }}</td>
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ formatTime(att.clock_out) || '-' }}</td>
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ att.total_hours ? att.total_hours + 'h' : '-' }}</td>
                <td class="px-4 py-3">
                  <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full" :class="statusClass(att.status)">
                    {{ att.status }}
                  </span>
                </td>
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ att.type }}</td>
              </tr>
              <tr v-if="!attendances.data?.length">
                <td colspan="6" class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">No attendance records</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import { ArrowRightOnRectangleIcon, ArrowLeftOnRectangleIcon, CheckCircleIcon, ExclamationCircleIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  today: { type: Object, default: null },
  attendances: { type: Object, default: () => ({ data: [] }) },
})

const clockingIn = ref(false)
const clockingOut = ref(false)

const currentDate = computed(() => {
  return new Date().toLocaleDateString('en-US', {
    weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
  })
})

function formatTime(dt) {
  if (!dt) return null
  const d = new Date(dt)
  return d.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })
}

function clockIn() {
  clockingIn.value = true
  router.post('/api/v1/attendance/clock-in', {}, {
    preserveState: true,
    onSuccess: () => { clockingIn.value = false },
    onError: () => { clockingIn.value = false },
  })
}

function clockOut() {
  clockingOut.value = true
  router.post('/api/v1/attendance/clock-out', {}, {
    preserveState: true,
    onSuccess: () => { clockingOut.value = false },
    onError: () => { clockingOut.value = false },
  })
}

function statusClass(status) {
  const map = {
    present: 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
    late: 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400',
    absent: 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
    half_day: 'bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400',
    holiday: 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
    on_leave: 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400',
  }
  return map[status] || 'bg-gray-100 text-gray-700'
}
</script>
