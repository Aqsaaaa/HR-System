<template>
  <AppLayout>
    <div class="max-w-2xl mx-auto space-y-6">
      <div class="flex items-center gap-4">
        <Link :href="route('leave.index')" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
          <ArrowLeftIcon class="w-5 h-5" />
        </Link>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Apply Leave</h1>
      </div>

      <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
        <form @submit.prevent="submit" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Leave Type *</label>
            <select v-model="form.leave_type_id" required
              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
              <option value="">Select leave type</option>
              <option v-for="type in leaveTypes" :key="type.id" :value="type.id">{{ type.name }} ({{ type.days_per_year }} days/yr)</option>
            </select>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Date *</label>
              <input v-model="form.start_date" type="date" required
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-blue-500 outline-none" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Date *</label>
              <input v-model="form.end_date" type="date" required
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-blue-500 outline-none" />
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Duration Type</label>
            <select v-model="form.duration_type"
              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
              <option value="full_day">Full Day</option>
              <option value="half_day_morning">Half Day (Morning)</option>
              <option value="half_day_afternoon">Half Day (Afternoon)</option>
              <option value="hourly">Hourly</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Reason *</label>
            <textarea v-model="form.reason" required rows="3"
              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-none"
              placeholder="Please provide a reason for your leave request"></textarea>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contact Number</label>
            <input v-model="form.contact_number"
              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-blue-500 outline-none" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Address During Leave</label>
            <textarea v-model="form.address_during_leave" rows="2"
              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-none"></textarea>
          </div>

          <div>
            <p v-if="Object.keys(errors).length" class="mb-4 text-sm text-red-600">
              <span v-for="(msg, field) in errors" :key="field" class="block">{{ msg }}</span>
            </p>
          </div>

          <div class="flex justify-end gap-3 pt-2">
            <Link :href="route('leave.index')"
              class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
              Cancel
            </Link>
            <button type="submit" :disabled="processing"
              class="px-6 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors disabled:opacity-50">
              {{ processing ? 'Submitting...' : 'Submit Request' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import { ArrowLeftIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  leaveTypes: { type: Array, default: () => [] },
  errors: { type: Object, default: () => ({}) },
})

const processing = ref(false)

const form = reactive({
  leave_type_id: '',
  start_date: '',
  end_date: '',
  duration_type: 'full_day',
  reason: '',
  contact_number: '',
  address_during_leave: '',
})

function submit() {
  processing.value = true
  router.post('/api/v1/leave-requests', form, {
    preserveState: true,
    onSuccess: () => router.get('/leave'),
    onFinish: () => { processing.value = false },
    onError: (errs) => { console.error(errs) },
  })
}
</script>
