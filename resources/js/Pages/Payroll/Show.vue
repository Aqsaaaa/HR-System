<template>
  <AppLayout>
    <div class="space-y-6">
      <div class="flex items-center gap-4">
        <Link :href="route('payroll.index')" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
          <ArrowLeftIcon class="w-5 h-5" />
        </Link>
        <div>
          <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ run.name }}</h1>
          <p class="text-sm text-gray-500 dark:text-gray-400">{{ formatDate(run.period_start) }} - {{ formatDate(run.period_end) }}</p>
        </div>
        <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full" :class="statusClass(run.status)">
          {{ run.status }}
        </span>
      </div>

      <!-- Summary -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-4">
          <span class="text-xs text-gray-500 dark:text-gray-400">Employees</span>
          <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ run.total_employees }}</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-4">
          <span class="text-xs text-gray-500 dark:text-gray-400">Total Gross</span>
          <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ formatCurrency(run.total_gross) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-4">
          <span class="text-xs text-gray-500 dark:text-gray-400">Total Deductions</span>
          <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ formatCurrency(run.total_deductions) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-4">
          <span class="text-xs text-gray-500 dark:text-gray-400">Net Pay</span>
          <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ formatCurrency(run.total_net) }}</p>
        </div>
      </div>

      <!-- Payslips -->
      <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-800">
          <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Payslips</h2>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="border-b border-gray-200 dark:border-gray-800">
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Payslip No</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Employee</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Earnings</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Deductions</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Net Pay</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
              <tr v-for="ps in payslips.data" :key="ps.id" class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                <td class="px-4 py-3 text-sm font-mono text-gray-700 dark:text-gray-300">{{ ps.payslip_no }}</td>
                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ ps.employee?.first_name }} {{ ps.employee?.last_name }}</td>
                <td class="px-4 py-3 text-sm text-green-600 dark:text-green-400">{{ formatCurrency(ps.total_earnings) }}</td>
                <td class="px-4 py-3 text-sm text-red-600 dark:text-red-400">{{ formatCurrency(ps.total_deductions) }}</td>
                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ formatCurrency(ps.net_pay) }}</td>
                <td class="px-4 py-3">
                  <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full" :class="ps.status === 'paid' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' : 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400'">
                    {{ ps.status }}
                  </span>
                </td>
              </tr>
              <tr v-if="!payslips.data?.length">
                <td colspan="6" class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">No payslips</td>
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
import { ArrowLeftIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  run: { type: Object, required: true },
  payslips: { type: Object, default: () => ({ data: [] }) },
})

function formatCurrency(val) {
  if (!val && val !== 0) return '-'
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(val)
}

function statusClass(status) {
  const map = {
    draft: 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-400',
    processing: 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400',
    completed: 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
    cancelled: 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
  }
  return map[status] || 'bg-gray-100 text-gray-700'
}
</script>
