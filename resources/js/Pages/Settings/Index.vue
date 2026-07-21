<template>
  <AppLayout>
    <div class="space-y-6">
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Settings</h1>

      <!-- Tabs -->
      <div class="flex gap-4 border-b border-gray-200 dark:border-gray-800">
        <button v-for="tab in tabs" :key="tab.key" @click="activeTab = tab.key"
          class="pb-3 text-sm font-medium transition-colors"
          :class="activeTab === tab.key
            ? 'text-blue-600 border-b-2 border-blue-600'
            : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'">
          {{ tab.label }}
        </button>
      </div>

      <!-- Company Settings -->
      <form v-if="activeTab === 'company'" @submit.prevent="updateCompany" class="space-y-6 max-w-2xl">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6 space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Company Name</label>
            <input v-model="form.company_name" type="text"
              class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Address</label>
            <textarea v-model="form.company_address" rows="3"
              class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm"></textarea>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone</label>
              <input v-model="form.company_phone" type="text"
                class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
              <input v-model="form.company_email" type="email"
                class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm" />
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Website</label>
              <input v-model="form.company_website" type="text"
                class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm" />
            </div>
          </div>
        </div>
        <div class="flex justify-end">
          <button type="submit" :disabled="saving"
            class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 disabled:opacity-50">
            {{ saving ? 'Saving...' : 'Save Company Settings' }}
          </button>
        </div>
      </form>

      <!-- General Settings -->
      <form v-if="activeTab === 'general'" @submit.prevent="updateGeneral" class="space-y-6 max-w-2xl">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6 space-y-4">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Timezone</label>
              <select v-model="form.timezone"
                class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm">
                <option value="UTC">UTC</option>
                <option value="Asia/Jakarta">Asia/Jakarta</option>
                <option value="Asia/Makassar">Asia/Makassar</option>
                <option value="Asia/Jayapura">Asia/Jayapura</option>
                <option value="America/New_York">America/New_York</option>
                <option value="Europe/London">Europe/London</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date Format</label>
              <select v-model="form.date_format"
                class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm">
                <option value="Y-m-d">Y-m-d (2026-07-21)</option>
                <option value="d/m/Y">d/m/Y (21/07/2026)</option>
                <option value="m/d/Y">m/d/Y (07/21/2026)</option>
              </select>
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Currency</label>
              <input v-model="form.currency" type="text"
                class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Language</label>
              <select v-model="form.language"
                class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm">
                <option value="en">English</option>
                <option value="id">Bahasa Indonesia</option>
              </select>
            </div>
          </div>
        </div>
        <div class="flex justify-end">
          <button type="submit" :disabled="saving"
            class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 disabled:opacity-50">
            {{ saving ? 'Saving...' : 'Save General Settings' }}
          </button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  company: { type: Object, default: () => ({}) },
  general: { type: Object, default: () => ({}) },
})

const tabs = [
  { key: 'company', label: 'Company' },
  { key: 'general', label: 'General' },
]
const activeTab = ref('company')
const saving = ref(false)

const form = reactive({
  company_name: props.company.company_name || '',
  company_address: props.company.company_address || '',
  company_phone: props.company.company_phone || '',
  company_email: props.company.company_email || '',
  company_website: props.company.company_website || '',
  timezone: props.general.timezone || 'UTC',
  date_format: props.general.date_format || 'Y-m-d',
  currency: props.general.currency || 'IDR',
  language: props.general.language || 'en',
})

function updateCompany() {
  saving.value = true
  router.post(route('settings.company.update'), {
    company_name: form.company_name,
    company_address: form.company_address,
    company_phone: form.company_phone,
    company_email: form.company_email,
    company_website: form.company_website,
  }, {
    onSuccess: () => saving.value = false,
    onError: () => saving.value = false,
  })
}

function updateGeneral() {
  saving.value = true
  router.post(route('settings.general.update'), {
    timezone: form.timezone,
    date_format: form.date_format,
    currency: form.currency,
    language: form.language,
  }, {
    onSuccess: () => saving.value = false,
    onError: () => saving.value = false,
  })
}
</script>
