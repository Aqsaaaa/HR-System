<template>
  <AppLayout>
    <div class="space-y-6">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
          <Link :href="route('employees.index')" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
            <ArrowLeftIcon class="w-5 h-5" />
          </Link>
          <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ employee.first_name }} {{ employee.last_name }}</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ employee.employee_id }}</p>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <Link :href="route('employees.edit', employee.id)"
            class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
            <PencilIcon class="w-4 h-4" />
            Edit
          </Link>
        </div>
      </div>

      <!-- Status Badge -->
      <div class="flex items-center gap-4">
        <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full" :class="statusClass(employee.employment_status)">
          {{ employee.employment_status }}
        </span>
        <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400">
          {{ employee.employment_type?.replace('_', ' ') }}
        </span>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Personal Info -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
          <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Personal Information</h2>
          <dl class="space-y-3">
            <div>
              <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase">Full Name</dt>
              <dd class="text-sm text-gray-900 dark:text-white font-medium">{{ employee.first_name }} {{ employee.last_name }}</dd>
            </div>
            <div>
              <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase">Gender</dt>
              <dd class="text-sm text-gray-900 dark:text-white">{{ employee.gender || '-' }}</dd>
            </div>
            <div>
              <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase">Date of Birth</dt>
              <dd class="text-sm text-gray-900 dark:text-white">{{ employee.date_of_birth || '-' }}</dd>
            </div>
            <div>
              <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase">Marital Status</dt>
              <dd class="text-sm text-gray-900 dark:text-white">{{ employee.marital_status || '-' }}</dd>
            </div>
            <div>
              <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase">Nationality</dt>
              <dd class="text-sm text-gray-900 dark:text-white">{{ employee.nationality || '-' }}</dd>
            </div>
          </dl>
        </div>

        <!-- Contact Info -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
          <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Contact</h2>
          <dl class="space-y-3">
            <div>
              <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase">Email</dt>
              <dd class="text-sm text-gray-900 dark:text-white">{{ employee.email }}</dd>
            </div>
            <div>
              <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase">Phone</dt>
              <dd class="text-sm text-gray-900 dark:text-white">{{ employee.phone || '-' }}</dd>
            </div>
            <div>
              <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase">Address</dt>
              <dd class="text-sm text-gray-900 dark:text-white">{{ employee.address || '-' }}</dd>
            </div>
            <div>
              <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase">City</dt>
              <dd class="text-sm text-gray-900 dark:text-white">{{ employee.city || '-' }}</dd>
            </div>
            <div>
              <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase">Country</dt>
              <dd class="text-sm text-gray-900 dark:text-white">{{ employee.country || '-' }}</dd>
            </div>
          </dl>
        </div>

        <!-- Employment Info -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
          <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Employment</h2>
          <dl class="space-y-3">
            <div>
              <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase">Department</dt>
              <dd class="text-sm text-gray-900 dark:text-white font-medium">{{ employee.department?.name || '-' }}</dd>
            </div>
            <div>
              <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase">Position</dt>
              <dd class="text-sm text-gray-900 dark:text-white font-medium">{{ employee.position?.name || '-' }}</dd>
            </div>
            <div>
              <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase">Reports To</dt>
              <dd class="text-sm text-gray-900 dark:text-white">{{ employee.reports_to?.first_name ? employee.reports_to.first_name + ' ' + employee.reports_to.last_name : '-' }}</dd>
            </div>
            <div>
              <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase">Hire Date</dt>
              <dd class="text-sm text-gray-900 dark:text-white">{{ employee.hire_date }}</dd>
            </div>
            <div>
              <dt class="text-xs text-gray-500 dark:text-gray-400 uppercase">Probation End</dt>
              <dd class="text-sm text-gray-900 dark:text-white">{{ employee.probation_end_date || '-' }}</dd>
            </div>
          </dl>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import { ArrowLeftIcon, PencilIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  employee: { type: Object, required: true },
})

function statusClass(status) {
  const map = {
    active: 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
    inactive: 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-400',
    terminated: 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
    resigned: 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400',
    suspended: 'bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400',
  }
  return map[status] || 'bg-gray-100 text-gray-700'
}
</script>
